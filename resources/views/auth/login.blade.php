<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion — DEVIA-MAINT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #EFF6FF 0%, #E0F2FE 40%, #F0FDF4 100%);
        }

        /* ====== PANNEAU GAUCHE (Décoratif) ====== */
        .left-panel {
            display: none;
            flex: 1;
            background: linear-gradient(160deg, #1E40AF 0%, #2563EB 50%, #059669 100%);
            padding: 48px;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 900px) {
            .left-panel { display: flex; }
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 350px; height: 350px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 280px; height: 280px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .left-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .left-logo-icon {
            width: 44px; height: 44px;
            background: rgba(255,255,255,0.2);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            backdrop-filter: blur(10px);
        }

        .left-stat {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .left-stat-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        /* ====== PANNEAU DROIT (Formulaire) ====== */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 24px;
            min-height: 100vh;
        }

        .form-card {
            width: 100%;
            max-width: 440px;
            background: white;
            border-radius: 24px;
            padding: 48px 44px;
            box-shadow: 0 25px 60px -12px rgba(37,99,235,0.15), 0 0 0 1px rgba(219,234,254,0.5);
            animation: fadeInUp 0.6s ease both;
        }

        @keyframes fadeInUp {
            from { opacity:0; transform:translateY(24px); }
            to { opacity:1; transform:translateY(0); }
        }

        /* ====== CHAMPS ====== */
        .field-group {
            margin-bottom: 20px;
        }
        .field-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .field-wrapper {
            position: relative;
        }
        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            width: 18px; height: 18px;
            pointer-events: none;
            transition: color 0.3s;
        }
        .field-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            font-size: 15px;
            color: #111827;
            background: #F9FAFB;
            transition: all 0.3s ease;
            outline: none;
        }
        .field-input:focus {
            border-color: #3B82F6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }
        .field-input:focus + .field-icon,
        .field-wrapper:focus-within .field-icon {
            color: #2563EB;
        }
        .error-msg {
            color: #EF4444;
            font-size: 12px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ====== Bouton principal ====== */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3B82F6, #2563EB);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(37,99,235,0.35);
        }
        .btn-submit:active { transform: translateY(0); }

        /* ====== Checkbox ====== */
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 14px;
            color: #6B7280;
        }
        .checkbox-input {
            width: 18px; height: 18px;
            accent-color: #2563EB;
            cursor: pointer;
        }

        /* ====== Toggle password ====== */
        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9CA3AF;
            padding: 0;
            transition: color 0.2s;
        }
        .toggle-pw:hover { color: #2563EB; }
    </style>
</head>
<body>

    <!-- ====== PANNEAU GAUCHE ====== -->
    <div class="left-panel">
        <!-- Logo -->
        <div class="left-logo">
            <div class="left-logo-icon">
                <svg style="width:22px;height:22px;color:white;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                </svg>
            </div>
            <a href="/" style="text-decoration:none;">
                <span style="font-size:20px;font-weight:800;color:white;">DEVIA<span style="color:#86EFAC;">-MAINT</span></span>
            </a>
        </div>

        <!-- Texte central -->
        <div style="z-index:1;">
            <h2 style="font-size:clamp(1.6rem,2.5vw,2.2rem);font-weight:900;color:white;line-height:1.2;margin-bottom:16px;">
                Bienvenue sur votre espace de gestion
            </h2>
            <p style="color:rgba(255,255,255,0.75);font-size:16px;line-height:1.6;margin-bottom:40px;">
                Suivez vos tickets en temps réel, consultez l'état de vos réparations et gérez vos équipements informatiques.
            </p>

            <!-- Statistiques -->
            <div class="left-stat">
                <div class="left-stat-icon">
                    <svg style="width:20px;height:20px;color:white;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:22px;font-weight:800;color:white;">+500</div>
                    <div style="font-size:13px;color:rgba(255,255,255,0.7);">Tickets traités ce mois</div>
                </div>
            </div>

            <div class="left-stat">
                <div class="left-stat-icon">
                    <svg style="width:20px;height:20px;color:white;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:22px;font-weight:800;color:white;">98%</div>
                    <div style="font-size:13px;color:rgba(255,255,255,0.7);">Taux de satisfaction client</div>
                </div>
            </div>
        </div>

        <!-- Footer gauche -->
        <div style="font-size:12px;color:rgba(255,255,255,0.5);z-index:1;">
            © {{ date('Y') }} DEVIA-MAINT — Plateforme IT Professionnelle
        </div>
    </div>

    <!-- ====== PANNEAU DROIT (FORMULAIRE) ====== -->
    <div class="right-panel">
        <div class="form-card">

            <!-- Header du formulaire -->
            <div style="text-align:center;margin-bottom:36px;">
                <!-- Logo mobile -->
                <div style="display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:24px;">
                    <div style="width:38px;height:38px;background:linear-gradient(135deg,#2563EB,#1D4ED8);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:20px;height:20px;color:white;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                        </svg>
                    </div>
                    <span style="font-size:18px;font-weight:800;color:#1E40AF;">DEVIA<span style="color:#059669;">-MAINT</span></span>
                </div>

                <h1 style="font-size:26px;font-weight:800;color:#111827;margin-bottom:8px;">Connexion</h1>
                <p style="font-size:14px;color:#9CA3AF;">Accédez à votre espace de gestion</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div style="background:#DCFCE7;border:1px solid #86EFAC;color:#166534;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:20px;">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Formulaire -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="field-group">
                    <label class="field-label" for="email">Adresse Email</label>
                    <div class="field-wrapper">
                        <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input id="email" type="email" name="email"
                               class="field-input"
                               value="{{ old('email') }}"
                               placeholder="votre@email.com"
                               required autofocus autocomplete="username">
                    </div>
                    @error('email')
                        <div class="error-msg">
                            <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="field-group">
                    <label class="field-label" for="password">Mot de Passe</label>
                    <div class="field-wrapper">
                        <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input id="password" type="password" name="password"
                               class="field-input"
                               placeholder="••••••••"
                               required autocomplete="current-password"
                               style="padding-right:48px;">
                        <button type="button" class="toggle-pw" onclick="togglePw('password', this)" title="Afficher/Masquer">
                            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-msg">
                            <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Se souvenir + Mot de passe oublié -->
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;">
                    <label class="checkbox-label">
                        <input class="checkbox-input" type="checkbox" name="remember" id="remember_me">
                        Se souvenir de moi
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           style="font-size:13px;color:#2563EB;text-decoration:none;font-weight:500;transition:color 0.2s;"
                           onmouseover="this.style.color='#1D4ED8'"
                           onmouseout="this.style.color='#2563EB'">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <!-- Bouton connexion -->
                <button type="submit" class="btn-submit">
                    <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Se connecter
                </button>

                <!-- Séparateur -->
                <div style="display:flex;align-items:center;gap:12px;margin:24px 0;">
                    <div style="flex:1;height:1px;background:#E5E7EB;"></div>
                    <span style="font-size:13px;color:#9CA3AF;">ou</span>
                    <div style="flex:1;height:1px;background:#E5E7EB;"></div>
                </div>

                <!-- Lien inscription -->
                @if (Route::has('register'))
                <div style="text-align:center;">
                    <p style="font-size:14px;color:#6B7280;margin-bottom:4px;">Nouveau client ? Créez votre compte</p>
                    <a href="{{ route('register') }}"
                       style="display:inline-flex;align-items:center;gap:6px;color:#059669;font-weight:600;text-decoration:none;font-size:14px;transition:color 0.2s;"
                       onmouseover="this.style.color='#047857'"
                       onmouseout="this.style.color='#059669'">
                        S'inscrire →
                    </a>
                    <p style="font-size:12px;color:#D1D5DB;margin-top:4px;">Réservé aux clients uniquement</p>
                </div>
                @endif
            </form>

        </div>
    </div>

    <!-- Retour accueil -->
    <a href="/"
       style="position:fixed;top:20px;right:20px;background:white;color:#6B7280;text-decoration:none;padding:8px 16px;border-radius:10px;font-size:13px;font-weight:500;box-shadow:0 2px 8px rgba(0,0,0,0.1);display:flex;align-items:center;gap:6px;transition:all 0.2s;"
       onmouseover="this.style.color='#2563EB';this.style.boxShadow='0 4px 16px rgba(37,99,235,0.2)'"
       onmouseout="this.style.color='#6B7280';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
        <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Accueil
    </a>

    <script>
        function togglePw(fieldId, btn) {
            const input = document.getElementById(fieldId);
            if (input.type === 'password') {
                input.type = 'text';
                btn.style.color = '#2563EB';
            } else {
                input.type = 'password';
                btn.style.color = '#9CA3AF';
            }
        }
    </script>
</body>
</html>
