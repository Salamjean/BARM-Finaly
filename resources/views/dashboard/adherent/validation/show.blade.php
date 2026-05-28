@extends('layouts.app')

@section('content')
    <style>
        .choice {
            background: linear-gradient(#E8EBE47E, #C2D2D37E);
            border: none;
            border-radius: 15px;
            box-shadow: 0 15px 15px -15px rgb(0 0 0 / 0.25);
            margin-bottom: 20px;
            margin-left: 1px;
        }

        .form-control-choice {
            border: none !important;
            background: rgba(255, 255, 255, 0.671);
            border-radius: 0;
            font-weight: 600;
            padding: 6px;
            padding-left: 10px;
        }

        .form-label-choice {
            font-size: 15px;
            margin-top: 10px;
            text-transform: uppercase;
        }

        .btn {
            color: white;
            font-weight: 600;
        }

        .btn-accepted {
            background: rgb(23, 88, 58);
        }

        .btn-refused {
            background: rgb(88, 23, 32);

        }

        .btn-accepted:hover {
            background: rgba(10, 161, 91, 0.8);
            color: white;
        }

        .btn-refused:hover {
            background: rgba(180, 6, 29, 0.8);
            color: white;

        }
    </style>
    <div class="container pt-2">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Candidatures/</span> {{ $title }} / <span
                class="{{ status($choice->candidature->status, 'css') }}">{{ status($choice->candidature->status) }}</span>
        </h4>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-content-center">
                            <a href="{{ route('adherent.candidature.validation.list') }}"><i class='bx bx-arrow-back'></i> Retour</a>
                        </div>
                        <div class="user-avatar-section">
                            <div class=" d-flex align-items-center flex-column">
                                <img class="img-fluid rounded my-4" src="{{ asset('assets/img/avatars/avatar.png') }}"
                                    height="110" width="110" alt="User avatar" />
                                <div class="user-info text-center">
                                    <h5 class="mb-2">{{ $choice->candidature->user->username }}</h5>
                                    <span
                                        class="badge bg-label-secondary">{{ roleFr($choice->candidature->user->roles->first()->name) }}</span>
                                </div>
                            </div>
                        </div>

                        <h5 class="pb-2 border-bottom mt-4">Informations personnelles</h5>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Nom et prénoms:</span>
                                    <span>{{ $choice->candidature->user->fullName() }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Mecano / Matricule:</span>
                                    <span>{{ $choice->candidature->user->mecano }}</span>
                                </li>
                                @if ($choice->candidature->birth_date)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Date de naissance:</span>
                                        <span>{{ dateFr($choice->candidature->birth_date) }}</span>
                                    </li>
                                @endif
                                @if ($choice->candidature->phone_number)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Numéro de téléphone:</span>
                                        <span>{{ $choice->candidature->phone_number }}</span>
                                    </li>
                                @endif
                                @if ($choice->candidature->user->email)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Email:</span>
                                        <span>{{ $choice->candidature->user->email }}</span>
                                    </li>
                                @endif
                                @if ($choice->candidature->orientation)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Orientation:</span>
                                        <span
                                            class="text-info text-uppercase">{{ statusCandidature($choice->candidature->orientation, 'orientation') }}</span>
                                    </li>
                                @endif
                                @if ($choice->candidature->gender)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Genre:</span>
                                        <span>{{ $choice->candidature->gender }}</span>
                                    </li>
                                @endif
                                @if ($choice->candidature->religion)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Réligion:</span>
                                        <span>{{ $choice->candidature->religion }}</span>
                                    </li>
                                @endif
                                @if ($choice->candidature->ethnic)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Ethnie:</span>
                                        <span>{{ $choice->candidature->ethnic }}</span>
                                    </li>
                                @endif

                                @if ($choice->candidature->situation_matrimoniale)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Sitatuation matrimoniale:</span>
                                        <span>{{ $choice->candidature->situation_matrimoniale }}</span>
                                    </li>
                                @endif

                                @if ($choice->candidature->residence)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Résidence:</span>
                                        <span>{{ $choice->candidature->residence }}</span>
                                    </li>
                                @endif

                                @if (count($choice->candidature->childs) > 0)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Nombre d'enfant:</span>
                                        <span>{{ count($choice->candidature->childs) }}</span>
                                    </li>
                                @endif

                                <li class="mb-3">
                                    <span class="fw-bold me-2">Statut du compte:</span>
                                    <span
                                        class="badge {{ $choice->candidature->user->status == 1 ? 'bg-label-success' : 'bg-label-danger' }} ">{{ $choice->candidature->user->status == 1 ? 'Actif' : 'Inactif' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">


                <div class="col-md-12 row p-2 py-4 rounded-2 choice">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="pb-1 fs-5 fw-bold text-danger">
                            CHOIX FINAL
                        </div>
                        @if ($choice->candidature->status != 'accepted')
                            <div class="mb-2">
                                <a class="btn btn-accepted text-uppercase"
                                    href="{{ route('adherent.candidature.validation.status', [$choice->id, 'accepted']) }}">Valider</a>
                                @if (($choice->candidature->orientation != 'auto-emploi') && ($choice->candidature->status != 'refused'))
                                    <a class="btn btn-refused text-uppercase"
                                        href="{{ route('adherent.candidature.validation.status', [$choice->id, 'refused']) }}">Refuser</a>
                                @endif
                            </div>
                        @endif

                    </div>

                    @if ($choice->domaine)
                        <div class="col-md-6">
                            <label class="form-label-choice">Domaine : </label>
                            <div class="form-control-choice">{{ $choice->domaine }}</div>
                        </div>
                    @endif
                    @if ($choice->specialisation)
                        <div class="col-md-6">
                            <label class="form-label-choice">Spécialisation : </label>
                            <div class="form-control-choice">{{ $choice->specialisation }} </div>
                        </div>
                    @endif

                    @if ($choice->region_retraite)
                        <div class="col-md-6">
                            <label class="form-label-choice">Région de projet : </label>
                            <div class="form-control-choice">{{ $choice->region_retraite }}</div>
                        </div>
                    @endif

                    @if ($choice->department)
                        <div class="col-md-6">
                            <label class="form-label-choice">Département : </label>
                            <div class="form-control-choice"> {{ $choice->department }} </div>
                        </div>
                    @endif

                    @if ($choice->locality)
                        <div class="col-md-6">
                            <label class="form-label-choice">Localité de projet :
                            </label>
                            <div class="form-control-choice"> {{ $choice->locality }} </div>
                        </div>
                    @endif

                    @if ($choice->adress_geo)
                        <div class="col-md-6">
                            <label class="form-label-choice">Adresse géographique :
                            </label>
                            <div class="form-control-choice"> {{ $choice->adress_geo }} </div>
                        </div>
                    @endif

                    @if ($choice->formation)
                        <div class="col-md-6">
                            <label class="form-label-choice">Formation souhaitée :
                            </label>
                            <div class="form-control-choice"> {{ $choice->formation }} </div>
                        </div>
                    @endif

                    @if ($choice->autres_form)
                        <div class="col-md-6">
                            <label class="form-label-choice">Autres solicitations :
                            </label>
                            <div class="form-control-choice"> {{ $choice->autres_form }} </div>
                        </div>
                    @endif

                    @if ($choice->partner_id)
                        <div class="col-md-12">
                            <label class="form-label-choice">Partenaire technique :
                            </label>
                            <div class="form-control-choice"> {{ $choice->partner->user->username }} </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-12">
                    <div class="card ms-0 mb-2">

                        <h5 class="card-header pb-2 text-uppercase">Informations sur la candidature</h5>
                        <div class="card-body py-4">
                            <div class="row g-3">

                                @if ($choice->candidature->type_piece)
                                    <div class=" col-md-12 card shadow-none my-0">
                                        <div class=" card-header pb-0">
                                            <h5 class="pb-0 border-bottom text-uppercase mt-2">IDENTITé</h5>
                                        </div>
                                        <div class="card-body row">
                                            @if ($choice->candidature->type_piece)
                                                <div class="col-md-6">
                                                    <label class="form-label">Type de pièce : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->type_piece }}" readonly />
                                                </div>
                                            @endif
                                            @if ($choice->candidature->no_card)
                                                <div class="col-md-6">
                                                    <label class="form-label">N° de Pièce : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->no_card }}" readonly />
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                @endif

                                @if ($choice->candidature->partner_fullname)
                                    <div class=" col-md-12 card shadow-none my-0">
                                        <div class=" card-header pb-0">
                                            <h5 class="pb-0 border-bottom mt-2">CONJOINT(E)</h5>
                                        </div>
                                        <div class="card-body row">
                                            @if ($choice->candidature->partner_fullname)
                                                <div class="col-md-6">
                                                    <label class="form-label">Nom & Prénoms du conjoint(e) :
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->partner_fullname }}" readonly />
                                                </div>
                                            @endif
                                            @if ($choice->candidature->partner_job)
                                                <div class="col-md-6">
                                                    <label class="form-label">Profession du conjoint(e) : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->partner_job }}" readonly />
                                                </div>
                                            @endif
                                            @if ($choice->candidature->partner_phone_number)
                                                <div class="col-md-6">
                                                    <label class="form-label">Contact du conjoint(e) : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->partner_phone_number }}"
                                                        readonly />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if (count($choice->candidature->childs) > 0)
                                    <div class=" col-md-12 card shadow-none my-0 mb-2">
                                        <div class=" card-header pb-0">
                                            <h5 class="pb-0 border-bottom mt-2">ENFANTS</h5>
                                        </div>
                                        @foreach ($choice->candidature->childs as $key => $child)
                                            <div class="card-body py-2 row">
                                                @if ($child->fullname)
                                                    <div class="col-md-12">
                                                        <li class="pb-0 text-warning">
                                                            Enfant {{ $key + 1 }}
                                                        </li>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Nom & Prénoms :
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $child->fullname }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($child->birth_date)
                                                    <div class="col-md-3">
                                                        <label class="form-label">Date de naissance :
                                                        </label>
                                                        <input type="date" class="form-control"
                                                            value="{{ $child->birth_date }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($child->level)
                                                    <div class="col-md-3">
                                                        <label class="form-label">Niveau d'étude :
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $child->level }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($child->file)
                                                    <div class="col-md-2 d-flex flex-column justify-content-center">
                                                        <label class="form-label">Document J. :
                                                        </label>
                                                        <div>
                                                            <a href="{{ asset($child->file) }}" download>
                                                                <i class='bx bx-cloud-download fs-2'></i>
                                                            </a>
                                                        </div>

                                                    </div>
                                                @endif

                                            </div>
                                        @endforeach

                                    </div>
                                @endif

                                @if ($choice->candidature->armee)
                                    <div class=" col-md-12 card shadow-none my-0">
                                        <div class=" card-header pb-0">
                                            <h5 class="pb-0 border-bottom mt-2">SITUATION PROFESSIONNELLE</h5>
                                        </div>
                                        <div class="card-body row">
                                            <div class="col-md-12">
                                                <li class="pb-1 text-warning">Origine</li>
                                            </div>
                                            @if ($choice->candidature->armee)
                                                <div class="col-md-6">
                                                    <label class="form-label">Type de militaire : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->armee }}" readonly />
                                                </div>
                                            @endif
                                            @if ($choice->candidature->unite_rattachement)
                                                <div class="col-md-6">
                                                    <label class="form-label">Unité de rattachement : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->unite_rattachement }}" readonly />
                                                </div>
                                            @endif
                                            @if ($choice->candidature->statut_prof)
                                                <div class="col-md-6">
                                                    <label class="form-label">Statut professionel : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->statut_prof }}" readonly />
                                                </div>
                                            @endif
                                            @if ($choice->candidature->grade)
                                                <div class="col-md-6">
                                                    <label class="form-label">Grade : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->grade }}" readonly />
                                                </div>
                                            @endif
                                            @if ($choice->candidature->date_entree)
                                                <div class="col-md-6">
                                                    <label class="form-label">Date d'entrée : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ dateFr($choice->candidature->date_entree) }}"
                                                        readonly />
                                                </div>
                                            @endif
                                            @if ($choice->candidature->date_radiation)
                                                <div class="col-md-6">
                                                    <label class="form-label">Date de radiation : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ dateFr($choice->candidature->date_radiation) }}"
                                                        readonly />
                                                </div>
                                            @endif
                                            @if ($choice->candidature->date_entree && $choice->candidature->date_radiation)
                                                <div class="col-md-6">
                                                    @php
                                                        $service_start = new Carbon\Carbon(
                                                            $choice->candidature->date_entree,
                                                        );
                                                        $service_end = new Carbon\Carbon(
                                                            $choice->candidature->date_radiation,
                                                        );
                                                    @endphp
                                                    <label class="form-label">Nombre d'année de service : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $service_end->diff($service_start)->days }} Jours"
                                                        readonly />
                                                </div>
                                            @endif
                                            @if (count($choice->candidature->jobs) > 0)
                                                <div class="col-md-12 pt-4 pb-2">
                                                    <li class="pb-1 text-warning">Emplois successifs</li>
                                                </div>
                                            @endif
                                            @foreach ($choice->candidature->jobs as $key => $job)
                                                @if ($job->periode)
                                                    <div class="col-md-4">
                                                        <label class="form-label">Périodes : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $job->periode }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($job->organism)
                                                    <div class="col-md-4">
                                                        <label class="form-label">Organisme : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $job->organism }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($job->fonction)
                                                    <div class="col-md-4">
                                                        <label class="form-label">Fonctions : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $job->fonction }}" readonly />
                                                    </div>
                                                @endif
                                            @endforeach
                                            @if (count($choice->candidature->diplomes) > 0)
                                                <div class="col-md-12 pt-4 pb-2">
                                                    <li class="pb-1 text-warning">Domaine de spécialité</li>
                                                </div>
                                            @endif
                                            @foreach ($choice->candidature->diplomes as $key => $diplome)
                                                @if ($diplome->diplome_militaire)
                                                    <div class="col-md-3">
                                                        <label class="form-label text-capitalize">DIPLÔMES
                                                            MILITAIRES : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $diplome->diplome_militaire }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($diplome->annees_dm)
                                                    <div class="col-md-3">
                                                        <label class="form-label">ANNÉES : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $diplome->annees_dm }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($diplome->diplome_civil)
                                                    <div class="col-md-3">
                                                        <label class="form-label">DIPLÔME CIVILS : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $diplome->diplome_civil }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($diplome->annees_dc)
                                                    <div class="col-md-3">
                                                        <label class="form-label">ANNÉES : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $diplome->annees_dc }}" readonly />
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if ($choice->candidature->domaine_1c)
                                    <div class=" col-md-12 card shadow-none my-0">
                                        <div class=" card-header pb-0">
                                            <h5 class="pb-0 border-bottom mt-2">PROJET PROFESSIONNEL</h5>
                                        </div>
                                        <div class="card-body row">

                                            <div class="col-md-12">
                                                <li class="pb-1 text-warning">
                                                    CHOIX 1
                                                    @if ($choice->candidature->choiceFinal)
                                                        <span class="text-danger fw-bold">
                                                            {{ $choice->candidature->choiceFinal->choice_number == 'one' ? '(choix final)' : '' }}
                                                        </span>
                                                    @endif
                                                </li>
                                            </div>

                                            @if ($choice->candidature->domaine_1c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Domaine : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->domaine_1c }}" readonly />
                                                </div>
                                            @endif
                                            @if ($choice->candidature->specialisation_1c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Spécialisation : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->specialisation_1c }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->region_retraite_1c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Région de projet : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->region_retraite_1c }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->department_1c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Département : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->department_1c }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->locality_1c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Localité de projet : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->locality_1c }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->adress_geo_1c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Adresse géographique : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->adress_geo_1c }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->formation_1c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Formation souhaitée : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->formation_1c }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->autres_form_1c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Autres solicitations : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->autres_form_1c }}" readonly />
                                                </div>
                                            @endif
                                            @if ($choice->candidature->domaine_2c)
                                                <div class="col-md-12 pt-4">
                                                    <li class="pb-1 text-warning">
                                                        CHOIX 2
                                                        @if ($choice->candidature->choiceFinal)
                                                            <span class="text-danger fw-bold">
                                                                {{ $choice->candidature->choiceFinal->choice_number == 'two' ? '(choix final)' : '' }}
                                                            </span>
                                                        @endif
                                                    </li>
                                                </div>


                                                <div class="col-md-6">
                                                    <label class="form-label">Domaine : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->domaine_2c }}" readonly />
                                                </div>
                                            @endif
                                            @if ($choice->candidature->specialisation_2c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Spécialisation : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->specialisation_2c }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->region_retraite_2c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Région de projet : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->region_retraite_2c }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->department_2c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Département : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->department_2c }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->locality_2c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Localité de projet : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->locality_2c }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->adress_geo_2c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Adresse géographique : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->adress_geo_2c }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->formation_2c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Formation souhaitée : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->formation_2c }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->autres_form_2c)
                                                <div class="col-md-6">
                                                    <label class="form-label">Autres solicitations : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->autres_form_2c }}" readonly />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if ($choice->candidature->condition_admin)
                                    <div class=" col-md-12 card shadow-none my-0">
                                        <div class=" card-header pb-0">
                                            <h5 class="pb-0 border-bottom text-uppercase mt-2">CONDITION DE DéPART
                                            </h5>
                                        </div>
                                        <div class="card-body row">
                                            @if ($choice->candidature->condition_admin)
                                                <div class="col-md-3">
                                                    <label class="form-label">Condition administratives : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->condition_admin }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->condition_financiere)
                                                <div class="col-md-9">
                                                    <label class="form-label">Condition financière : </label>
                                                    <div class=" rounded-2 row gap-2 p-1 px-2">
                                                        @foreach (json_decode($choice->candidature->condition_financiere) as $condition_financiere)
                                                            <div class="border  rounded-2 p-1 px-2 col-md-12"
                                                                style="background-color: #7A7A7A3F">
                                                                {{ $condition_financiere }}
                                                            </div>
                                                        @endforeach

                                                    </div>

                                                </div>
                                            @endif

                                            @if ($choice->candidature->condition_disciplinaire)
                                                <div class="col-md-12">
                                                    <label class="form-label">Condition Disciplinaire : </label>
                                                    <textarea class="form-control" readonly>{{ $choice->candidature->condition_disciplinaire }}</textarea>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if ($choice->candidature->accident_maladie)
                                    <div class=" col-md-12 card shadow-none my-0">
                                        <div class=" card-header pb-0">
                                            <h5 class="pb-0 border-bottom text-uppercase mt-2">ACCIDENT / MALADIE
                                            </h5>
                                        </div>
                                        <div class="card-body row">
                                            @if ($choice->candidature->accident_maladie)
                                                <div class="col-md-6">
                                                    <label class="form-label">Accident maladie : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->accident_maladie }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->demarche_nature)
                                                <div class="col-md-6">
                                                    <label class="form-label">Nature de la demarche : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->demarche_nature }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->demarche_admin)
                                                <div class="col-md-6">
                                                    <label class="form-label">Administration de la démarche :
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->demarche_admin }}" readonly />
                                                </div>
                                            @endif

                                            @if ($choice->candidature->etat_avancement)
                                                <div class="col-md-6">
                                                    <label class="form-label">Etat d'avancement : </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $choice->candidature->etat_avancement }}" readonly />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <h5 class="card-header pb-0 text-uppercase">Pièces jointes</h5>
                        <div class="table-responsive">
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    @if ($choice->candidature->partner_card)
                                        <div class="col-md-6">
                                            <div
                                                class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                <div>Pièce d'identité du conjoint(e)</div>
                                                <div>
                                                    <a href="{{ asset($choice->candidature->partner_card) }}" download>
                                                        <i class='bx bx-cloud-download fs-2'></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($choice->candidature->marriage_certificate)
                                        <div class="col-md-6">
                                            <div
                                                class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                <div>Certificat de mariage</div>
                                                <div>
                                                    <a href="{{ asset($choice->candidature->marriage_certificate) }}"
                                                        download>
                                                        <i class='bx bx-cloud-download fs-2'></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($choice->candidature->demande_manuscrite)
                                        <div class="col-md-6">
                                            <div
                                                class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                <div>Demande manuscrite</div>
                                                <div>
                                                    <a href="{{ asset($choice->candidature->demande_manuscrite) }}"
                                                        download>
                                                        <i class='bx bx-cloud-download fs-2'></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($choice->candidature->cv)
                                        <div class="col-md-6">
                                            <div
                                                class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                <div>CV</div>
                                                <div>
                                                    <a href="{{ asset($choice->candidature->cv) }}" download>
                                                        <i class='bx bx-cloud-download fs-2'></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($choice->candidature->id_card)
                                        <div class="col-md-6">
                                            <div
                                                class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                <div>Pièce d'identité</div>
                                                <div>
                                                    <a href="{{ asset($choice->candidature->id_card) }}" download>
                                                        <i class='bx bx-cloud-download fs-2'></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($choice->candidature->carte_pro)
                                        <div class="col-md-6">
                                            <div
                                                class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                <div>Carte professionnelle</div>
                                                <div>
                                                    <a href="{{ asset($choice->candidature->carte_pro) }}" download>
                                                        <i class='bx bx-cloud-download fs-2'></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($choice->candidature->fiche_engagement)
                                        <div class="col-md-6">
                                            <div
                                                class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                <div>Fiche d'engagement</div>
                                                <div>
                                                    <a href="{{ asset($choice->candidature->fiche_engagement) }}"
                                                        download>
                                                        <i class='bx bx-cloud-download fs-2'></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($choice->candidature->fiche_individuelle)
                                        <div class="col-md-6">
                                            <div
                                                class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                <div>Fiche individuelle</div>
                                                <div>
                                                    <a href="{{ asset($choice->candidature->fiche_individuelle) }}"
                                                        download>
                                                        <i class='bx bx-cloud-download fs-2'></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($choice->candidature->arrete_radiation)
                                        <div class="col-md-6">
                                            <div
                                                class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                <div>Arrêté de radiation</div>
                                                <div>
                                                    <a href="{{ asset($choice->candidature->arrete_radiation) }}"
                                                        download>
                                                        <i class='bx bx-cloud-download fs-2'></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($choice->candidature->certificat)
                                        <div class="col-md-6">
                                            <div
                                                class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                <div>Certificat médical</div>
                                                <div>
                                                    <a href="{{ asset($choice->candidature->certificat) }}" download>
                                                        <i class='bx bx-cloud-download fs-2'></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
