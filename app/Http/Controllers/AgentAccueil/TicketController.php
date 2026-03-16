<?php

namespace App\Http\Controllers\AgentAccueil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Client;
use App\Models\Materiel;

class TicketController extends Controller
{
    /**
     * Affiche la liste des tickets (vue globale simplifiée pour l'accueil).
     */
    public function index()
    {
        // L'agent d'accueil voit tous les tickets (ou ceux en attente)
        $tickets = Ticket::with(['client.utilisateur', 'materiel'])->orderBy('created_at', 'desc')->get();
        return view('agent_accueil.tickets.index', compact('tickets'));
    }

    /**
     * Formulaire pour qu'un agent d'accueil crée un ticket pour un client.
     */
    public function create(Request $request)
    {
        // On récupère tous les clients existants
        $clients = Client::with('utilisateur')->get();
        
        // Si un client spécifique est sélectionné (via l'URL ou JavaScript)
        $selectedClientId = $request->query('client_id');
        $materiels = [];
        if ($selectedClientId) {
            $materiels = Materiel::where('id_client', $selectedClientId)->get();
        } else {
            $materiels = Materiel::all();
        }

        return view('agent_accueil.tickets.create', compact('clients', 'materiels', 'selectedClientId'));
    }

    /**
     * Enregistre un ticket créé par l'agent d'accueil.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_client' => 'required|exists:clients,id',
            'id_mat' => 'required|exists:materiels,id',
            'description_panne' => 'required|string|min:10',
            'priorite' => 'required|in:Basse,Moyenne,Haute,Critique',
        ]);

        // Vérification de sécurité: le matériel appartient bien au client ?
        $materiel = Materiel::find($request->id_mat);
        if ($materiel->id_client != $request->id_client) {
            return back()->withInput()->withErrors(['id_mat' => 'Ce matériel n\'appartient pas à ce client.']);
        }

        Ticket::create([
            'description_panne' => $request->description_panne,
            'statut' => 'En attente', // Statut initial
            'priorite' => $request->priorite,
            'id_client' => $request->id_client,
            'id_mat' => $request->id_mat,
        ]);

        return redirect()->route('agent_accueil.tickets.index')->with('success', 'Le ticket de panne a été créé avec succès pour le client.');
    }
}
