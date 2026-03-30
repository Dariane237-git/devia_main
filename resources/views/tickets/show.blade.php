<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; align-items:center; gap:12px;">
            <a href="{{ route('tickets.index') }}" style="color:#6B7280; text-decoration:none;">
                <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            Détails du Ticket #TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
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
        .badge-new { background: #EFF6FF; color: #2563EB; border: 1px solid #DBEAFE; }
        .badge-assigned { background: #F5F3FF; color: #7C3AED; border: 1px solid #EDE9FE; }
        .badge-progress { background: #FFF7ED; color: #EA580C; border: 1px solid #FFEDD5; }
        .badge-done { background: #F0FDF4; color: #16A34A; border: 1px solid #DCFCE7; }
        
        .problem-box {
            background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 12px; padding: 16px; color: #374151; font-size: 14px; line-height: 1.6;
        }
    </style>

    <div class="grid-container">
        <!-- Colonne Principale (Gauche) -->
        <div>
            <!-- Description du Problème -->
            <div class="card">
                <div class="card-header">
                    <h3>
                        <svg style="width:20px;height:20px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Description de la panne
                    </h3>
                    @if($ticket->statut == 'Nouveau')
                        <span class="status-badge badge-new">{{ $ticket->statut }}</span>
                    @elseif($ticket->statut == 'Assigné')
                        <span class="status-badge badge-assigned">{{ $ticket->statut }}</span>
                    @elseif(in_array($ticket->statut, ['En cours', 'En attente']))
                        <span class="status-badge badge-progress">{{ $ticket->statut }}</span>
                    @elseif($ticket->statut == 'Résolu')
                        <span class="status-badge badge-done">{{ $ticket->statut }}</span>
                    @else
                        <span class="status-badge badge-new">{{ $ticket->statut }}</span>
                    @endif
                </div>
                <div class="card-body">
                    <div style="display:flex; justify-content:space-between; margin-bottom:16px;">
                        <div class="info-group" style="margin-bottom:0;">
                            <span class="info-label">Date de déclaration</span>
                            <span class="info-value">{{ $ticket->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="info-group" style="margin-bottom:0;">
                            <span class="info-label">Priorité</span>
                            <span class="info-value">{{ $ticket->priorite }}</span>
                        </div>
                    </div>
                    
                    <div class="problem-box">
                        {!! nl2br(e($ticket->description_panne ?? $ticket->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Informations sur le Devis (si existant) -->
            @if($ticket->devis)
            <div class="card">
                <div class="card-header">
                    <h3>
                        <svg style="width:20px;height:20px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Devis Associé
                    </h3>
                    <span class="status-badge badge-new" style="background: @if($ticket->devis->statut == 'Validé') #DCFCE7; color:#166534; border-color:#BBF7D0; @elseif($ticket->devis->statut == 'Refusé') #FEE2E2; color:#DC2626; border-color:#FECACA; @else #FEF3C7; color:#D97706; border-color:#FDE68A; @endif">
                        {{ $ticket->devis->statut }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="grid-container" style="grid-template-columns: 1fr 1fr; gap:16px; margin-bottom: 16px;">
                        <div class="info-group">
                            <span class="info-label">Montant Estimé</span>
                            <span class="info-value" style="font-size:18px; font-weight:700; color:#111827;">{{ number_format($ticket->devis->mont_estimer, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="info-group">
                            <span class="info-label">Créé le</span>
                            <span class="info-value">{{ $ticket->devis->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    
                    @if(Auth::user()->id_role == 3 && $ticket->devis->statut == 'Validé')
                    <!-- Le responsable peut générer la facture finale si le devis est validé -->
                    <div style="border-top:1px solid #E5E7EB; padding-top:16px;">
                        <a href="{{ route('factures.create_from_devis', $ticket->devis->id) }}" style="display:inline-block; padding:10px 20px; background:linear-gradient(135deg, #10B981, #059669); color:white; border-radius:10px; font-weight:600; text-decoration:none; font-size:14px; box-shadow:0 2px 4px rgba(16,185,129,0.2);">
                            Générer la Facture Finale
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
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
                            {{ substr($ticket->client->utilisateur->prenom ?? 'C', 0, 1) }}{{ substr($ticket->client->utilisateur->nom ?? '', 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight:700;color:#111827;">{{ $ticket->client->utilisateur->prenom ?? '' }} {{ $ticket->client->utilisateur->nom ?? 'Client Inconnu' }}</div>
                            <div style="font-size:13px;color:#6B7280;">{{ $ticket->client->type_clt ?? '' }}</div>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <span class="info-label">Téléphone</span>
                        <div style="display:flex;align-items:center;gap:8px;color:#374151;font-size:14px;font-weight:500;">
                            <svg style="width:16px;height:16px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $ticket->client->utilisateur->tel ?? 'Non renseigné' }}
                        </div>
                    </div>
                    <div class="info-group">
                        <span class="info-label">Email</span>
                        <div style="display:flex;align-items:center;gap:8px;color:#374151;font-size:14px;font-weight:500;">
                            <svg style="width:16px;height:16px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <a href="mailto:{{ $ticket->client->utilisateur->email ?? '' }}" style="color:#2563EB;text-decoration:none;">{{ $ticket->client->utilisateur->email ?? 'Non renseigné' }}</a>
                        </div>
                    </div>
                    <div class="info-group" style="margin-bottom:0;">
                        <span class="info-label">Adresse</span>
                        <div style="display:flex;align-items:flex-start;gap:8px;color:#374151;font-size:14px;font-weight:500;">
                            <svg style="width:16px;height:16px;color:#9CA3AF;margin-top:2px;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $ticket->client->adresse_clt ?? 'Non renseignée' }}
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
                        <h4 style="font-size:18px;font-weight:700;color:#111827;margin:0;">{{ $ticket->materiel->marque ?? 'N/A' }}</h4>
                        <div style="font-size:14px;color:#4B5563;font-weight:500;">{{ $ticket->materiel->modele ?? 'N/A' }}</div>
                    </div>

                    <div style="background:#F9FAFB; border-radius:12px; padding:16px; border:1px solid #E5E7EB;">
                        <div style="display:flex;justify-content:space-between;border-bottom:1px solid #E5E7EB;padding-bottom:8px;margin-bottom:8px;">
                            <span style="font-size:13px;color:#6B7280;">N° Série</span>
                            <span style="font-size:13px;font-weight:600;color:#111827;font-family:monospace;">{{ $ticket->materiel->num_serie ?? 'N/A' }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;">
                            <span style="font-size:13px;color:#6B7280;">Achat</span>
                            <span style="font-size:13px;font-weight:600;color:#111827;">{{ $ticket->materiel->date_achat ? \Carbon\Carbon::parse($ticket->materiel->date_achat)->format('d/m/Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
