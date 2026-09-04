<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche Individuelle d'Engagement - BARM</title>
    <style>
        @page {
            margin: 15px 25px 15px 25px;
        }
        body {
            font-family: 'Times-Roman', 'Times New Roman', serif;
            font-size: 9.5pt;
            color: #000;
            line-height: 1.22;
            margin: 0;
            padding: 0;
        }
        .header-top {
            text-align: center;
            margin-bottom: 6px;
        }
        .header-top .rep {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header-top .motto {
            font-size: 9pt;
            font-style: italic;
            margin-bottom: 3px;
        }
        .header-top .ministere {
            font-size: 10.5pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header-top .programme {
            font-size: 9.5pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .separator {
            letter-spacing: 1px;
            font-size: 8pt;
            margin: 2px 0;
        }

        .logo-photo-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            margin-bottom: 6px;
        }
        .logo-cell {
            width: 50%;
            text-align: center;
            vertical-align: middle;
        }
        .logo-img {
            max-height: 75px;
            width: auto;
        }
        .photo-cell {
            width: 25%;
            text-align: right;
            vertical-align: middle;
        }
        .spacer-cell {
            width: 25%;
        }
        .photo-box {
            width: 85px;
            height: 100px;
            border: 1px solid #000;
            display: inline-block;
            text-align: center;
            line-height: 100px;
            font-weight: bold;
            font-size: 10pt;
            overflow: hidden;
            vertical-align: middle;
        }

        .title-doc {
            text-align: center;
            font-size: 13.5pt;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 8px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .intro-text {
            margin-bottom: 6px;
            font-size: 10pt;
        }

        table.info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table.info-table td {
            border: 1px solid #444;
            padding: 3.2px 8px;
            font-size: 9.2pt;
        }
        table.info-table td.label-col {
            width: 42%;
        }
        table.info-table td.colon-col {
            width: 3%;
            text-align: center;
        }
        table.info-table td.val-col {
            width: 55%;
            font-weight: bold;
            font-size: 9.5pt;
        }

        table.commit-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        table.commit-table td {
            font-size: 8.6pt;
            line-height: 1.22;
            padding-bottom: 4px;
            vertical-align: top;
        }
        table.commit-table td.num-col {
            width: 22px;
            font-weight: bold;
        }
        table.commit-table td.text-col {
            text-align: justify;
        }

        .bottom-container {
            width: 100%;
            margin-top: 15px;
        }
        .signature-cell {
            float: right;
            width: 45%;
            text-align: center;
            font-size: 9.5pt;
        }
        .signature-title {
            font-weight: bold;
            margin-bottom: 4px;
        }
        .signature-sub {
            font-size: 8.5pt;
            line-height: 1.3;
        }

        .footnotes {
            float: left;
            width: 50%;
            font-size: 8.5pt;
            line-height: 1.25;
        }
        .footnotes .note {
            font-style: italic;
        }
        .nb-legaliser {
            margin-top: 6px;
            font-weight: bold;
            font-style: italic;
            font-size: 9.5pt;
        }
    </style>
</head>
<body>

    <!-- EN-TÊTE -->
    <div class="header-top">
        <div class="rep">RÉPUBLIQUE DE CÔTE D'IVOIRE</div>
        <div class="motto">Union – Discipline – Travail</div>
        <div class="separator">-------------------------</div>
        <div class="ministere">MINISTERE D'ETAT, MINISTERE DE LA DEFENSE</div>
        <div class="programme">PROGRAMME D'ACCOMPAGNEMENT A LA RECONVERSION DES MILITAIRES</div>
        <div class="separator">-------------------------</div>
    </div>

    <!-- LOGO ET PHOTO (3 COLONNES POUR CENTRER LE LOGO SUR LA PAGE) -->
    <table class="logo-photo-table">
        <tr>
            <td class="spacer-cell"></td>
            <td class="logo-cell">
                @if(file_exists(public_path('assets/img/logo/barm.jpg')))
                    <img src="{{ convertImageToBase64(public_path('assets/img/logo/barm.jpg')) }}" class="logo-img" alt="Logo BARM" />
                @elseif(file_exists(public_path(setting('app_logo'))))
                    <img src="{{ convertImageToBase64(public_path(setting('app_logo'))) }}" class="logo-img" alt="Logo BARM" />
                @endif
            </td>
            <td class="photo-cell">
                <div class="photo-box">
                    @if(!empty($photoPath) && file_exists(public_path($photoPath)))
                        <img src="{{ convertImageToBase64(public_path($photoPath)) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Photo" />
                    @else
                        PHOTO
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <div class="title-doc">FICHE INDIVIDUELLE D'ENGAGEMENT</div>

    <div class="intro-text">Je soussigné :</div>

    <!-- TABLEAU DE RENSEIGNEMENTS -->
    <table class="info-table">
        <tr>
            <td class="label-col">Nom</td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $nom }}</td>
        </tr>
        <tr>
            <td class="label-col">Prénoms</td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $prenoms }}</td>
        </tr>
        <tr>
            <td class="label-col">Sexe<sup>1</sup></td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $sexe }}</td>
        </tr>
        <tr>
            <td class="label-col">Matricule CGRAE</td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $matriculeCgrae }}</td>
        </tr>
        <tr>
            <td class="label-col">N° CNI / carte retraité / passeport<sup>2</sup></td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $noCard }}</td>
        </tr>
        <tr>
            <td class="label-col">Adresse postale</td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $adresse }}</td>
        </tr>
        <tr>
            <td class="label-col">Téléphone</td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $telephone }}</td>
        </tr>
        <tr>
            <td class="label-col">Email</td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $email }}</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight: bold; background-color: #fafafa; padding: 2px 5px;">Personne à contacter en cas d'urgence</td>
        </tr>
        <tr>
            <td class="label-col">Nom et prénoms</td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $urgenceNom }}</td>
        </tr>
        <tr>
            <td class="label-col">Téléphone</td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $urgencePhone }}</td>
        </tr>
        <tr>
            <td class="label-col">Email</td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $urgenceEmail }}</td>
        </tr>
    </table>

    <!-- LISTE DES ENGAGEMENTS (POINTS 1 À 9 SUR UNE SEULE PAGE) -->
    <table class="commit-table">
        <tr>
            <td class="num-col">1.</td>
            <td class="text-col">
                Ai bien compris que le <strong>Bureau d'Accompagnement à la Reconversion des Militaires (BARM)</strong> n'est pas un bureau de financement de projet de reconversion ;
            </td>
        </tr>
        <tr>
            <td class="num-col">2.</td>
            <td class="text-col">
                Ai bien compris que le <strong>BARM</strong> ne dispose pas de fonds propres destinés à financer les projets de reconversion ;
            </td>
        </tr>
        <tr>
            <td class="num-col">3.</td>
            <td class="text-col">
                Ai bien compris que le <strong>BARM</strong> a pour mission d'apporter un accompagnement psychotechnique à la mise en œuvre de projets à travers un ensemble de processus éprouvés par des partenaires techniques du <strong>BARM</strong> ;
            </td>
        </tr>
        <tr>
            <td class="num-col">4.</td>
            <td class="text-col">
                Ai bien compris que les fonds de création des activités génératrices de revenu sont des crédits octroyés par des partenaires financiers du <strong>BARM</strong> ou des fonds personnels ;
            </td>
        </tr>
        <tr>
            <td class="num-col">5.</td>
            <td class="text-col">
                Ai bien compris que dans sa mission, le <strong>BARM</strong> n'a pas obligation de m'orienter vers le secteur d'activité de mon choix ;
            </td>
        </tr>
        <tr>
            <td class="num-col">6.</td>
            <td class="text-col">
                Ai bien compris qu'il est interdit de manifester de quelques manières que ce soient sa désapprobation suite aux décisions du <strong>BARM</strong> ;
            </td>
        </tr>
        <tr>
            <td class="num-col">7.</td>
            <td class="text-col">
                Déclare avoir informé le <strong>BARM</strong> de mon état de santé ;
            </td>
        </tr>
        <tr>
            <td class="num-col">8.</td>
            <td class="text-col">
                Certifie avoir pris connaissance de la mission du <strong>BARM</strong> et avoir adhéré volontairement à son Programme de reconversion ;
            </td>
        </tr>
        <tr>
            <td class="num-col">9.</td>
            <td class="text-col">
                Ai pris connaissance des conditions générales et m'engage à les accepter, sous peine de perdre le bénéfice accordé par le programme.
            </td>
        </tr>
    </table>

    <!-- BLOC BAS DE PAGE (FOOTNOTES + SIGNATURE) -->
    <div class="bottom-container">
        <div class="footnotes">
            <div class="note"><sup>1</sup><em>Préciser <strong>M</strong> pour Masculin et <strong>F</strong> pour Féminin</em></div>
            <div class="note"><sup>2</sup><em>Barrer la mention inutile</em></div>
            <div class="nb-legaliser"><u>NB</u> : <em>A légaliser</em></div>
        </div>
        <div class="signature-cell">
            <div class="signature-title">Le Candidat</div>
            <div class="signature-sub">
                Date et Signature / empreinte<br>
                Mention « Lu et approuvé »
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>
