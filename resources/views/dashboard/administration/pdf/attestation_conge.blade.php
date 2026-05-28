<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attestation de conge</title>
</head>
<body>
    <div class="container">
        <p style="float: right;margin-right : 50px;">
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>{{$title}}</title>
                <style>
                    body {
                        font-family: Times , sans-serif;
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
                        padding: 10px;
                    }
            
                    .section-content p {
                        margin: 0;
                    }
                       
                    img {
                        width: 100px;
                    }
            
                    .details {
                        border-collapse: collapse;
                        width: 100%;
                    }

                    .details, .details th, .details td {
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
						justify-content: space-between;
						align-items: center;
					}
				
					.centered-text {
						text-align: center;
					}


                    h6 {
                        font-size: 65%; /* Taille de la police pour le titre */
                        margin-bottom: 0; /* Espacement entre le titre et le paragraphe suivant */
                    }

                    .title-head {
                        font-size:70%; /* Taille de la police pour les paragraphes */
                        margin-bottom: 0; /* Espacement entre les paragraphes */
                    }

                    .text-content {
                        font-size:16px; /* Taille de la police pour les paragraphes */
                        margin-bottom: 0; /* Espacement entre les paragraphes */
                    }
                </style>
            </head>
            <body>
                   <div class="container">
						<div class="header__section">
							{{-- <div style="position: absolute; top:0; left :0;"><img src="{{ asset('assets/img/uploads/ministere.jpg') }}" alt=""></div>
						  	<div style="position: absolute; top:0; right :0;"><img src="{{ asset('assets/img/uploads/republique.png') }}" alt=""></div> --}}
                              <div style="text-align:center">
								<h6>REPUBLIQUE DE CÔTE D’IVOIRE</h6>
								<small>Union – Discipline – Travail</small><br><br>
								<span style="text-align: center">
                                    -------------
                                </span>
								<p class="title-head">MINISTÈRE D’ÉTAT, MINISTÈRE DE LA DÉFENSE</p>
                                <span style="text-align: center">
                                    -------------
                                </span>
							</div>
                           {{-- <div style="text-align:center"><img src="{{ asset('assets/img/uploads/barm.jpg') }}" alt=""></div>--}}
                        <div class="section" style="margin-top: 25px; text-align:left; text-align:justify">
                            <div class="section-content-nob">
                                <p class="title-head" style="text-align: left">
                                ATTESTATION DE CONGES N° ____________/MEMDEF/BARM/GRH du 
                                ____________
                                </p>
                                <br>
                                <br>
                                <p class="text-content">Je soussigné le colonel <b>AKE-DANHO SPTEPHANE</b>, chef de la cellule suivi
                                de Projet du Bureau d’Accompagnement de la Reconversion des Militaires (CSP-BARM), atteste que <b>Monsieur Edoukou Honoré</b>, Point Focal d'Abidjan, beneficie 
                                d'un conge annuel de trente (30) jours consecutif au titre de l'année {{ date('Y', strtotime($personnels->created_at)) }} allant du <b>{{ date('d/m/Y', strtotime($personnels->leavefrom)) }} au {{ date('d/m/Y', strtotime($personnels->leaveto)) }} inclus</b>.</p>
                                <p class="text-content"> La date de reprise de l'argent susmentionné est prévue pour le jeudi <b> {{ date('d/m/Y', strtotime($personnels->returndate)) }} à 08 heures 00 minutes</b>.</p>
                                <p class="text-content"> En foi que, la présente attestation lui est délivrée pour le service et valoir ce que de droit.</p> 
                                   
                            </div>
                            <br>
                            <p style="float: right;margin-right : 50px;">
							Abidjan, le {{ date('d/m/Y', strtotime($personnels->created_at)) }}.
						  </p>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="container">
                            <p style="float: right;margin-right : 60px;">
                             <b>LE CHEF BARM</b> 
                            </p>
                            <p>
                                <u>Ampliations:</u><br><br>
                               - Responsable AF 01 <br>
                               - Gestionnaire RH 01 <br>
                               - Intéressé(e)  01<br>
                               - Dossier intéressé(e) 01 <br>
                               - A/C                  01
                            </p> 
                        </div>

                    </div>   
</body>   