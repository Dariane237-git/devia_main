<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Devis;
use App\Models\Intervention;
use App\Models\Facture;
use App\Models\Technicien;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord approprié selon le rôle de l'utilisateur.
     */
    public function index()
    {
        $user = Auth::user();

        // Redirection selon le rôle de l'utilisateur
        if ($user->id_role == 1) {
            return $this->clientDashboard($user);
        }

        if ($user->id_role == 2) {
            // L'agent d'accueil possède un espace séparé défini dans les routes d'accueil
            return redirect()->route('agent_accueil.dashboard');
        }

        if ($user->id_role == 4) {
            // Le technicien accède à son propre espace de travail
            return redirect()->route('technicien.dashboard');
        }

        // Dashboard du Responsable Maintenance (rôle 3) et autres rôles par défaut
        
        // --- 1. Statistiques Rapides ---
        $stats = [
            'tickets_nouveaux' => Ticket::where('statut', 'Nouveau')->count(),
            'devis_attente' => Devis::where('statut', 'En attente')->count(),
            'interventions_actives' => Intervention::where('statut', 'En cours')->count(),
            'factures_impayees' => Facture::where('statut_paiement', 'En attente')->count(),
        ];

        // --- 2. Tickets non assignés (prioritaires) ---
        // On récupère les tickets "Nouveau" avec leurs relations (client et matériel)
        $ticketsPriority = Ticket::with(['client.utilisateur', 'materiel'])
                            ->where('statut', 'Nouveau')
                            ->orderBy('created_at', 'desc')
                            ->take(6)
                            ->get();

        // 3. Statut des techniciens (Rôle ID 4 = Technicien)
        $techniciens = Utilisateur::with('technicien')
            ->where('id_role', 4)
            ->get();

        return view('dashboard', compact('stats', 'ticketsPriority', 'techniciens'));
    }

    /**
     * Dashboard dédié au Client (rôle 1).
     */
    private function clientDashboard($user)
    {
        $client = $user->client;

        // Si le profil client n'existe pas encore, on le crée automatiquement
        if (!$client) {
            $client = \App\Models\Client::create([
                'user_id' => $user->id,
                'adresse_clt' => '',
                'type_clt' => 'Particulier',
            ]);
        }

        // Statistiques personnelles
        $stats = [
            'tickets_en_cours' => Ticket::where('id_client', $client->id)
                ->whereNotIn('statut', ['Clôturé', 'Rejeté'])
                ->count(),
            'devis_en_attente' => Devis::whereHas('ticket', function ($q) use ($client) {
                $q->where('id_client', $client->id);
            })->where('statut', 'En attente')->count(),
            'mes_materiels' => $client->materiels()->count(),
        ];

        // Derniers tickets du client
        $mesTickets = Ticket::with(['materiel', 'devis'])
            ->where('id_client', $client->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('client.dashboard', compact('stats', 'mesTickets', 'client'));
    }
}
