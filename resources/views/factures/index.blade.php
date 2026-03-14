<x-app-layout>
    <x-slot name="header">
        Gestion des Factures
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
        .badge-paid { background: #F0FDF4; color: #16A34A; border: 1px solid #DCFCE7; }
        .badge-pending { background: #FEF3C7; color: #D97706; border: 1px solid #FFEDD5; }
        .action-link { color: #6B7280; transition: color 0.2s; display: inline-flex; padding: 6px; border-radius: 6px; text-decoration: none; }
        .action-link:hover { color: #2563EB; background: #EFF6FF; }
    </style>

    <div class="page-header">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 4px;">Factures</h2>
            <p style="color: #6B7280; font-size: 14px;">Consultez et suivez les factures émises.</p>
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
                    <th>N° Facture</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Montant Total</th>
                    <th>Paiement</th>
                    <th>Date d'émission</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($factures as $facture)
                <tr>
                    <td style="font-weight:600;color:#111827;">{{ $facture->numero_fac }}</td>
                    <td>
                        @if($facture->devis && $facture->devis->ticket && $facture->devis->ticket->client && $facture->devis->ticket->client->utilisateur)
                            {{ $facture->devis->ticket->client->utilisateur->prenom }} {{ $facture->devis->ticket->client->utilisateur->nom }}
                        @else
                            <span style="color:#9CA3AF;">Client inconnu</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-size:13px;color:#4B5563;">{{ $facture->type_fac }}</span>
                    </td>
                    <td style="font-weight:600;">{{ number_format($facture->mont_total, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($facture->statut_paiement == 'Payée')
                            <span class="badge badge-paid">✅ Payée</span>
                        @else
                            <span class="badge badge-pending">⏳ En attente</span>
                        @endif
                    </td>
                    <td style="color:#6B7280;font-size:13px;">{{ $facture->date_emission ? \Carbon\Carbon::parse($facture->date_emission)->format('d/m/Y') : '—' }}</td>
                    <td style="text-align:right;">
                        <a href="{{ route('factures.show', $facture->id) }}" class="action-link" title="Voir le détail">
                            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px;color:#9CA3AF;">
                        <svg style="width:48px;height:48px;margin:0 auto 16px;color:#D1D5DB;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <div style="font-size:16px;font-weight:600;color:#374151;">Aucune facture pour le moment</div>
                        <p style="font-size:14px;margin-top:4px;">Les factures apparaîtront ici une fois émises.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-app-layout>
