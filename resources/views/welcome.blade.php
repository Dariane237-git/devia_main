<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DEVIA-MAINT - Gestion de Maintenance Informatique</title>
        <meta name="description" content="Plateforme professionnelle de gestion de maintenance informatique.">

        <!-- Google Fonts : Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }

            /* ====== Animations ====== */
            @keyframes fadeInDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }
            @keyframes fadeInUp   { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
            @keyframes float      { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
            @keyframes glow       { 0%,100%{box-shadow:0 0 0 0 rgba(37,99,235,0.3)} 50%{box-shadow:0 0 0 10px rgba(37,99,235,0)} }
            @keyframes slideRight { from{transform:translateX(-100%);opacity:0} to{transform:translateX(0);opacity:1} }

            .anim-nav    { animation: fadeInDown 0.6s ease both; }
            .anim-hero-1 { animation: fadeInUp 0.7s ease 0.1s both; }
            .anim-hero-2 { animation: fadeInUp 0.7s ease 0.25s both; }
            .anim-hero-3 { animation: fadeInUp 0.7s ease 0.4s both; }
            .anim-hero-4 { animation: fadeInUp 0.7s ease 0.55s both; }
            .anim-float  { animation: float 4s ease-in-out infinite; }
            .anim-glow   { animation: glow 2.5s ease-in-out infinite; }

            /* ====== Navbar ====== */
            .navbar {
                background: rgba(255,255,255,0.92);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(219,234,254,0.8);
                transition: box-shadow 0.3s ease;
            }
            .navbar.scrolled { box-shadow: 0 4px 24px rgba(37,99,235,0.1); }

            /* ====== Boutons ====== */
            .btn-blue {
                background: linear-gradient(135deg, #3B82F6, #2563EB);
                color: white;
                padding: 12px 28px;
                border-radius: 12px;
                font-weight: 600;
                font-size: 15px;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
            }
            .btn-blue:hover {
                transform: translateY(-3px);
                box-shadow: 0 12px 28px rgba(37,99,235,0.35);
                background: linear-gradient(135deg, #2563EB, #1D4ED8);
            }

            .btn-green {
                background: linear-gradient(135deg, #10B981, #059669);
                color: white;
                padding: 12px 28px;
                border-radius: 12px;
                font-weight: 600;
                font-size: 15px;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
            }
            .btn-green:hover {
                transform: translateY(-3px);
                box-shadow: 0 12px 28px rgba(5,150,105,0.35);
            }

            .btn-ghost {
                background: transparent;
                color: #2563EB;
                border: 2px solid #3B82F6;
                padding: 10px 24px;
                border-radius: 12px;
                font-weight: 600;
                font-size: 15px;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
            }
            .btn-ghost:hover {
                background: #2563EB;
                color: white;
                transform: translateY(-2px);
            }

            /* ====== Hero ====== */
            .hero-bg {
                background: linear-gradient(135deg, #EFF6FF 0%, #E0F2FE 30%, #F0FDF4 70%, #ECFDF5 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                padding-top: 80px;
            }

            /* ====== Badge ====== */
            .badge-live {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: #EFF6FF;
                color: #2563EB;
                border: 1px solid #BFDBFE;
                padding: 6px 16px;
                border-radius: 9999px;
                font-size: 13px;
                font-weight: 600;
            }
            .badge-live .dot {
                width: 8px; height: 8px;
                background: #22C55E;
                border-radius: 50%;
                animation: glow 1.5s ease-in-out infinite;
            }

            /* ====== Dashboard Mockup ====== */
            .mockup {
                border-radius: 18px;
                overflow: hidden;
                box-shadow: 0 40px 80px -20px rgba(37,99,235,0.25), 0 0 0 1px rgba(219,234,254,0.5);
            }
            .mockup-bar {
                background: linear-gradient(135deg, #1E40AF, #2563EB);
                padding: 14px 20px;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .mockup-dot { width: 12px; height: 12px; border-radius: 50%; }

            /* ====== Cards Fonctionnalités ====== */
            .feature-card {
                background: white;
                border-radius: 20px;
                padding: 32px;
                border: 1px solid #EFF6FF;
                transition: all 0.35s cubic-bezier(0.25,0.46,0.45,0.94);
                opacity: 0;
                transform: translateY(30px);
            }
            .feature-card.visible {
                opacity: 1;
                transform: translateY(0);
            }
            .feature-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 25px 60px -10px rgba(37,99,235,0.15);
                border-color: #BFDBFE;
            }
            .card-icon {
                width: 56px; height: 56px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 20px;
                transition: all 0.3s ease;
            }
            .feature-card:hover .card-icon { transform: scale(1.1) rotate(-5deg); }

            /* ====== Étapes ====== */
            .step-card {
                border-radius: 20px;
                padding: 28px 32px;
                display: flex;
                align-items: flex-start;
                gap: 20px;
                transition: all 0.3s ease;
                opacity: 0;
                transform: translateY(20px);
            }
            .step-card.visible { opacity: 1; transform: translateY(0); }
            .step-card:hover { transform: translateY(-4px); box-shadow: 0 15px 40px -10px rgba(0,0,0,0.1); }

            .step-num {
                width: 48px; height: 48px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                font-weight: 900;
                flex-shrink: 0;
            }

            /* ====== Stats ====== */
            .stat-card {
                border-radius: 20px;
                padding: 32px;
                text-align: center;
                transition: all 0.3s ease;
                opacity: 0;
                transform: translateY(20px);
            }
            .stat-card.visible { opacity: 1; transform: translateY(0); }
            .stat-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px -10px rgba(37,99,235,0.15); }

            /* ====== CTA Banner ====== */
            .cta-banner {
                background: linear-gradient(135deg, #1D4ED8 0%, #2563EB 50%, #059669 100%);
                background-size: 200% 200%;
                animation: gradientShift 5s ease infinite;
            }
            @keyframes gradientShift {
                0%,100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }

            /* ====== Scroll-based animations ====== */
            .scroll-anim {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }
            .scroll-anim.visible {
                opacity: 1;
                transform: translateY(0);
            }

            /* ====== Nav link hover ====== */
            .nav-lnk {
                color: #6B7280;
                font-weight: 500;
                font-size: 14px;
                text-decoration: none;
                padding: 6px 2px;
                position: relative;
                transition: color 0.3s;
            }
            .nav-lnk::after {
                content:'';
                position: absolute;
                bottom: 0; left: 0;
                width: 0; height: 2px;
                background: #2563EB;
                transition: width 0.3s ease;
            }
            .nav-lnk:hover { color: #2563EB; }
            .nav-lnk:hover::after { width: 100%; }

            /* ====== Tag Pill ====== */
            .pill {
                display: inline-block;
                padding: 4px 12px;
                border-radius: 9999px;
                font-size: 12px;
                font-weight: 600;
            }
        </style>
    </head>
    <body style="background:#fff; color:#374151;">

        <!-- ===================== NAVBAR ===================== -->
        <nav class="navbar anim-nav" id="navbar" style="position:fixed; top:0; left:0; right:0; width:100%; z-index:50;">
            <div style="max-width:1200px; margin:0 auto; padding:0 24px;">
                <div style="display:flex; align-items:center; justify-content:space-between; height:72px;">

                    <!-- Logo -->
                    <a href="/" style="display:flex; align-items:center; gap:12px; text-decoration:none;">
                        <div class="anim-glow" style="width:40px;height:40px;background:linear-gradient(135deg,#2563EB,#1D4ED8);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:22px;height:22px;color:white;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                            </svg>
                        </div>
                        <span style="font-size:20px;font-weight:800;color:#1E40AF;">DEVIA<span style="color:#059669;">-MAINT</span></span>
                    </a>

                    <!-- Links Desktop -->
                    <div style="display:none;" id="navLinks" class="nav-desktop">
                        <a href="#fonctionnalites" class="nav-lnk" style="margin-right:32px;">Fonctionnalités</a>
                        <a href="#processus" class="nav-lnk" style="margin-right:32px;">Processus</a>
                        <a href="#stats" class="nav-lnk">Statistiques</a>
                    </div>

                    <!-- Auth Buttons -->
                    <div style="display:flex; align-items:center; gap:12px;">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-blue" style="padding:10px 20px;">
                                Tableau de bord →
                            </a>
                        @else
                            <!-- Bouton Se connecter : pour TOUS les utilisateurs -->
                            <a href="{{ route('login') }}" class="btn-ghost" style="padding:10px 20px; display:none;" id="loginBtn">Se connecter</a>
                            @if(Route::has('register'))
                            <!-- Bouton S'inscrire : réservé aux CLIENTS uniquement -->
                            <div style="display:none; flex-direction:column; align-items:center; gap:2px;" id="registerBtn">
                                <a href="{{ route('register') }}" class="btn-green" style="padding:8px 16px;font-size:13px;">
                                    <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    S'inscrire
                                </a>
                                <span style="font-size:10px;color:#9CA3AF;font-weight:500;">Nouveau client</span>
                            </div>
                            @endif
                        @endauth
                        <!-- Burger mobile -->
                        <button id="burgerBtn" onclick="toggleMobileMenu()" style="display:flex;padding:8px;border:none;background:transparent;cursor:pointer;color:#6B7280;">
                            <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div id="mobileMenu" style="display:none; padding:12px 0 20px; border-top:1px solid #DBEAFE;">
                    <a href="#fonctionnalites" class="nav-lnk" style="display:block;padding:10px 4px;margin-bottom:4px;">Fonctionnalités</a>
                    <a href="#processus" class="nav-lnk" style="display:block;padding:10px 4px;margin-bottom:4px;">Processus</a>
                    <a href="#stats" class="nav-lnk" style="display:block;padding:10px 4px;margin-bottom:12px;">Statistiques</a>
                    @guest
                    <a href="{{ route('login') }}" class="btn-ghost" style="display:block;text-align:center;margin-bottom:10px;">Se connecter</a>
                    @if(Route::has('register'))
                    <div style="text-align:center;">
                        <a href="{{ route('register') }}" class="btn-green" style="padding:10px 20px;display:inline-flex;">S'inscrire (Nouveau client)</a>
                    </div>
                    @endif
                    @endguest
                </div>
            </div>
        </nav>

        <!-- ===================== HERO ===================== -->
        <section class="hero-bg">
            <div style="max-width:1200px; margin:0 auto; padding:80px 24px;">
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:64px; align-items:center;">

                    <!-- Texte -->
                    <div>
                        <div class="badge-live anim-hero-1" style="margin-bottom:24px;">
                            <span class="dot"></span>
                            Plateforme Professionnelle IT
                        </div>

                        <h1 class="anim-hero-2" style="font-size:clamp(2.2rem,4vw,3.5rem); font-weight:900; color:#111827; line-height:1.1; margin-bottom:24px;">
                            Gérez votre<br>
                            <span style="color:#2563EB;">parc informatique</span><br>
                            <span style="color:#059669;">efficacement</span>
                        </h1>

                        <p class="anim-hero-3" style="font-size:17px; color:#6B7280; line-height:1.7; margin-bottom:36px; max-width:480px;">
                            Centralisez vos tickets, suivez vos interventions, gérez vos techniciens et automatisez votre facturation. Conçu pour les équipes IT modernes.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="anim-hero-3" style="display:flex; flex-wrap:wrap; gap:14px; margin-bottom:36px;">
                            @auth
                            <a href="{{ url('/dashboard') }}" class="btn-blue">
                                <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Tableau de bord
                            </a>
                            @else
                            {{-- Se connecter : pour TOUS (Client, Agent, Tech, Responsable) --}}
                            <a href="{{ route('login') }}" class="btn-blue">
                                <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Se connecter
                            </a>
                            {{-- S'inscrire : UNIQUEMENT pour les nouveaux clients --}}
                            @if(Route::has('register'))
                            <div style="display:flex;flex-direction:column;align-items:flex-start;gap:4px;">
                                <a href="{{ route('register') }}" class="btn-ghost">
                                    <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    S'inscrire
                                </a>
                                <span style="font-size:12px;color:#9CA3AF;padding-left:4px;">👤 Nouveau client uniquement</span>
                            </div>
                            @endif
                            @endauth
                        </div>

                        <!-- Trust badges -->
                        <div class="anim-hero-4" style="display:flex; flex-wrap:wrap; gap:20px; font-size:13px; color:#9CA3AF;">
                            <span style="display:flex;align-items:center;gap:6px;">
                                <svg style="width:16px;height:16px;color:#22C55E;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Accès sécurisé par rôle
                            </span>
                            <span style="display:flex;align-items:center;gap:6px;">
                                <svg style="width:16px;height:16px;color:#22C55E;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Suivi en temps réel
                            </span>
                            <span style="display:flex;align-items:center;gap:6px;">
                                <svg style="width:16px;height:16px;color:#22C55E;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Factures automatiques
                            </span>
                        </div>
                    </div>

                    <!-- Dashboard Mockup -->
                    <div class="anim-float" style="display:none;" id="heroMockup">
                        <div class="mockup">
                            <!-- Barre titre -->
                            <div class="mockup-bar">
                                <div class="mockup-dot" style="background:#EF4444;"></div>
                                <div class="mockup-dot" style="background:#F59E0B;"></div>
                                <div class="mockup-dot" style="background:#22C55E;"></div>
                                <span style="color:rgba(255,255,255,0.6);font-size:12px;margin-left:16px;font-family:monospace;">devia-maint.fr/dashboard</span>
                            </div>
                            <!-- Corps -->
                            <div style="background:#F8FAFF;padding:24px;">
                                <!-- Mini stats -->
                                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;">
                                    <div style="background:white;border-radius:14px;padding:16px;text-align:center;box-shadow:0 2px 8px rgba(37,99,235,0.08);">
                                        <div style="font-size:26px;font-weight:800;color:#2563EB;">24</div>
                                        <div style="font-size:11px;color:#9CA3AF;margin-top:4px;">Tickets ouverts</div>
                                    </div>
                                    <div style="background:white;border-radius:14px;padding:16px;text-align:center;box-shadow:0 2px 8px rgba(5,150,105,0.08);">
                                        <div style="font-size:26px;font-weight:800;color:#059669;">8</div>
                                        <div style="font-size:11px;color:#9CA3AF;margin-top:4px;">En cours</div>
                                    </div>
                                    <div style="background:white;border-radius:14px;padding:16px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                                        <div style="font-size:26px;font-weight:800;color:#374151;">156</div>
                                        <div style="font-size:11px;color:#9CA3AF;margin-top:4px;">Résolus</div>
                                    </div>
                                </div>
                                <!-- Liste tickets -->
                                <div style="font-size:11px;font-weight:700;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:10px;">Derniers tickets</div>
                                <div style="background:white;border-radius:12px;padding:14px;display:flex;align-items:center;gap:12px;margin-bottom:8px;box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                                    <div style="width:10px;height:10px;background:#EF4444;border-radius:50%;flex-shrink:0;"></div>
                                    <div style="flex:1;">
                                        <div style="font-size:13px;font-weight:600;color:#111827;">PC Portable - Panne démarrage</div>
                                        <div style="font-size:11px;color:#9CA3AF;">Jean Dupont</div>
                                    </div>
                                    <span style="font-size:11px;background:#FEE2E2;color:#DC2626;padding:3px 10px;border-radius:9999px;font-weight:600;">Urgent</span>
                                </div>
                                <div style="background:white;border-radius:12px;padding:14px;display:flex;align-items:center;gap:12px;margin-bottom:8px;box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                                    <div style="width:10px;height:10px;background:#F59E0B;border-radius:50%;flex-shrink:0;"></div>
                                    <div style="flex:1;">
                                        <div style="font-size:13px;font-weight:600;color:#111827;">Imprimante réseau HS</div>
                                        <div style="font-size:11px;color:#9CA3AF;">Entreprise ABC</div>
                                    </div>
                                    <span style="font-size:11px;background:#FEF3C7;color:#D97706;padding:3px 10px;border-radius:9999px;font-weight:600;">En cours</span>
                                </div>
                                <div style="background:white;border-radius:12px;padding:14px;display:flex;align-items:center;gap:12px;box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                                    <div style="width:10px;height:10px;background:#22C55E;border-radius:50%;flex-shrink:0;"></div>
                                    <div style="flex:1;">
                                        <div style="font-size:13px;font-weight:600;color:#111827;">Remplacement RAM 16Go</div>
                                        <div style="font-size:11px;color:#9CA3AF;">Paul Martin</div>
                                    </div>
                                    <span style="font-size:11px;background:#DCFCE7;color:#16A34A;padding:3px 10px;border-radius:9999px;font-weight:600;">Terminé</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ===================== SECTION STATS ===================== -->
        <section id="stats" style="background:white;padding:80px 24px;">
            <div style="max-width:1200px;margin:0 auto;">
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:24px;">
                    <div class="stat-card" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE);">
                        <div style="font-size:48px;font-weight:900;color:#2563EB;margin-bottom:8px;">+500</div>
                        <div style="font-size:15px;color:#6B7280;font-weight:500;">Tickets traités</div>
                    </div>
                    <div class="stat-card" style="background:linear-gradient(135deg,#F0FDF4,#DCFCE7);">
                        <div style="font-size:48px;font-weight:900;color:#059669;margin-bottom:8px;">98%</div>
                        <div style="font-size:15px;color:#6B7280;font-weight:500;">Satisfaction client</div>
                    </div>
                    <div class="stat-card" style="background:linear-gradient(135deg,#F9FAFB,#F3F4F6);">
                        <div style="font-size:48px;font-weight:900;color:#374151;margin-bottom:8px;">4h</div>
                        <div style="font-size:15px;color:#6B7280;font-weight:500;">Délai moyen de réponse</div>
                    </div>
                    <div class="stat-card" style="background:linear-gradient(135deg,#EFF6FF,#F0FDF4);">
                        <div style="font-size:48px;font-weight:900;color:#1D4ED8;margin-bottom:8px;">24/7</div>
                        <div style="font-size:15px;color:#6B7280;font-weight:500;">Accès à la plateforme</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== SECTION FONCTIONNALITÉS ===================== -->
        <section id="fonctionnalites" style="background:#F8FAFF;padding:96px 24px;">
            <div style="max-width:1200px;margin:0 auto;">
                <!-- Header -->
                <div style="text-align:center;margin-bottom:64px;" class="scroll-anim">
                    <span style="font-size:13px;font-weight:700;color:#059669;text-transform:uppercase;letter-spacing:0.1em;">Ce que nous offrons</span>
                    <h2 style="font-size:clamp(1.8rem,3vw,2.8rem);font-weight:900;color:#111827;margin:12px 0 16px;">
                        Tout ce dont votre équipe a besoin
                    </h2>
                    <p style="font-size:17px;color:#6B7280;max-width:520px;margin:0 auto;line-height:1.6;">
                        DEVIA-MAINT centralise tous vos outils de gestion en une seule plateforme intuitive.
                    </p>
                </div>

                <!-- Grid -->
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px;">

                    <div class="feature-card">
                        <div class="card-icon" style="background:#EFF6FF;">
                            <svg style="width:26px;height:26px;color:#2563EB;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 style="font-size:18px;font-weight:700;color:#111827;margin-bottom:10px;">Gestion des Tickets</h3>
                        <p style="font-size:14px;color:#6B7280;line-height:1.6;margin-bottom:18px;">Créez, assignez et suivez chaque demande de maintenance en temps réel. Priorisez les urgences.</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            <span class="pill" style="background:#EFF6FF;color:#2563EB;">Création rapide</span>
                            <span class="pill" style="background:#EFF6FF;color:#2563EB;">Priorités</span>
                            <span class="pill" style="background:#EFF6FF;color:#2563EB;">Historique</span>
                        </div>
                    </div>

                    <div class="feature-card">
                        <div class="card-icon" style="background:#F0FDF4;">
                            <svg style="width:26px;height:26px;color:#059669;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 style="font-size:18px;font-weight:700;color:#111827;margin-bottom:10px;">Tableau de Bord</h3>
                        <p style="font-size:14px;color:#6B7280;line-height:1.6;margin-bottom:18px;">Visualisez l'état de toutes vos interventions, les performances et les tendances de pannes.</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            <span class="pill" style="background:#F0FDF4;color:#059669;">Statistiques</span>
                            <span class="pill" style="background:#F0FDF4;color:#059669;">Graphiques</span>
                            <span class="pill" style="background:#F0FDF4;color:#059669;">KPIs</span>
                        </div>
                    </div>

                    <div class="feature-card">
                        <div class="card-icon" style="background:#EFF6FF;">
                            <svg style="width:26px;height:26px;color:#2563EB;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 style="font-size:18px;font-weight:700;color:#111827;margin-bottom:10px;">Devis & Facturation</h3>
                        <p style="font-size:14px;color:#6B7280;line-height:1.6;margin-bottom:18px;">Générez des devis précis, envoyez-les au client et transformez-les en factures automatiquement.</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            <span class="pill" style="background:#EFF6FF;color:#2563EB;">PDF auto</span>
                            <span class="pill" style="background:#EFF6FF;color:#2563EB;">Signature</span>
                            <span class="pill" style="background:#EFF6FF;color:#2563EB;">Suivi paiement</span>
                        </div>
                    </div>

                    <div class="feature-card">
                        <div class="card-icon" style="background:#F9FAFB;">
                            <svg style="width:26px;height:26px;color:#374151;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h3 style="font-size:18px;font-weight:700;color:#111827;margin-bottom:10px;">Gestion des Techniciens</h3>
                        <p style="font-size:14px;color:#6B7280;line-height:1.6;margin-bottom:18px;">Gérez la disponibilité, les spécialités et la charge de travail de vos techniciens.</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            <span class="pill" style="background:#F3F4F6;color:#374151;">Planning</span>
                            <span class="pill" style="background:#F3F4F6;color:#374151;">Spécialités</span>
                            <span class="pill" style="background:#F3F4F6;color:#374151;">Charge</span>
                        </div>
                    </div>

                    <div class="feature-card">
                        <div class="card-icon" style="background:#F0FDF4;">
                            <svg style="width:26px;height:26px;color:#059669;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 style="font-size:18px;font-weight:700;color:#111827;margin-bottom:10px;">Parc Matériel</h3>
                        <p style="font-size:14px;color:#6B7280;line-height:1.6;margin-bottom:18px;">Inventaire complet des équipements de vos clients avec garanties, historique et état en temps réel.</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            <span class="pill" style="background:#F0FDF4;color:#059669;">Inventaire</span>
                            <span class="pill" style="background:#F0FDF4;color:#059669;">Garanties</span>
                            <span class="pill" style="background:#F0FDF4;color:#059669;">Historique</span>
                        </div>
                    </div>

                    <div class="feature-card">
                        <div class="card-icon" style="background:#EFF6FF;">
                            <svg style="width:26px;height:26px;color:#2563EB;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h3 style="font-size:18px;font-weight:700;color:#111827;margin-bottom:10px;">Accès par Rôle</h3>
                        <p style="font-size:14px;color:#6B7280;line-height:1.6;margin-bottom:18px;">Client, Agent, Technicien, Responsable — chacun son espace personnalisé et sécurisé.</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            <span class="pill" style="background:#EFF6FF;color:#2563EB;">Client</span>
                            <span class="pill" style="background:#EFF6FF;color:#2563EB;">Agent</span>
                            <span class="pill" style="background:#EFF6FF;color:#2563EB;">Technicien</span>
                            <span class="pill" style="background:#EFF6FF;color:#2563EB;">Responsable</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ===================== PROCESSUS ===================== -->
        <section id="processus" style="background:white;padding:96px 24px;">
            <div style="max-width:900px;margin:0 auto;">
                <div style="text-align:center;margin-bottom:64px;" class="scroll-anim">
                    <span style="font-size:13px;font-weight:700;color:#2563EB;text-transform:uppercase;letter-spacing:0.1em;">Simple & efficace</span>
                    <h2 style="font-size:clamp(1.8rem,3vw,2.8rem);font-weight:900;color:#111827;margin:12px 0;">
                        Le processus en 4 étapes
                    </h2>
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(380px,1fr));gap:20px;">
                    <div class="step-card" style="background:#EFF6FF;">
                        <div class="step-num" style="background:#2563EB;color:white;">1</div>
                        <div>
                            <h3 style="font-size:17px;font-weight:700;color:#111827;margin-bottom:8px;">Création du Ticket</h3>
                            <p style="font-size:14px;color:#6B7280;line-height:1.6;">Le client signale la panne depuis son espace, ou l'agent l'enregistre à l'accueil du matériel.</p>
                        </div>
                    </div>
                    <div class="step-card" style="background:#F0FDF4;">
                        <div class="step-num" style="background:#059669;color:white;">2</div>
                        <div>
                            <h3 style="font-size:17px;font-weight:700;color:#111827;margin-bottom:8px;">Diagnostic & Devis</h3>
                            <p style="font-size:14px;color:#6B7280;line-height:1.6;">Le technicien diagnostique. Le responsable établit le devis et l'envoie au client pour validation.</p>
                        </div>
                    </div>
                    <div class="step-card" style="background:#F9FAFB;">
                        <div class="step-num" style="background:#374151;color:white;">3</div>
                        <div>
                            <h3 style="font-size:17px;font-weight:700;color:#111827;margin-bottom:8px;">Réparation</h3>
                            <p style="font-size:14px;color:#6B7280;line-height:1.6;">Après accord du client, le technicien procède à la réparation et saisit son rapport d'intervention.</p>
                        </div>
                    </div>
                    <div class="step-card" style="background:#EFF6FF;">
                        <div class="step-num" style="background:#2563EB;color:white;">4</div>
                        <div>
                            <h3 style="font-size:17px;font-weight:700;color:#111827;margin-bottom:8px;">Clôture & Facturation</h3>
                            <p style="font-size:14px;color:#6B7280;line-height:1.6;">La facture est générée automatiquement, le dossier est archivé, le matériel est restitué au client.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== CTA FINAL ===================== -->
        <section class="cta-banner" style="padding:96px 24px;text-align:center;">
            <div style="max-width:680px;margin:0 auto;" class="scroll-anim">
                <h2 style="font-size:clamp(1.8rem,3vw,2.8rem);font-weight:900;color:white;margin-bottom:20px;">
                    Prêt à moderniser votre gestion IT ?
                </h2>
                <p style="font-size:17px;color:rgba(255,255,255,0.8);margin-bottom:40px;line-height:1.6;">
                    Rejoignez DEVIA-MAINT et simplifiez votre quotidien avec une plateforme conçue pour les équipes professionnelles.
                </p>
                @guest
                <a href="{{ route('login') }}"
                   style="background:white;color:#2563EB;font-weight:700;font-size:17px;padding:16px 40px;border-radius:14px;text-decoration:none;display:inline-block;transition:all 0.3s ease;box-shadow:0 8px 24px rgba(0,0,0,0.15);"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 16px 40px rgba(0,0,0,0.2)'"
                   onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.15)'">
                    Accéder à la plateforme →
                </a>
                @else
                <a href="{{ url('/dashboard') }}"
                   style="background:white;color:#2563EB;font-weight:700;font-size:17px;padding:16px 40px;border-radius:14px;text-decoration:none;display:inline-block;">
                    Mon tableau de bord →
                </a>
                @endguest
            </div>
        </section>

        <!-- ===================== FOOTER ===================== -->
        <footer style="background:#111827;color:#9CA3AF;padding:64px 24px 32px;">
            <div style="max-width:1200px;margin:0 auto;">
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:40px;margin-bottom:48px;">
                    <div>
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                            <div style="width:36px;height:36px;background:#2563EB;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <svg style="width:18px;height:18px;color:white;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                                </svg>
                            </div>
                            <span style="font-size:18px;font-weight:800;color:white;">DEVIA<span style="color:#34D399;">-MAINT</span></span>
                        </div>
                        <p style="font-size:14px;line-height:1.6;">Plateforme de gestion de maintenance informatique pour les équipes IT professionnelles.</p>
                    </div>
                    <div>
                        <h4 style="color:white;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;">Navigation</h4>
                        <ul style="list-style:none;padding:0;margin:0;space-y:8px;">
                            <li style="margin-bottom:10px;"><a href="#fonctionnalites" style="color:#9CA3AF;text-decoration:none;font-size:14px;transition:color 0.2s;" onmouseover="this.style.color='#60A5FA'" onmouseout="this.style.color='#9CA3AF'">Fonctionnalités</a></li>
                            <li style="margin-bottom:10px;"><a href="#processus" style="color:#9CA3AF;text-decoration:none;font-size:14px;" onmouseover="this.style.color='#60A5FA'" onmouseout="this.style.color='#9CA3AF'">Processus</a></li>
                            <li><a href="#stats" style="color:#9CA3AF;text-decoration:none;font-size:14px;" onmouseover="this.style.color='#60A5FA'" onmouseout="this.style.color='#9CA3AF'">Statistiques</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 style="color:white;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;">Accès</h4>
                        <ul style="list-style:none;padding:0;margin:0;">
                            <li style="margin-bottom:10px;"><a href="{{ route('login') }}" style="color:#9CA3AF;text-decoration:none;font-size:14px;" onmouseover="this.style.color='#60A5FA'" onmouseout="this.style.color='#9CA3AF'">Se connecter</a></li>
                            @if(Route::has('register'))
                            <li><a href="{{ route('register') }}" style="color:#9CA3AF;text-decoration:none;font-size:14px;" onmouseover="this.style.color='#34D399'" onmouseout="this.style.color='#9CA3AF'">Créer un compte</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div style="border-top:1px solid #1F2937;padding-top:24px;text-align:center;font-size:13px;">
                    © {{ date('Y') }} DEVIA-MAINT — Projet BTS Gestion des Systèmes d'Information
                </div>
            </div>
        </footer>

        <!-- ===================== JAVASCRIPT ===================== -->
        <script>
            // ---- Responsive : afficher bonnes zones selon taille écran ----
            function handleResize() {
                const w = window.innerWidth;
                const navLinks = document.getElementById('navLinks');
                const loginBtn = document.getElementById('loginBtn');
                const registerBtn = document.getElementById('registerBtn');
                const heroMockup = document.getElementById('heroMockup');
                const burgerBtn = document.getElementById('burgerBtn');

                if (w >= 900) {
                    navLinks.style.display = 'flex';
                    navLinks.style.alignItems = 'center';
                    loginBtn && (loginBtn.style.display = 'flex');
                    registerBtn && (registerBtn.style.display = 'flex');
                    heroMockup && (heroMockup.style.display = 'block');
                    burgerBtn.style.display = 'none';
                } else {
                    navLinks.style.display = 'none';
                    loginBtn && (loginBtn.style.display = 'none');
                    registerBtn && (registerBtn.style.display = 'none');
                    heroMockup && (heroMockup.style.display = 'none');
                    burgerBtn.style.display = 'flex';
                }

                // Grid hero : full width en mobile
                const heroGrid = document.querySelector('.hero-bg > div > div');
                if (heroGrid) {
                    heroGrid.style.gridTemplateColumns = w >= 900 ? '1fr 1fr' : '1fr';
                }
            }
            handleResize();
            window.addEventListener('resize', handleResize);

            // ---- Mobile Menu Toggle ----
            function toggleMobileMenu() {
                const menu = document.getElementById('mobileMenu');
                menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
            }
            document.querySelectorAll('#mobileMenu a').forEach(a => {
                a.addEventListener('click', () => { document.getElementById('mobileMenu').style.display = 'none'; });
            });

            // ---- Smooth Scroll ----
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) target.scrollIntoView({ behavior: 'smooth' });
                });
            });

            // ---- Navbar scroll shadow ----
            window.addEventListener('scroll', () => {
                const nav = document.getElementById('navbar');
                nav.classList.toggle('scrolled', window.scrollY > 20);
            });

            // ---- Intersection Observer : animations au scroll ----
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

            // Animer les cartes avec un délai en cascade
            document.querySelectorAll('.feature-card').forEach((el, i) => {
                el.style.transitionDelay = (i * 80) + 'ms';
                observer.observe(el);
            });
            document.querySelectorAll('.stat-card, .step-card, .scroll-anim').forEach(el => {
                observer.observe(el);
            });
        </script>

    </body>
</html>
