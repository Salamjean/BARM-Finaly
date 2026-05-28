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

                    .details,
                    .details th,
                    .details td {
                        border: 1px solid #000000;
                        padding: 5px;
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
                        font-size: 70%;
                        margin-bottom: 0;
                    }
                </style>
            </head>

            <body>
                <div class="container">
                    <div class="header__section">
                        <div style="position: absolute; top:0; left :0; height:100%; width: 100%"><img
                                src="{{ asset('assets/img/uploads/republique.png') }}" alt=""></div>
                        <div style="position: absolute; top:0; right :0;"><img
                                src="{{ asset('assets/img/uploads/CDD.jpeg') }}" alt=""></div>
                        <div style="text-align:center">
                            <h6>REPUBLIQUE DE CÔTE D’IVOIRE</h6>
                            <small>Union – Discipline – Travail</small>
                            <p class="title-head">…………….…..</p>
                            <p class="title-head">MINISTÈRE D’ÉTAT, MINISTÈRE DE LA DÉFENSE</p>
                        </div>
                        {{-- <div style="text-align:center"><img src="{{ asset('assets/img/uploads/barm.jpg') }}"
                                alt=""></div>--}}

                        <div style="position: absolute; top:23; right :50; font-weight: 100;">
                            <p>Abidjan, le {{ dateFr($besoin->updated_at) }}</p>
                        </div>
                        <div class="section" style="margin-top: 25px;">
                            <div class="section-content-nob">
                                <h1 style="text-align:center; font-weight: 900; text-decoration: underline;">
                                    {{$title}}
                                </h1>
                            </div>
                        </div>

                        <div class="container">
                            {{-- <table class="details">
                                <tr class="title-head">
                                    <th colspan="2" style="text-align:center">Motif(s)</th>
                                </tr>
                                <tr class="title-head">
                                    <td colspan="2">
                                        {{ $besoin->reason}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                            </table> --}}
                            <table class="details">
                                <tr>
                                    <td style="text-align:center; font-weight:bold;">N/D</td>
                                    <td style="text-align:center; font-weight:bold;">Designation du consommable</td>
                                    <td style="text-align:center; font-weight:bold;">Quantité</td>
                                </tr>
                                @foreach ($besoin->besoinitems as $besoinitem)
                                    <tr>
                                        <td style="text-align:center">{{ $loop->index+1 }}</td>
                                        <td style="text-align:center">{{ $besoinitem->consommable->designation }}</td>
                                        <td style="text-align:center">{{ $besoinitem->qte_recue }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            
                            <div style="margin-top:15px">
                                <p>Au profit du: <strong>{{ $besoin->user->fullName() }}</strong></p>
                            </div>

                            <div style="position: absolute; left:0; font-weight: 100;">
                                <p style="text-decoration: underline;">UTILISATEUR</p>
                                <p style="text-align:center">{{ $besoin->user->fullName() }}</p>
                            </div>
                            <div style="position: absolute; right :0; font-weight: 100;">
                                <p style="text-decoration: underline;">RESPONSABLE MOYENS GENERAUX</p>
                            </div>
                            <div style="margin-top:150px; position: absolute; left:200; font-weight: 100;">
                                <p style="text-decoration: underline;">LE CHEF BARM</p>
                            </div>
                            {{-- <h6>
                                <u>Ampliations</u><br><br>
                                - Responsable AF <br>
                                - Gestionnaire RH <br>
                                - Intéressé(e) <br>
                                - Dossier intéressé(e) <br>
                                - Chrono
                            </h6> --}}
                        </div>
                    </div>
                </div>
            </body>
        </p>
    </div>
</body>