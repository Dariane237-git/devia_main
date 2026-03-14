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
     * Affiche le formulaire de création d'une nouvelle ressource.
     */
    public function create()
    {
        //
    }

    /**
     * Enregistre une nouvelle ressource dans la base de données.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Affiche les détails d'une ressource spécifique.
     */
    public function show(string $id)
    {
        //
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
