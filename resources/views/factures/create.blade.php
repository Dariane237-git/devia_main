<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: 600; color: #1F2937; margin: 0;">
            {{ __('Générer une Facture Finale') }}
        </h2>
    </x-slot>

    <div style="padding: 32px; max-width: 800px; margin: 0 auto;">
        
        <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #E5E7EB;">
            
            <div style="background: #F9FAFB; padding: 20px 24px; border-bottom: 1px solid #E5E7EB; border-radius: 16px 16px 0 0;">
                <h3 style="font-size: 16px; font-weight: 700; color: #111827; margin:0;">Informations du Devis #{{ $devis->id }}</h3>
                <p style="font-size: 14px; color: #6B7280; margin: 4px 0 0 0;">Client : {{ $devis->ticket->client->utilisateur->prenom ?? '' }} {{ $devis->ticket->client->utilisateur->nom ?? '' }}</p>
                <p style="font-size: 14px; color: #6B7280; margin: 4px 0 0 0;">Matériel : {{ $devis->ticket->materiel->nom ?? 'Inconnu' }}</p>
                <p style="font-size: 14px; color: #6B7280; margin: 4px 0 0 0;">Montant Estimé Initial : <strong style="color: #2563EB;">{{ number_format($devis->mont_estimer, 0, ',', ' ') }} FCFA</strong></p>
            </div>

            <div style="padding: 32px;">
                <form action="{{ route('factures.store') }}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="id_devis" value="{{ $devis->id }}">

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                            Montant Total Définitif de la Réparation (FCFA) <span style="color:#EF4444;">*</span>
                        </label>
                        <input type="number" 
                               name="mont_total" 
                               value="{{ old('mont_total', $devis->mont_estimer) }}" 
                               required 
                               min="0"
                               style="width: 100%; border: 1px solid #D1D5DB; border-radius: 8px; padding: 12px 16px; font-size: 16px; font-weight: 700; color: #111827;">
                        <p style="font-size: 12px; color: #6B7280; margin-top: 6px;">
                            Ajustez ce montant en fonction des pièces réellement utilisées et du temps passé par le technicien.
                        </p>
                        @error('mont_total') <span style="color:#DC2626; font-size:12px; display:block; margin-top:4px;">{{ $message }}</span> @enderror
                    </div>

                    <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px;">
                        <a href="{{ route('tickets.index') }}" style="padding: 10px 20px; background: white; color: #374151; border: 1px solid #D1D5DB; border-radius: 10px; font-weight: 600; text-decoration: none; font-size: 14px;">Annuler</a>
                        <button type="submit" style="padding: 10px 20px; background: linear-gradient(135deg, #2563EB, #1D4ED8); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 14px;">
                            Générer la Facture Finale
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
        
    </div>
</x-app-layout>
