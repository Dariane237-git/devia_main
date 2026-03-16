<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: 600; color: #1F2937; margin: 0;">
            {{ __('Assigner une Intervention (Technicien)') }}
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
        
        .form-group { margin-bottom: 16px; }
        .form-group:last-child { margin-bottom: 0; }
        
        .form-label { display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .form-input, .form-select { width: 100%; border: 1px solid #D1D5DB; border-radius: 8px; padding: 12px 16px; font-size: 14px; color: #111827; background: #fff; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box;}
        .form-input:focus, .form-select:focus { border-color: #2563EB; outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
        .error-text { color: #DC2626; font-size: 12px; margin-top: 4px; display: block; }
        
        .form-actions { display: flex; justify-content: flex-end; padding-top: 24px; border-top: 1px solid #E5E7EB; margin-top: 32px; }
        .btn-submit { background: linear-gradient(135deg, #2563EB, #10B981); color: white; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; text-decoration: none; border: none; cursor: pointer; transition: transform 0.2s;}
        .btn-submit:hover { transform: translateY(-1px); }

        .dev-box { background: #EFF6FF; border: 1px solid #BFDBFE; padding: 16px; border-radius: 8px; margin-bottom: 24px; }
        .dev-text { color: #1E40AF; font-size: 14px; font-weight: 500; }
    </style>

    <div class="page-container">
        <div class="card">
            
            <a href="{{ route('interventions.index') }}" class="back-link">
                <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour au planning
            </a>

            @if($devisSelectionne)
                <div class="dev-box">
                    <div class="dev-text">
                        <strong>Création depuis un devis accepté :</strong><br>
                        Vous êtes sur le point d'assigner l'intervention pour le <strong>Devis #DVS-{{ str_pad($devisSelectionne->id, 4, '0', STR_PAD_LEFT) }}</strong> 
                        (Ticket #TKT-{{ str_pad($devisSelectionne->ticket->id, 4, '0', STR_PAD_LEFT) }} de {{ $devisSelectionne->ticket->client->utilisateur->nom ?? 'Client' }}).
                    </div>
                </div>
            @endif

            <form action="{{ route('interventions.store') }}" method="POST">
                @csrf
                
                <div class="form-grid">
                    
                    <div class="form-group col-span-2">
                        <label class="form-label">Assigner à un Devis Validé <span style="color:#EF4444;">*</span></label>
                        @if($devisSelectionne)
                            <select name="id_devis" class="form-select" readonly style="background-color: #F3F4F6; cursor: not-allowed;">
                                <option value="{{ $devisSelectionne->id }}" selected>
                                    Devis #DVS-{{ str_pad($devisSelectionne->id, 4, '0', STR_PAD_LEFT) }} | Ticket #TKT-{{ str_pad($devisSelectionne->ticket->id, 4, '0', STR_PAD_LEFT) }} - {{ $devisSelectionne->ticket->client->utilisateur->nom ?? '' }}
                                </option>
                            </select>
                        @else
                            <select name="id_devis" class="form-select" required>
                                <option value="" disabled selected>Sélectionner un devis en attente d'intervention...</option>
                                @foreach($devisDisponibles as $devis)
                                    <option value="{{ $devis->id }}" {{ old('id_devis') == $devis->id ? 'selected' : '' }}>
                                        Devis #DVS-{{ str_pad($devis->id, 4, '0', STR_PAD_LEFT) }} | Ticket #TKT-{{ str_pad($devis->ticket->id ?? 0, 4, '0', STR_PAD_LEFT) }} - {{ $devis->ticket->client->utilisateur->nom ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        @error('id_devis') <span class="error-text">{{ $message }}</span> @enderror
                        <p style="font-size:12px; color:#6B7280; margin-top:6px;">Seuls les devis avec le statut "Accepté" et sans intervention en cours apparaissent ici.</p>
                    </div>

                    <div class="form-group col-span-2">
                        <label class="form-label">Assigner au Technicien <span style="color:#EF4444;">*</span></label>
                        <select name="id_tech" class="form-select" required>
                            <option value="" disabled selected>Choisir le technicien responsable...</option>
                            @foreach($techniciens as $tech)
                                <option value="{{ $tech->id }}" {{ old('id_tech') == $tech->id ? 'selected' : '' }}>
                                    {{ $tech->utilisateur->prenom ?? '' }} {{ $tech->utilisateur->nom ?? '' }} 
                                    (Spécialité : {{ $tech->specialite ?? 'Général' }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_tech') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date de début Prévue <span style="color:#EF4444;">*</span></label>
                        <input type="datetime-local" name="date_debut" value="{{ old('date_debut', now()->format('Y-m-d\TH:i')) }}" class="form-input" required>
                        @error('date_debut') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date de fin Prévue (Optionnel)</label>
                        <input type="datetime-local" name="date_fin" value="{{ old('date_fin') }}" class="form-input">
                        @error('date_fin') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        Assigner le Ticket au Technicien
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
