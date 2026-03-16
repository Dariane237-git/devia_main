<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InterventionController extends Controller
{
    /**
     * Affiche la liste des interventions (Planning).
     */
    public function index()
    {
        $interventions = \App\Models\Intervention::with(['devis.ticket.client.utilisateur', 'technicien.utilisateur'])
            ->orderBy('date_debut', 'desc')
            ->get();

        return view('interventions.index', compact('interventions'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle intervention.
     */
    public function create(Request $request)
    {
        // On récupère le devis ciblé s'il est passé dans l'URL (ex: ?devis=1)
        $devisId = $request->query('devis');
        $devisSelectionne = null;
        
        if ($devisId) {
            $devisSelectionne = \App\Models\Devis::with('ticket.client.utilisateur')->find($devisId);
        }

        // On ne liste que les devis 'Accepté' qui n'ont pas encore d'intervention
        $devisDisponibles = \App\Models\Devis::where('statut', 'Accepté')
                            ->whereDoesntHave('intervention')
                            ->with('ticket.client.utilisateur')
                            ->get();

        // Récupérer les techniciens avec le compte utilisateur associé
        $techniciens = \App\Models\Technicien::with('utilisateur')->get();

        return view('interventions.create', compact('devisSelectionne', 'devisDisponibles', 'techniciens'));
    }

    /**
     * Enregistre une nouvelle intervention dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_devis' => 'required|exists:devis,id|unique:interventions,id_devis',
            'id_tech' => 'required|exists:techniciens,id',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ], [
            'id_devis.unique' => 'Ce devis est déjà associé à une intervention existante.',
        ]);

        \App\Models\Intervention::create([
            'id_devis' => $request->id_devis,
            'id_tech' => $request->id_tech,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'statut' => 'Planifiée', // Statut initial
        ]);

        return redirect()->route('interventions.index')->with('success', 'L\'intervention a été planifiée avec succès et assignée au technicien.');
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
}
