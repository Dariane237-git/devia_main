<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Technicien;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les tickets avec les relations utiles (client.utilisateur, matériel)
        // On trie par date de création descendante
        $tickets = Ticket::with(['client.utilisateur', 'materiel'])
            ->orderBy('created_at', 'desc')
            ->get();

        // On récupère la liste des techniciens pour permettre l'assignation depuis la vue index
        $techniciens = Technicien::with('utilisateur')->get();

        return view('tickets.index', compact('tickets', 'techniciens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Réservé principalement au Client ou à l'Agent d'accueil
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::with(['client.utilisateur', 'materiel', 'devis'])->findOrFail($id);
        
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * Utilisé notamment pour assigner un technicien ou changer le statut du ticket
     */
    public function update(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);

        // Exemple: Assigner un technicien via un formulaire ou un bouton
        if ($request->has('action') && $request->action == 'assign_technician') {
            $request->validate([
                'id_technicien' => 'required|exists:techniciens,id'
            ]);

            // L'assignation d'un ticket déclenche souvent la création d'une ligne d'Intervention ou de Devis.
            // Pour l'instant on met juste à jour le statut du ticket
            $ticket->update(['statut' => 'Assigné']);
            
            // Note: Normalement on créerait l'Intervention avec l'id_technicien ici.
            // On y reviendra dans la gestion des Interventions.
            
            return redirect()->route('tickets.index')->with('success', 'Ticket assigné avec succès.');
        }
        
        // Exemple: Rejeter le ticket
        if ($request->has('action') && $request->action == 'reject') {
            $ticket->update(['statut' => 'Rejeté']);
            return redirect()->route('tickets.index')->with('success', 'Le ticket a été rejeté.');
        }

        return redirect()->route('tickets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        
        return redirect()->route('tickets.index')->with('success', 'Ticket supprimé avec succès.');
    }
}
