<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations Personnelles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h5 {
            margin-bottom: 10px;
            text-transform: uppercase;
            color: #007bff;
            font-size: 24px;
            font-weight: bold;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .info-container ul {
            list-style: none;
            padding: 0;
        }

        .info-container ul li {
            margin-bottom: 15px;
        }

        .info-container ul li span {
            font-weight: bold;
            color: #555;
        }

        .section-title {
            margin-bottom: 10px;
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
        }

        .card {
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header,
        .card-body {
            padding: 10px;
        }

        .card-body .row {
            margin-left: -15px;
            margin-right: -15px;
        }

        .card-body .col-md-6 {
            padding: 15px;
        }

        .form-label {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
            display: block;
        }

        .form-control[readonly] {
            background-color: #f5f5f5;
            border: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
        }

        .c_finan{
            background-color: #f5f5f5;
            border: none;
            padding: 10px 10px;
            margin-left: 20px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .form-control[readonly]:focus {
            outline: none;
        }

        .form-control[readonly]::placeholder {
            color: #888;
        }



        .card-header {}
    </style>
</head>

<body>
    <h5 style="margin-bottom: 0; text-transform: uppercase;">Informations personnelles</h5>
    <div class="info-container">
        <ul>
            <li>
                <span>Nom & Prénoms:</span>
                <span>{{ $user->fullName() }}</span>
            </li>
            <li>
                <span>Mecano / Matricule:</span>
                <span>{{ $user->mecano }}</span>
            </li>
            <li>
                <span>N° de téléphone:</span>
                <span>{{ $user->candidate->phone_number }}</span>
            </li>
            @if ($user->email)
                <li>
                    <span>Email:</span>
                    <span>{{ $user->email }}</span>
                </li>
            @endif
            @if ($user->candidate->birth_date)
                <li>
                    <span>Date de naissance:</span>
                    <span>{{ dateFr($user->candidate->birth_date) }}</span>
                </li>
            @endif
            @if ($user->candidate->orientation)
                <li>
                    <span>Orientation:</span>
                    <span class="text-info">{{ $user->candidate->orientation }}</span>
                </li>
            @endif
            @if ($user->candidate->gender)
                <li>
                    <span>Genre:</span>
                    <span>{{ $user->candidate->gender }}</span>
                </li>
            @endif
            @if ($user->candidate->religion)
                <li>
                    <span>Réligion:</span>
                    <span>{{ $user->candidate->religion }}</span>
                </li>
            @endif
            @if ($user->candidate->ethnic)
                <li>
                    <span>Ethnie:</span>
                    <span>{{ $user->candidate->ethnic }}</span>
                </li>
            @endif
            @if ($user->candidate->situation_matrimoniale)
                <li>
                    <span>Sitatuation matrimoniale:</span>
                    <span>{{ $user->candidate->situation_matrimoniale }}</span>
                </li>
            @endif
            @if ($user->candidate->residence)
                <li>
                    <span>Résidence:</span>
                    <span>{{ $user->candidate->residence }}</span>
                </li>
            @endif
            @if (count($user->candidate->childs) > 0)
                <li>
                    <span>Nombre d'enfant:</span>
                    <span>{{ count($user->candidate->childs) }}</span>
                </li>
            @endif
            <li>
                <span>Statut du compte:</span>
                <span
                    class="badge {{ $user->status == 1 ? 'bg-label-success' : 'bg-label-danger' }}">{{ $user->status == 1 ? 'Actif' : 'Inactif' }}</span>
            </li>
        </ul>
    </div>
    <div class="container">
            <h5 style="margin-bottom: 0; text-transform: uppercase;">Informations sur la candidature</h5>

            <div class="card-body">
                <div class="row">

                    <!-- Section Identité -->
                    @if ($user->candidate->type_piece)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="section-title">Identité</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        @if ($user->candidate->type_piece)
                                            <li class="mb-3">
                                                <span class="fw-bold">Type de pièce:</span>
                                                <span>{{ $user->candidate->type_piece }}</span>
                                            </li>
                                        @endif
                                        @if ($user->candidate->no_card)
                                            <li class="mb-3">
                                                <span class="fw-bold">N° de Pièce:</span>
                                                <span>{{ $user->candidate->no_card }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Section Conjoint(e) -->
                    @if ($user->candidate->partner_fullname)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="section-title">Conjoint(e)</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        @if ($user->candidate->partner_fullname)
                                            <li class="mb-3">
                                                <span class="fw-bold">Nom & Prénoms du conjoint(e) :</span>
                                                <span>{{ $user->candidate->partner_fullname }}</span>
                                            </li>
                                        @endif
                                        @if ($user->candidate->partner_job)
                                            <li class="mb-3">
                                                <span class="fw-bold">Profession du conjoint(e) :</span>
                                                <span>{{ $user->candidate->partner_job }}</span>
                                            </li>
                                        @endif

                                        @if ($user->candidate->partner_phone_number)
                                            <li class="mb-3">
                                                <span class="fw-bold">Contact du conjoint(e) :</span>
                                                <span>{{ $user->candidate->partner_phone_number }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Autres sections à ajouter de la même manière -->
                    @if (count($user->candidate->childs) > 0)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="section-title">Enfants</h5>
                                </div>
                                <div class="card-body">
                                    @foreach ($user->candidate->childs as $key => $child)
                                        @if ($child->fullname)
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <p class="text-warning">Enfant {{ $key + 1 }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="fw-bold me-2">Nom & Prénoms :</span>
                                                    <span>{{ $child->fullname }}</span>
                                                </div>
                                                @if ($child->birth_date)
                                                    <div class="col-md-3">
                                                        <span class="fw-bold me-2">Date de naissance :</span>
                                                        <span>{{ $child->birth_date }}</span>
                                                    </div>
                                                @endif
                                                @if ($child->level)
                                                    <div class="col-md-3">
                                                        <span class="fw-bold me-2">Niveau d'étude :</span>
                                                        <span>{{ $child->level }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($user->candidate->armee)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="section-title">Situation professionnelle</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-warning">Origine</p>
                                        </div>
                                        @if ($user->candidate->armee)
                                            <div class="col-md-6">
                                                <label class="form-label">Type de militaire :</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->armee }}" readonly>
                                            </div>
                                        @endif
                                        @if ($user->candidate->unite_rattachement)
                                            <div class="col-md-6">
                                                <label class="form-label">Unité de rattachement :</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->unite_rattachement }}" readonly>
                                            </div>
                                        @endif
                                        @if ($user->candidate->statut_prof)
                                            <div class="col-md-6">
                                                <label class="form-label">Statut professionel : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->statut_prof }}" readonly />
                                            </div>
                                        @endif
                                        @if ($user->candidate->grade)
                                            <div class="col-md-6">
                                                <label class="form-label">Grade : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->grade }}" readonly />
                                            </div>
                                        @endif
                                        @if ($user->candidate->date_entree)
                                            <div class="col-md-6">
                                                <label class="form-label">Date d'entrée : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ dateFr($user->candidate->date_entree) }}" readonly />
                                            </div>
                                        @endif
                                        @if ($user->candidate->date_radiation)
                                            <div class="col-md-6">
                                                <label class="form-label">Date de radiation : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ dateFr($user->candidate->date_radiation) }}" readonly />
                                            </div>
                                        @endif
                                        @if ($user->candidate->date_entree && $user->candidate->date_radiation)
                                            <div class="col-md-6">
                                                @php
                                                    $service_start = new Carbon\Carbon($user->candidate->date_entree);
                                                    $service_end = new Carbon\Carbon($user->candidate->date_radiation);
                                                @endphp
                                                <label class="form-label">Nombre d'année de service : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $service_end->diff($service_start)->days }} Jours"
                                                    readonly />
                                            </div>
                                        @endif

                                        <div class="col-md-12 pt-4 pb-2">
                                            <p class="text-warning">Emplois successifs</p>
                                        </div>
                                        @foreach ($user->candidate->jobs as $key => $job)
                                            <div class="col-md-4">
                                                @if ($job->periode)
                                                    <label class="form-label">Périodes :</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $job->periode }}" readonly>
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
                                            </div>
                                        @endforeach

                                        <div class="col-md-12 pt-4 pb-2">
                                            <p class="text-warning">Domaine de spécialité</p>
                                        </div>
                                        @foreach ($user->candidate->diplomes as $key => $diplome)
                                            <div class="col-md-3">
                                                @if ($diplome->diplome_militaire)
                                                    <label class="form-label">Diplômes militaires :</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $diplome->diplome_militaire }}" readonly>
                                                @endif
                                                @if ($diplome->annees_dm)
                                                    <div class="col-md-3">
                                                        <label class="form-label">Années : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $diplome->annees_dm }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($diplome->diplome_civil)
                                                    <div class="col-md-3">
                                                        <label class="form-label">Diplômes civils : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $diplome->diplome_civil }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($diplome->annees_dc)
                                                    <div class="col-md-3">
                                                        <label class="form-label">Années : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $diplome->annees_dc }}" readonly />
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($user->candidate->domaine_1c)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="section-title">Projet professionnel</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-warning">Choix 1</p>
                                        </div>
                                        @if ($user->candidate->domaine_1c)
                                            <div class="col-md-6">
                                                <label class="form-label">Domaine :</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->domaine_1c }}" readonly>
                                            </div>
                                        @endif
                                        @if ($user->candidate->specialisation_1c)
                                            <div class="col-md-6">
                                                <label class="form-label">Spécialisation :</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->specialisation_1c }}" readonly>
                                            </div>
                                        @endif
                                        @if ($user->candidate->region_retraite_1c)
                                            <div class="col-md-6">
                                                <label class="form-label">Région de projet : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->region_retraite_1c }}" readonly />
                                            </div>
                                        @endif

                                        @if ($user->candidate->department_1c)
                                            <div class="col-md-6">
                                                <label class="form-label">Département : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->department_1c }}" readonly />
                                            </div>
                                        @endif

                                        @if ($user->candidate->locality_1c)
                                            <div class="col-md-6">
                                                <label class="form-label">Localité de projet : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->locality_1c }}" readonly />
                                            </div>
                                        @endif

                                        @if ($user->candidate->adress_geo_1c)
                                            <div class="col-md-6">
                                                <label class="form-label">Adresse géographique : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->adress_geo_1c }}" readonly />
                                            </div>
                                        @endif

                                        @if ($user->candidate->formation_1c)
                                            <div class="col-md-6">
                                                <label class="form-label">Formation souhaitée : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->formation_1c }}" readonly />
                                            </div>
                                        @endif

                                        @if ($user->candidate->autres_form_1c)
                                            <div class="col-md-6">
                                                <label class="form-label">Autres solicitations : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->autres_form_1c }}" readonly />
                                            </div>
                                        @endif

                                        @if ($user->candidate->domaine_2c)
                                            <div class="col-md-12 pt-4">
                                                <p class="text-warning">Choix 2</p>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Domaine :</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->domaine_2c }}" readonly>
                                            </div>
                                            <!-- Ajoute les autres champs ici de la même manière -->
                                        @endif
                                        @if ($user->candidate->specialisation_2c)
                                            <div class="col-md-6">
                                                <label class="form-label">Spécialisation : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->specialisation_2c }}" readonly />
                                            </div>
                                        @endif

                                        @if ($user->candidate->region_retraite_2c)
                                            <div class="col-md-6">
                                                <label class="form-label">Région de projet : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->region_retraite_2c }}" readonly />
                                            </div>
                                        @endif

                                        @if ($user->candidate->department_2c)
                                            <div class="col-md-6">
                                                <label class="form-label">Département : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->department_2c }}" readonly />
                                            </div>
                                        @endif

                                        @if ($user->candidate->locality_2c)
                                            <div class="col-md-6">
                                                <label class="form-label">Localité de projet : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->locality_2c }}" readonly />
                                            </div>
                                        @endif

                                        @if ($user->candidate->adress_geo_2c)
                                            <div class="col-md-6">
                                                <label class="form-label">Adresse géographique : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->adress_geo_2c }}" readonly />
                                            </div>
                                        @endif

                                        @if ($user->candidate->formation_2c)
                                            <div class="col-md-6">
                                                <label class="form-label">Formation souhaitée : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->formation_2c }}" readonly />
                                            </div>
                                        @endif

                                        @if ($user->candidate->autres_form_2c)
                                            <div class="col-md-6">
                                                <label class="form-label">Autres solicitations : </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->autres_form_2c }}" readonly />
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (
                        $user->candidate->condition_admin ||
                            $user->candidate->condition_financiere ||
                            $user->candidate->condition_disciplinaire)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="section-title">Conditions de départ</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if ($user->candidate->condition_admin)
                                            <div class="col-md-3">
                                                <label class="form-label">Conditions administratives :</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->condition_admin }}" readonly>
                                            </div>
                                        @endif

                                        @if ($user->candidate->condition_financiere)
                                            <div class="col-md-9">
                                                <label class="form-label">Conditions financières :</label>
                                                <div class="row">
                                                    @foreach (json_decode($user->candidate->condition_financiere) as $condition_financiere)
                                                        <div class="col-md-12 mb-2">
                                                            <div class="rounded-2 p-2 c_finan"
                                                                style="">
                                                                {{ $condition_financiere }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        @if ($user->candidate->condition_disciplinaire)
                                            <div class="col-md-12">
                                                <label class="form-label">Conditions disciplinaires :</label>
                                                <textarea class="form-control" readonly>{{ $user->candidate->condition_disciplinaire }}</textarea>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (
                        $user->candidate->accident_maladie ||
                            $user->candidate->demarche_nature ||
                            $user->candidate->demarche_admin ||
                            $user->candidate->etat_avancement)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="section-title">Accident / Maladie</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if ($user->candidate->accident_maladie)
                                            <div class="col-md-6">
                                                <label class="form-label">Accident ou maladie :</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->accident_maladie }}" readonly>
                                            </div>
                                        @endif

                                        @if ($user->candidate->demarche_nature)
                                            <div class="col-md-6">
                                                <label class="form-label">Nature de la démarche :</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->demarche_nature }}" readonly>
                                            </div>
                                        @endif

                                        @if ($user->candidate->demarche_admin)
                                            <div class="col-md-6">
                                                <label class="form-label">Administration de la démarche :</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->demarche_admin }}" readonly>
                                            </div>
                                        @endif

                                        @if ($user->candidate->etat_avancement)
                                            <div class="col-md-6">
                                                <label class="form-label">État d'avancement :</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->candidate->etat_avancement }}" readonly>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</body>

</html>
