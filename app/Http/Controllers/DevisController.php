<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use Illuminate\Http\Request;

class DevisController extends Controller
{
    /**
     * Affiche la liste des devis.
     */
    public function index()
    {
        $devis = Devis::with(['ticket.client.utilisateur', 'facture'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('devis.index', compact('devis'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau devis.
     */
    public function create()
    {
        // Récupérer les tickets qui n'ont pas encore de devis
        $tickets = \App\Models\Ticket::whereDoesntHave('devis')
            ->with('client.utilisateur')
            ->get();

        return view('devis.create', compact('tickets'));
    }

    /**
     * Enregistre un nouveau devis dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ticket' => 'required|exists:tickets,id',
            'date_devis' => 'required|date',
            'mont_estimer' => 'required|numeric|min:0',
        ]);

        Devis::create([
            'id_ticket' => $request->id_ticket,
            'date_devis' => $request->date_devis,
            'mont_estimer' => $request->mont_estimer,
            'statut' => 'En attente', // Statut par défaut
        ]);

        return redirect()->route('devis.index')
            ->with('success', 'Le devis a été généré avec succès.');
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
