<x-app-layout>
    <x-slot name="header">
        Gestion des Tickets
    </x-slot>

    <style>
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .table-card { background: white; border-radius: 16px; border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); overflow: hidden; }
        .table-list { width: 100%; border-collapse: collapse; }
        .table-list th { text-align: left; padding: 14px 24px; font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; background: #F9FAFB; border-bottom: 1px solid #E5E7EB; }
        .table-list td { padding: 16px 24px; font-size: 14px; color: #374151; border-bottom: 1px solid #F3F4F6; vertical-align: middle; }
        .table-list tr:hover td { background: #F9FAFB; }
        .table-list tr:last-child td { border-bottom: none; }
        .badge { padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; }
        .badge-new { background: #EFF6FF; color: #2563EB; border: 1px solid #DBEAFE; }
        .badge-assigned { background: #F5F3FF; color: #7C3AED; border: 1px solid #EDE9FE; }
        .badge-progress { background: #FFF7ED; color: #EA580C; border: 1px solid #FFEDD5; }
        .badge-done { background: #F0FDF4; color: #16A34A; border: 1px solid #DCFCE7; }
        .badge-rejected { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .badge-high { background: #FEE2E2; color: #DC2626; }
        .badge-medium { background: #FEF3C7; color: #D97706; }
        .badge-low { background: #E0F2FE; color: #0284C7; }
        .action-link { color: #6B7280; transition: color 0.2s; display: inline-flex; padding: 6px; border-radius: 6px; text-decoration: none; }
        .action-link:hover { color: #2563EB; background: #EFF6FF; }
        .btn-assign { padding: 6px 14px; background: #2563EB; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; color: white; cursor: pointer; transition: background 0.2s; }
        .btn-assign:hover { background: #1D4ED8; }
    </style>

    <div class="page-header">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 4px;">Gestion des Tickets</h2>
            <p style="color: #6B7280; font-size: 14px;">Visualisez, assignez et suivez l'évolution des pannes signalées.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#DCFCE7;border:1px solid #86EFAC;color:#166534;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card" style="overflow-x:auto;">
        <table class="table-list">
            <thead>
                <tr>
                    <th>Ticket</th>
                    <th>Client & Matériel</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                <tr>
                    <td>
                        <div style="font-weight:600;color:#111827;">#TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</div>
                        <div style="font-size:12px;color:#6B7280;margin-top:4px;">{{ $ticket->created_at ? $ticket->created_at->format('d/m/Y') : 'Date inconnue' }}</div>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:40px;height:40px;background:#EFF6FF;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#2563EB;font-weight:600;font-size:14px;">
                                {{ substr($ticket->client->utilisateur->prenom ?? 'C', 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight:600;color:#111827;font-size:14px;">{{ $ticket->client->utilisateur->prenom ?? '' }} {{ $ticket->client->utilisateur->nom ?? 'Client Inconnu' }}</div>
                                <div style="font-size:12px;color:#6B7280;margin-top:2px;">{{ $ticket->materiel->nom ?? 'Matériel non spécifié' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @php
                            $prioBadge = match(strtolower($ticket->priorite ?? '')) {
                                'haute', 'critique' => 'badge-high',
                                'moyenne' => 'badge-medium',
                                default => 'badge-low'
                            };
                        @endphp
                        <span class="badge {{ $prioBadge }}">{{ $ticket->priorite }}</span>
                    </td>
                    <td>
                        @php
                            $statusBadge = match($ticket->statut) {
                                'Nouveau' => 'badge-new',
                                'Assigné' => 'badge-assigned',
                                'En cours' => 'badge-progress',
                                'Résolu', 'Clôturé' => 'badge-done',
                                'Rejeté' => 'badge-rejected',
                                default => 'badge-new'
                            };
                        @endphp
                        <span class="badge {{ $statusBadge }}">{{ $ticket->statut }}</span>
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:4px;">
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="action-link" title="Voir le détail">
                                <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @if($ticket->statut == 'Nouveau')
                            <div x-data="{ openAssign: false }" style="position:relative;">
                                <button @click="openAssign = !openAssign" class="btn-assign" title="Assigner">
                                    <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                </button>
                                <div x-show="openAssign" @click.away="openAssign = false" style="display:none;position:absolute;right:0;top:40px;width:280px;background:white;border-radius:12px;box-shadow:0 10px 25px rgba(0,0,0,0.1);border:1px solid #E5E7EB;z-index:50;padding:16px;text-align:left;">
                                    <div style="font-weight:600;font-size:14px;color:#111827;margin-bottom:12px;">Assigner un technicien</div>
                                    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="action" value="assign_technician">
                                        <select name="id_technicien" required style="width:100%;border:1px solid #E5E7EB;border-radius:8px;padding:10px;font-size:14px;background:#F9FAFB;margin-bottom:12px;">
                                            <option value="">Sélectionner...</option>
                                            @foreach($techniciens as $tech)
                                            <option value="{{ $tech->id }}">{{ $tech->utilisateur->prenom ?? '' }} {{ $tech->utilisateur->nom ?? '' }} — {{ $tech->specialite ?? 'Généraliste' }}</option>
                                            @endforeach
                                        </select>
                                        <div style="display:flex;gap:8px;">
                                            <button type="submit" class="btn-assign" style="flex:1;padding:8px;">Confirmer</button>
                                            <button type="button" @click="openAssign = false" style="flex:1;padding:8px;background:#F3F4F6;color:#4B5563;border:none;border-radius:8px;font-weight:600;cursor:pointer;">Annuler</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:40px;color:#9CA3AF;">
                        <svg style="width:48px;height:48px;margin:0 auto 16px;color:#D1D5DB;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        <div style="font-size:16px;font-weight:600;color:#374151;">Aucun ticket pour le moment</div>
                        <p style="font-size:14px;margin-top:4px;color:#9CA3AF;">Les tickets soumis apparaîtront ici.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-app-layout>
