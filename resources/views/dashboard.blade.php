<x-app-layout>
    <x-slot name="header">
        Vue d'ensemble
    </x-slot>

    <style>
        /* ===== GRID SYSTEM ===== */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }
        @media (max-width: 1100px) {
            .dashboard-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .dashboard-grid { grid-template-columns: 1fr; }
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #E5E7EB;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }
        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 4px;
            line-height: 1;
        }
        .stat-label {
            font-size: 13px;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .stat-trend {
            font-size: 13px;
            font-weight: 500;
            display: flex; align-items: center; gap: 4px;
            margin-top: 8px;
        }

        /* ===== SECTIONS CONTENT ===== */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }
        @media (max-width: 1000px) {
            .content-grid { grid-template-columns: 1fr; }
        }

        .section-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #E5E7EB;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }
        .section-header {
            padding: 20px 24px;
            border-bottom: 1px solid #F3F4F6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #FDFDFD;
        }
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            display: flex; align-items: center; gap: 8px;
        }

        /* ===== TABLE TICKETS ===== */
        .table-list {
            width: 100%;
            border-collapse: collapse;
        }
        .table-list th {
            text-align: left;
            padding: 12px 24px;
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
        .table-list tr:last-child td { border-bottom: none; }
        .table-list tr:hover td { background: #F9FAFB; }

        /* Badges */
        .badge {
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .badge-red { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .badge-orange { background: #FFF7ED; color: #EA580C; border: 1px solid #FFEDD5; }
        .badge-blue { background: #EFF6FF; color: #2563EB; border: 1px solid #DBEAFE; }
        .badge-green { background: #F0FDF4; color: #16A34A; border: 1px solid #DCFCE7; }

        /* Buttons */
        .btn-action {
            padding: 6px 14px;
            background: white;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-action:hover {
            background: #F3F4F6;
            border-color: #9CA3AF;
        }
        .btn-primary-sm {
            padding: 6px 14px;
            background: #2563EB;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-primary-sm:hover { background: #1D4ED8; }

        /* ===== LISTE TECHNICIENS ===== */
        .tech-list { padding: 0; margin: 0; list-style: none; }
        .tech-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            border-bottom: 1px solid #F3F4F6;
        }
        .tech-item:last-child { border-bottom: none; }
        .tech-info { display: flex; align-items: center; gap: 12px; }
        .tech-avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: #E5E7EB;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #4B5563; font-size: 14px;
        }
        .tech-status-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            border: 2px solid white;
            position: absolute;
            bottom: 0; right: 0;
        }
    </style>

    <!-- Bienvenue -->
    <div style="margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 4px;">Bonjour, {{ Auth::user()->prenom }} 👋</h2>
        <p style="color: #6B7280; font-size: 14px;">Voici l'état actuel de votre centre de maintenance.</p>
    </div>

    <!-- ===== 4 STAT CARDS ===== -->
    <div class="dashboard-grid">
        <!-- Nouveaux Tickets -->
        <div class="stat-card">
            <div>
                <div class="stat-label">Tickets Non Assignés</div>
                <div class="stat-value">{{ $stats['tickets_nouveaux'] }}</div>
                @if($stats['tickets_nouveaux'] > 0)
                <div class="stat-trend" style="color: #EF4444;">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span>À traiter</span>
                </div>
                @else
                <div class="stat-trend" style="color: #10B981;">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>À jour</span>
                </div>
                @endif
            </div>
            <div class="stat-icon" style="background: #FEE2E2; color: #DC2626;">
                <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>

        <!-- Devis en attente -->
        <div class="stat-card">
            <div>
                <div class="stat-label">Devis à valider</div>
                <div class="stat-value">{{ $stats['devis_attente'] }}</div>
                <div class="stat-trend" style="color: #F59E0B;">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>En attente client</span>
                </div>
            </div>
            <div class="stat-icon" style="background: #FEF3C7; color: #D97706;">
                <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>

        <!-- Interventions en cours -->
        <div class="stat-card">
            <div>
                <div class="stat-label">Interventions actives</div>
                <div class="stat-value">{{ $stats['interventions_actives'] }}</div>
                <div class="stat-trend" style="color: #10B981;">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Techniciens sur le terrain</span>
                </div>
            </div>
            <div class="stat-icon" style="background: #D1FAE5; color: #059669;">
                <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>

        <!-- Factures -->
        <div class="stat-card">
            <div>
                <div class="stat-label">Factures impayées</div>
                <div class="stat-value">{{ $stats['factures_impayees'] }}</div>
                <div class="stat-trend" style="color: #6B7280;">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>En attente de règlement</span>
                </div>
            </div>
            <div class="stat-icon" style="background: #E0E7FF; color: #4F46E5;">
                <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- ===== CONTENU PRINCIPAL ===== -->
    <div class="content-grid">
        
        <!-- Tickets Prioritaires -->
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title">
                    <svg style="width:20px;height:20px;color:#EF4444;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Tickets non assignés
                </h3>
                <a href="#" style="font-size:13px;font-weight:600;color:#2563EB;text-decoration:none;">Voir tout →</a>
            </div>
            <div style="overflow-x:auto;">
                <table class="table-list">
                    <thead>
                        <tr>
                            <th>N° Ticket</th>
                            <th>Client</th>
                            <th>Problème</th>
                            <th>Urgence</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ticketsPriority as $ticket)
                        <tr>
                            <td style="font-weight:600;">#T-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div style="font-weight:600;color:#111827;">
                                    {{ $ticket->client->utilisateur->prenom ?? '' }} {{ $ticket->client->utilisateur->nom ?? 'Client Inconnu' }}
                                </div>
                                <div style="font-size:12px;color:#6B7280;">{{ $ticket->materiel->nom_mat ?? 'Matériel non spécifié' }}</div>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($ticket->description_panne, 40) }}</td>
                            <td>
                                @if(strtolower($ticket->priorite) == 'critique' || strtolower($ticket->priorite) == 'haute')
                                    <span class="badge badge-red">🚨 {{ $ticket->priorite }}</span>
                                @elseif(strtolower($ticket->priorite) == 'moyenne')
                                    <span class="badge badge-orange">{{ $ticket->priorite }}</span>
                                @else
                                    <span class="badge badge-blue">{{ $ticket->priorite }}</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn-primary-sm">Assigner</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center;color:#6B7280;padding:24px;">Aucun ticket non assigné pour le moment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Colonne de droite -->
        <div style="display:flex;flex-direction:column;gap:24px;">
            
            <!-- Disponibilité Techniciens -->
            <div class="section-card">
                <div class="section-header" style="padding:16px 20px;">
                    <h3 class="section-title">
                        <svg style="width:20px;height:20px;color:#10B981;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Équipe Technique
                    </h3>
                </div>
                <ul class="tech-list">
                    @forelse($techniciens as $techUser)
                    @php 
                        $status = ['Disponible', 'En Intervention', 'Indisponible'][array_rand(['Disponible', 'En Intervention', 'Indisponible'])];
                    @endphp
                    <li class="tech-item">
                        <div class="tech-info">
                            <div style="position:relative;">
                                <div class="tech-avatar">{{ substr($techUser->prenom ?? 'T', 0, 1) }}{{ substr($techUser->nom ?? '', 0, 1) }}</div>
                                <div class="tech-status-dot" style="background:{{ $status == 'Disponible' ? '#10B981' : ($status == 'En Intervention' ? '#F59E0B' : '#EF4444') }};"></div>
                            </div>
                            <div class="tech-info">
                                <div style="font-size:14px;font-weight:600;color:#111827;">{{ $techUser->prenom }} {{ $techUser->nom }}</div>
                                <div style="font-size:12px;color:#6B7280;">{{ optional($techUser->technicien)->specialite ?? 'Généraliste' }}</div>
                            </div>
                        </div>
                        @if($status == 'Disponible')
                            <span class="badge badge-green">Disponible</span>
                        @elseif($status == 'En Intervention')
                            <span class="badge badge-orange">En Intervention</span>
                        @else
                            <span class="badge badge-red">Indisponible</span>
                        @endif
                    </li>
                    @empty
                    <li class="tech-item" style="justify-content:center;color:#6B7280;font-size:13px;">Aucun technicien enregistré.</li>
                    @endforelse
                </ul>
                <div style="padding:12px 20px;background:#F9FAFB;border-top:1px solid #F3F4F6;text-align:center;">
                    <a href="#" style="font-size:13px;font-weight:500;color:#4B5563;text-decoration:none;">Gérer les plannings →</a>
                </div>
            </div>

            <!-- Raccourcis Rapides -->
            <div class="section-card" style="background:linear-gradient(135deg, #1E40AF, #3B82F6);color:white;border:none;">
                <div style="padding:24px;">
                    <h3 style="font-size:16px;font-weight:700;margin-bottom:16px;">Actions Rapides</h3>
                    <div style="display:grid;grid-template-columns:1fr;gap:12px;">
                        <button style="width:100%;padding:12px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.2);border-radius:10px;color:white;font-weight:600;text-align:left;display:flex;align-items:center;gap:10px;cursor:pointer;transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Créer un Devis
                        </button>
                        <button style="width:100%;padding:12px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.2);border-radius:10px;color:white;font-weight:600;text-align:left;display:flex;align-items:center;gap:10px;cursor:pointer;transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Générer un Rapport
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
