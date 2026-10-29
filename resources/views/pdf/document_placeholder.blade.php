<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $name ?? 'Document administratif' }}</title>
    <style>
        @page {
            margin: 25mm 20mm 20mm 20mm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1a202c;
            line-height: 1.5;
            font-size: 13px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #003366;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header .rep {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #333;
        }
        .header .devise {
            font-size: 10px;
            font-style: italic;
            margin-bottom: 8px;
            color: #666;
        }
        .header .ministere {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #003366;
            margin-bottom: 4px;
        }
        .header .barm {
            font-size: 14px;
            font-weight: bold;
            color: #b8860b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .doc-card {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 20px;
            background-color: #f8fafc;
            margin-top: 20px;
        }
        .doc-title {
            font-size: 18px;
            font-weight: bold;
            color: #003366;
            text-transform: uppercase;
            margin-bottom: 12px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 8px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .info-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
        }
        .info-table td.label {
            font-weight: bold;
            color: #475569;
            width: 35%;
        }
        .badge-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            background-color: #e0f2fe;
            color: #0369a1;
            font-weight: bold;
            font-size: 11px;
        }
        .notice {
            margin-top: 30px;
            padding: 15px;
            background-color: #fefce8;
            border-left: 4px solid #eab308;
            font-size: 11px;
            color: #713f12;
            line-height: 1.6;
        }
        .footer {
            margin-top: 60px;
            text-align: right;
            padding-right: 30px;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
        }
        .signature-box .date {
            font-size: 11px;
            color: #475569;
            margin-bottom: 40px;
        }
        .signature-box .sign {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            color: #003366;
            border-top: 1px dotted #94a3b8;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="rep">République de Côte d'Ivoire</div>
        <div class="devise">Union – Discipline – Travail</div>
        <div class="ministere">Ministère d'État, Ministère de la Défense</div>
        <div class="barm">Bureau d'Accompagnement à la Reconversion des Militaires (BARM)</div>
    </div>

    <div class="doc-card">
        <div class="doc-title">{{ $name ?? 'Document administratif' }}</div>
        
        <table class="info-table">
            <tr>
                <td class="label">Type de document :</td>
                <td><strong>{{ $name ?? 'Pièce justificative enregistrée' }}</strong></td>
            </tr>
            @if(!empty($userName))
            <tr>
                <td class="label">Adhérent / Candidat :</td>
                <td><strong>{{ $userName }}</strong></td>
            </tr>
            @endif
            @if(!empty($matricule))
            <tr>
                <td class="label">Matricule / Mécano :</td>
                <td>{{ $matricule }}</td>
            </tr>
            @endif
            <tr>
                <td class="label">Statut d'archivage :</td>
                <td><span class="badge-status">Document enregistré au dossier</span></td>
            </tr>
            <tr>
                <td class="label">Référence système :</td>
                <td><code style="font-size: 10px; color: #64748b;">{{ basename($path) }}</code></td>
            </tr>
            <tr>
                <td class="label">Date de consultation :</td>
                <td>{{ $date ?? date('d/m/Y à H:i') }}</td>
            </tr>
        </table>

        <div class="notice">
            <strong>Notice administrative :</strong> Ce document a été validé et enregistré dans le dossier individuel de l'adhérent au sein du système d'information du BARM. Le fichier original scanné est archivé dans le dossier physique ou la base sécurisée de la cellule de reconversion.
        </div>
    </div>

    <div class="footer">
        <div class="signature-box">
            <div class="date">Fait à Abidjan, le {{ date('d/m/Y') }}</div>
            <div class="sign">La Cellule Administrative du BARM</div>
        </div>
    </div>

</body>
</html>
