<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    /**
     * Affiche la liste des factures.
     */
    public function index()
    {
        $factures = Facture::with(['devis.ticket.client.utilisateur'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('factures.index', compact('factures'));
    }

    /**
     * Affiche le formulaire de création d'une facture finale depuis un devis.
     */
    public function createFromDevis($id_devis)
    {
        $devis = \App\Models\Devis::with('ticket.materiel')->findOrFail($id_devis);
        
        // Vérifier s'il a déjà une facture finale
        $exist = Facture::where('id_devis', $id_devis)->where('type_fac', 'Finale')->first();
        if ($exist) {
            return redirect()->route('factures.show', $exist->id)->with('info', 'Une facture finale existe déjà pour ce devis.');
        }

        return view('factures.create', compact('devis'));
    }

    /**
     * Enregistre une nouvelle ressource dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_devis' => 'required|exists:devis,id',
            'mont_total' => 'required|numeric|min:0',
        ]);

        $devis = \App\Models\Devis::findOrFail($request->id_devis);
        
        $facture = Facture::create([
            'numero_fac' => 'FAC-' . str_pad($devis->id, 5, '0', STR_PAD_LEFT) . '-' . date('Ymd'),
            'date_emission' => now(),
            'mont_total' => $request->mont_total,
            'type_fac' => 'Finale',
            'statut_paiement' => 'En attente',
            'id_devis' => $devis->id,
        ]);

        // Mettre à jour le statut du ticket
        $devis->ticket->update(['statut' => 'Terminé']);

        return redirect()->route('factures.show', $facture->id)
            ->with('success', 'Facture Finale générée avec succès.');
    }

    /**
     * Affiche les détails d'une ressource spécifique.
     */
    public function show(string $id)
    {
        $facture = Facture::with('devis.ticket.client.utilisateur')->findOrFail($id);
        return view('factures.show', compact('facture'));
    }

    /**
     * Affiche le formulaire de modification d'une ressource spécifique.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Met à jour la ressource spécifique dans la base de données.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Supprime la ressource spécifique de la base de données.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Génère et télécharge le PDF de la facture.
     */
    public function downloadPdf($id)
    {
        $facture = Facture::with('devis.ticket.client.utilisateur')->findOrFail($id);
        
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->id_role != 3 && ($user->client->id ?? 0) != $facture->devis->ticket->id_client) {
            abort(403, 'Accès non autorisé.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.facture', compact('facture'));
        return $pdf->download('Facture_'.$facture->numero_fac.'.pdf');
    }
}
