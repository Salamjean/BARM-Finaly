<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Pré-inscription BARM - Informations et Dossier</title>
    <style>
        @page {
            margin: 20px 25px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #1a202c;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 10px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-cell {
            width: 120px;
        }
        .logo-img {
            max-width: 110px;
            height: auto;
        }
        .title-cell {
            text-align: center;
        }
        .org-title {
            font-size: 15px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .org-subtitle {
            font-size: 11px;
            color: #4b5563;
            margin-top: 2px;
            font-weight: bold;
        }
        .banner {
            background-color: #ecfdf5;
            border: 2px solid #10b981;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            margin-bottom: 15px;
        }
        .banner-title {
            font-size: 16px;
            font-weight: bold;
            color: #065f46;
            margin-bottom: 4px;
        }
        .banner-subtitle {
            font-size: 11px;
            font-weight: bold;
            color: #047857;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #ffffff;
            background-color: #1e293b;
            padding: 6px 10px;
            border-radius: 4px;
            margin-top: 15px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        table.contacts-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.contacts-table th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: bold;
            font-size: 10px;
            text-align: left;
            padding: 6px 8px;
            border: 1px solid #cbd5e1;
            text-transform: uppercase;
        }
        table.contacts-table td {
            padding: 5px 8px;
            border: 1px solid #cbd5e1;
            font-size: 9.5px;
        }
        table.contacts-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .highlight-row {
            background-color: #eff6ff !important;
            font-weight: bold;
        }
        .dossier-box {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px 15px;
            background-color: #ffffff;
        }
        .dossier-list {
            margin: 0;
            padding-left: 18px;
        }
        .dossier-list li {
            margin-bottom: 5px;
            font-size: 10px;
            color: #1e293b;
            font-weight: 500;
        }
        .footer {
            margin-top: 20px;
            font-size: 8.5px;
            color: #64748b;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    <!-- Header avec Logo BARM -->
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                @if(file_exists(public_path('assets/img/logo/barm.jpg')))
                    <img src="{{ convertImageToBase64(public_path('assets/img/logo/barm.jpg')) }}" class="logo-img" alt="Logo BARM" />
                @elseif(file_exists(public_path(setting('app_logo'))))
                    <img src="{{ convertImageToBase64(public_path(setting('app_logo'))) }}" class="logo-img" alt="Logo BARM" />
                @endif
            </td>
            <td class="title-cell">
                <div class="org-title">Bureau d'Accompagnement à la Reconversion des Militaires</div>
                <div class="org-subtitle">Ministère d'État, Ministère de la Défense - Côte d'Ivoire</div>
            </td>
        </tr>
    </table>

    <!-- Banner Confirmation -->
    <div class="banner">
        <div class="banner-title">Pré-inscription terminée !</div>
        <div class="banner-subtitle">Merci de vous rapprocher du bureau BARM le plus proche pour votre inscription.</div>
    </div>

    <!-- Section Points Focaux -->
    <div class="section-title">1. Bureaux BARM et Points Focaux</div>
    <table class="contacts-table">
        <thead>
            <tr>
                <th style="width: 8%; text-align: center;">N°</th>
                <th style="width: 47%;">ZONE DE COMPÉTENCE</th>
                <th style="width: 45%;">CONTACTS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; font-weight: bold;">1</td>
                <td>POINT FOCAL MAN</td>
                <td>0709106274 / 0101427374</td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold;">2</td>
                <td>POINT FOCAL KORHOGO</td>
                <td>0777976090 / 0759365610</td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold;">3</td>
                <td>POINT FOCAL BOUAKE</td>
                <td>0103476391 / 07 58 48 41 93</td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold;">4</td>
                <td>POINT FOCAL ABENGOUROU</td>
                <td>0102798715</td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold;">5</td>
                <td>POINT FOCAL DALOA</td>
                <td>0140098122</td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold;">6</td>
                <td>POINT FOCAL SAN-PEDRO</td>
                <td>0709094077 / 0102470800</td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold;">7</td>
                <td>POINT FOCAL EGS MARCORY</td>
                <td>0747642888</td>
            </tr>
            <tr class="highlight-row">
                <td style="text-align: center; font-weight: bold;">8</td>
                <td><strong>BARM ABIDJAN (Siège) Cocody Angré pont Soro</strong></td>
                <td><strong>0504423153 / 0747709955<br>0152441468 / 0556499851</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Section Dossiers d'inscription -->
    <div class="section-title">2. Dossiers d'inscription au BARM</div>
    <div class="dossier-box">
        <ul class="dossier-list">
            <li>Demande manuscrite adressée au Chef BARM</li>
            <li>Fiche d’inscription à retirer au BARM (pré-profilage)</li>
            <li>Curriculum Vitae (CV)</li>
            <li>Fiche d’engagement légalisée (à télécharger par le candidat)</li>
            <li>Fiche individuelle (DORH / BRH) ou L’Etat signalétique des services (Troupe) pour les Gendarmes</li>
            <li>Copie d’une pièce d’identité (CNI ou carte de retraité ou passeport)</li>
            <li>Arrêté de radiation</li>
            <li>Quatre (04) photos d’identité</li>
            <li>Chemise à rabat</li>
            <li>Certificat médical (pathologies spécifiques)</li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="footer">
        Document généré le {{ date('d/m/Y à H:i') }} - Bureau d'Accompagnement à la Reconversion des Militaires (BARM)
    </div>

</body>
</html>
