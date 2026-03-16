<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; align-items:center; gap:12px;">
            <a href="{{ route('technicien.interventions.index') }}" style="color:#6B7280; text-decoration:none;">
                <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            Détail de l'intervention #{{ str_pad($intervention->id, 4, '0', STR_PAD_LEFT) }}
        </div>
    </x-slot>

    <style>
        .grid-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }
        @media (max-width: 1024px) {
            .grid-container { grid-template-columns: 1fr; }
        }

        .card {
            background: white; border-radius: 16px; border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); overflow: hidden; margin-bottom: 24px;
        }
        .card-header {
            padding: 16px 24px; border-bottom: 1px solid #E5E7EB; background: #F9FAFB; display: flex; align-items: center; justify-content: space-between;
        }
        .card-header h3 { font-size: 16px; font-weight: 700; color: #111827; margin: 0; display:flex; align-items:center; gap:8px; }
        .card-body { padding: 24px; }

        .info-group { margin-bottom: 16px; }
        .info-label { font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; margin-bottom: 4px; display: block; }
        .info-value { font-size: 14px; color: #111827; font-weight: 500; }

        .status-badge {
            padding: 6px 12px; border-radius: 9999px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;
        }
        .badge-encours { background: #FEF3C7; color: #D97706; border: 1px solid #FDE68A; }
        .badge-termine { background: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
        .badge-planifie { background: #E0E7FF; color: #4338CA; border: 1px solid #C7D2FE; }

        .problem-box {
            background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 12px; padding: 16px; color: #374151; font-size: 14px; line-height: 1.6;
        }

        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .form-textarea {
            width: 100%; padding: 12px; border: 1px solid #D1D5DB; border-radius: 10px; font-size: 14px; transition: all 0.2s; min-height: 150px; resize: vertical;
        }
        .form-textarea:focus { border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); outline: none; }

        .btn-submit {
            background: linear-gradient(135deg, #10B981, #059669); color: white; padding: 12px 24px; border-radius: 10px; font-size: 15px; font-weight: 600; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; width: 100%; justify-content: center; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 15px -3px rgba(16, 185, 129, 0.3); }
        .btn-submit:disabled { background: #9CA3AF; cursor: not-allowed; transform: none; box-shadow: none; }

        .btn-action {
            display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s; border: 1px solid transparent; cursor: pointer;
        }
        .btn-start { background: #E0F2FE; color: #0369A1; border-color: #BAE6FD; }
        .btn-start:hover { background: #BAE6FD; }
        .btn-pause { background: #F3F4F6; color: #374151; border-color: #D1D5DB; }
        .btn-pause:hover { background: #E5E7EB; }

        .piece-item {
            display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #F9FAFB; border-radius: 10px; margin-bottom: 8px; border: 1px solid #F3F4F6;
        }
        .piece-name { font-weight: 600; color: #111827; font-size: 14px; }
        .piece-qte { font-size: 12px; color: #6B7280; background: #EEF2FF; padding: 2px 8px; border-radius: 9999px; color: #4F46E5; }
    </style>

    <div class="grid-container">
        <!-- Colonne Principale (Gauche) -->
        <div>
            <!-- Description du Problème -->
            <div class="card">
                <div class="card-header">
                    <h3>
                        <svg style="width:20px;height:20px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Description de la panne #TKT-{{ str_pad($intervention->devis->ticket->id, 4, '0', STR_PAD_LEFT) }}
                    </h3>
                    @if($intervention->statut == 'Terminé')
                        <span class="status-badge badge-termine">Terminé</span>
                    @elseif($intervention->statut == 'En cours')
                        <span class="status-badge badge-encours">En cours</span>
                    @else
                        <span class="status-badge badge-planifie">En attente</span>
                    @endif
                </div>
                <div class="card-body">
                    @if($intervention->statut != 'Terminé')
                        <div style="display:flex; gap:12px; margin-bottom: 24px;">
                            @if($intervention->statut != 'En cours')
                                <form action="{{ route('technicien.interventions.demarrer', $intervention->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-action btn-start">
                                        <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Démarrer la réparation
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('technicien.interventions.suspendre', $intervention->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-action btn-pause">
                                        <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Mettre en pause
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                    <div class="info-group">
                        <span class="info-label">Date de déclaration</span>
                        <span class="info-value">{{ $intervention->devis->ticket->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                    <div class="problem-box">
                        {!! nl2br(e($intervention->devis->ticket->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Gestion des Pièces Détachées -->
            <div class="card">
                <div class="card-header">
                    <h3>
                        <svg style="width:20px;height:20px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Pièces Détachées Utilisées
                    </h3>
                </div>
                <div class="card-body">
                    @if($intervention->statut != 'Terminé')
                        <form action="{{ route('technicien.interventions.ajouter_piece', $intervention->id) }}" method="POST" style="display:grid; grid-template-columns: 2fr 1fr auto; gap:12px; margin-bottom:20px; background:#F9FAFB; padding:12px; border-radius:12px; border:1px solid #E5E7EB;">
                            @csrf
                            <div>
                                <select name="id_piece" class="form-textarea" style="min-height:auto; padding:8px;" required>
                                    <option value="">Choisir une pièce...</option>
                                    @foreach($piecesDisponibles as $p)
                                        <option value="{{ $p->id }}">{{ $p->nom }} ({{ number_format($p->pu, 0, ',', ' ') }} FCFA)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <input type="number" name="qte" value="1" min="1" class="form-textarea" style="min-height:auto; padding:8px;" required>
                            </div>
                            <button type="submit" class="btn-action btn-start" style="padding: 8px 12px; height: 38px;">
                                <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </form>
                    @endif

                    <div id="pieces-list">
                        @forelse($intervention->pieces as $piece)
                            <div class="piece-item">
                                <div>
                                    <div class="piece-name">{{ $piece->nom }}</div>
                                    <div style="font-size:12px; color:#6B7280;">PU: {{ number_format($piece->pu, 0, ',', ' ') }} FCFA</div>
                                </div>
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <span class="piece-qte">x{{ $piece->pivot->qte_reel_utiliser }}</span>
                                    @if($intervention->statut != 'Terminé')
                                        <form action="{{ route('technicien.interventions.retirer_piece', [$intervention->id, $piece->id]) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="background:none; border:none; color:#EF4444; cursor:pointer; padding:4px;">
                                                <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p style="text-align:center; color:#9CA3AF; font-size:14px; margin:20px 0;">Aucune pièce ajoutée pour le moment.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Rapport d'Intervention -->
            <div class="card">
                <div class="card-header">
                    <h3>
                        <svg style="width:20px;height:20px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Rapport d'Intervention
                    </h3>
                </div>
                <div class="card-body">
                    @if($intervention->statut == 'Terminé')
                        <div style="background: #F0FDF4; border: 1px solid #BBF7D0; padding: 20px; border-radius: 12px; color: #166534;">
                            <h4 style="font-weight:700; margin:0 0 12px 0; display:flex; align-items:center; gap:8px;">
                                <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Intervention Clôturée
                            </h4>
                            <p style="margin:0; font-size:14px; line-height:1.6; color:#065F46;">
                                {!! nl2br(e($intervention->rapport_intervention)) !!}
                            </p>
                        </div>
                    @else
                        <form action="{{ route('technicien.interventions.rapport', $intervention->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="rapport_intervention" class="form-label">Détails des réparations effectuées <span style="color:#EF4444;">*</span></label>
                                <textarea name="rapport_intervention" id="rapport_intervention" class="form-textarea" placeholder="Décrivez les actions menées pour résoudre la panne, les pièces changées, etc..." required>{{ old('rapport_intervention', $intervention->rapport_intervention) }}</textarea>
                                @error('rapport_intervention')
                                    <p style="color:#EF4444; font-size:12px; margin-top:4px;">{{ $message }}</p>
                                @enderror
                                <p style="font-size:12px; color:#6B7280; margin-top:8px;">Note: La soumission de ce rapport changera le statut de l'intervention à "Terminé" et résoudra le ticket client.</p>
                            </div>
                            
                            <button type="submit" class="btn-submit" onclick="return confirm('Êtes-vous sûr de vouloir clôturer cette intervention ? Cette action alertera le client.')">
                                <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Soumettre le rapport et Clôturer
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Colonne Secondaire (Droite) -->
        <div>
            <!-- Infos Client -->
            <div class="card">
                <div class="card-header">
                    <h3>
                        <svg style="width:20px;height:20px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Informations Client
                    </h3>
                </div>
                <div class="card-body">
                    <div style="display:flex; align-items:center; gap:16px; margin-bottom: 20px;">
                        <div style="width:48px;height:48px;border-radius:50%;background:#F3F4F6;display:flex;align-items:center;justify-content:center;font-weight:700;color:#374151;font-size:16px;">
                            {{ substr($intervention->devis->ticket->client->utilisateur->prenom, 0, 1) }}{{ substr($intervention->devis->ticket->client->utilisateur->nom, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight:700;color:#111827;">{{ $intervention->devis->ticket->client->utilisateur->prenom }} {{ $intervention->devis->ticket->client->utilisateur->nom }}</div>
                            <div style="font-size:13px;color:#6B7280;">{{ $intervention->devis->ticket->client->type_clt }}</div>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <span class="info-label">Téléphone</span>
                        <div style="display:flex;align-items:center;gap:8px;color:#374151;font-size:14px;font-weight:500;">
                            <svg style="width:16px;height:16px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $intervention->devis->ticket->client->utilisateur->tel ?? 'Non renseigné' }}
                        </div>
                    </div>
                    <div class="info-group">
                        <span class="info-label">Email</span>
                        <div style="display:flex;align-items:center;gap:8px;color:#374151;font-size:14px;font-weight:500;">
                            <svg style="width:16px;height:16px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <a href="mailto:{{ $intervention->devis->ticket->client->utilisateur->email }}" style="color:#2563EB;text-decoration:none;">{{ $intervention->devis->ticket->client->utilisateur->email }}</a>
                        </div>
                    </div>
                    <div class="info-group" style="margin-bottom:0;">
                        <span class="info-label">Adresse</span>
                        <div style="display:flex;align-items:flex-start;gap:8px;color:#374151;font-size:14px;font-weight:500;">
                            <svg style="width:16px;height:16px;color:#9CA3AF;margin-top:2px;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $intervention->devis->ticket->client->adresse_clt ?? 'Non renseignée' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Infos Matériel -->
            <div class="card">
                <div class="card-header">
                    <h3>
                        <svg style="width:20px;height:20px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Matériel Concerné
                    </h3>
                </div>
                <div class="card-body">
                    <div style="text-align:center; margin-bottom:20px;">
                        <div style="width:80px;height:80px;background:#EFF6FF;border-radius:16px;margin:0 auto 12px auto;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:40px;height:40px;color:#2563EB;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h4 style="font-size:18px;font-weight:700;color:#111827;margin:0;">{{ $intervention->devis->ticket->materiel->marque }}</h4>
                        <div style="font-size:14px;color:#4B5563;font-weight:500;">{{ $intervention->devis->ticket->materiel->modele }}</div>
                    </div>

                    <div style="background:#F9FAFB; border-radius:12px; padding:16px; border:1px solid #E5E7EB;">
                        <div style="display:flex;justify-content:space-between;border-bottom:1px solid #E5E7EB;padding-bottom:8px;margin-bottom:8px;">
                            <span style="font-size:13px;color:#6B7280;">N° Série</span>
                            <span style="font-size:13px;font-weight:600;color:#111827;font-family:monospace;">{{ $intervention->devis->ticket->materiel->num_serie }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;">
                            <span style="font-size:13px;color:#6B7280;">Catégorie</span>
                            <span style="font-size:13px;font-weight:600;color:#111827;">{{ $intervention->devis->ticket->materiel->categorie ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
