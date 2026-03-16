<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Intervention;
use App\Models\Ticket;
use App\Models\Piece;
use Illuminate\Support\Facades\DB;

class TechnicienDashboardController extends Controller
{
    /**
     * Affiche le tableau de bord du technicien.
     */
    public function index()
    {
        $user = Auth::user();
        $technicien = $user->technicien;

        if (!$technicien) {
            abort(403, 'Profil technicien introuvable.');
        }

        // Statistiques
        $stats = [
            'interventions_en_cours' => Intervention::where('id_tech', $technicien->id)
                                        ->where('statut', 'En cours')
                                        ->count(),
            'interventions_terminees' => Intervention::where('id_tech', $technicien->id)
                                        ->where('statut', 'Terminé')
                                        ->count(),
        ];

        // Dernières interventions en cours (max 5)
        $recentesInterventions = Intervention::with(['devis.ticket.client.utilisateur', 'devis.ticket.materiel'])
            ->where('id_tech', $technicien->id)
            ->where('statut', 'En cours')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('technicien.dashboard', compact('stats', 'recentesInterventions'));
    }

    /**
     * Liste toutes les interventions du technicien.
     */
    public function mesInterventions()
    {
        $user = Auth::user();
        $technicien = $user->technicien;

        if (!$technicien) {
            abort(403, 'Profil technicien introuvable.');
        }

        $interventions = Intervention::with(['devis.ticket.client.utilisateur', 'devis.ticket.materiel'])
            ->where('id_tech', $technicien->id)
            ->orderByRaw("FIELD(statut, 'En cours', 'Planifiée', 'Terminé', 'Annulé')")
            ->orderBy('date_debut', 'asc')
            ->get();

        return view('technicien.interventions.index', compact('interventions'));
    }

    /**
     * Affiche le détail d'une intervention et le formulaire de rapport.
     */
    public function showIntervention($id)
    {
        $user = Auth::user();
        $technicien = $user->technicien;

        $intervention = Intervention::with(['devis.ticket.client.utilisateur', 'devis.ticket.materiel', 'pieces'])
            ->where('id_tech', $technicien->id)
            ->findOrFail($id);

        $piecesDisponibles = Piece::orderBy('nom')->get();

        return view('technicien.interventions.show', compact('intervention', 'piecesDisponibles'));
    }

    /**
     * Marquer l'intervention comme commencée.
     */
    public function demarrerIntervention($id)
    {
        $user = Auth::user();
        $technicien = $user->technicien;
        $intervention = Intervention::where('id_tech', $technicien->id)->findOrFail($id);

        DB::transaction(function () use ($intervention) {
            $intervention->update(['statut' => 'En cours']);
            $intervention->devis->ticket->update(['statut' => 'En cours']);
        });

        return back()->with('success', 'L\'intervention a été démarrée. Travaillez bien !');
    }

    /**
     * Marquer l'intervention comme suspendue/en attente.
     */
    public function suspendreIntervention($id)
    {
        $user = Auth::user();
        $technicien = $user->technicien;
        $intervention = Intervention::where('id_tech', $technicien->id)->findOrFail($id);

        DB::transaction(function () use ($intervention) {
            $intervention->update(['statut' => 'Planifiée']); // Ou un nouveau statut 'En attente'
            $intervention->devis->ticket->update(['statut' => 'En attente']);
        });

        return back()->with('info', 'L\'intervention a été mise en pause.');
    }

    /**
     * Ajouter une pièce détachée réellement utilisée.
     */
    public function ajouterPiece(Request $request, $id)
    {
        $user = Auth::user();
        $technicien = $user->technicien;
        $intervention = Intervention::where('id_tech', $technicien->id)->findOrFail($id);

        $request->validate([
            'id_piece' => 'required|exists:pieces,id',
            'qte' => 'required|integer|min:1',
        ]);

        // Vérifier si la pièce est déjà dans la liste
        if ($intervention->pieces()->where('id_piece', $request->id_piece)->exists()) {
            $intervention->pieces()->updateExistingPivot($request->id_piece, [
                'qte_reel_utiliser' => DB::raw('qte_reel_utiliser + ' . $request->qte)
            ]);
        } else {
            $intervention->pieces()->attach($request->id_piece, [
                'qte_reel_utiliser' => $request->qte
            ]);
        }

        return back()->with('success', 'La pièce a été ajoutée à l\'intervention.');
    }

    /**
     * Retirer une pièce de l'intervention.
     */
    public function retirerPiece($id, $piece_id)
    {
        $user = Auth::user();
        $technicien = $user->technicien;
        $intervention = Intervention::where('id_tech', $technicien->id)->findOrFail($id);

        $intervention->pieces()->detach($piece_id);

        return back()->with('success', 'La pièce a été retirée.');
    }

    /**
     * Soumet le rapport d'intervention et clôture le ticket.
     */
    public function soumettreRapport(Request $request, $id)
    {
        $user = Auth::user();
        $technicien = $user->technicien;

        $intervention = Intervention::where('id_tech', $technicien->id)->findOrFail($id);

        $request->validate([
            'rapport_intervention' => 'required|string|min:10',
        ]);

        // Mise à jour de l'intervention
        $intervention->update([
            'rapport_intervention' => $request->rapport_intervention,
            'statut' => 'Terminé'
        ]);

        // Mise à jour du ticket associé
        if ($intervention->ticket) {
            $intervention->ticket->update([
                'statut' => 'Résolu'
            ]);
        }

        return redirect()->route('technicien.interventions.index')
            ->with('success', 'Rapport soumis avec succès. L\'intervention et le ticket ont été clôturés.');
    }
}
