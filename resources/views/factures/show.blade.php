<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1F2937; margin: 0;">
                {{ __('Détails Facture') }} #{{ $facture->numero_fac }}
            </h2>
            <a href="{{ route('factures.index') }}" style="color:#6B7280;text-decoration:none;font-size:14px;">&larr; Retour aux factures</a>
        </div>
    </x-slot>

    <div style="padding: 32px; max-width: 900px; margin: 0 auto;">
        
        @if(session('success'))
            <div style="background:#DCFCE7;border:1px solid #86EFAC;color:#166534;padding:16px;border-radius:12px;margin-bottom:24px;display:flex;align-items:center;gap:8px;">
                <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('info'))
            <div style="background:#EFF6FF;border:1px solid #BFDBFE;color:#1E40AF;padding:16px;border-radius:12px;margin-bottom:24px;display:flex;align-items:center;gap:8px;">
                <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('info') }}
            </div>
        @endif

        <div style="background: white; border-radius: 16px; border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); overflow: hidden; margin-bottom: 24px;">
            <div style="padding: 32px; display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:24px; border-bottom:1px solid #F3F4F6;">
                <div>
                    <h3 style="font-size: 28px; font-weight: 900; color: #111827; margin:0 0 8px 0; letter-spacing:-0.5px;">{{ $facture->numero_fac }}</h3>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <span style="padding:4px 10px; border-radius:999px; font-size:12px; font-weight:600; background:#F3F4F6; color:#4B5563;">Type: {{ $facture->type_fac }}</span>
                        @if($facture->statut_paiement == 'Payée')
                            <span style="padding:4px 10px; border-radius:999px; font-size:12px; font-weight:600; background:#F0FDF4; color:#16A34A; border:1px solid #DCFCE7;">✅ Payée</span>
                        @else
                            <span style="padding:4px 10px; border-radius:999px; font-size:12px; font-weight:600; background:#FFF7ED; color:#EA580C; border:1px solid #FFEDD5;">⏳ En attente de paiement</span>
                        @endif
                    </div>
                </div>
                
                <div style="text-align:right;">
                    <div style="font-size:13px; color:#6B7280; font-weight:600; text-transform:uppercase; margin-bottom:4px;">Date d'émission</div>
                    <div style="font-size:16px; color:#111827; font-weight:500;">{{ \Carbon\Carbon::parse($facture->date_emission)->format('d/m/Y') }}</div>
                </div>
            </div>

            <div style="padding: 32px; display:grid; grid-template-columns: repeat(2, 1fr); gap: 32px; border-bottom:1px solid #F3F4F6;">
                <div>
                    <h4 style="font-size:12px; font-weight:700; color:#6B7280; text-transform:uppercase; border-bottom:1px solid #E5E7EB; padding-bottom:8px; margin-bottom:12px;">Facturé à</h4>
                    <div style="font-size:15px; color:#111827; font-weight:600; margin-bottom:4px;">
                        @if($facture->devis && $facture->devis->ticket && $facture->devis->ticket->client && $facture->devis->ticket->client->utilisateur)
                            {{ $facture->devis->ticket->client->utilisateur->prenom }} {{ $facture->devis->ticket->client->utilisateur->nom }}
                            @if($facture->devis->ticket->client->entreprise)
                                <span style="color:#6B7280; font-weight:400;">({{ $facture->devis->ticket->client->entreprise }})</span>
                            @endif
                        @else
                            Client Inconnu
                        @endif
                    </div>
                    @if($facture->devis && $facture->devis->ticket && $facture->devis->ticket->client)
                    <div style="font-size:14px; color:#4B5563;">{{ $facture->devis->ticket->client->adresse_clt ?? 'Adresse non renseignée' }}</div>
                    @endif
                </div>
                
                <div>
                    <h4 style="font-size:12px; font-weight:700; color:#6B7280; text-transform:uppercase; border-bottom:1px solid #E5E7EB; padding-bottom:8px; margin-bottom:12px;">Référence Intervention</h4>
                    @if($facture->devis && $facture->devis->ticket)
                    <div style="font-size:14px; color:#111827; margin-bottom:4px;"><strong>Ticket :</strong> #TKT-{{ str_pad($facture->devis->ticket->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div style="font-size:14px; color:#4B5563; margin-bottom:4px;"><strong>Matériel concerné :</strong> {{ $facture->devis->ticket->materiel->nom ?? 'Inconnu' }}</div>
                    <div style="font-size:14px; color:#4B5563;"><strong>Devis initial :</strong> #DVS-{{ str_pad($facture->devis->id, 4, '0', STR_PAD_LEFT) }}</div>
                    @endif
                </div>
            </div>

            <div style="padding: 32px; background:#F9FAFB;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:16px; font-weight:600; color:#374151;">Montant Total TTC</span>
                    <span style="font-size:32px; font-weight:900; color:#111827; letter-spacing:-1px;">{{ number_format($facture->mont_total, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:16px;">
            <a href="{{ route('factures.pdf', $facture->id) }}" style="padding:12px 24px; background:linear-gradient(135deg, #2563EB, #1D4ED8); color:white; border:none; border-radius:10px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Générer PDF
            </a>
        </div>

    </div>
</x-app-layout>
