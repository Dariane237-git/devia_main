<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: 600; color: #1F2937; margin: 0;">
            {{ __('Gestion des Matériels') }}
        </h2>
    </x-slot>

    <style>
        .page-container { padding: 32px; max-width: 1200px; margin: 0 auto; }
        .card { background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 24px; border: 1px solid #E5E7EB; }
        .flex-between { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .title { font-size: 18px; font-weight: 700; color: #111827; }
        
        /* Boutons */
        .btn-primary { 
            background: linear-gradient(135deg, #2563EB, #10B981); 
            color: white; padding: 10px 20px; border-radius: 10px; 
            font-weight: 600; font-size: 14px; text-decoration: none; 
            display: inline-flex; align-items: center; gap: 8px; 
            transition: transform 0.2s; border: none; cursor: pointer;
        }
        .btn-primary:hover { transform: translateY(-1px); }
        .btn-edit { color: #2563EB; background: #EFF6FF; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; transition: background 0.2s;}
        .btn-edit:hover { background: #DBEAFE; }
        .btn-delete { color: #DC2626; background: #FEF2F2; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 13px; font-weight: 500; transition: background 0.2s;}
        .btn-delete:hover { background: #FEE2E2; }
        
        /* Table */
        .table-container { overflow-x: auto; }
        .custom-table { width: 100%; text-align: left; border-collapse: collapse; }
        .custom-table th { padding: 12px 24px; background: #F9FAFB; color: #6B7280; font-size: 12px; text-transform: uppercase; font-weight: 600; border-bottom: 1px solid #E5E7EB; }
        .custom-table td { padding: 16px 24px; border-bottom: 1px solid #F3F4F6; color: #374151; font-size: 14px; }
        .custom-table tr:hover td { background: #F9FAFB; }
        
        .badge { background: #F3F4F6; color: #374151; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 500; border: 1px solid #E5E7EB; }
        .alert-success { background: #F0FDF4; border: 1px solid #DCFCE7; color: #16A34A; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; font-weight: 500; }
        .empty-state { text-align: center; padding: 48px 24px; color: #6B7280; }
    </style>

    <div class="page-container">
        <div class="card">
            <div class="flex-between">
                <h3 class="title">Liste des Matériels Enregistrés</h3>
                <a href="{{ route('materiels.create') }}" class="btn-primary">
                    <svg style="width:20px; height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Enregistrer un matériel
                </a>
            </div>

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Client Propriétaire</th>
                            <th>Matériel</th>
                            <th>Marque / Modèle</th>

                            <th>Garantie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materiels as $mat)
                            <tr>
                                <td style="font-weight: 700; color: #111827;">
                                    {{ $mat->client->utilisateur->nom ?? 'Inconnu' }} {{ $mat->client->utilisateur->prenom ?? '' }}
                                </td>
                                <td style="font-weight: 500;">
                                    {{ $mat->nom }}
                                </td>
                                <td>
                                    {{ $mat->marque ?? '-' }} / {{ $mat->modele ?? '-' }}
                                </td>

                                <td>
                                    {{ $mat->garantie ?? '-' }}
                                </td>
                                <td>
                                    <div style="display: flex; gap: 8px;">
                                        <a href="{{ route('materiels.edit', $mat->id) }}" class="btn-edit">Modifier</a>
                                        <form action="{{ route('materiels.destroy', $mat->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce matériel ? Cette action est irréversible.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <svg style="width:48px;height:48px;color:#D1D5DB;margin:0 auto 12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <p style="font-size: 16px;">Aucun matériel enregistré dans le système.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
