<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture {{ $facture->numero_fac }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 20px; }
        .header { border-bottom: 2px solid #2563EB; padding-bottom: 20px; margin-bottom: 30px; display: table; width: 100%; }
        .header-col { display: table-cell; vertical-align: top; width: 50%; }
        .title { color: #2563EB; font-size: 28px; font-weight: bold; margin: 0 0 5px 0; }
        .subtitle { color: #666; font-size: 14px; margin: 0; }
        .company-info { text-align: right; font-size: 13px; line-height: 1.5; color: #555; }
        .info-grid { display: table; width: 100%; margin-bottom: 30px; }
        .info-col { display: table-cell; width: 50%; padding: 15px; background: #f9f9f9; border-radius: 5px; }
        .info-title { font-size: 11px; font-weight: bold; text-transform: uppercase; color: #888; margin: 0 0 5px 0; }
        .info-val { font-size: 14px; font-weight: bold; margin: 0 0 10px 0; color: #222; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .table th { background: #E5E7EB; color: #374151; font-size: 12px; font-weight: bold; text-align: left; padding: 10px; border-bottom: 2px solid #D1D5DB; }
        .table td { padding: 12px 10px; border-bottom: 1px solid #E5E7EB; font-size: 13px; }
        .total-box { display: block; width: 300px; float: right; background: #F3F4F6; padding: 15px; border-radius: 5px; margin-top: 20px; }
        .total-row { display: table; width: 100%; font-size: 18px; font-weight: bold; color: #111827; }
        .total-label { display: table-cell; text-align: left; }
        .total-value { display: table-cell; text-align: right; }
        .footer { position: fixed; bottom: 0; left: 0; width: 100%; text-align: center; font-size: 11px; color: #888; border-top: 1px solid #EEE; padding-top: 10px; }
        .badge { display: inline-block; padding: 5px 10px; font-size: 11px; font-weight: bold; border-radius: 3px; background: #E5E7EB; color: #374151; }
        .badge-paid { background: #Dcfce7; color: #16a34a; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-col">
            <h1 class="title">FACTURE</h1>
            <p class="subtitle">Référence : {{ $facture->numero_fac }}</p>
            <p class="subtitle">Date : {{ \Carbon\Carbon::parse($facture->date_emission)->format('d/m/Y') }}</p>
            
            <div style="margin-top: 10px;">
                @if($facture->statut_paiement == 'Payée')
                    <span class="badge badge-paid">PAYÉE</span>
                @else
                    <span class="badge">EN ATTENTE</span>
                @endif
                <span class="badge">{{ strtoupper($facture->type_fac) }}</span>
            </div>
        </div>
        <div class="header-col company-info">
            <strong>FixFlow Technologies</strong><br>
            123 Rue de l'Informatique, Zone Industrielle<br>
            contact@fixflow.com<br>
            Tél: +225 01 23 45 67 89
        </div>
    </div>

    <div class="info-grid">
        <div class="info-col" style="border-right: 5px solid white;">
            <p class="info-title">Facturé à</p>
            <p class="info-val">
                @if($facture->devis && $facture->devis->ticket && $facture->devis->ticket->client && $facture->devis->ticket->client->utilisateur)
                    {{ $facture->devis->ticket->client->utilisateur->prenom }} {{ $facture->devis->ticket->client->utilisateur->nom }}<br>
                    <span style="font-weight: normal; font-size: 13px;">{{ $facture->devis->ticket->client->entreprise ?? 'Particulier' }}</span>
                @else
                    Client Inconnu
                @endif
            </p>
            <p style="margin:0; font-size:13px;">{{ $facture->devis->ticket->client->adresse_clt ?? '' }}</p>
        </div>
        <div class="info-col">
            <p class="info-title">Détails de l'intervention</p>
            <p style="margin: 0 0 5px 0; font-size: 13px;"><strong>Ticket :</strong> #TKT-{{ str_pad($facture->devis->ticket->id, 4, '0', STR_PAD_LEFT) }}</p>
            <p style="margin: 0 0 5px 0; font-size: 13px;"><strong>Matériel :</strong> {{ $facture->devis->ticket->materiel->nom ?? 'N/A' }} ({{ $facture->devis->ticket->materiel->marque ?? '' }})</p>
            <p style="margin: 0; font-size: 13px;"><strong>Devis Lié :</strong> #DVS-{{ str_pad($facture->devis->id, 4, '0', STR_PAD_LEFT) }}</p>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Description / Prestation</th>
                <th style="width: 20%; text-align: right;">Montant TTC</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @if($facture->type_fac == 'Diagnostic')
                        Frais de Diagnostic initial suite au refus de devis ({{ $facture->devis->ticket->description_panne ?? 'Panne déclarée' }})
                    @else
                        Main d'œuvre, réparation technique et pièces remplacées pour l'intervention sur le matériel défini.
                    @endif
                </td>
                <td style="text-align: right; font-weight: bold;">
                    {{ number_format($facture->mont_total, 0, ',', ' ') }} FCFA
                </td>
            </tr>
        </tbody>
    </table>

    <div class="total-box">
        <div class="total-row">
            <div class="total-label">Total :</div>
            <div class="total-value">{{ number_format($facture->mont_total, 0, ',', ' ') }} FCFA</div>
        </div>
    </div>

    <div style="clear: both; margin-top: 60px; padding: 20px; background: #F9FAFB; border-left: 4px solid #3B82F6; font-size: 12px; line-height: 1.5;">
        <strong>Conditions de paiement :</strong> Le règlement est attendu sous 15 jours à compter de la date d'émission. Vous pouvez régler en ligne via votre espace client ou par virement bancaire sur le compte CI000 12345 67890 12.
    </div>

    <div class="footer">
        FixFlow Technologies - SARL au capital de 1 000 000 FCFA - RCCM: CI-ABJ-2026-B-1234<br>
        Document généré automatiquement à {{ date('H:i') }} le {{ date('d/m/Y') }}.
    </div>

</body>
</html>
