<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: 600; color: #1F2937; margin: 0;">
            {{ __('Tableau de Bord - Agent d\'Accueil') }}
        </h2>
    </x-slot>

    <style>
        .page-container { padding: 32px; max-width: 1200px; margin: 0 auto; }
        
        .welcome-mb { margin-bottom: 24px; }
        .welcome-title { font-size: 24px; font-weight: 800; color: #111827; margin: 0; }
        .welcome-sub { color: #6B7280; font-size: 14px; margin-top: 4px; }
        
        /* Grid des raccourcis */
        .actions-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px; }
        @media (max-width: 900px) { .actions-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .actions-grid { grid-template-columns: 1fr; } }
        
        .action-card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #E5E7EB; text-decoration: none; display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s; }
        .action-card:hover { transform: translateY(-4px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        
        .icon-container { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 24px; }
        .icon-blue { background: #EFF6FF; color: #2563EB; }
        .icon-purple { background: #FAF5FF; color: #9333EA; }
        .icon-orange { background: #FFF7ED; color: #EA580C; }
        
        .action-title { font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 8px; }
        .action-desc { font-size: 14px; color: #6B7280; flex-grow: 1; margin-bottom: 16px; line-height: 1.5; }
        .action-link { font-size: 14px; font-weight: 600; color: currentColor; display: flex; align-items: center; gap: 4px; margin-top: auto; }
        
        /* Liste récente stylisée */
        .recent-section { background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #E5E7EB; overflow: hidden; }
        .recent-header { padding: 20px 24px; border-bottom: 1px solid #E5E7EB; background: #F9FAFB; display: flex; justify-content: space-between; align-items: center; }
        .recent-title { font-size: 16px; font-weight: 700; color: #111827; margin: 0; }
        .recent-content { padding: 24px; text-align: center; color: #6B7280; font-size: 14px; }
    </style>

    <div class="page-container">
        
        <div class="welcome-mb">
            <h1 class="welcome-title">Bonjour, {{ Auth::user()->prenom ?? '' }} 👋</h1>
            <p class="welcome-sub">Bienvenue à l'accueil. Sélections rapides pour servir vos clients au comptoir.</p>
        </div>

        <div class="actions-grid">
            
            <a href="{{ route('agent_accueil.tickets.create') }}" class="action-card" style="color: #2563EB;">
                <div class="icon-container icon-blue">
                    <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <h3 class="action-title">Déclarer une Panne</h3>
                <p class="action-desc">Un client se présente avec un appareil défectueux ? Ouvrez un ticket d'intervention ici.</p>
                <div class="action-link">Créer un ticket ➔</div>
            </a>

            <!-- Liens placeholders vers les utilisateurs/création. L'admin et l'accueil utilisent la même route de création théoriquement -->
            <a href="{{ route('users.index') }}" class="action-card" style="color: #9333EA;">
                <div class="icon-container icon-purple">
                    <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <h3 class="action-title">Nouveau Client</h3>
                <p class="action-desc">Enregistrez les informations personnelles d'un client qui vient pour la première fois.</p>
                <div class="action-link">Ajouter un profil ➔</div>
            </a>

            <a href="{{ route('materiels.index') }}" class="action-card" style="color: #EA580C;">
                <div class="icon-container icon-orange">
                    <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="action-title">Catalogue Matériels</h3>
                <p class="action-desc">Consultez ou enregistrez les appareils appartenant aux clients de l'entreprise.</p>
                <div class="action-link">Gérer le matériel ➔</div>
            </a>

        </div>

        <div class="recent-section">
            <div class="recent-header">
                <h3 class="recent-title">Dernières Activités</h3>
                <a href="{{ route('agent_accueil.tickets.index') }}" style="color: #2563EB; font-size: 14px; font-weight: 500; text-decoration: none;">Voir tout l'historique</a>
            </div>
            
            <div class="recent-content">
                Pour voir les tickets récemment saisis à l'accueil, cliquez sur le bouton "Voir tout l'historique". <br><br>
                <em>Les données récentes viendront s'afficher ici prochainement.</em>
            </div>
        </div>

    </div>
</x-app-layout>
