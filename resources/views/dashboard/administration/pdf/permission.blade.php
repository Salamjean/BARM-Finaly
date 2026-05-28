<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de permission</title>
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
                        font-family: Arial, sans-serif;
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
                        font-size: 65%;
                        margin-bottom: 0;
                    }

                    .title-head {
                        font-size:70%;
                        margin-bottom: 0;
                    }

                </style>
            </head>
            <body>
                   <div class="container">
						<div class="header__section">
                            {{-- <div style="position: absolute; top:0; left :0; height:100%; width: 100%"><img src="{{ asset('assets/img/uploads/republique.png') }}" alt=""></div>
                            <div style="position: absolute; top:0; right :0;"><img src="{{ asset('assets/img/uploads/CDD.jpeg') }}" alt=""></div> --}}
                            <div style="text-align:center">
								<h6>REPUBLIQUE DE CÔTE D’IVOIRE</h6>
								<small>Union – Discipline – Travail</small>
								<p class="title-head">…………….…..</p>
								<p class="title-head">MINISTÈRE D’ÉTAT, MINISTÈRE DE LA DÉFENSE</p>
							</div>
                            {{-- <div style="text-align:center"><img src="{{ asset('assets/img/uploads/barm.jpg') }}" alt=""></div>--}}
                        <div class="section" style="margin-top: 25px;">
                            <div class="section-content-nob">
                                <h5>
                                    <i>DEMANDE D’AUTORISATION D’ABSENCE N°________________MEMDEF/BARM/GRH DU _______________</i>
                                </h5>
                                <p class="title-head">Je soussigné(e) Monsieur <b>{{$leaves->user->fullName()}}</b><br>
                                    Fonction : <b>{{$leaves->user->personnel->fonction}}</b><br>
                                    Matricule : <b>{{$leaves->user->personnel->matricule}}</b><br>
                                    Sollicite une autorisation d’absence de <b>({{ $leaves->nb_day }} Jours)</b> du <b>@php echo e(date('d/m/Y',strtotime($leaves->leavefrom)))@endphp
                                    au
                                    @php echo e(date('d/m/Y',strtotime($leaves->leaveto)))@endphp inclus.</b></p>
                            </div>
                        </div>

                        <div class="container">
                            <table class="details">
                                <tr class="title-head">
                                    <th colspan="2" style="text-align:center">Motif(s)</th>
                                </tr>
                                <tr class="title-head">
                                    <td colspan="2">
                                        {{ $leaves->reason}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                            </table>
                            <table class="details">
                                <tr class="title-head">
                                    <td>Signature du Demandeur</td>
                                    <td>Avis et visa du RAF/GRH</td>
                                    <td>Décision et visa du Chef BARM</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    @if ($leaves->status == 'Approuvé')
                                    <td class="title-head" style="text-align: center"><i>Avis favorable</i><br><br><br><br></td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td></td>
                                </tr>
                            </table>
                            <table class="details">
                                <tr class="title-head">
                                    <th colspan="2" style="text-align:center">Réservé à l’administration</th>
                                </tr>
                                <tr class="title-head">
                                    <td>Nombre de jours accordés :</td>
                                    <td>{{ $leaves->nb_day }}</td>
                                </tr>
                                <tr class="title-head">
                                    <td>Date de départ : <b>@php echo e(date('d/m/Y',strtotime($leaves->leavefrom)))@endphp</b></td>
                                    <td>Date de reprise : <b>@php echo e(date('d/m/Y',strtotime($leaves->returndate)))@endphp</b></td>
                                </tr>
                            </table>
                            <h6>
                                <u>Ampliations</u><br><br>
                               - Responsable AF <br>
                               - Gestionnaire RH <br>
                               - Intéressé(e) <br>
                               - Dossier intéressé(e) <br>
                               - Chrono
                            </h6>
                        </div>
                    </div>
</body>
