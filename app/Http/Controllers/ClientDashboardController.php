<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Devis;
use App\Models\Materiel;

class ClientDashboardController extends Controller
{
    /**
     * Affiche la liste des tickets du client connecté.
     */
    public function mesTickets()
    {
        $client = Auth::user()->client;
        $tickets = Ticket::with(['materiel', 'devis'])
            ->where('id_client', $client->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.tickets.index', compact('tickets'));
    }

    /**
     * Affiche le formulaire de déclaration d'incident.
     */
    public function creerTicket()
    {
        $client = Auth::user()->client;
        $materiels = Materiel::where('id_client', $client->id)->get();

        return view('client.tickets.create', compact('materiels'));
    }

    /**
     * Enregistre un nouveau ticket.
     */
    public function storeTicket(Request $request)
    {
        $client = Auth::user()->client;

        $request->validate([
            'id_mat' => 'required|exists:materiels,id',
            'description_panne' => 'required|string|min:10',
            'priorite' => 'required|in:Basse,Moyenne,Haute,Critique',
        ]);

        Ticket::create([
            'date_creation' => now(),
            'description_panne' => $request->description_panne,
            'statut' => 'Nouveau',
            'priorite' => $request->priorite,
            'id_client' => $client->id,
            'id_mat' => $request->id_mat,
        ]);

        return redirect()->route('client.tickets.index')
            ->with('success', 'Votre ticket a été créé avec succès. Le responsable sera notifié.');
    }

    /**
     * Affiche la liste des devis du client.
     */
    public function mesDevis()
    {
        $client = Auth::user()->client;
        $devis = Devis::with('ticket.materiel')
            ->whereHas('ticket', function ($q) use ($client) {
                $q->where('id_client', $client->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.devis.index', compact('devis'));
    }

    /**
     * Valider un devis (le client accepte).
     */
    public function validerDevis($id)
    {
        $client = Auth::user()->client;
        $devis = Devis::whereHas('ticket', function ($q) use ($client) {
            $q->where('id_client', $client->id);
        })->findOrFail($id);

        $devis->update(['statut' => 'Validé']);
        $devis->ticket->update(['statut' => 'Assigné']);

        return redirect()->route('client.devis.index')
            ->with('success', 'Le devis a été accepté. L\'intervention sera planifiée prochainement.');
    }

    /**
     * Refuser un devis (le client refuse).
     * Déclenche la création automatique d'une facture de diagnostic.
     */
    public function refuserDevis($id)
    {
        $client = Auth::user()->client;
        $devis = Devis::with('ticket')->whereHas('ticket', function ($q) use ($client) {
            $q->where('id_client', $client->id);
        })->findOrFail($id);

        // 1. Mettre à jour le statut du devis
        $devis->update(['statut' => 'Refusé']);

        // 2. Mettre à jour le statut du ticket
        $devis->ticket->update(['statut' => 'Devis refusé']);

        // 3. Créer automatiquement la facture de diagnostic
        $frais = $devis->frais_diagnostic ?? 0;
        \App\Models\Facture::create([
            'numero_fac'       => 'DIAG-' . str_pad($devis->id, 5, '0', STR_PAD_LEFT) . '-' . date('Ymd'),
            'date_emission'    => now(),
            'mont_total'       => $frais,
            'type_fac'         => 'Diagnostic',
            'statut_paiement'  => 'En attente',
            'id_devis'         => $devis->id,
        ]);

        return redirect()->route('client.devis.index')
            ->with('success', 'Le devis a été refusé. Une facture de diagnostic de ' . number_format($frais, 0, ',', ' ') . ' FCFA a été générée.');
    }

    /**
     * Affiche la liste des matériels du client.
     */
    public function mesMateriels()
    {
        $client = Auth::user()->client;
        $materiels = Materiel::with('tickets')
            ->where('id_client', $client->id)
            ->get();

        return view('client.materiels.index', compact('materiels'));
    }

    /**
     * Affiche la liste des factures du client.
     */
    public function mesFactures()
    {
        $client = Auth::user()->client;
        $factures = \App\Models\Facture::with(['devis.ticket.materiel'])
            ->whereHas('devis.ticket', function ($q) use ($client) {
                $q->where('id_client', $client->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.factures.index', compact('factures'));
    }

    /**
     * Simule le paiement en ligne d'une facture.
     */
    public function payerFacture($id)
    {
        $client = Auth::user()->client;
        $facture = \App\Models\Facture::whereHas('devis.ticket', function ($q) use ($client) {
            $q->where('id_client', $client->id);
        })->findOrFail($id);

        if ($facture->statut_paiement != 'Payée') {
            $facture->update(['statut_paiement' => 'Payée']);
            return redirect()->route('client.factures.index')->with('success', 'Le paiement de la facture ' . $facture->numero_fac . ' a été effectué avec succès.');
        }

        return redirect()->route('client.factures.index')->with('info', 'Cette facture est déjà payée.');
    }
}
