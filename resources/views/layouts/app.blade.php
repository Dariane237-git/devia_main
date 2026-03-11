<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DEVIA-MAINT') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js (pour la réactivité sans rechargement) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * { font-family: 'Inter', sans-serif; }
        
        body {
            background-color: #F3F4F6;
            color: #1F2937;
            overflow-x: hidden;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 260px;
            background: #ffffff;
            border-right: 1px solid #E5E7EB;
            z-index: 50;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        /* Animation mobile */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
        }

        .sidebar-header {
            height: 72px;
            display: flex;
            align-items: center;
            padding: 0 24px;
            border-bottom: 1px solid #F3F4F6;
            background: linear-gradient(to right, #ffffff, #F8FAFC);
        }

        .sidebar-nav {
            flex: 1;
            padding: 24px 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #6B7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            background: #F3F4F6;
            color: #111827;
        }

        .nav-item.active {
            background: #EFF6FF; /* Blue-50 */
            color: #2563EB;      /* Blue-600 */
        }
        .nav-item.active .nav-icon {
            color: #2563EB;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            color: #9CA3AF;
            transition: color 0.2s ease;
        }

        /* Overlay mobile */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(17, 24, 39, 0.4);
            backdrop-filter: blur(4px);
            z-index: 40;
            display: none;
        }
        .mobile-overlay.active { display: block; }

        /* ========== MAIN CONTENT ========== */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 768px) {
            .main-wrapper { margin-left: 0; }
        }

        /* ========== TOPBAR ========== */
        .topbar {
            height: 72px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .burger-btn {
            display: none;
            background: none;
            border: none;
            color: #4B5563;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
        }
        .burger-btn:hover { background: #F3F4F6; }

        @media (max-width: 768px) {
            .burger-btn { display: flex; align-items: center; justify-content: center; }
            .topbar { padding: 0 16px; }
        }

        /* User Menu / Avatar */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .notifications-btn {
            position: relative;
            background: none;
            border: none;
            color: #6B7280;
            cursor: pointer;
            width: 36px; height: 36px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .notifications-btn:hover { background: #F3F4F6; color: #111827; }
        .notif-badge {
            position: absolute;
            top: 6px; right: 8px;
            width: 8px; height: 8px;
            background: #EF4444;
            border-radius: 50%;
            border: 2px solid white;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 4px 8px 4px 4px;
            border-radius: 9999px;
            transition: background 0.2s;
        }
        .user-profile:hover { background: #F3F4F6; }

        .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3B82F6, #10B981);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        /* Dropdown (Alpine) */
        .dropdown-menu {
            position: absolute;
            top: 60px; right: 24px;
            width: 220px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
            border: 1px solid #E5E7EB;
            overflow: hidden;
            z-index: 50;
        }
        .dropdown-item {
            display: flex; align-items: center; gap: 8px;
            padding: 12px 16px;
            color: #374151; font-size: 14px; text-decoration: none;
            transition: background 0.2s;
        }
        .dropdown-item:hover { background: #F9FAFB; }

        /* ========== CONTENT AREA ========== */
        .content-area {
            flex: 1;
            padding: 32px;
        }
        @media (max-width: 768px) {
            .content-area { padding: 20px 16px; }
        }
    </style>
</head>
<body x-data="{ sidebarOpen: false, userMenuOpen: false }">

    <!-- OVERLAY MOBILE -->
    <div class="mobile-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    <!-- SIDEBAR -->
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
            <!-- Navigation items -->
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Tableau de bord
            </a>

            <a href="#" class="nav-item">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                Tickets
            </a>

            <a href="#" class="nav-item">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Devis & Factures
            </a>

            <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Utilisateurs
            </a>
            
            <a href="#" class="nav-item">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Rapports
            </a>
        </nav>

        <!-- Sidebar footer -->
        <div style="padding:24px 16px;border-top:1px solid #E5E7EB;">
            <div style="background:#F0FDF4;border-radius:12px;padding:16px;text-align:center;">
                <div style="font-size:12px;color:#059669;font-weight:600;margin-bottom:8px;">BESOIN D'AIDE ?</div>
                <a href="#" style="font-size:13px;color:#10B981;text-decoration:none;font-weight:500;">Consulter le manuel →</a>
            </div>
        </div>
    </aside>

    <!-- MAIN AREA -->
    <div class="main-wrapper">
        <!-- TOPBAR -->
        <header class="topbar">
            <!-- Mobile Toggle -->
            <div style="display:flex;align-items:center;gap:16px;">
                <button class="burger-btn" @click="sidebarOpen = true">
                    <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                
                @if (isset($header))
                    <h1 style="font-size:18px;font-weight:700;color:#111827;margin:0;">{{ $header }}</h1>
                @endif
            </div>

            <!-- Header Right Menu -->
            <div class="user-menu">
                <button class="notifications-btn">
                    <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <div class="notif-badge"></div>
                </button>

                <div style="position:relative;" @click.away="userMenuOpen = false">
                    <div class="user-profile" @click="userMenuOpen = !userMenuOpen">
                        <div class="avatar">
                            {{ substr(Auth::user()->prenom ?? 'U', 0, 1) }}{{ substr(Auth::user()->nom ?? 'S', 0, 1) }}
                        </div>
                        <div style="display:none;flex-direction:column;" class="md:flex">
                            <span style="font-size:14px;font-weight:600;color:#111827;line-height:1.2;">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                            <span style="font-size:12px;color:#6B7280;">Responsable Maintenance</span>
                        </div>
                        <svg style="width:16px;height:16px;color:#9CA3AF;margin-left:4px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    <!-- Dropdown Alpine -->
                    <div class="dropdown-menu" x-show="userMenuOpen" x-transition style="display:none;">
                        <div style="padding:16px;border-bottom:1px solid #E5E7EB;background:#F9FAFB;">
                            <div style="font-weight:600;color:#111827;font-size:14px;">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                            <div style="font-size:12px;color:#6B7280;">{{ Auth::user()->email }}</div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <svg style="width:16px;height:16px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Mon Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" style="width:100%;border:none;background:none;cursor:pointer;color:#EF4444;border-top:1px solid #E5E7EB;">
                                <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="content-area">
            {{ $slot }}
        </main>
    </div>

</body>
</html>
