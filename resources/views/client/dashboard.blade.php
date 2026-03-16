<x-client-layout>
    <x-slot name="header">
        Mon Tableau de Bord
    </x-slot>

    <style>
        .client-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px; }
        @media (max-width: 900px) { .client-grid { grid-template-columns: 1fr; } }
        .stat-card {
            background: white; border-radius: 16px; padding: 24px;
            border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            display: flex; align-items: flex-start; justify-content: space-between;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .stat-value { font-size: 28px; font-weight: 800; color: #111827; margin-bottom: 4px; line-height: 1; }
        .stat-label { font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.05em; }

        .section-card { background: white; border-radius: 16px; border: 1px solid #E5E7EB; overflow: hidden; }
        .section-header { padding: 20px 24px; border-bottom: 1px solid #F3F4F6; display: flex; align-items: center; justify-content: space-between; background: #FDFDFD; }
        .section-title { font-size: 16px; font-weight: 700; color: #111827; display: flex; align-items: center; gap: 8px; }

        .ticket-list { padding: 0; margin: 0; list-style: none; }
        .ticket-item { display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; border-bottom: 1px solid #F3F4F6; transition: background 0.2s; }
        .ticket-item:last-child { border-bottom: none; }
        .ticket-item:hover { background: #F9FAFB; }
        .badge { padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; }
        .badge-blue { background: #EFF6FF; color: #2563EB; border: 1px solid #DBEAFE; }
        .badge-orange { background: #FFF7ED; color: #EA580C; border: 1px solid #FFEDD5; }
        .badge-green { background: #F0FDF4; color: #16A34A; border: 1px solid #DCFCE7; }
        .badge-red { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .badge-gray { background: #F3F4F6; color: #6B7280; border: 1px solid #E5E7EB; }

        .btn-primary {
            padding: 12px 24px; background: linear-gradient(135deg, #2563EB, #10B981);
            border: none; border-radius: 12px; font-weight: 700; color: white;
            cursor: pointer; transition: transform 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-primary:hover { transform: translateY(-1px); }
    </style>

    <!-- Bienvenue -->
    <div style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #111827;">Bonjour, {{ Auth::user()->prenom }} 👋</h2>
            <p style="color: #6B7280; font-size: 14px;">Bienvenue sur votre espace de suivi de maintenance.</p>
        </div>
        <a href="{{ route('client.tickets.create') }}" class="btn-primary">
            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Déclarer une panne
        </a>
    </div>

    <!-- Statistiques -->
    <div class="client-grid">
        <div class="stat-card">
            <div>
                <div class="stat-label">Tickets en cours</div>
                <div class="stat-value">{{ $stats['tickets_en_cours'] }}</div>
            </div>
            <div class="stat-icon" style="background: #DBEAFE; color: #2563EB;">
                <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <div class="stat-label">Devis en attente</div>
                <div class="stat-value">{{ $stats['devis_en_attente'] }}</div>
            </div>
            <div class="stat-icon" style="background: #D1FAE5; color: #059669;">
                <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <div class="stat-label">Mes matériels</div>
                <div class="stat-value">{{ $stats['mes_materiels'] }}</div>
            </div>
            <div class="stat-icon" style="background: #DBEAFE; color: #2563EB;">
                <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Derniers Tickets -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title">
                <svg style="width:20px;height:20px;color:#2563EB;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Mes derniers tickets
            </h3>
            <a href="{{ route('client.tickets.index') }}" style="font-size:13px;font-weight:600;color:#2563EB;text-decoration:none;">Voir tout →</a>
        </div>
        <ul class="ticket-list">
            @forelse($mesTickets as $ticket)
            <li class="ticket-item">
                <div style="display:flex;align-items:center;gap:16px;">
                    <div style="width:40px;height:40px;background:#DBEAFE;border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:700;color:#2563EB;font-size:12px;">
                        #{{ $ticket->id }}
                    </div>
                    <div>
                        <div style="font-weight:600;color:#111827;">{{ $ticket->materiel->nom ?? 'Matériel' }} - {{ $ticket->materiel->marque ?? '' }}</div>
                        <div style="font-size:12px;color:#6B7280;">{{ \Illuminate\Support\Str::limit($ticket->description_panne, 50) }}</div>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($ticket->statut == 'Nouveau')
                        <span class="badge badge-blue">📋 Nouveau</span>
                    @elseif($ticket->statut == 'Assigné')
                        <span class="badge badge-orange">⚡ Assigné</span>
                    @elseif($ticket->statut == 'En cours')
                        <span class="badge badge-orange">🔧 En cours</span>
                    @elseif($ticket->statut == 'Résolu' || $ticket->statut == 'Clôturé')
                        <span class="badge badge-green">✅ {{ $ticket->statut }}</span>
                    @elseif($ticket->statut == 'Rejeté')
                        <span class="badge badge-red">❌ {{ $ticket->statut }}</span>
                    @else
                        <span class="badge badge-gray">{{ $ticket->statut }}</span>
                    @endif
                    <span style="font-size:12px;color:#9CA3AF;">{{ $ticket->created_at->format('d/m/Y') }}</span>
                </div>
            </li>
            @empty
            <li class="ticket-item" style="justify-content:center;padding:48px;">
                <div style="text-align:center;">
                    <svg style="width:48px;height:48px;color:#D1D5DB;margin:0 auto 12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p style="color:#6B7280;font-size:14px;">Vous n'avez pas encore de ticket.</p>
                    <a href="{{ route('client.tickets.create') }}" style="color:#2563EB;font-weight:600;text-decoration:none;font-size:14px;">Déclarer votre première panne →</a>
                </div>
            </li>
            @endforelse
        </ul>
    </div>
</x-client-layout>
