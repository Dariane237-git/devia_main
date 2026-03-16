<x-app-layout>
    <x-slot name="header">
        Mon Espace Technicien
    </x-slot>

    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #E5E7EB;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
        }

        .icon-blue { background: #EFF6FF; color: #2563EB; }
        .icon-green { background: #F0FDF4; color: #16A34A; }

        .stat-info span {
            display: block;
            font-size: 14px;
            color: #6B7280;
            font-weight: 500;
        }

        .stat-info h3 {
            font-size: 28px;
            font-weight: 800;
            color: #111827;
            margin: 4px 0 0 0;
            line-height: 1;
        }

        .section-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #E5E7EB;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .section-header {
            padding: 20px 24px;
            border-bottom: 1px solid #E5E7EB;
            background: #F9FAFB;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-header h3 {
            font-size: 16px; font-weight: 700; color: #111827; margin: 0;
        }

        .btn-link {
            font-size: 14px; color: #2563EB; font-weight: 600; text-decoration: none;
        }
        .btn-link:hover { text-decoration: underline; }

        .table-list { width: 100%; border-collapse: collapse; }
        .table-list th {
            text-align: left; padding: 12px 24px; font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; border-bottom: 1px solid #E5E7EB; background: white;
        }
        .table-list td {
            padding: 16px 24px; font-size: 14px; color: #374151; border-bottom: 1px solid #F3F4F6;
        }
        .table-list tr:hover td { background: #F9FAFB; }

        .badge {
            padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-flex;
        }
        .badge-encours { background: #FEF3C7; color: #D97706; }
    </style>

    <div class="mb-8">
        <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 4px;">Bonjour, {{ Auth::user()->prenom }} ! 👋</h2>
        <p style="color: #6B7280; font-size: 15px;">Voici le résumé de vos interventions en cours.</p>
    </div>

    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <svg style="width:28px;height:28px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span>Interventions en cours</span>
                <h3>{{ $stats['interventions_en_cours'] }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-green">
                <svg style="width:28px;height:28px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span>Interventions terminées</span>
                <h3>{{ $stats['interventions_terminees'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Dernières interventions -->
    <div class="section-card">
        <div class="section-header">
            <h3>Pannes actuellement en cours de traitement</h3>
            <a href="{{ route('technicien.interventions.index') }}" class="btn-link">Voir tout →</a>
        </div>
        
        <div style="overflow-x:auto;">
            <table class="table-list">
                <thead>
                    <tr>
                        <th>N° Ticket</th>
                        <th>Client</th>
                        <th>Matériel</th>
                        <th>Date Planifiée</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentesInterventions as $intervention)
                        <tr>
                            <td style="font-weight:600;">#TKT-{{ str_pad($intervention->devis->ticket->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div>{{ $intervention->devis->ticket->client->utilisateur->prenom }} {{ $intervention->devis->ticket->client->utilisateur->nom }}</div>
                                <div style="font-size:12px;color:#6B7280;">{{ $intervention->devis->ticket->client->utilisateur->tel ?? 'Aucun tél' }}</div>
                            </td>
                            <td>
                                <div>{{ $intervention->devis->ticket->materiel->marque }} {{ $intervention->devis->ticket->materiel->modele }}</div>
                                <div style="font-size:12px;color:#6B7280;">S/N: {{ $intervention->devis->ticket->materiel->num_serie }}</div>
                            </td>
                            <td>{{ $intervention->date_debut ? \Carbon\Carbon::parse($intervention->date_debut)->format('d M Y') : 'Non définie' }}</td>
                            <td>
                                <a href="{{ route('technicien.interventions.show', $intervention->id) }}" style="color:#2563EB;text-decoration:none;font-size:13px;font-weight:600;display:inline-flex;align-items:center;gap:4px;padding:6px 12px;background:#EFF6FF;border-radius:6px;transition:all 0.2s;">
                                    Gérer
                                    <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:32px;color:#6B7280;">
                                <svg style="width:48px;height:48px;margin:0 auto 12px auto;color:#D1D5DB;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Vous n'avez aucune intervention en cours pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
