<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: 600; color: #1F2937; margin: 0;">
            {{ __('Déclarer une panne (Agent d\'Accueil)') }}
        </h2>
    </x-slot>

    <style>
        .page-container { padding: 32px; max-width: 800px; margin: 0 auto; }
        .card { background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 32px; border: 1px solid #E5E7EB; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 24px; }
        @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } }
        
        .col-span-2 { grid-column: span 2; }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .form-input, .form-select, .form-textarea { width: 100%; border: 1px solid #D1D5DB; border-radius: 8px; padding: 12px 16px; font-size: 14px; color: #111827; background: #fff; box-sizing: border-box; }
        .form-textarea { resize: vertical; min-height: 120px; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: #2563EB; outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
        .error-text { color: #DC2626; font-size: 12px; margin-top: 4px; display: block; }
        
        .btn-submit { background: linear-gradient(135deg, #2563EB, #10B981); color: white; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; border: none; cursor: pointer; transition: transform 0.2s; width: 100%; }
        .btn-submit:hover { transform: translateY(-1px); }
    </style>

    <div class="page-container">
        <div class="card">
            
            <form action="{{ route('agent_accueil.tickets.store') }}" method="POST">
                @csrf
                
                <div class="form-grid">
                    
                    <div class="form-group col-span-2">
                        <label class="form-label">Client <span style="color:#EF4444;">*</span></label>
                        <select name="id_client" id="client_select" class="form-select" required>
                            <option value="" disabled {{ !$selectedClientId ? 'selected' : '' }}>Sélectionnez le client qui se présente...</option>
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}" {{ $selectedClientId == $c->id ? 'selected' : '' }}>
                                    {{ $c->utilisateur->prenom ?? '' }} {{ $c->utilisateur->nom ?? '' }} - {{ $c->entreprise ?? 'Particulier' }}
                                </option>
                            @endforeach
                        </select>
                        <p style="font-size:12px; color:#6B7280; margin-top:6px;">Sélectionnez un client pour charger ses appareils ci-dessous.</p>
                        @error('id_client') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-span-2">
                        <label class="form-label">Appareil concerné <span style="color:#EF4444;">*</span></label>
                        <select name="id_mat" id="mat_select" class="form-select" required>
                            @if(count($materiels) == 0 && !$selectedClientId)
                                <option value="" disabled selected>Veuillez d'abord sélectionner un client avec des matériels enregistrés...</option>
                            @elseif(count($materiels) == 0 && $selectedClientId)
                                <option value="" disabled selected>Ce client n'a aucun appareil enregistré.</option>
                            @else
                                <option value="" disabled {{ !old('id_mat') ? 'selected' : '' }}>Choisir l'appareil en panne...</option>
                                @foreach($materiels as $mat)
                                    <option value="{{ $mat->id }}" {{ old('id_mat') == $mat->id ? 'selected' : '' }}>
                                        {{ $mat->nom }} - {{ $mat->marque }} {{ $mat->modele }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('id_mat') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-span-2">
                        <label class="form-label">Niveau d'Urgence (Priorité) <span style="color:#EF4444;">*</span></label>
                        <select name="priorite" class="form-select" required>
                            <option value="Basse" {{ old('priorite') == 'Basse' ? 'selected' : '' }}>🟡 Basse (Gênant mais non bloquant)</option>
                            <option value="Moyenne" {{ old('priorite') == 'Moyenne' ? 'selected' : '' }}>🟠 Moyenne (Opérations perturbées)</option>
                            <option value="Haute" {{ old('priorite') == 'Haute' ? 'selected' : '' }}>🔴 Haute (Bloquant pour le client)</option>
                            <option value="Critique" {{ old('priorite') == 'Critique' ? 'selected' : '' }}>⚫ Critique (Arrêt total ou urgence absolue)</option>
                        </select>
                        @error('priorite') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-span-2">
                        <label class="form-label">Description détaillée de la panne ressentie <span style="color:#EF4444;">*</span></label>
                        <textarea name="description_panne" class="form-textarea" placeholder="Notez ici les symptômes décrits par le client (ex: L'ordinateur ne s'allume plus, bip sonore répétitif...)" required>{{ old('description_panne') }}</textarea>
                        @error('description_panne') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="margin-top: 32px;">
                    <button type="submit" class="btn-submit">
                        Enregistrer la Demande d'Intervention
                    </button>
                </div>
            </form>

            <!-- Le script JS gère maintenant le chargement dynamique -->
            
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clientSelect = document.getElementById('client_select');
            const matSelect = document.getElementById('mat_select');

            clientSelect.addEventListener('change', function() {
                const clientId = this.value;
                if (!clientId) return;

                // Afficher un état de chargement
                matSelect.innerHTML = '<option value="" disabled selected>Chargement des appareils...</option>';

                fetch(`/api/materiels/client/${clientId}`)
                    .then(response => response.json())
                    .then(data => {
                        matSelect.innerHTML = ''; // Vider le select
                        
                        if (data.length === 0) {
                            matSelect.innerHTML = '<option value="" disabled selected>Ce client n\'a aucun appareil enregistré.</option>';
                            return;
                        }

                        matSelect.innerHTML = '<option value="" disabled selected>Choisir l\'appareil en panne...</option>';
                        data.forEach(mat => {
                            const option = document.createElement('option');
                            option.value = mat.id;
                            option.textContent = `${mat.nom} - ${mat.marque || ''} ${mat.modele || ''}`;
                            matSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des matériels:', error);
                        matSelect.innerHTML = '<option value="" disabled selected>Erreur de chargement des matériels.</option>';
                    });
            });
        });
    </script>
</x-app-layout>
