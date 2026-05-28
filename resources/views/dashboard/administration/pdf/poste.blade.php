<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat de prise de service</title>
    <style>
		body {
			font-family: 'Times New Roman', sans-serif;
			/* background-image: url("assets/img/uploads/logo.png"); */
			background-repeat: no-repeat;
			background-position: center;
			background-size: 65%;
			background-color: rgba(255, 255, 255,0.1);
		}

       .container {
            width: 700px;
            margin: 20px auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-size: 28px;
        }

       .section {
            margin-bottom: 10px;

        }

       .section-content {
            padding: 16px;
            font-size: 18px;
        }

       .section-content p {
            margin: 0;
        }

        img {
            width: 100%;
            height: auto;
        }

       .details {
            border-collapse: collapse;
            width: 100%;
        }

       .details,.details th,.details td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

       .details th {
            background-color: #f2f2f2;
        }

        #watermark {
            position: fixed;
            top: 150px;
            left: 30px;
            width: 100%;
            height: 100%;
            z-index: -2000;
            opacity: 0.3;
        }

       .img__content {
            width: 100%;
            height: 60%
        }

        footer {
            position: fixed;
            bottom: 2px;
            left: 0px;
            right: 0px;
            height: 50px;
            color: gray;
            text-align: center;
            font-size: 14px;
            line-height: 20px;
        }

       .content {
            margin-bottom: 30px;
        }

       .header__section {
            display: flex;
            align-items: center;
        }
		.header__section img {
			top: 0;
			left: 0;
			width: 100%;
			height: auto;
			opacity: 0.5;
		}

       .header__section.overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 5);
        }


       .centered-text {
            text-align: center;
        }

        h6 {
            font-size: 65%;
            margin-bottom: 0;
        }

       .title-head {
            font-size: 10px;
            margin-bottom: 0;
        }
       .footer-text-container {
            text-align: center;
            color: gray;
            font-size: 14px;
            line-height: 20px;
            padding: 5px 0;
            margin: 1px 0;
            position: relative;
        }

       .footer-text-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 2px;
            width: 35%;
            background: orange;
        }
       .footer-text-container::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            height: 2px;
            width: 35%;
            background: rgb(109, 214, 109);
        }
		.align-right {
			text-align: right;
			margin-right: 20px;
		}
    </style>
</head>
<body>
    <div class="container">
        <div class="header__section">
            {{-- <img src="{{ asset('assets/img/entete.png') }}" alt="Logo de la République de Côte d'Ivoire"> --}}
            <div style="position: absolute; top:0; left :0;">

                <div class="section" style="margin-top: 150px;">
                    <div class="section-content">
					  <div class="section-content-nob">
						<h5 style="float: right;margin-right : 50px;">
						  Abidjan, le {{ date('d/m/Y', strtotime($personnels->created_at)) }}.
						</h5>
						<h5  style="float: left;margin-left : 50px;">
						  N° ____________/MEMDEF/BARM/GRH
						</h5>
						<br>
						<br>
						<br>
						<br>
					  </div>
						<h3 style="text-align:center">
							<u>CERTIFICAT DE PRISE DE SERVICE</u>
						</h3>
						<div style="margin-top: 30px; text-align:left; text-align:justify">
							<div class="content_section">
								<br>
								<br>
                                <p class="text-content">
                                    Le Chef du <b>Bureau d'Accompagnement de la Reconversion des Militaires (BARM) </b>du Ministère d'Etat,Ministère de la Défense soussigné(e), <br>certifie que :<b> @if ($personnels->gender == 'Masculin') M. @else Mme @endif{{$personnels->user->fullName()}}</b>,
                                    Matricule : @if ($personnels->matricule_barm == NULL) <i>(non-défini)</i> @else <b>{{$personnels->matricule_barm}} </b>@endif,Grade : @if ($personnels->grade == NULL) <i>(non-défini)</i> @else <b>{{$personnels->grade}}</b>@endif, a effectivement pris service le @if ($personnels->date_prise_service_barm == NULL) <i>(non-défini)</i> @else <b>{{ date('d/m/Y', strtotime($personnels->date_prise_service_barm))}}</b> @endif,
                                    à la @if ($personnels->lieu_service == NULL) <i>(non-défini)</i> @else <b>{{$personnels->lieu_service}}</b>@endif en qualité de @if ($personnels->fonction == NULL) <i>(non-défini)</i> @else <b>{{$personnels->fonction}}</b> @endif. <br><br>
                                    En foi de quoi, le présent certificat est établi pour le service et valoir ce que de droit.
                                </p>
							</div>
						</div>
                    </div>
				  <br>
				  <br>
                  <div class="container">
                    <p style="float: right;margin-right : 60px;">
                     <b>LE CHEF BARM</b>
                    </p>
                    <br>
                    <br>
                    <br>
                    <table style="border: none; width: 100%;">
                        <tr>
                            <td><b><u>Ampliations : </u></b></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>- Responsable AF</td>
                            <td style="width:75%;">1</td>
                        </tr>
                        <tr>
                            <td>- Gestionnaire RH</td>
                            <td style="width:75%;">1</td>
                        </tr>
                        <tr>
                            <td>- Intéressé(e)</td>
                            <td style="width:75%;">1</td>
                        </tr>
                        <tr>
                            <td>- Dossier intéressé(e)</td>
                            <td style="width:75%;">1</td>
                        </tr>
                        <tr>
                            <td>- A/C </td>
                            <td style="width:75%;">1</td>
                        </tr>
                    </table>
                </div>
                </div>
            </div>
        </div>
    <footer>
        <div class="footer-text-container"">
            <small>
                <i>Bureau d'Accompagnement à la Reconversion des Militaires -Cocody-Angré 8èTranche(Pont SORO)<br>
                04 BP 2981 Abidjan 04 - Cel : 07 77 13 05 69 <br>
                www.barm.ci
                </i>
            </small>
        </div>
    </footer>
</body>
</html>
