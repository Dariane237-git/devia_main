<x-client-layout>
    <x-slot name="header">Mes Tickets</x-slot>

    <style>
        .tickets-container { background: white; border-radius: 16px; border: 1px solid #E5E7EB; overflow: hidden; }
        .tickets-table { width: 100%; border-collapse: collapse; }
        .tickets-table th { background: #F9FAFB; padding: 14px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; border-bottom: 1px solid #E5E7EB; }
        .tickets-table td { padding: 16px 24px; font-size: 14px; border-bottom: 1px solid #F3F4F6; }
        .tickets-table tr:hover td { background: #F9FAFB; }
        .badge { padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; }
        .badge-blue { background: #EFF6FF; color: #2563EB; border: 1px solid #DBEAFE; }
        .badge-orange { background: #FFF7ED; color: #EA580C; border: 1px solid #FFEDD5; }
        .badge-green { background: #F0FDF4; color: #16A34A; border: 1px solid #DCFCE7; }
        .badge-red { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .btn-primary { padding: 10px 20px; background: linear-gradient(135deg, #2563EB, #10B981); border: none; border-radius: 10px; font-weight: 600; color: white; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
    </style>

    @if(session('success'))
    <div style="background:#F0FDF4;border:1px solid #DCFCE7;border-radius:12px;padding:16px;margin-bottom:20px;color:#16A34A;font-weight:600;display:flex;align-items:center;gap:8px;">
        <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div style="margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h2 style="font-size:24px;font-weight:800;color:#111827;">Mes Tickets</h2>
            <p style="color:#6B7280;font-size:14px;">Suivez l'avancement de vos demandes de réparation.</p>
        </div>
        <a href="{{ route('client.tickets.create') }}" class="btn-primary">
            <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nouveau ticket
        </a>
    </div>

    <div class="tickets-container">
        <table class="tickets-table">
            <thead>
                <tr>
                    <th>N° Ticket</th>
                    <th>Matériel</th>
                    <th>Description</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                <tr>
                    <td style="font-weight:700;color:#2563EB;">#TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $ticket->materiel->nom ?? 'Non spécifié' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($ticket->description_panne, 40) }}</td>
                    <td>
                        @if(in_array(strtolower($ticket->priorite), ['critique', 'haute']))
                            <span class="badge badge-red">{{ $ticket->priorite }}</span>
                        @elseif(strtolower($ticket->priorite) == 'moyenne')
                            <span class="badge badge-orange">{{ $ticket->priorite }}</span>
                        @else
                            <span class="badge badge-blue">{{ $ticket->priorite }}</span>
                        @endif
                    </td>
                    <td>
                        @if($ticket->statut == 'Nouveau')
                            <span class="badge badge-blue">📋 {{ $ticket->statut }}</span>
                        @elseif(in_array($ticket->statut, ['Assigné', 'En cours']))
                            <span class="badge badge-orange">⚡ {{ $ticket->statut }}</span>
                        @elseif(in_array($ticket->statut, ['Résolu', 'Clôturé']))
                            <span class="badge badge-green">✅ {{ $ticket->statut }}</span>
                        @else
                            <span class="badge badge-red">{{ $ticket->statut }}</span>
                        @endif
                    </td>
                    <td style="color:#6B7280;font-size:13px;">{{ $ticket->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:48px;color:#6B7280;">
                        Aucun ticket pour le moment.
                        <a href="{{ route('client.tickets.create') }}" style="color:#2563EB;font-weight:600;text-decoration:none;"> Déclarer une panne →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-client-layout>
