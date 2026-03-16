<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DEVIA-MAINT') }} - Espace Client</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background-color: #F3F4F6; color: #1F2937; overflow-x: hidden; }

        /* ========== SIDEBAR CLIENT ========== */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; width: 260px;
            background: #ffffff; border-right: 1px solid #E5E7EB; z-index: 50;
            display: flex; flex-direction: column; transition: transform 0.3s ease;
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
        }
        .sidebar-header {
            height: 72px; display: flex; align-items: center; padding: 0 24px;
            border-bottom: 1px solid #F3F4F6; background: linear-gradient(to right, #ffffff, #F8FAFC);
        }
        .sidebar-nav { flex: 1; padding: 24px 16px; overflow-y: auto; display: flex; flex-direction: column; gap: 6px; }
        .nav-item {
            display: flex; align-items: center; gap: 12px; padding: 12px 16px;
            border-radius: 12px; color: #6B7280; text-decoration: none;
            font-size: 14px; font-weight: 500; transition: all 0.2s ease;
        }
        .nav-item:hover { background: #F3F4F6; color: #111827; }
        .nav-item.active { background: #EFF6FF; color: #2563EB; }
        .nav-item.active .nav-icon { color: #2563EB; }
        .nav-icon { width: 20px; height: 20px; color: #9CA3AF; transition: color 0.2s ease; }

        .mobile-overlay { position: fixed; inset: 0; background: rgba(17, 24, 39, 0.4); backdrop-filter: blur(4px); z-index: 40; display: none; }
        .mobile-overlay.active { display: block; }

        /* ========== MAIN CONTENT ========== */
        .main-wrapper { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; transition: margin-left 0.3s ease; }
        @media (max-width: 768px) { .main-wrapper { margin-left: 0; } }

        .topbar {
            height: 72px; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px);
            border-bottom: 1px solid #E5E7EB; display: flex; align-items: center;
            justify-content: space-between; padding: 0 24px; position: sticky; top: 0; z-index: 30;
        }
        .burger-btn { display: none; background: none; border: none; color: #4B5563; cursor: pointer; padding: 8px; border-radius: 8px; }
        .burger-btn:hover { background: #F3F4F6; }
        @media (max-width: 768px) {
            .burger-btn { display: flex; align-items: center; justify-content: center; }
            .topbar { padding: 0 16px; }
        }
        .user-menu { display: flex; align-items: center; gap: 16px; }
        .user-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 4px 8px 4px 4px; border-radius: 9999px; transition: background 0.2s; }
        .user-profile:hover { background: #F3F4F6; }
        .avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #3B82F6, #10B981); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; }
        .dropdown-menu { position: absolute; top: 60px; right: 24px; width: 220px; background: white; border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); border: 1px solid #E5E7EB; overflow: hidden; z-index: 50; }
        .dropdown-item { display: flex; align-items: center; gap: 8px; padding: 12px 16px; color: #374151; font-size: 14px; text-decoration: none; transition: background 0.2s; }
        .dropdown-item:hover { background: #F9FAFB; }

        .content-area { flex: 1; padding: 32px; }
        @media (max-width: 768px) { .content-area { padding: 20px 16px; } }
    </style>
</head>
<body x-data="{ sidebarOpen: false, userMenuOpen: false }">

    <!-- OVERLAY MOBILE -->
    <div class="mobile-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    <!-- SIDEBAR CLIENT -->
    <aside class="sidebar" :class="{ 'mobile-open': sidebarOpen }">
        <div class="sidebar-header">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:32px;height:32px;background:linear-gradient(135deg,#2563EB,#10B981);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;color:white;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                    </svg>
                </div>
                <span style="font-size:18px;font-weight:800;color:#1E40AF;">DEVIA<span style="color:#059669;">-MAINT</span></span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Tableau de bord
            </a>

            <a href="{{ route('client.tickets.index') }}" class="nav-item {{ request()->routeIs('client.tickets.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                Mes Tickets
            </a>

            <a href="{{ route('client.devis.index') }}" class="nav-item {{ request()->routeIs('client.devis.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Mes Devis
            </a>

            <a href="{{ route('client.materiels') }}" class="nav-item {{ request()->routeIs('client.materiels') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Mes Matériels
            </a>
        </nav>

        <!-- Profil en bas -->
        <div style="padding:16px;border-top:1px solid #F3F4F6;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="avatar">{{ substr(Auth::user()->prenom ?? 'U', 0, 1) }}</div>
                <div>
                    <div style="font-size:14px;font-weight:600;color:#111827;">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                    <div style="font-size:12px;color:#6B7280;">Client</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-wrapper">
        <!-- TOPBAR -->
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:16px;">
                <button class="burger-btn" @click="sidebarOpen = !sidebarOpen">
                    <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 style="font-size:18px;font-weight:700;color:#111827;">{{ $header ?? 'Mon Espace' }}</h1>
            </div>

            <div class="user-menu" x-data="{ userMenuOpen: false }">
                <div @click="userMenuOpen = !userMenuOpen" class="user-profile">
                    <div class="avatar">{{ substr(Auth::user()->prenom ?? 'U', 0, 1) }}</div>
                    <svg style="width:16px;height:16px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-transition class="dropdown-menu">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Mon Profil
                    </a>
                    <div style="border-top:1px solid #F3F4F6;"></div>
                    <form method="POST" action="{{ route('logout') }}" x-data="{ showConfirm: false }">
                        @csrf
                        <button type="button" @click="showConfirm = true" class="dropdown-item" style="width:100%;border:none;background:none;cursor:pointer;color:#EF4444;">
                            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Déconnexion
                        </button>

                        <!-- Modal de confirmation -->
                        <div x-show="showConfirm" x-transition style="position:fixed;inset:0;z-index:100;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.4);backdrop-filter:blur(4px);">
                            <div @click.away="showConfirm = false" style="background:white;border-radius:16px;padding:32px;max-width:380px;width:90%;text-align:center;box-shadow:0 20px 40px rgba(0,0,0,0.15);">
                                <div style="width:56px;height:56px;background:#FEF2F2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                                    <svg style="width:28px;height:28px;color:#EF4444;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </div>
                                <h3 style="font-size:18px;font-weight:700;color:#111827;margin-bottom:8px;">Se déconnecter ?</h3>
                                <p style="color:#6B7280;font-size:14px;margin-bottom:24px;">Êtes-vous sûr de vouloir quitter votre espace ?</p>
                                <div style="display:flex;gap:12px;justify-content:center;">
                                    <button type="button" @click="showConfirm = false" style="padding:10px 24px;background:#F3F4F6;border:none;border-radius:10px;font-weight:600;color:#374151;cursor:pointer;">Annuler</button>
                                    <button type="submit" style="padding:10px 24px;background:#EF4444;border:none;border-radius:10px;font-weight:600;color:white;cursor:pointer;">Oui, me déconnecter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="content-area">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
