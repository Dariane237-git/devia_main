<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Devis #DVS-{{ str_pad($devis->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 20px; }
        .header { border-bottom: 2px solid #10B981; padding-bottom: 20px; margin-bottom: 30px; display: table; width: 100%; }
        .header-col { display: table-cell; vertical-align: top; width: 50%; }
        .title { color: #10B981; font-size: 28px; font-weight: bold; margin: 0 0 5px 0; }
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
    </style>
</head>
<body>

    <div class="header">
        <div class="header-col">
            <h1 class="title">DEVIS</h1>
            <p class="subtitle">Référence : #DVS-{{ str_pad($devis->id, 4, '0', STR_PAD_LEFT) }}</p>
            <p class="subtitle">Date : {{ \Carbon\Carbon::parse($devis->date_devis)->format('d/m/Y') }}</p>
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
            <p class="info-title">Destinataire</p>
            <p class="info-val">
                @if($devis->ticket && $devis->ticket->client && $devis->ticket->client->utilisateur)
                    {{ $devis->ticket->client->utilisateur->prenom }} {{ $devis->ticket->client->utilisateur->nom }}<br>
                    <span style="font-weight: normal; font-size: 13px;">{{ $devis->ticket->client->entreprise ?? 'Particulier' }}</span>
                @else
                    Client Inconnu
                @endif
            </p>
        </div>
        <div class="info-col">
            <p class="info-title">Détails de l'intervention</p>
            <p style="margin: 0 0 5px 0; font-size: 13px;"><strong>Ticket :</strong> #TKT-{{ str_pad($devis->ticket->id ?? 0, 4, '0', STR_PAD_LEFT) }}</p>
            <p style="margin: 0; font-size: 13px;"><strong>Matériel :</strong> {{ $devis->ticket->materiel->nom ?? 'N/A' }} ({{ $devis->ticket->materiel->marque ?? '' }})</p>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Description de la réparation évaluée</th>
                <th style="width: 20%; text-align: right;">Montant Estimé TTC</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $devis->details ?? 'Réparation matérielle et diagnostic logiciel' }}</td>
                <td style="text-align: right; font-weight: bold;">
                    {{ number_format($devis->mont_estimer, 0, ',', ' ') }} FCFA
                </td>
            </tr>
            @if(isset($devis->frais_diagnostic) && $devis->frais_diagnostic > 0)
            <tr>
                <td style="color: #666; font-size: 11px;">(Frais de diagnostic appliqués en cas de refus : {{ number_format($devis->frais_diagnostic, 0, ',', ' ') }} FCFA)</td>
                <td></td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="total-box">
        <div class="total-row">
            <div class="total-label">Total TTC:</div>
            <div class="total-value">{{ number_format($devis->mont_estimer, 0, ',', ' ') }} FCFA</div>
        </div>
    </div>

    <div style="clear: both; margin-top: 60px; padding: 20px; background: #F9FAFB; border-left: 4px solid #10B981; font-size: 12px; line-height: 1.5;">
        <strong>Validité du devis :</strong> Ce devis est valable pour une durée de 30 jours. Merci de le valider directement depuis votre Espace Client FixFlow pour que les travaux de réparation commencent. En cas de refus, seuls les frais de diagnostic vous seront facturés.
    </div>

    <div class="footer">
        FixFlow Technologies - SARL au capital de 1 000 000 FCFA - RCCM: CI-ABJ-2026-B-1234<br>
        Document généré automatiquement.
    </div>

</body>
</html>
