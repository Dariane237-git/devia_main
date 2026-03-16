<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: 600; color: #1F2937; margin: 0;">
            {{ __('Enregistrer un Matériel') }}
        </h2>
    </x-slot>

    <style>
        .page-container { padding: 32px; max-width: 800px; margin: 0 auto; }
        .card { background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 32px; border: 1px solid #E5E7EB; }
        
        .back-link { display: inline-flex; align-items: center; gap: 4px; color: #2563EB; font-size: 14px; font-weight: 500; text-decoration: none; margin-bottom: 24px; transition: color 0.2s;}
        .back-link:hover { color: #1E40AF; }
        
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 24px; }
        @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } }
        
        .col-span-2 { grid-column: span 2; }
        .section-box { background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 12px; padding: 20px; }
        .section-title { font-size: 13px; font-weight: 700; color: #4B5563; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; border-bottom: 1px solid #E5E7EB; padding-bottom: 8px;}
        
        .form-group { margin-bottom: 16px; }
        .form-group:last-child { margin-bottom: 0; }
        
        .form-label { display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .form-input, .form-select { width: 100%; border: 1px solid #D1D5DB; border-radius: 8px; padding: 10px 14px; font-size: 14px; color: #111827; background: #fff; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box;}
        .form-input:focus, .form-select:focus { border-color: #2563EB; outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
        .error-text { color: #DC2626; font-size: 12px; margin-top: 4px; display: block; }
        
        .form-actions { display: flex; justify-content: flex-end; padding-top: 24px; border-top: 1px solid #E5E7EB; margin-top: 32px; }
        .btn-submit { background: linear-gradient(135deg, #2563EB, #10B981); color: white; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; text-decoration: none; border: none; cursor: pointer; transition: transform 0.2s;}
        .btn-submit:hover { transform: translateY(-1px); }
    </style>

    <div class="page-container">
        <div class="card">
            
            <a href="{{ route('materiels.index') }}" class="back-link">
                <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à la liste
            </a>

            <form action="{{ route('materiels.store') }}" method="POST">
                @csrf
                
                <div class="form-grid">
                    <!-- Section Client -->
                    <div class="col-span-2 section-box">
                        <div class="section-title">Propriétaire du Matériel</div>
                        <div class="form-group">
                            <label class="form-label">Sélectionner le Client <span style="color:#EF4444;">*</span></label>
                            <select name="id_client" class="form-select" required>
                                <option value="" disabled selected>Choisir un client...</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('id_client') == $client->id ? 'selected' : '' }}>
                                        {{ $client->utilisateur->nom ?? 'Inconnu' }} {{ $client->utilisateur->prenom ?? '' }} 
                                        ({{ $client->type_clt }} - {{ $client->utilisateur->email ?? 'Sans email' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_client') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Infos Matériel -->
                    <div class="col-span-2">
                        <div class="section-title" style="border:none; margin-bottom:8px;">Informations de l'appareil</div>
                    </div>

                    <div class="form-group col-span-2">
                        <label class="form-label">Type de Matériel <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex: PC Portable, Imprimante, Routeur..." class="form-input" required>
                        @error('nom') <span class="error-text">{{ $message }}</span> @enderror
                    </div>



                    <div class="form-group">
                        <label class="form-label">Date d'achat</label>
                        <input type="date" name="date_achat" value="{{ old('date_achat') }}" class="form-input">
                        @error('date_achat') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Marque</label>
                        <input type="text" name="marque" value="{{ old('marque') }}" placeholder="Ex: Dell, HP, Apple..." class="form-input">
                        @error('marque') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Modèle</label>
                        <input type="text" name="modele" value="{{ old('modele') }}" placeholder="Ex: XPS 15, LaserJet Pro..." class="form-input">
                        @error('modele') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-span-2">
                        <label class="form-label">Garantie</label>
                        <input type="text" name="garantie" value="{{ old('garantie') }}" placeholder="Ex: 1 an, 24 mois, Expirée..." class="form-input">
                        @error('garantie') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        Enregistrer le matériel
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
