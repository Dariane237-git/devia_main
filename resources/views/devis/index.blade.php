<x-app-layout>
    <x-slot name="header">
        Gestion des Devis
    </x-slot>

    <style>
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .table-card { background: white; border-radius: 16px; border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); overflow: hidden; }
        .table-list { width: 100%; border-collapse: collapse; }
        .table-list th { text-align: left; padding: 14px 24px; font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; background: #F9FAFB; border-bottom: 1px solid #E5E7EB; }
        .table-list td { padding: 16px 24px; font-size: 14px; color: #374151; border-bottom: 1px solid #F3F4F6; vertical-align: middle; }
        .table-list tr:hover td { background: #F9FAFB; }
        .table-list tr:last-child td { border-bottom: none; }
        .badge { padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-flex; }
        .badge-waiting { background: #FEF3C7; color: #D97706; border: 1px solid #FFEDD5; }
        .badge-accepted { background: #F0FDF4; color: #16A34A; border: 1px solid #DCFCE7; }
        .badge-refused { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .action-link { color: #6B7280; transition: color 0.2s; display: inline-flex; padding: 6px; border-radius: 6px; text-decoration: none; }
        .action-link:hover { color: #2563EB; background: #EFF6FF; }
    </style>

    <div class="page-header">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 4px;">Devis</h2>
            <p style="color: #6B7280; font-size: 14px;">Consultez et gérez les devis de réparation.</p>
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
                    <th>N° Devis</th>
                    <th>Client</th>
                    <th>Ticket associé</th>
                    <th>Montant estimé</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($devis as $d)
                <tr>
                    <td style="font-weight:600;color:#111827;">#DEV-{{ str_pad($d->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        @if($d->ticket && $d->ticket->client && $d->ticket->client->utilisateur)
                            {{ $d->ticket->client->utilisateur->prenom }} {{ $d->ticket->client->utilisateur->nom }}
                        @else
                            <span style="color:#9CA3AF;">Client inconnu</span>
                        @endif
                    </td>
                    <td>
                        @if($d->ticket)
                            <span style="color:#2563EB;font-weight:500;">#TKT-{{ str_pad($d->ticket->id, 4, '0', STR_PAD_LEFT) }}</span>
                        @else
                            —
                        @endif
                    </td>
                    <td style="font-weight:600;">{{ number_format($d->mont_estimer, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @php
                            $statBadge = match($d->statut) {
                                'Accepté' => 'badge-accepted',
                                'Refusé' => 'badge-refused',
                                default => 'badge-waiting'
                            };
                        @endphp
                        <span class="badge {{ $statBadge }}">{{ $d->statut }}</span>
                    </td>
                    <td style="color:#6B7280;font-size:13px;">{{ $d->date_devis ? \Carbon\Carbon::parse($d->date_devis)->format('d/m/Y') : '—' }}</td>
                    <td style="text-align:right;">
                        <a href="{{ route('devis.show', $d->id) }}" class="action-link" title="Voir le détail">
                            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        @if($d->statut == 'Validé')
                            @if(!$d->intervention)
                                <a href="{{ route('interventions.create', ['devis' => $d->id]) }}" class="badge badge-green" style="text-decoration:none; padding: 6px 12px; font-weight:700;">
                                    👉 Assigner un Technicien
                                </a>
                            @else
                                <span style="font-size:12px; color:#10B981; font-weight:600;">Intervention Planifiée</span>
                            @endif
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px;color:#9CA3AF;">
                        <svg style="width:48px;height:48px;margin:0 auto 16px;color:#D1D5DB;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <div style="font-size:16px;font-weight:600;color:#374151;">Aucun devis pour le moment</div>
                        <p style="font-size:14px;margin-top:4px;">Les devis apparaîtront ici une fois créés.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-app-layout>
