<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: 600; color: #1F2937; margin: 0;">
            {{ __('Tickets Clients (Accueil)') }}
        </h2>
    </x-slot>

    <style>
        .page-container { padding: 32px; max-width: 1200px; margin: 0 auto; }
        
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-title { font-size: 24px; font-weight: 800; color: #111827; margin: 0; }
        .page-subtitle { color: #6B7280; font-size: 14px; margin-top: 4px; }
        
        .btn-primary { background: #2563EB; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; border: none; cursor: pointer; transition: background 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary:hover { background: #1D4ED8; }

        .table-container { background: white; border-radius: 16px; border: 1px solid #E5E7EB; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background: #F9FAFB; padding: 16px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; border-bottom: 1px solid #E5E7EB; }
        .data-table td { padding: 16px 24px; font-size: 14px; border-bottom: 1px solid #F3F4F6; vertical-align: middle; }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover { background-color: #F9FAFB; }

        .badge { padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; }
        .badge-gray { background: #F3F4F6; color: #374151; }
        .badge-blue { background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE; }
        .badge-orange { background: #FFF7ED; color: #EA580C; border: 1px solid #FED7AA; }
        .badge-green { background: #F0FDF4; color: #16A34A; border: 1px solid #BBF7D0; }
        .badge-red { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        
        .client-info { font-weight: 600; color: #111827; display: block; }
        .client-sub { font-size: 12px; color: #6B7280; }
        
        .action-link { color: #2563EB; font-weight: 500; text-decoration: none; font-size: 14px; padding: 6px 12px; border-radius: 6px; transition: background 0.2s; }
        .action-link:hover { background: #EFF6FF; }
    </style>

    <div class="page-container">
        
        @if(session('success'))
            <div style="background: #F0FDF4; border: 1px solid #BBF7D0; color: #16A34A; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-weight: 500;">
                {{ session('success') }}
            </div>
        @endif

        <div class="header-actions">
            <div>
                <h1 class="page-title">Gestion des Réceptions</h1>
                <p class="page-subtitle">Consultez tous les tickets déclarés et enregistrez-en de nouveaux pour les clients au comptoir.</p>
            </div>
            <a href="{{ route('agent_accueil.tickets.create') }}" class="btn-primary">
                <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Déclarer une panne (Comptoir)
            </a>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>N° Ticket</th>
                        <th>Client</th>
                        <th>Matériel</th>
                        <th>Date Déclaration</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td style="font-weight:700; color:#2563EB;">#TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <span class="client-info">{{ $ticket->client->utilisateur->prenom ?? '' }} {{ $ticket->client->utilisateur->nom ?? 'Inconnu' }}</span>
                            @if($ticket->client && $ticket->client->entreprise)
                                <span class="client-sub">{{ $ticket->client->entreprise }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="client-info">{{ $ticket->materiel->nom ?? 'Non spécifié' }}</span>
                            <span class="client-sub">{{ $ticket->materiel->marque ?? '' }}</span>
                        </td>
                        <td style="color:#4B5563;">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if(in_array(strtolower($ticket->priorite), ['critique', 'haute']))
                                <span class="badge badge-red">🔴 {{ $ticket->priorite }}</span>
                            @elseif(strtolower($ticket->priorite) == 'moyenne')
                                <span class="badge badge-orange">🟠 {{ $ticket->priorite }}</span>
                            @else
                                <span class="badge badge-gray">🟡 {{ $ticket->priorite }}</span>
                            @endif
                        </td>
                        <td>
                            @if(strtolower($ticket->statut) == 'en attente')
                                <span class="badge badge-gray">⏳ {{ $ticket->statut }}</span>
                            @elseif(in_array(strtolower($ticket->statut), ['en cours', 'diagnostiqué']))
                                <span class="badge badge-blue">⚡ {{ $ticket->statut }}</span>
                            @else
                                <span class="badge badge-green">✔ {{ $ticket->statut }}</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="action-link">Voir détails</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 48px; color: #6B7280;">
                            Aucun ticket enregistré pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
