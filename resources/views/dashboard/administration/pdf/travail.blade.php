<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attestation de travail</title>
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
						<h2 style="text-align:center">
							<u>ATTESTATION DE TRAVAIL</u>
						</h2>
						<div style="margin-top: 30px; text-align:left; text-align:justify">
							<div class="content_section">
								<br>
								<br>
								<p class="text-content">Je soussigné, le chef du Bureau d'Accompagnement de la Reconversion des Militaires (BARM), atteste que <b>{{$personnels->user->fullName()}}</b>,
								exerce au Bureau d'Accompagnement de la Reconversion des Militaires, <br>en qualité d'Assistante du Responsable de Suivi-Evaluation, depuis le {{ date('d/m/Y', strtotime($personnels->date_prise_service_barm)) }},
								la date de prise de service jusqu'à ce jour.<br><br>
								<p class="text-content"> En foi de quoi, la présente attestation lui est délivrée pour le service et valoir ce que de droit.</p>
							</div>
						</div>
                    </div>
				  <br>
				  <br>
				  <br>
				  <br>
				  <br>
				  <br>
				  <p class="align-right">
					  <b>LE CHEF BARM</b>
				  </p>
				  <br>
				  <br>
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
