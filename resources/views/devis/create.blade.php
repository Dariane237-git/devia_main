<x-app-layout>
    <x-slot name="header">
        Créer un nouveau Devis
    </x-slot>

    <style>
        .form-card {
            background: white; border-radius: 16px; padding: 32px;
            border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
            max-width: 800px; margin: 0 auto;
        }
        .form-group { margin-bottom: 24px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .form-input {
            width: 100%; padding: 12px; border: 1px solid #D1D5DB; border-radius: 10px;
            font-size: 14px; background: #F9FAFB; transition: border-color 0.2s;
        }
        .form-input:focus { border-color: #2563EB; outline: none; background: white; }
        .btn-submit {
            background: #2563EB; color: white; padding: 12px 24px; border: none;
            border-radius: 10px; font-weight: 700; cursor: pointer; transition: background 0.2s;
        }
        .btn-submit:hover { background: #1D4ED8; }
    </style>

    <div style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; max-width: 800px; margin: 0 auto 24px;">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #111827;">Nouveau Devis</h2>
            <p style="color: #6B7280; font-size: 14px;">Établissez une estimation pour une réparation.</p>
        </div>
        <a href="{{ route('devis.index') }}" style="color: #6B7280; text-decoration: none; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 6px;">
            <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('devis.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Sélectionner un Ticket <span style="color:#EF4444;">*</span></label>
                <select name="id_ticket" class="form-input" required>
                    <option value="" disabled selected>Choisir un ticket en attente...</option>
                    @foreach($tickets as $ticket)
                        <option value="{{ $ticket->id }}">
                            #TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }} - {{ $ticket->client->utilisateur->prenom ?? '' }} {{ $ticket->client->utilisateur->nom ?? '' }} ({{ $ticket->materiel->nom ?? 'Matériel inconnu' }})
                        </option>
                    @endforeach
                </select>
                @error('id_ticket') <span style="color:#EF4444;font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Date du devis <span style="color:#EF4444;">*</span></label>
                    <input type="date" name="date_devis" class="form-input" value="{{ date('Y-m-d') }}" required>
                    @error('date_devis') <span style="color:#EF4444;font-size:12px;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Montant Estimé (FCFA) <span style="color:#EF4444;">*</span></label>
                    <input type="number" name="mont_estimer" class="form-input" placeholder="0" min="0" required>
                    @error('mont_estimer') <span style="color:#EF4444;font-size:12px;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="text-align: right; padding-top: 12px; border-top: 1px solid #F3F4F6;">
                <button type="submit" class="btn-submit">
                    Générer le devis
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
