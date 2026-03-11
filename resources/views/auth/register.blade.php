<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription — DEVIA-MAINT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #F0FDF4 0%, #E0F2FE 40%, #EFF6FF 100%);
        }

        /* ====== PANNEAU GAUCHE ====== */
        .left-panel {
            display: none;
            width: 380px;
            flex-shrink: 0;
            background: linear-gradient(160deg, #059669 0%, #10B981 40%, #2563EB 100%);
            padding: 48px 40px;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        @media (min-width: 1000px) {
            .left-panel { display: flex; }
        }
        .left-panel::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 350px; height: 350px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -80px;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 24px;
        }
        .step-num {
            width: 32px; height: 32px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            color: white;
            flex-shrink: 0;
        }

        /* ====== PANNEAU DROIT ====== */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 32px 24px;
            overflow-y: auto;
        }

        .form-card {
            width: 100%;
            max-width: 520px;
            background: white;
            border-radius: 24px;
            padding: 44px 44px;
            box-shadow: 0 25px 60px -12px rgba(5,150,105,0.15), 0 0 0 1px rgba(209,250,229,0.5);
            animation: fadeInUp 0.6s ease both;
            margin: 16px 0;
        }

        @keyframes fadeInUp {
            from { opacity:0; transform:translateY(24px); }
            to { opacity:1; transform:translateY(0); }
        }

        /* ====== Grille 2 colonnes ====== */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        @media (max-width: 500px) {
            .grid-2 { grid-template-columns: 1fr; }
            .form-card { padding: 32px 24px; }
        }

        /* ====== CHAMPS ====== */
        .field-group { margin-bottom: 18px; }

        .field-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .field-label .required {
            color: #EF4444;
            margin-left: 2px;
        }
        .field-label .optional {
            color: #9CA3AF;
            font-weight: 400;
            font-size: 12px;
            margin-left: 4px;
        }

        .field-wrapper { position: relative; }

        .field-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            width: 17px; height: 17px;
            pointer-events: none;
            transition: color 0.3s;
        }

        .field-input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 2px solid #E5E7EB;
            border-radius: 11px;
            font-size: 14px;
            color: #111827;
            background: #F9FAFB;
            transition: all 0.3s ease;
            outline: none;
        }
        .field-input:focus {
            border-color: #10B981;
            background: white;
            box-shadow: 0 0 0 4px rgba(16,185,129,0.1);
        }
        .field-wrapper:focus-within .field-icon { color: #10B981; }

        .field-select {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 2px solid #E5E7EB;
            border-radius: 11px;
            font-size: 14px;
            color: #111827;
            background: #F9FAFB;
            transition: all 0.3s ease;
            outline: none;
            appearance: none;
            cursor: pointer;
        }
        .field-select:focus {
            border-color: #10B981;
            background: white;
            box-shadow: 0 0 0 4px rgba(16,185,129,0.1);
        }

        .error-msg {
            color: #EF4444;
            font-size: 12px;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ====== Séparateur section ====== */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0 20px;
        }
        .section-divider div { flex:1; height:1px; background:#E5E7EB; }
        .section-divider span {
            font-size: 12px;
            font-weight: 700;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            white-space: nowrap;
        }

        /* ====== Bouton ====== */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10B981, #059669);
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
            box-shadow: 0 12px 28px rgba(5,150,105,0.35);
        }

        /* ====== Toggle password ====== */
        .toggle-pw {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9CA3AF;
            padding: 0;
            transition: color 0.2s;
        }
        .toggle-pw:hover { color: #10B981; }

        /* ====== Badge info ====== */
        .info-badge {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            border-radius: 10px;
            padding: 12px 16px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #065F46;
        }
    </style>
</head>
<body>

    <!-- ====== PANNEAU GAUCHE ====== -->
    <div class="left-panel">
        <div>
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:32px;">
                <div style="width:40px;height:40px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(10px);">
                    <svg style="width:22px;height:22px;color:white;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                    </svg>
                </div>
                <a href="/" style="text-decoration:none;">
                    <span style="font-size:20px;font-weight:800;color:white;">DEVIA<span style="color:#A7F3D0;">-MAINT</span></span>
                </a>
            </div>

            <h2 style="font-size:1.7rem;font-weight:900;color:white;margin-bottom:12px;line-height:1.2;">
                Créez votre compte client
            </h2>
            <p style="color:rgba(255,255,255,0.75);font-size:14px;line-height:1.6;margin-bottom:36px;">
                Rejoignez DEVIA-MAINT pour gérer vos demandes de maintenance informatique en ligne.
            </p>

            <!-- Étapes -->
            <div class="step-item">
                <div class="step-num">1</div>
                <div>
                    <div style="font-weight:700;color:white;font-size:14px;margin-bottom:3px;">Vos informations personnelles</div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.65);">Nom, prénom, email, téléphone</div>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div>
                    <div style="font-weight:700;color:white;font-size:14px;margin-bottom:3px;">Votre profil client</div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.65);">Adresse, type (particulier ou entreprise)</div>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div>
                    <div style="font-weight:700;color:white;font-size:14px;margin-bottom:3px;">Sécurisez votre accès</div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.65);">Choisissez un mot de passe sécurisé</div>
                </div>
            </div>

            <!-- Séparateur -->
            <div style="height:1px;background:rgba(255,255,255,0.15);margin:28px 0;"></div>

            <!-- Note -->
            <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:16px;border:1px solid rgba(255,255,255,0.15);">
                <div style="font-size:12px;font-weight:700;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:6px;">Note importante</div>
                <p style="font-size:13px;color:rgba(255,255,255,0.8);line-height:1.5;">L'inscription est <strong style="color:white;">réservée aux clients</strong>. Les agents, techniciens et responsables doivent utiliser leurs identifiants fournis par l'entreprise.</p>
            </div>
        </div>

        <div style="font-size:12px;color:rgba(255,255,255,0.45);z-index:1;">
            © {{ date('Y') }} DEVIA-MAINT — Projet BTS GSI
        </div>
    </div>

    <!-- ====== PANNEAU DROIT ====== -->
    <div class="right-panel">
        <div class="form-card">

            <!-- Header -->
            <div style="text-align:center;margin-bottom:28px;">
                <div style="display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:20px;">
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,#10B981,#059669);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:18px;height:18px;color:white;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <span style="font-size:18px;font-weight:800;color:#1E40AF;">DEVIA<span style="color:#059669;">-MAINT</span></span>
                </div>
                <h1 style="font-size:24px;font-weight:800;color:#111827;margin-bottom:6px;">Créer un compte</h1>
                <p style="font-size:13px;color:#9CA3AF;">Remplissez tous les champs pour créer votre compte client</p>
            </div>

            <!-- Badge info -->
            <div class="info-badge">
                <svg style="width:18px;height:18px;flex-shrink:0;margin-top:1px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Ce formulaire est <strong>exclusivement réservé aux clients</strong>. Si vous êtes un employé de l'entreprise, connectez-vous avec vos identifiants.</span>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- ─── SECTION 1 : Informations personnelles ─── -->
                <div class="section-divider">
                    <div></div>
                    <span>Informations personnelles</span>
                    <div></div>
                </div>

                <div class="grid-2">
                    <!-- Nom -->
                    <div class="field-group">
                        <label class="field-label" for="nom">
                            Nom <span class="required">*</span>
                        </label>
                        <div class="field-wrapper">
                            <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <input id="nom" type="text" name="nom"
                                   class="field-input"
                                   value="{{ old('nom') }}"
                                   placeholder="Noumssi"
                                   required maxlength="100">
                        </div>
                        @error('nom')
                            <div class="error-msg">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div class="field-group">
                        <label class="field-label" for="prenom">
                            Prénom <span class="required">*</span>
                        </label>
                        <div class="field-wrapper">
                            <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <input id="prenom" type="text" name="prenom"
                                   class="field-input"
                                   value="{{ old('prenom') }}"
                                   placeholder="Dariane"
                                   required maxlength="100">
                        </div>
                        @error('prenom')
                            <div class="error-msg">⚠ {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="field-group">
                    <label class="field-label" for="email">
                        Adresse Email <span class="required">*</span>
                    </label>
                    <div class="field-wrapper">
                        <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input id="email" type="email" name="email"
                               class="field-input"
                               value="{{ old('email') }}"
                               placeholder="kengnejosy74@gmail.com"
                               required maxlength="150">
                    </div>
                    @error('email')
                        <div class="error-msg">⚠ {{ $message }}</div>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div class="field-group">
                    <label class="field-label" for="tel">
                        Téléphone <span class="optional">(optionnel)</span>
                    </label>
                    <div class="field-wrapper">
                        <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <input id="tel" type="tel" name="tel"
                               class="field-input"
                               value="{{ old('tel') }}"
                               placeholder="+237 6 00 00 00 00"
                               maxlength="20">
                    </div>
                    @error('tel')
                        <div class="error-msg">⚠ {{ $message }}</div>
                    @enderror
                </div>

                <!-- ─── SECTION 2 : Profil Client ─── -->
                <div class="section-divider">
                    <div></div>
                    <span>Profil client</span>
                    <div></div>
                </div>

                <!-- Type de client -->
                <div class="field-group">
                    <label class="field-label" for="type_clt">
                        Type de client <span class="required">*</span>
                    </label>
                    <div class="field-wrapper">
                        <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <select id="type_clt" name="type_clt" class="field-select" required>
                            <option value="" disabled {{ old('type_clt') ? '' : 'selected' }}>Sélectionnez votre profil…</option>
                            <option value="Particulier" {{ old('type_clt') == 'Particulier' ? 'selected' : '' }}>👤 Particulier</option>
                            <option value="Entreprise" {{ old('type_clt') == 'Entreprise' ? 'selected' : '' }}>🏢 Entreprise</option>
                        </select>
                        <!-- Flèche select -->
                        <svg style="position:absolute;right:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#9CA3AF;pointer-events:none;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    @error('type_clt')
                        <div class="error-msg">⚠ {{ $message }}</div>
                    @enderror
                </div>

                <!-- Adresse -->
                <div class="field-group">
                    <label class="field-label" for="adresse_clt">
                        Adresse <span class="optional">(optionnel)</span>
                    </label>
                    <div class="field-wrapper">
                        <svg class="field-icon" style="top:14px;transform:none;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <textarea id="adresse_clt" name="adresse_clt"
                               class="field-input"
                               style="padding-top:11px;resize:vertical;min-height:70px;"
                               placeholder="123 Rue de la Paix, Abidjan..."
                               maxlength="255">{{ old('adresse_clt') }}</textarea>
                    </div>
                    @error('adresse_clt')
                        <div class="error-msg">⚠ {{ $message }}</div>
                    @enderror
                </div>

                <!-- ─── SECTION 3 : Mot de passe ─── -->
                <div class="section-divider">
                    <div></div>
                    <span>Sécurité</span>
                    <div></div>
                </div>

                <div class="grid-2">
                    <!-- Mot de passe -->
                    <div class="field-group">
                        <label class="field-label" for="password">
                            Mot de passe <span class="required">*</span>
                        </label>
                        <div class="field-wrapper">
                            <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <input id="password" type="password" name="password"
                                   class="field-input"
                                   placeholder="••••••••"
                                   required autocomplete="new-password"
                                   style="padding-right:40px;">
                            <button type="button" class="toggle-pw" onclick="togglePw('password', this)">
                                <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-msg">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirmation -->
                    <div class="field-group">
                        <label class="field-label" for="password_confirmation">
                            Confirmation <span class="required">*</span>
                        </label>
                        <div class="field-wrapper">
                            <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   class="field-input"
                                   placeholder="••••••••"
                                   required autocomplete="new-password"
                                   style="padding-right:40px;">
                            <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation', this)">
                                <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Force du mot de passe -->
                <div id="pwStrengthBar" style="display:none;margin-bottom:16px;">
                    <div style="height:4px;background:#E5E7EB;border-radius:9999px;overflow:hidden;margin-bottom:4px;">
                        <div id="pwStrengthFill" style="height:100%;width:0%;background:#EF4444;border-radius:9999px;transition:all 0.3s ease;"></div>
                    </div>
                    <div id="pwStrengthText" style="font-size:12px;color:#6B7280;"></div>
                </div>

                <!-- Bouton -->
                <button type="submit" class="btn-submit">
                    <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Créer mon compte
                </button>

                <!-- Lien connexion -->
                <div style="text-align:center;margin-top:20px;">
                    <p style="font-size:14px;color:#6B7280;">
                        Déjà un compte ?
                        <a href="{{ route('login') }}"
                           style="color:#2563EB;font-weight:600;text-decoration:none;"
                           onmouseover="this.style.color='#1D4ED8'"
                           onmouseout="this.style.color='#2563EB'">
                            Se connecter →
                        </a>
                    </p>
                </div>

            </form>
        </div>
    </div>

    <!-- Retour accueil -->
    <a href="/"
       style="position:fixed;top:20px;right:20px;background:white;color:#6B7280;text-decoration:none;padding:8px 16px;border-radius:10px;font-size:13px;font-weight:500;box-shadow:0 2px 8px rgba(0,0,0,0.1);display:flex;align-items:center;gap:6px;transition:all 0.2s;z-index:99;"
       onmouseover="this.style.color='#059669';this.style.boxShadow='0 4px 16px rgba(5,150,105,0.2)'"
       onmouseout="this.style.color='#6B7280';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
        <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Accueil
    </a>

    <script>
        function togglePw(fieldId, btn) {
            const input = document.getElementById(fieldId);
            input.type = input.type === 'password' ? 'text' : 'password';
            btn.style.color = input.type === 'text' ? '#10B981' : '#9CA3AF';
        }

        // ── Force du mot de passe ──
        const pwInput = document.getElementById('password');
        const bar = document.getElementById('pwStrengthBar');
        const fill = document.getElementById('pwStrengthFill');
        const text = document.getElementById('pwStrengthText');

        pwInput.addEventListener('input', function() {
            const val = this.value;
            bar.style.display = val.length ? 'block' : 'none';
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [
                { w: '25%', c: '#EF4444', t: 'Trop faible' },
                { w: '50%', c: '#F59E0B', t: 'Faible' },
                { w: '75%', c: '#3B82F6', t: 'Moyen' },
                { w: '100%', c: '#10B981', t: 'Fort ✓' },
            ];
            const l = levels[score - 1] || levels[0];
            fill.style.width = val.length ? l.w : '0%';
            fill.style.background = l.c;
            text.textContent = val.length ? l.t : '';
            text.style.color = l.c;
        });
    </script>
</body>
</html>
