<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autorisation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
            padding: 10px 50px;
            position: relative;
            box-sizing: border-box;
            height: calc(100vh - 140px);
        }

        .header,
        .footer {
            width: 100%;
            text-align: center;
            position: absolute;
            left: 0;
            color: #666;
        }

        .header {
            top: 0;
            height: 80px;
            background-color: #f1f1f1;
            border-bottom: 1px solid #ccc;
        }

        .header img {
            max-width: 100%;
            height: auto;
        }

        .footer {
            bottom: 20px;
            height: 60px;
            background-color: #f1f1f1;
            border-top: 1px solid #ccc;
        }

        .footer img {
            max-width: 100%;
            height: auto;
        }

        .content {
            padding-top: 350px;
            padding-bottom: 20px;
            position: relative;
            z-index: 10;
            box-sizing: border-box;
            overflow-y: auto;
        }

        .contact {
            text-align: left;
            margin-bottom: 20px;
            font-size: 14px;
            position: absolute;
            top: 200px;
            width: 250px;
            right: 50px;
        }

        .signature {
            margin-top: 30px;
            font-size: 16px;
            text-align: right;
        }

        .highlight {
            color: #0056b3;
            font-weight: bold;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.05;
            z-index: 1;
            pointer-events: none;
            user-select: none;
        }

        .watermark img {
            width: 329px;
            height: 280px;
        }
    </style>
</head>

<body>
    <div class="watermark">
        <img src="{{ convertImageToBase64(public_path('assets/img/logo/barm.jpg')) }}" alt="logo" />
    </div>

    <div class="header">
        <img src="{{ convertImageToBase64(public_path('assets/img/logo/en_tete.png')) }}" alt="en_tete" />
    </div>

    <div class="container">
        <div class="content">
            <div class="contact">
                Madame la Présidente Directrice Générale du {{ $adherent->partnerFinancial->user->username }}<br>
                <u>ABIDJAN</u>
            </div>

            <p>
                <span class="highlight">Objet :</span> Autorisation pour l’ouverture d’un compte bancaire dans vos
                livres au profit d’un bénéficiaire du BARM
            </p>

            <p style="padding:30px 0px;"><strong>Madame,</strong></p>

            <p>
                Je soussigné Colonel AKE-DANHO Stéphane autorise l’ouverture d’un compte bancaire dans vos livres au
                profit de :
            </p>

            <p>
                <strong>Nom :</strong> {{ $adherent->user->firstname }}<br>
                <strong>Prénoms :</strong> {{ $adherent->user->lastname }}<br>
                <strong>Téléphone :</strong> {{ $adherent->phone_number }}<br>
                @if ($adherent->user->email)
                    <strong>Email :</strong> {{ $adherent->user->email }}<br>
                @endif
                <strong>PENSIONNAIRE CGRAE :</strong> {{ $adherent->pensionnaire_cgrae }}<br>
                @if ($adherent->pensionnaire_cgrae === 'Oui')
                    <strong>MATRICULE CGRAE :</strong> {{ $adherent->cgrae_no }}
                @endif
            </p>

            <p>
                A l’issue du profilage ce bénéficiaire est affecté au partenaire technique
                <strong>{{ $adherent->partnerTechnical->user->username }}</strong> pour la réalisation de son projet.
            </p>

            <p>
                Ce document est établi pour servir et valoir ce que de droit.
            </p>

            <p><u>IMPUTATION</u> : {{ $adherent->imputation }}</p>

            <div class="signature">
                <p>Fait à Abidjan le {{ date('d-m-Y') }}</p>
                <p></p>
            </div>
        </div>
    </div>

    <div class="footer">
        <img src="{{ convertImageToBase64(public_path('assets/img/logo/pied.png')) }}" alt="pied" />
    </div>
</body>

</html>
