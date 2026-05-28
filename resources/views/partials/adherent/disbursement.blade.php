
    <style>
        .avatarr {
            width: 300px !important;
            height: 300px !important;
            object-fit: cover;
            border-radius: 100%;
            background-color: #f5f5f5;
        }

        body {
            color: #6F8BA4;
            margin-top: 20px;
        }

        .section {
            padding: 10px 0;
            position: relative;
        }

        .gray-bg {
            background-color: #f5f5f5;
        }

        img {
            max-width: 100%;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        /* About Me
                                                                                            ---------------------*/
        .about-text h3 {
            font-size: 45px;
            font-weight: 700;
            margin: 0 0 6px;
        }

        @media (max-width: 767px) {
            .about-text h3 {
                font-size: 35px;
            }
        }

        .about-text h6 {
            font-weight: 600;
            margin-bottom: 15px;
        }

        @media (max-width: 767px) {
            .about-text h6 {
                font-size: 18px;
            }
        }

        .about-text p {
            font-size: 18px;
            max-width: 450px;
        }

        .about-text p mark {
            font-weight: 600;
            color: #20247b;
        }

        .about-list {
            padding-top: 10px;
        }

        .about-list .media {
            padding: 5px 0;
        }

        .about-list label {
            color: #20247b;
            font-weight: 600;
            width: 200px;
            margin: 0;
            position: relative;
        }

        .about-list label:after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            right: 11px;
            width: 1px;
            height: 12px;
            background: #20247b;
            -moz-transform: rotate(15deg);
            -o-transform: rotate(15deg);
            -ms-transform: rotate(15deg);
            -webkit-transform: rotate(15deg);
            transform: rotate(15deg);
            margin: auto;
            opacity: 0.5;
        }

        .about-list p {
            margin: 0;
            font-size: 15px;
        }

        @media (max-width: 991px) {
            .about-avatar {
                margin-top: 30px;
            }
        }

        .about-section .counter {
            padding: 20px 20px;
            margin-top: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(31, 45, 61, 0.125);
        }

        .about-section .counter .count-data {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .about-section .counter .count {
            font-weight: 700;
            color: #20247b;
            margin: 0 0 5px;
        }

        .about-section .counter p {
            font-weight: 600;
            margin: 0;
        }

        mark {
            background-image: linear-gradient(rgba(252, 83, 86, 0.6), rgba(252, 83, 86, 0.6));
            background-size: 100% 3px;
            background-repeat: no-repeat;
            background-position: 0 bottom;
            background-color: transparent;
            padding: 0;
            color: currentColor;
        }

        .theme-color {
            color: #fc5356;
        }

        .dark-color {
            color: #20247b;
        }
    </style>
    <div class="container-fuild">
        <div class="mb-10">
            <div class="">
                <div class="card-body">
                    @if(!isset($show_adherent))
                    <section class="section about-section" id="about">
                        <div class="container">
                            <div class="row align-items-center flex-row-reverse">
                                <div class="col-lg-9">
                                    <div class="about-text go-to">
                                        <h3 class="dark-color">Informations</h3>
                                        <h6 class="theme-color lead">{{ $adherent->user->fullName() }}</h6>

                                        <div class="row about-list">
                                            <div class="col-md-6 ">
                                                <div class="media">
                                                    <label>Mecano</label>
                                                    <p>{{ $adherent->user->mecano }}</p>
                                                </div>
                                                <div class="media">
                                                    <label>Date de naissance</label>
                                                    <p>{{ dateFr($adherent->birth_date) }}</p>
                                                </div>
                                                <div class="media">
                                                    <label>Pièce d&apos;identité</label>
                                                    <p>{{ $adherent->type_piece }} / {{ $adherent->no_card }}</p>
                                                </div>
                                                <div class="media">
                                                    <label>Adresse</label>
                                                    <p>{{ $adherent->address }}</p>
                                                </div>
                                                @if ($adherent->user->email)
                                                    <div class="media">
                                                        <label>E-mail</label>
                                                        <p>{{ $adherent->user->email ?? 'None' }}</p>
                                                    </div>
                                                @endif
                                                <div class="media">
                                                    <label>Numéro de téléphone</label>
                                                    <p>(+225) {{ $adherent->phone_number }}
                                                        {{ $adherent->phone_number2 ? ', ' . $adherent->phone_number2 : '' }}
                                                        {{ $adherent->phone_number3 ? ', ' . $adherent->phone_number3 : '' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                    <div class="media">
                                                        <label>Partenaire technique</label>
                                                        <p>{{ $adherent->partnerTechnical->user->username }}</p>
                                                    </div>
                                                <div class="media">
                                                    <label>Partenaire financier</label>
                                                    <p>{{ $adherent->partnerFinancial->user->username }}</p>
                                                </div>
                                                <div class="media">
                                                    <label>Titre du plan d&apos;affaire</label>
                                                    <p>{{ $adherent->paAccepted->title }}</p>
                                                </div>
                                                <div class="media">
                                                    <label>Montant</label>
                                                    <p>{{ amount($adherent->paAccepted->amount) . DEVICE }}</p>
                                                </div>
                                                <div class="media">
                                                    <label>Crédit sollicité</label>
                                                    <p>{{ amount($adherent->paAccepted->credit) . DEVICE }}</p>
                                                </div>
                                                <div class="media">
                                                    <label>Date d&apos;ouverture de compte</label>
                                                    <p>{{ dateFr($adherent->selfEmploymentMonitoredPayment->datetime_authorization_approved, 'complet') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="about-avatar">
                                        <img src="{{ asset($adherent->image) }}" title="" alt="img"
                                            class="avatarr">
                                    </div>
                                </div>
                            </div>

                            <div class="counter">
                                <div class="row">
                                    <div class="col-6 col-lg-3">
                                        <div class="count-data text-center">
                                            <h6 class="count h3" data-to="0"
                                                data-speed="{{ count($adherent->selfEmploymentMonitoredPayment->disbursements->where('status', 'finished')) }}">
                                                {{ count($adherent->selfEmploymentMonitoredPayment->disbursements->where('status', 'finished')) }}
                                            </h6>
                                            <p class="m-0px font-w-600">Nombre de decaissement</p>
                                        </div>
                                    </div>

                                    <div class="col-6 col-lg-3">
                                        <div class="count-data text-center">
                                            <h6 class="count h3" data-to="0}" data-speed="{{ $amount_disbursed }}">
                                                {{ amount($amount_disbursed) . DEVICE }}</h6>
                                            <p class="m-0px font-w-600">Montant décaissé</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div class="count-data text-center">
                                            <h6 class="count h3" data-to="0" data-speed="{{ $left_pay }}">
                                                {{ amount($left_pay) . DEVICE }}</h6>
                                            <p class="m-0px font-w-600">Reste à décaisser</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div class="count-data text-center">
                                            <h6 class="count h3 text-{{ $left_pay === 0 ? 'success' : 'warning' }}">
                                                {{ $left_pay === 0 ? 'Terminer' : 'En cours' }}</h6>
                                            <p class="m-0px font-w-600">Statut de la procédure</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    @endif




                    <div class="@if (!isset($show_adherent)) px-4 @endif">
                        <div class="table-responsive mt-1">
                            <table class="table @if (!isset($show_adherent)) table-striped @else bg-white @endif ">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Montant</th>
                                        <th>D. Soumission</th>
                                        <th>F. Décaissement</th>
                                        <th>D. Autorisation</th>
                                        <th>F. Decaissement signé</th>
                                        <th>D. Decaissement</th>
                                        <th>D. Rapport</th>
                                        <th>Rapport</th>
                                        <th>Statut</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($adherent->selfEmploymentMonitoredPayment->disbursements as $index => $disbursement)
                                        <tr>
                                            <td class="w-25">{{ $disbursement->title }}</td>
                                            <td class="w-25">{{ amount($disbursement->amount_disbursement) . DEVICE }}</td>
                                            <td>{{ dateFr($disbursement->date_hour_submission_document) }}</td>
                                            <td>
                                                @if ($disbursement->document_file)
                                                    <a href="{{ asset($disbursement->document_file) }}"><i class="bx bxs-download"></i></a>
                                                @endif
                                            </td>
                                            <td>{{ dateFr($disbursement->authorization_date) }}</td>
                    
                                            <td>
                                                @if ($disbursement->authorization_file)
                                                    <a href="{{ asset($disbursement->authorization_file) }}"><i class="bx bxs-download"></i></a>
                                                @endif
                                            </td>
                    
                                            <td>{{ dateFr($disbursement->date_disbursement) }}</td>
                    
                                            <td>{{ dateFr($disbursement->report_date) }}</td>
                                            <td>
                                                @if ($disbursement->report_file)
                                                    <a href="{{ asset($disbursement->report_file) }}"><i class="bx bxs-download"></i></a>
                                                @endif
                                            </td>
                                            <td class="{{ status($disbursement->status, 'css') }}">
                                                {{ status($disbursement->status) }}</td>
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Pas de décaissement...</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



