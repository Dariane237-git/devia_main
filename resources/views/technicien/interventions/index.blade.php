<x-app-layout>
    <x-slot name="header">
        Mes Interventions Assignées
    </x-slot>

    <style>
        .page-header {
            display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;
        }

        .table-card {
            background: white; border-radius: 16px; border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); overflow: hidden;
        }

        .table-list { width: 100%; border-collapse: collapse; }
        .table-list th {
            text-align: left; padding: 14px 24px; font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; background: #F9FAFB; border-bottom: 1px solid #E5E7EB;
        }
        .table-list td {
            padding: 16px 24px; font-size: 14px; color: #374151; border-bottom: 1px solid #F3F4F6; vertical-align: middle;
        }
        .table-list tr:hover td { background: #F9FAFB; }
        .table-list tr:last-child td { border-bottom: none; }

        .badge {
            padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;
        }
        .badge-encours { background: #FEF3C7; color: #D97706; border: 1px solid #FDE68A; }
        .badge-termine { background: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
        .badge-planifie { background: #E0E7FF; color: #4338CA; border: 1px solid #C7D2FE; }

        .btn-action {
            display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s;
        }
        .btn-action.primary {
            background: #EFF6FF; color: #2563EB; border: 1px solid transparent;
        }
        .btn-action.primary:hover { background: #DBEAFE; border-color: #BFDBFE; }
        
        .btn-action.secondary {
            background: white; color: #4B5563; border: 1px solid #D1D5DB;
        }
        .btn-action.secondary:hover { background: #F3F4F6; color: #111827; }
    </style>

    <div class="page-header">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 4px;">Toutes mes interventions</h2>
            <p style="color: #6B7280; font-size: 14px;">La liste complète des pannes qui vous ont été assignées.</p>
        </div>
    </div>

    @if (session('success'))
        <div style="background:#DCFCE7;border:1px solid #86EFAC;color:#166534;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card" style="overflow-x:auto;">
        <table class="table-list">
            <thead>
                <tr>
                    <th>Ticket & Client</th>
                    <th>Matériel</th>
                    <th>Date Planifiée</th>
                    <th>Statut</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($interventions as $intervention)
                    <tr>
                        <td style="width: 25%;">
                            <div style="font-weight:700;color:#111827;margin-bottom:4px;">#TKT-{{ str_pad($intervention->devis->ticket->id, 4, '0', STR_PAD_LEFT) }}</div>
                            <div style="display:flex;align-items:center;gap:6px;color:#4B5563;font-size:13px;">
                                <svg style="width:14px;height:14px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ $intervention->devis->ticket->client->utilisateur->prenom }} {{ $intervention->devis->ticket->client->utilisateur->nom }}
                            </div>
                        </td>
                        
                        <td style="width: 25%;">
                            <div style="font-weight:600;color:#374151;">{{ $intervention->devis->ticket->materiel->marque }} {{ $intervention->devis->ticket->materiel->modele }}</div>
                            <div style="font-size:12px;color:#6B7280;margin-top:2px;">Type: {{ $intervention->devis->ticket->materiel->categorie ?? 'Non spécifié' }}</div>
                        </td>

                        <td style="width: 20%;">
                            <div style="display:flex;align-items:center;gap:6px;color:#4B5563;">
                                <svg style="width:16px;height:16px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $intervention->date_debut ? \Carbon\Carbon::parse($intervention->date_debut)->format('d M Y') : 'Non définie' }}
                            </div>
                        </td>

                        <td style="width: 15%;">
                            @if($intervention->statut == 'Terminé')
                                <span class="badge badge-termine">
                                    <svg style="width:12px;height:12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Terminé
                                </span>
                            @elseif($intervention->statut == 'En cours')
                                <span class="badge badge-encours">
                                    <span style="width:6px;height:6px;border-radius:50%;background:#D97706;"></span>
                                    En cours
                                </span>
                            @else
                                <span class="badge badge-planifie">
                                    <svg style="width:12px;height:12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Planifié
                                </span>
                            @endif
                        </td>

                        <td style="text-align:right; width: 15%;">
                            @if($intervention->statut == 'Terminé')
                                <a href="{{ route('technicien.interventions.show', $intervention->id) }}" class="btn-action secondary">Consulter le rapport</a>
                            @else
                                <a href="{{ route('technicien.interventions.show', $intervention->id) }}" class="btn-action primary">Traiter</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:48px 24px;color:#6B7280;">
                            <div style="width:64px;height:64px;background:#F3F4F6;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px auto;">
                                <svg style="width:32px;height:32px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <h3 style="font-size:16px;font-weight:600;color:#111827;margin:0 0 4px 0;">Aucune intervention</h3>
                            <p style="font-size:14px;margin:0;">Vous n'avez actuellement aucune intervention assignée.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-app-layout>
