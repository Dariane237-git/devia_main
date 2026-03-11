<x-app-layout>
    <x-slot name="header">
        Gestion des Utilisateurs
    </x-slot>

    <style>
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(37, 99, 235, 0.3);
        }

        .table-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #E5E7EB;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        .table-list { width: 100%; border-collapse: collapse; }
        .table-list th {
            text-align: left;
            padding: 14px 24px;
            font-size: 12px;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
            background: #F9FAFB;
            border-bottom: 1px solid #E5E7EB;
        }
        .table-list td {
            padding: 16px 24px;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #F3F4F6;
            vertical-align: middle;
        }
        .table-list tr:hover td { background: #F9FAFB; }
        .table-list tr:last-child td { border-bottom: none; }

        .avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: #E5E7EB;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #4B5563; font-size: 14px;
            flex-shrink: 0;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
        }
        .badge-client { background: #F0FDF4; color: #16A34A; border: 1px solid #DCFCE7; }
        .badge-manager { background: #EFF6FF; color: #2563EB; border: 1px solid #DBEAFE; }
        .badge-tech { background: #FFF7ED; color: #EA580C; border: 1px solid #FFEDD5; }
        .badge-agent { background: #F5F3FF; color: #7C3AED; border: 1px solid #EDE9FE; }

        .action-link {
            color: #6B7280;
            transition: color 0.2s;
            display: inline-flex;
            padding: 6px;
            border-radius: 6px;
        }
        .action-link:hover { color: #2563EB; background: #EFF6FF; }
    </style>

    <div class="page-header">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 4px;">Équipe et Clients</h2>
            <p style="color: #6B7280; font-size: 14px;">Gérez l'ensemble des utilisateurs de l'application DEVIA-MAINT.</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn-primary">
            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter un utilisateur
        </a>
    </div>

    @if (session('success'))
        <div style="background:#DCFCE7;border:1px solid #86EFAC;color:#166534;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @php
        $roleFamilies = [
            [
                'title' => 'Direction & Responsables',
                'description' => 'Gestionnaires de l\'application et superviseurs',
                'items' => $users->where('id_role', 3),
                'badge' => 'badge-manager'
            ],
            [
                'title' => 'Agents d\'Accueil',
                'description' => 'Première ligne de contact, réception de matériel',
                'items' => $users->where('id_role', 2),
                'badge' => 'badge-agent'
            ],
            [
                'title' => 'Équipe Technique',
                'description' => 'Techniciens chargés des interventions et réparations',
                'items' => $users->where('id_role', 4),
                'badge' => 'badge-tech'
            ],
            [
                'title' => 'Clients',
                'description' => 'Entreprises et particuliers bénéficiaires des services',
                'items' => $users->where('id_role', 1),
                'badge' => 'badge-client'
            ]
        ];
    @endphp

    @foreach($roleFamilies as $family)
    <div style="margin-bottom: 32px;">
        <div style="margin-bottom: 12px; padding-left: 8px; border-left: 4px solid #DFE4EA;">
            <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0;">{{ $family['title'] }} <span style="font-size: 14px; font-weight: 500; color: #6B7280; margin-left:8px; background: #F3F4F6; padding: 2px 8px; border-radius: 9999px;">{{ $family['items']->count() }}</span></h3>
            <p style="font-size: 13px; color: #6B7280; margin-top: 4px;">{{ $family['description'] }}</p>
        </div>

        <div class="table-card" style="overflow-x:auto;">
            <table class="table-list">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Contact</th>
                        <th>Rôle</th>
                        <th>Date d'inscription</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($family['items'] as $user)
                    <tr>
                        <td style="width: 30%;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div class="avatar">
                                    {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;color:#111827;">{{ $user->prenom }} {{ $user->nom }}</div>
                                    <div style="font-size:12px;color:#6B7280;">ID: {{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="width: 25%;">
                            <div style="font-size:14px;color:#374151;display:flex;align-items:center;gap:6px;">
                                <svg style="width:14px;height:14px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ $user->email }}
                            </div>
                            @if($user->tel)
                            <div style="font-size:12.5px;color:#6B7280;display:flex;align-items:center;gap:6px;margin-top:4px;">
                                <svg style="width:14px;height:14px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $user->tel }}
                            </div>
                            @endif
                        </td>
                        <td style="width: 15%;">
                            @php $roleName = $user->role->nom_role ?? 'Inconnu'; @endphp
                            <span class="badge {{ $family['badge'] }}">{{ $roleName }}</span>
                        </td>
                        <td style="width: 15%;">
                            <div style="color:#4B5563;font-size:13px;">{{ $user->created_at ? $user->created_at->format('d M Y') : 'Date inconnue' }}</div>
                        </td>
                        <td style="text-align:right; width: 15%;">
                            <div style="display:flex;align-items:center;justify-content:flex-end;gap:4px;">
                                <!-- Edit -->
                                <a href="{{ route('users.edit', $user->id) }}" class="action-link" title="Modifier">
                                    <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <!-- Delete -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Souhaitez-vous vraiment supprimer définitivement cet utilisateur ? Cette action est irréversible.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-link" style="border:none;background:none;cursor:pointer;color:#EF4444;" title="Supprimer">
                                        <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:24px;color:#9CA3AF;font-size:14px;background:#FDFDFD;">
                            Aucun compte n'a encore été créé dans la catégorie <strong>{{ $family['title'] }}</strong>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

</x-app-layout>
