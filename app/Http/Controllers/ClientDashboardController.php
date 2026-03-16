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
     */
    public function refuserDevis($id)
    {
        $client = Auth::user()->client;
        $devis = Devis::whereHas('ticket', function ($q) use ($client) {
            $q->where('id_client', $client->id);
        })->findOrFail($id);

        $devis->update(['statut' => 'Refusé']);
        $devis->ticket->update(['statut' => 'Rejeté']);

        return redirect()->route('client.devis.index')
            ->with('success', 'Le devis a été refusé.');
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
}
