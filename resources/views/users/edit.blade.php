<x-app-layout>
    <x-slot name="header">
        Modifier l'Utilisateur
    </x-slot>

    <style>
        .page-header {
            display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;
        }

        .btn-back {
            background: white; color: #4B5563; padding: 8px 16px; border-radius: 8px;
            font-size: 13px; font-weight: 600; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
            border: 1px solid #D1D5DB; transition: all 0.2s;
        }
        .btn-back:hover { background: #F3F4F6; }

        .form-card {
            background: white; border-radius: 16px; padding: 32px;
            border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); max-width: 800px;
        }

        .form-section { margin-bottom: 32px; }
        .section-title {
            font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 16px; 
            padding-bottom: 8px; border-bottom: 1px solid #F3F4F6;
        }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width:600px){ .grid-2 { grid-template-columns: 1fr; } }

        .field-group { margin-bottom: 20px; }
        .field-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .field-input {
            width: 100%; padding: 10px 14px; border: 1px solid #D1D5DB;
            border-radius: 8px; font-size: 14px; transition: all 0.2s;
            background: #F9FAFB;
        }
        .field-input:focus { border-color: #2563EB; background: white; outline: none; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .error-msg { color: #EF4444; font-size: 12px; margin-top: 4px; display:block; }

        .btn-submit {
            background: #2563EB; color: white; padding: 12px 24px;
            border-radius: 8px; font-size: 15px; font-weight: 600; border: none;
            cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
            transition: background 0.2s;
        }
        .btn-submit:hover { background: #1D4ED8; }
    </style>

    <div class="page-header">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 4px;">Édition de Profil</h2>
            <p style="color: #6B7280; font-size: 14px;">Modifiez les informations de l'utilisateur {{ $user->prenom }} {{ $user->nom }}.</p>
        </div>
        <a href="{{ route('users.index') }}" class="btn-back">
            <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour à la liste
        </a>
    </div>

    <!-- Alpine X-DATA pour gérer l'affichage conditionnel -->
    <div class="form-card" x-data="{ selectedRole: '{{ old('id_role', $user->id_role) }}' }">
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <!-- Informations de base -->
            <div class="form-section">
                <div class="section-title">Informations Personnelles</div>
                <div class="grid-2">
                    <div class="field-group">
                        <label class="field-label" for="nom">Nom <span style="color:#EF4444;">*</span></label>
                        <input id="nom" type="text" name="nom" class="field-input" value="{{ old('nom', $user->nom) }}" required>
                        @error('nom') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="prenom">Prénom <span style="color:#EF4444;">*</span></label>
                        <input id="prenom" type="text" name="prenom" class="field-input" value="{{ old('prenom', $user->prenom) }}" required>
                        @error('prenom') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field-group">
                        <label class="field-label" for="email">Adresse Email <span style="color:#EF4444;">*</span></label>
                        <input id="email" type="email" name="email" class="field-input" value="{{ old('email', $user->email) }}" required>
                        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="tel">Téléphone</label>
                        <input id="tel" type="text" name="tel" class="field-input" value="{{ old('tel', $user->tel) }}">
                        @error('tel') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Rôle & Spécificités -->
            <div class="form-section">
                <div class="section-title">Accès & Rôle</div>
                
                <div class="field-group" style="max-width: 50%;">
                    <label class="field-label" for="id_role">Assigner un rôle <span style="color:#EF4444;">*</span></label>
                    <select id="id_role" name="id_role" class="field-input" x-model="selectedRole" required>
                        <option value="" disabled>Sélectionnez un rôle...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->nom_role }}</option>
                        @endforeach
                    </select>
                    @error('id_role') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <!-- Champs Client -->
                <div x-show="selectedRole == 1" style="display:none; background:#F0FDF4; padding:20px; border-radius:12px; border:1px solid #DCFCE7; margin-top:20px;">
                    <div style="font-weight:600; color:#166534; font-size:14px; margin-bottom:12px;">Profil Client Complémentaire</div>
                    <div class="grid-2">
                        <div class="field-group" style="margin-bottom:0;">
                            <label class="field-label">Type de client <span style="color:#EF4444;">*</span></label>
                            <select name="type_clt" class="field-input" :required="selectedRole == 1">
                                <option value="" disabled>Choisir...</option>
                                <option value="Particulier" {{ old('type_clt', optional($user->client)->type_clt) == 'Particulier' ? 'selected' : '' }}>Particulier</option>
                                <option value="Entreprise" {{ old('type_clt', optional($user->client)->type_clt) == 'Entreprise' ? 'selected' : '' }}>Entreprise</option>
                            </select>
                            @error('type_clt') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="field-group" style="margin-bottom:0;">
                            <label class="field-label">Adresse (Optionnel)</label>
                            <input type="text" name="adresse_clt" class="field-input" value="{{ old('adresse_clt', optional($user->client)->adresse_clt) }}">
                            @error('adresse_clt') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Champs Technicien -->
                <div x-show="selectedRole == 4" style="display:none; background:#FFF7ED; padding:20px; border-radius:12px; border:1px solid #FFEDD5; margin-top:20px;">
                    <div style="font-weight:600; color:#9A3412; font-size:14px; margin-bottom:12px;">Profil Technicien Complémentaire</div>
                    <div class="field-group" style="margin-bottom:0; max-width: 50%;">
                        <label class="field-label">Spécialité Principale</label>
                        <input type="text" name="specialite" class="field-input" value="{{ old('specialite', optional($user->technicien)->specialite) }}" placeholder="Ex: Réseaux, Matériel, Logiciel...">
                        @error('specialite') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Mot de passe -->
            <div class="form-section" style="margin-bottom: 24px;">
                <div class="section-title">Sécurité (Optionnel)</div>
                <div class="grid-2">
                    <div class="field-group">
                        <label class="field-label" for="password">Nouveau mot de passe</label>
                        <input id="password" type="password" name="password" class="field-input">
                        <span style="font-size:12px;color:#9CA3AF;margin-top:4px;display:block;">Laissez vide si vous ne souhaitez pas le changer.</span>
                        @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="password_confirmation">Confirmer le mot de passe</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="field-input">
                    </div>
                </div>
            </div>

            <!-- Validation -->
            <div style="padding-top: 24px; border-top: 1px solid #F3F4F6; text-align: right;">
                <button type="submit" class="btn-submit">
                    Enregistrer les modifications
                    <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
