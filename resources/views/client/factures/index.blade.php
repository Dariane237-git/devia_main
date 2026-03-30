<x-client-layout>
    <x-slot name="header">Mes Factures</x-slot>

    <style>
        .facture-container { background: white; border-radius: 16px; border: 1px solid #E5E7EB; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        .facture-list { padding: 0; margin: 0; list-style: none; }
        .facture-item { padding: 24px; border-bottom: 1px solid #F3F4F6; transition: background 0.2s; }
        .facture-item:last-child { border-bottom: none; }
        .facture-item:hover { background: #F9FAFB; }
        .badge { padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; }
        .badge-orange { background: #FFF7ED; color: #EA580C; border: 1px solid #FFEDD5; }
        .badge-green { background: #F0FDF4; color: #16A34A; border: 1px solid #DCFCE7; }
        .badge-blue { background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE; }
        
        .btn-pay { padding: 10px 20px; background: linear-gradient(135deg, #10B981, #059669); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 14px; transition: transform 0.2s, box-shadow 0.2s; display: inline-flex; align-items: center; gap: 6px; }
        .btn-pay:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
        .btn-pdf { padding: 10px 20px; background: white; color: #374151; border: 1px solid #D1D5DB; border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 14px; transition: background 0.2s; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
        .btn-pdf:hover { background: #F3F4F6; color: #111827; }
    </style>

    @if(session('success'))
    <div style="background:#F0FDF4;border:1px solid #DCFCE7;border-radius:12px;padding:16px;margin-bottom:20px;color:#16A34A;font-weight:600;display:flex;align-items:center;gap:8px;">
        <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('info'))
    <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:12px;padding:16px;margin-bottom:20px;color:#2563EB;font-weight:600;display:flex;align-items:center;gap:8px;">
        <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('info') }}
    </div>
    @endif

    <div style="margin-bottom:32px; display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px;">
        <div>
            <h2 style="font-size:26px;font-weight:900;color:#111827;letter-spacing:-0.5px;margin-bottom:8px;">Mes Factures</h2>
            <p style="color:#6B7280;font-size:15px;margin:0;">Consultez vos reçus et réglez vos factures en ligne (Simulation).</p>
        </div>
    </div>

    <div class="facture-container">
        <ul class="facture-list">
            @forelse($factures as $f)
            <li class="facture-item">
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:20px;">
                    
                    <div style="flex:1; min-width:300px;">
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
                            <span style="font-weight:800;color:#1F2937;font-size:16px;">{{ $f->numero_fac }}</span>
                            
                            @if($f->type_fac == 'Diagnostic')
                                <span class="badge badge-orange" style="background:#FFF7ED;color:#C2410C;border-color:#FFEDD5;">🔍 Diagnostique</span>
                            @else
                                <span class="badge badge-blue">🛠️ Réparation Finale</span>
                            @endif

                            @if($f->statut_paiement == 'En attente')
                                <span class="badge badge-orange">⏳ En attente de paiement</span>
                            @elseif($f->statut_paiement == 'Payée')
                                <span class="badge badge-green">✅ Payée</span>
                            @else
                                <span class="badge badge-orange" style="background:#F3F4F6;color:#4B5563;border-color:#E5E7EB;">{{ $f->statut_paiement }}</span>
                            @endif
                        </div>
                        
                        <div style="font-size:14px;color:#4B5563;margin-bottom:6px;line-height:1.5;">
                            <strong>Matériel :</strong> {{ $f->devis->ticket->materiel->nom ?? 'Inconnu' }} 
                            <span style="color:#D1D5DB;margin:0 8px;">|</span> 
                            <strong>Date d'émission :</strong> {{ \Carbon\Carbon::parse($f->date_emission)->format('d/m/Y') }}
                        </div>
                        
                        <div style="margin-top:12px;">
                            <span style="font-size:13px;color:#6B7280;font-weight:500;text-transform:uppercase;letter-spacing:0.05em;">Montant Total</span><br>
                            <span style="font-size:24px;font-weight:900;color:#111827;letter-spacing:-0.5px;">{{ number_format($f->mont_total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>

                    <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                        <!-- Bouton PDF fonctionnel -->
                        <a href="{{ route('factures.pdf', $f->id) }}" class="btn-pdf" title="Télécharger la facture">
                            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Télécharger PDF
                        </a>

                        @if($f->statut_paiement == 'En attente')
                        <!-- Bouton de simulation de paiement -->
                        <form action="{{ route('client.factures.payer', $f->id) }}" method="POST" onsubmit="return confirm('Attention : Il s\'agit d\'une simulation de paiement par Mobile Money / Carte. Confirmer ce paiement de {{ number_format($f->mont_total, 0, ',', ' ') }} FCFA ?');">
                            @csrf
                            <button type="submit" class="btn-pay">
                                <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                Payer en ligne
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </li>
            @empty
            <li class="facture-item" style="text-align:center;padding:64px 20px;">
                <div style="width:64px;height:64px;background:#F3F4F6;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <svg style="width:32px;height:32px;color:#9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 style="font-size:16px;font-weight:700;color:#111827;margin-bottom:8px;">Aucune facture</h3>
                <p style="color:#6B7280;font-size:14px;max-width:400px;margin:0 auto;">Vos factures de diagnostic ou de réparation finale apparaîtront ici.</p>
            </li>
            @endforelse
        </ul>
    </div>
</x-client-layout>
