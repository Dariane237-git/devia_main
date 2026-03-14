<x-app-layout>
    <x-slot name="header">
        Rapports
    </x-slot>

    <style>
        .page-header { margin-bottom: 24px; }
        .report-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px; }
        @media (max-width: 1000px) { .report-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .report-grid { grid-template-columns: 1fr; } }
        .report-card {
            background: white; border-radius: 16px; padding: 24px;
            border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
            display: flex; flex-direction: column; gap: 16px;
            transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;
        }
        .report-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
        .report-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }
        .coming-soon {
            background: white; border-radius: 16px; padding: 48px; text-align: center;
            border: 2px dashed #E5E7EB;
        }
    </style>

    <div class="page-header">
        <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 4px;">Rapports & Statistiques</h2>
        <p style="color: #6B7280; font-size: 14px;">Suivez les indicateurs clés de performance de votre centre de maintenance.</p>
    </div>

    <!-- Cartes de rapports rapides -->
    <div class="report-grid">
        <!-- Rapport Tickets -->
        <div class="report-card">
            <div class="report-icon" style="background:#EFF6FF;color:#2563EB;">
                <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
            <div>
                <div style="font-size:16px;font-weight:700;color:#111827;">Rapport des Tickets</div>
                <p style="font-size:13px;color:#6B7280;margin-top:4px;">Nombre de tickets créés, résolus, en attente par période.</p>
            </div>
            <div style="margin-top:auto;padding-top:12px;border-top:1px solid #F3F4F6;">
                <span style="font-size:13px;color:#2563EB;font-weight:600;">Consulter →</span>
            </div>
        </div>

        <!-- Rapport Interventions -->
        <div class="report-card">
            <div class="report-icon" style="background:#F0FDF4;color:#059669;">
                <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <div style="font-size:16px;font-weight:700;color:#111827;">Rapport des Interventions</div>
                <p style="font-size:13px;color:#6B7280;margin-top:4px;">Durée moyenne, taux de réussite, charge par technicien.</p>
            </div>
            <div style="margin-top:auto;padding-top:12px;border-top:1px solid #F3F4F6;">
                <span style="font-size:13px;color:#059669;font-weight:600;">Consulter →</span>
            </div>
        </div>

        <!-- Rapport Financier -->
        <div class="report-card">
            <div class="report-icon" style="background:#F5F3FF;color:#7C3AED;">
                <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div style="font-size:16px;font-weight:700;color:#111827;">Rapport Financier</div>
                <p style="font-size:13px;color:#6B7280;margin-top:4px;">Chiffre d'affaires, factures payées/impayées, coût moyen.</p>
            </div>
            <div style="margin-top:auto;padding-top:12px;border-top:1px solid #F3F4F6;">
                <span style="font-size:13px;color:#7C3AED;font-weight:600;">Consulter →</span>
            </div>
        </div>
    </div>

    <!-- Section en cours de développement -->
    <div class="coming-soon">
        <svg style="width:64px;height:64px;margin:0 auto 20px;color:#D1D5DB;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
        <h3 style="font-size:18px;font-weight:700;color:#374151;margin-bottom:8px;">Rapports détaillés — Bientôt disponible</h3>
        <p style="font-size:14px;color:#9CA3AF;max-width:500px;margin:0 auto;">Les rapports détaillés avec graphiques et exports PDF seront disponibles dans une prochaine mise à jour.</p>
    </div>

</x-app-layout>
