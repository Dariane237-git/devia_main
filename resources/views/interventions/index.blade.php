<x-app-layout>
    <x-slot name="header">
        Planning des Interventions
    </x-slot>

    <style>
        .planning-container { background: white; border-radius: 16px; border: 1px solid #E5E7EB; overflow: hidden; }
        .planning-table { width: 100%; border-collapse: collapse; }
        .planning-table th { background: #F9FAFB; padding: 16px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; border-bottom: 1px solid #E5E7EB; }
        .planning-table td { padding: 16px 24px; font-size: 14px; border-bottom: 1px solid #F3F4F6; }
        .badge { padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; }
        .badge-blue { background: #EFF6FF; color: #2563EB; border: 1px solid #DBEAFE; }
        .badge-orange { background: #FFF7ED; color: #EA580C; border: 1px solid #FFEDD5; }
        .badge-green { background: #F0FDF4; color: #16A34A; border: 1px solid #DCFCE7; }
    </style>

    <div style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #111827;">Planning & Interventions</h2>
            <p style="color: #6B7280; font-size: 14px;">Suivez le déroulement des réparations sur le terrain.</p>
        </div>
        <a href="{{ route('interventions.create') }}" style="padding: 10px 20px; background: #2563EB; color: white; border-radius: 10px; font-weight: 600; text-decoration: none; cursor: pointer;">
            Nouvelle Intervention
        </a>
    </div>

    <div class="planning-container">
        <table class="planning-table">
            <thead>
                <tr>
                    <th>Technicien</th>
                    <th>Ticket / Client</th>
                    <th>Début Prévu</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($interventions as $intervention)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #111827;">{{ $intervention->technicien->utilisateur->prenom ?? '' }} {{ $intervention->technicien->utilisateur->nom ?? 'Inconnu' }}</div>
                        <div style="font-size: 12px; color: #6B7280;">{{ $intervention->technicien->specialite ?? 'Technicien' }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #111827;">#TKT-{{ str_pad($intervention->devis->id_ticket ?? 0, 4, '0', STR_PAD_LEFT) }}</div>
                        <div style="font-size: 12px; color: #6B7280;">{{ $intervention->devis->ticket->client->utilisateur->nom ?? 'Client' }}</div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($intervention->date_debut)->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($intervention->statut == 'En cours')
                            <span class="badge badge-orange">⚡ {{ $intervention->statut }}</span>
                        @elseif($intervention->statut == 'Terminée')
                            <span class="badge badge-green">✔ {{ $intervention->statut }}</span>
                        @else
                            <span class="badge badge-blue">📅 {{ $intervention->statut }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="#" style="color: #2563EB; font-weight: 600; text-decoration: none;">Détails</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 48px; color: #6B7280;">
                        Observez ici vos futures interventions. Aucune donnée pour le moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
