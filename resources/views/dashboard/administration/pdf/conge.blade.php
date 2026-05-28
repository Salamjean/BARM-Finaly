<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de congé</title>
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
							{{-- <div style="position: absolute; top:0; left :0;"><img src="{{ asset('assets/img/uploads/ministere.jpg') }}" alt=""></div>
						  	<div style="position: absolute; top:0; right :0;"><img src="{{ asset('assets/img/uploads/republique.png') }}" alt=""></div> --}}
                              <div style="text-align:center">
								<h6>REPUBLIQUE DE CÔTE D’IVOIRE</h6>
								<small>Union – Discipline – Travail</small>
								<p class="title-head">…………….…..</p>
								<p class="title-head">MINISTÈRE D’ÉTAT, MINISTÈRE DE LA DÉFENSE</p>
							</div>
                            {{-- <div style="text-align:center"><img src="{{ asset('assets/img/uploads/barm.jpg') }}" alt=""></div>--}}
                        <div class="section" style="margin-top: 25px;">
                            <div class="section-content-nob">
                                <p style="text-align:center">
                                    <h4>ATTESTATION DE CONGE N°______________/MEMDEF/BARM/Grh du _______________</h4>
                                </p>
                                <br>
                                <br>
                                @php
                                    $anneePrecedente = \Carbon\Carbon::parse($leaves->created_at)->subYear()->format('Y');
                                @endphp
                                <div class="content">
                                    <p style="text-align: justify; font-size: 18px">
                                        Je soussigné le Colonel AKE-DANHO SPTEPHANE, le Chef du Bureau d’Accompagnement à la Reconversion des Militaires (BARM),  atteste que @if ($leaves->user->personnel->gender == 'Masculin')<b>M. </b>@else<b>Mme </b>@endif<b>{{$leaves->user->fullName()}}</b>, bénéficie
                                        d'un conge annuel de ({{ $leaves->nb_day }}) jours consécutifs au titre de l'année <b>{{ $anneePrecedente }}</b> allant du <b>@php echo e(date('d/m/Y',strtotime($leaves->leavefrom)))@endphp au @php echo e(date('d/m/Y',strtotime($leaves->leaveto)))@endphp inclus</b>. <br>
                                        La date de reprise de l'agent susmentionné est prévue pour le<b> {{ date('d/m/Y', strtotime($leaves->returndate)) }} à 08 H</b>. <br><br>
                                        En foi que, la présente attestation lui est délivrée pour le service et valoir ce que de droit.
                                    </p>
                                </div>
                            </div>
                                <br>
                                <p style="float: right;margin-right : 50px;">
                                Abidjan, le {{ date('d/m/Y', strtotime($leaves->created_at)) }}.
                                </p>
                        </div>
                        <br>
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
</body>
