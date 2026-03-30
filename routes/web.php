<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\AgentAccueil\TicketController as AgentTicketController;
use App\Http\Controllers\TechnicienDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('devis', DevisController::class);
    Route::get('/factures/devis/{id}', [FactureController::class, 'createFromDevis'])->name('factures.create_from_devis');
    Route::resource('factures', FactureController::class);
    Route::resource('interventions', InterventionController::class);
    Route::resource('materiels', MaterielController::class);

    // Rapports (page simple pour l'instant)
    Route::get('/rapports', function () {
        return view('rapports.index');
    })->name('rapports.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== ROUTES CLIENT =====
    Route::prefix('client')->group(function () {
        Route::get('/tickets', [ClientDashboardController::class, 'mesTickets'])->name('client.tickets.index');
        Route::get('/tickets/create', [ClientDashboardController::class, 'creerTicket'])->name('client.tickets.create');
        Route::post('/tickets', [ClientDashboardController::class, 'storeTicket'])->name('client.tickets.store');

        Route::get('/devis', [ClientDashboardController::class, 'mesDevis'])->name('client.devis.index');
        Route::post('/devis/{id}/valider', [ClientDashboardController::class, 'validerDevis'])->name('client.devis.valider');
        Route::post('/devis/{id}/refuser', [ClientDashboardController::class, 'refuserDevis'])->name('client.devis.refuser');
        
        Route::get('/factures', [ClientDashboardController::class, 'mesFactures'])->name('client.factures.index');
        Route::post('/factures/{id}/payer', [ClientDashboardController::class, 'payerFacture'])->name('client.factures.payer');
        
        Route::get('/materiels', [ClientDashboardController::class, 'mesMateriels'])->name('client.materiels');
    });

    // ===== ROUTES PDF (Accessibles pour Client ET Responsable) =====
    Route::get('/devis/{id}/pdf', [DevisController::class, 'downloadPdf'])->name('devis.pdf');
    Route::get('/factures/{id}/pdf', [FactureController::class, 'downloadPdf'])->name('factures.pdf');
    // ===== ROUTES AGENT D'ACCUEIL =====
    Route::prefix('accueil')->name('agent_accueil.')->group(function () {
        Route::get('/tickets', [AgentTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [AgentTicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [AgentTicketController::class, 'store'])->name('tickets.store');
        
        // Vue d'ensemble (Dashboard Accueil)
        Route::get('/dashboard', function () {
            // Un dashboard simplifié pour l'agent d'accueil
            return view('agent_accueil.dashboard');
        })->name('dashboard');
    });

    // ===== ROUTES TECHNICIEN =====
    Route::prefix('technicien')->name('technicien.')->group(function () {
        Route::get('/dashboard', [TechnicienDashboardController::class, 'index'])->name('dashboard');
        Route::get('/interventions', [TechnicienDashboardController::class, 'mesInterventions'])->name('interventions.index');
        Route::get('/interventions/{id}', [TechnicienDashboardController::class, 'showIntervention'])->name('interventions.show');
        Route::post('/interventions/{id}/rapport', [TechnicienDashboardController::class, 'soumettreRapport'])->name('interventions.rapport');
        
        // Suivi d'avancement
        Route::post('/interventions/{id}/demarrer', [TechnicienDashboardController::class, 'demarrerIntervention'])->name('interventions.demarrer');
        Route::post('/interventions/{id}/suspendre', [TechnicienDashboardController::class, 'suspendreIntervention'])->name('interventions.suspendre');
        
        // Gestion des pièces
        Route::post('/interventions/{id}/ajouter-piece', [TechnicienDashboardController::class, 'ajouterPiece'])->name('interventions.ajouter_piece');
        Route::delete('/interventions/{id}/retirer-piece/{piece_id}', [TechnicienDashboardController::class, 'retirerPiece'])->name('interventions.retirer_piece');
    });

    // API Interne pour les formulaires AJAX
    Route::get('/api/materiels/client/{id}', [MaterielController::class, 'getByClient'])->name('api.materiels.client');
});

require __DIR__.'/auth.php';
