<x-client-layout>
    <x-slot name="header">Mes Matériels</x-slot>

    <style>
        .materiel-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .materiel-card {
            background: white; border-radius: 16px; padding: 24px;
            border: 1px solid #E5E7EB; transition: transform 0.2s, box-shadow 0.2s;
        }
        .materiel-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
        .materiel-icon { width: 48px; height: 48px; border-radius: 12px; background: #DBEAFE; color: #2563EB; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #F3F4F6; font-size: 13px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #6B7280; font-weight: 500; }
        .info-value { color: #111827; font-weight: 600; }
    </style>

    <div style="margin-bottom:24px;">
        <h2 style="font-size:24px;font-weight:800;color:#111827;">Mes Matériels</h2>
        <p style="color:#6B7280;font-size:14px;">Vos appareils enregistrés dans notre système.</p>
    </div>

    <div class="materiel-grid">
        @forelse($materiels as $mat)
        <div class="materiel-card">
            <div class="materiel-icon">
                <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 style="font-size:16px;font-weight:700;color:#111827;margin-bottom:12px;">{{ $mat->nom }}</h3>
            <div>
                <div class="info-row">
                    <span class="info-label">Marque</span>
                    <span class="info-value">{{ $mat->marque ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Modèle</span>
                    <span class="info-value">{{ $mat->modele ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date d'achat</span>
                    <span class="info-value">{{ $mat->date_achat ? \Carbon\Carbon::parse($mat->date_achat)->format('d/m/Y') : '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Garantie</span>
                    <span class="info-value">{{ $mat->garantie ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Réparations</span>
                    <span class="info-value">{{ $mat->tickets->count() }} ticket(s)</span>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:48px;color:#6B7280;background:white;border-radius:16px;border:1px solid #E5E7EB;">
            <svg style="width:48px;height:48px;color:#D1D5DB;margin:0 auto 12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <p>Aucun matériel enregistré. Veuillez contacter l'agent d'accueil pour enregistrer votre appareil.</p>
        </div>
        @endforelse
    </div>
</x-client-layout>
