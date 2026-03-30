<x-client-layout>
    <x-slot name="header">Mes Devis</x-slot>

    <style>
        .devis-container { background: white; border-radius: 16px; border: 1px solid #E5E7EB; overflow: hidden; }
        .devis-list { padding: 0; margin: 0; list-style: none; }
        .devis-item { padding: 24px; border-bottom: 1px solid #F3F4F6; transition: background 0.2s; }
        .devis-item:last-child { border-bottom: none; }
        .devis-item:hover { background: #F9FAFB; }
        .badge { padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; }
        .badge-orange { background: #FFF7ED; color: #EA580C; border: 1px solid #FFEDD5; }
        .badge-green { background: #F0FDF4; color: #16A34A; border: 1px solid #DCFCE7; }
        .badge-red { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .btn-accept { padding: 8px 16px; background: #16A34A; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 13px; }
        .btn-accept:hover { background: #15803D; }
        .btn-refuse { padding: 8px 16px; background: white; color: #DC2626; border: 1px solid #FECACA; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 13px; }
        .btn-refuse:hover { background: #FEF2F2; }
    </style>

    @if(session('success'))
    <div style="background:#F0FDF4;border:1px solid #DCFCE7;border-radius:12px;padding:16px;margin-bottom:20px;color:#16A34A;font-weight:600;display:flex;align-items:center;gap:8px;">
        <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div style="margin-bottom:24px;">
        <h2 style="font-size:24px;font-weight:800;color:#111827;">Mes Devis</h2>
        <p style="color:#6B7280;font-size:14px;">Consultez et validez les estimations de réparation.</p>
    </div>

    <div class="devis-container">
        <ul class="devis-list">
            @forelse($devis as $d)
            <li class="devis-item">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                    <div style="flex:1;">
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                            <span style="font-weight:700;color:#2563EB;font-size:15px;">Devis #{{ $d->id }}</span>
                            @if($d->statut == 'En attente')
                                <span class="badge badge-orange">⏳ En attente de votre réponse</span>
                            @elseif($d->statut == 'Validé')
                                <span class="badge badge-green">✅ Accepté</span>
                            @elseif($d->statut == 'Refusé')
                                <span class="badge badge-red">❌ Refusé</span>
                            @endif
                        </div>
                        <div style="font-size:14px;color:#374151;">
                            <strong>Matériel :</strong> {{ $d->ticket->materiel->nom ?? 'Non spécifié' }} —
                            <strong>Ticket :</strong> #TKT-{{ str_pad($d->ticket->id ?? 0, 4, '0', STR_PAD_LEFT) }}
                        </div>
                        <div style="font-size:14px;color:#374151;margin-top:4px;">
                            <strong>Date :</strong> {{ \Carbon\Carbon::parse($d->date_devis)->format('d/m/Y') }} —
                            <strong>Montant estimé :</strong> <span style="font-size:18px;font-weight:800;color:#111827;">{{ number_format($d->mont_estimer, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>

                    <div style="display:flex;gap:8px;align-items:center;">
                        <a href="{{ route('devis.pdf', $d->id) }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #D1D5DB; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 13px; text-decoration: none;">
                            📄 PDF
                        </a>
                        
                        @if($d->statut == 'En attente')
                        <form action="{{ route('client.devis.valider', $d->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-accept">✅ Accepter</button>
                        </form>
                        <form action="{{ route('client.devis.refuser', $d->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-refuse">❌ Refuser</button>
                        </form>
                        @endif
                    </div>
                </div>
            </li>
            @empty
            <li class="devis-item" style="text-align:center;padding:48px;color:#6B7280;">
                Aucun devis pour le moment. Les devis apparaîtront ici une fois que le responsable aura analysé vos tickets.
            </li>
            @endforelse
        </ul>
    </div>
</x-client-layout>
