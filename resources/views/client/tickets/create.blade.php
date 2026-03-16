<x-client-layout>
    <x-slot name="header">Déclarer une Panne</x-slot>

    <style>
        .form-card { background: white; border-radius: 16px; padding: 32px; border: 1px solid #E5E7EB; max-width: 700px; margin: 0 auto; }
        .form-group { margin-bottom: 24px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .form-input { width: 100%; padding: 12px; border: 1px solid #D1D5DB; border-radius: 10px; font-size: 14px; background: #F9FAFB; transition: border-color 0.2s; box-sizing: border-box; }
        .form-input:focus { border-color: #2563EB; outline: none; background: white; }
        .btn-submit { background: linear-gradient(135deg, #2563EB, #10B981); color: white; padding: 12px 24px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; transition: transform 0.2s; }
        .btn-submit:hover { transform: translateY(-1px); }
        .priority-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
        .priority-option { display: none; }
        .priority-label {
            display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 16px 8px;
            border: 2px solid #E5E7EB; border-radius: 12px; cursor: pointer; transition: all 0.2s; text-align: center;
            font-size: 13px; font-weight: 600; color: #6B7280;
        }
        .priority-option:checked + .priority-label { border-color: #2563EB; background: #EFF6FF; color: #2563EB; }
    </style>

    <div style="margin-bottom:24px;max-width:700px;margin:0 auto 24px;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h2 style="font-size:24px;font-weight:800;color:#111827;">Nouvelle Déclaration</h2>
            <p style="color:#6B7280;font-size:14px;">Décrivez votre problème pour que notre équipe puisse intervenir.</p>
        </div>
        <a href="{{ route('client.tickets.index') }}" style="color:#6B7280;text-decoration:none;font-size:14px;font-weight:600;display:flex;align-items:center;gap:6px;">
            <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('client.tickets.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Quel matériel est concerné ? <span style="color:#EF4444;">*</span></label>
                <select name="id_mat" class="form-input" required>
                    <option value="" disabled selected>Sélectionnez votre appareil...</option>
                    @foreach($materiels as $mat)
                        <option value="{{ $mat->id }}">{{ $mat->nom }} - {{ $mat->marque }} {{ $mat->modele }}</option>
                    @endforeach
                </select>
                @error('id_mat') <span style="color:#EF4444;font-size:12px;">{{ $message }}</span> @enderror
                @if($materiels->isEmpty())
                    <p style="color:#F59E0B;font-size:12px;margin-top:8px;">⚠️ Aucun matériel enregistré. Contactez l'agent d'accueil pour enregistrer votre appareil.</p>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label">Décrivez le problème <span style="color:#EF4444;">*</span></label>
                <textarea name="description_panne" class="form-input" rows="5" placeholder="Mon écran ne s'allume plus depuis ce matin..." required minlength="10">{{ old('description_panne') }}</textarea>
                @error('description_panne') <span style="color:#EF4444;font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Niveau d'urgence <span style="color:#EF4444;">*</span></label>
                <div class="priority-grid">
                    <div>
                        <input type="radio" name="priorite" value="Basse" id="p-basse" class="priority-option">
                        <label for="p-basse" class="priority-label">🟢<br>Basse</label>
                    </div>
                    <div>
                        <input type="radio" name="priorite" value="Moyenne" id="p-moyenne" class="priority-option" checked>
                        <label for="p-moyenne" class="priority-label">🟡<br>Moyenne</label>
                    </div>
                    <div>
                        <input type="radio" name="priorite" value="Haute" id="p-haute" class="priority-option">
                        <label for="p-haute" class="priority-label">🟠<br>Haute</label>
                    </div>
                    <div>
                        <input type="radio" name="priorite" value="Critique" id="p-critique" class="priority-option">
                        <label for="p-critique" class="priority-label">🔴<br>Critique</label>
                    </div>
                </div>
                @error('priorite') <span style="color:#EF4444;font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div style="text-align:right;padding-top:16px;border-top:1px solid #F3F4F6;">
                <button type="submit" class="btn-submit">
                    <svg style="width:18px;height:18px;display:inline;vertical-align:middle;margin-right:6px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Envoyer ma demande
                </button>
            </div>
        </form>
    </div>
</x-client-layout>
