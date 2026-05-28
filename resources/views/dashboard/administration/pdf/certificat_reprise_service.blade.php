<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat de reprise service</title>
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
                        background-image: url("asset/img/uploads/barm.jpg");
                        background-repeat: no-repeat, repeat;
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
                        font-size:15px; /* Taille de la police pour les paragraphes */
                        margin-bottom: 0; /* Espacement entre les paragraphes */
                    }
                </style>
            </head>
            <body>
                   <div class="container">
						<div class="header__section">
							{{-- <div style="position: absolute; top:0; left :0;"><img src="{{ asset('assets/img/uploads/barm.jpg') }}" alt=""></div>
						  	<div style="position: absolute; top:0; right :0;"><img src="{{ asset('assets/img/uploads/republique.png') }}" alt=""><small>Union – Discipline – Travail</small></div> --}}
                            <div style="float: right;margin-right : 50px;">
								<h6>REPUBLIQUE DE CÔTE D’IVOIRE</h6>
                                <small>Union – Discipline – Travail</small>
                                {{--<div style="position: absolute; top:0; right :0;"><img src="{{ asset('assets/img/uploads/republique.png') }}" alt=""></div> --}}
                            </div>
                            <div style="float: left;margin-left : 50px;">
								<!-- <h6>REPUBLIQUE DE CÔTE D’IVOIRE</h6> -->
								<h5>MINISTÈRE D'ETAT,<br> MINISTÈRE DE LA DEFENSE</h6><br>
                                <span style="text-align: center">
                                    -------------
                                </span>
								<h5>BUREAU D’ACCOMPAGNEMENT <br> A LA RECONVERSION DES MINISTÈRE</h6><br>
                                <span style="text-align: center">
                                    -------------
                                </span>
                                {{-- <div style="position: absolute; top:0; left :0;"><img src="{{ asset('assets/img/uploads/barm.jpg') }}" alt=""></div>--}}
							</div>
                            <br>
                            <br>
                           {{-- <div style="text-align:center"><img src="{{ asset('assets/img/uploads/barm.jpg') }}" alt=""></div>--}}
                        <div class="section" style="margin-top: 100px; text-align:left; text-align:justify">
                            <div class="section-content-nob">
                                <p style="text-align: right;margin-buttom : 10px;">
                                    Abidjan, le {{ date('d/m/Y', strtotime($personnels->created_at)) }}.
                                </p>
                                <p  style="text-align: left;margin-left : 50px;">
                                N° ____________/MEMDEF/BARM/GRH 
                                </p>
                                
                            </div>
                                <br>
                                <br>
                            <div >
                                <p style="text-align:center; font-size:18px">
                                  <b>CERTIFICAT DE REPRISE DE SERVICE</b>
                                </p>
                                <br>
                                <p class="text-content">Le Chef du <b>Bureau d'Accompagnement de la Reconversion des Militaires (BARM)</b>du Ministère d'Etat,Ministère de la Défense soussigné(e),certifie que:<br> Monsieur/Mademoiselle <b>DOSSO NANNAN</b>,
                                 Matricule <b>480 594E</b>,Grade <b>A3</b>,Educateur,(précédement en service à la comptabilité de la Direction des Ressources Humaines de Ministère d'Etat, Ministère de la Défence ), a éffectivement pris service le {{ date('d/m/Y', strtotime($personnels->created_at)) }},
                                 à la <b>cellule Formation-Insertion</b> en qualité de <b>Conseiller en Reconversion</b>.</p>
                                <p class="text-content"> En foi de quoi, le présent certificat est établi pour le service et valoir ce que de droit.</p> 
                                   
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="container">
                            <p style="float: right;margin-right : 60px;">
                             <b>LE CHEF BARM</b> 
                            </p>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="footer" style="margin-bottom:14px" >
                            <hr />
                        <p style="font-size:14px">Bureau d’Accompagnement à la Reconversion des Militaires - Cocody Angré 8ème tranche (Pont SORO)
                         04 BP 2981 Abidjan 04 Cel: 07 77 13 05 69 www.barm.ci
                        </p>
                    </div>
                    </div>  
</body>   