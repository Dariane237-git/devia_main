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

        // Si l'utilisateur est le Responsable Maintenance (id_role = 2 par exemple, ou on le gère globalement pour l'instant)
        // Pour ce projet, on part du principe que la vue dashboard est celle du Responsable.
        
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
}
