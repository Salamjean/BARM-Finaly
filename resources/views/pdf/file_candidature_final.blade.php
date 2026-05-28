<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Profil Utilisateur</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #FFFFFFFF;
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.4em;
            font-weight: bold;
            color: #333;
            border-bottom: 2px solid #007bff;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }

        .orientation-title {
            font-size: 1.2em;
            font-weight: bold;
            color: #007bff;
            text-align: center;
            margin: 20px 0 10px;
        }

        .badge {
            padding: 3px 6px;
            background-color: #444;
            color: #fff;
            font-size: 0.85em;
            border-radius: 4px;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
            margin-bottom: 10px;
        }

        .info-list li {
            margin-bottom: 8px;
        }

        .section-content {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info-list ul {
            margin-left: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th,
        .table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 0.9em;
        }

        .table th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .btn {
            padding: 5px 10px;
            color: #fff;
            border-radius: 5px;
            background-color: #007bff;
            text-decoration: none;
        }

        .download-icon {
            font-size: 1.2em;
            color: #007bff;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 10px auto;
            display: block;
            border: 3px solid #007bff;
        }

        .text-success {
            color: green;
        }

        .text-danger {
            color: red;
        }

        .footer {
            text-align: center;
            font-size: 0.8em;
            color: #777;
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <div class="container">

        @if ($user->candidate->image)
            <img src="{{ public_path($user->candidate->image) }}" alt="Profil Image" class="profile-image">
        @endif


        <h3 class="section-title">Informations Personnelles</h3>
        <div class="section-content">
            <ul class="info-list">
                <li><strong>Nom & Prénoms:</strong> {{ $user->fullName() }}</li>
                <li><strong>Mecano:</strong> {{ $user->mecano }}</li>
                @if ($user->matricule)
                    <li><strong>Matricule:</strong> {{ $user->matricule ?? 'N/A' }}</li>
                @endif
                <li><strong>Date de naissance:</strong> {{ dateFr($user->candidate->birth_date ?? '') }}</li>
                <li><strong>Genre:</strong> {{ $user->candidate->gender ?? 'N/A' }}</li>
                {{-- <li><strong>Religion:</strong> {{ $user->candidate->religion ?? 'N/A' }}</li>
            <li><strong>Ethnie:</strong> {{ $user->candidate->ethnic ?? 'N/A' }}</li> --}}
                <li><strong>Situation matrimoniale:</strong> {{ $user->candidate->situation_matrimoniale ?? 'N/A' }}
                </li>
                <li><strong>Numéro de téléphone:</strong> {{ $user->candidate->phone_number ?? 'N/A' }}</li>
                <li><strong>Résidence:</strong> {{ $user->candidate->residence ?? 'N/A' }}</li>
            </ul>
        </div>


        @if ($user->candidate->partner_fullname || $user->candidate->sos_person_phone_number)
            <h3 class="section-title">Informations Familiales</h3>
            <div class="section-content">
                <ul class="info-list">
                    @if ($user->candidate->partner_fullname)
                        <li><strong>Nom & Prénoms du conjoint(e):</strong>
                            {{ $user->candidate->partner_fullname ?? 'N/A' }}</li>
                        <li><strong>Profession du conjoint(e):</strong> {{ $user->candidate->partner_job ?? 'N/A' }}
                        </li>
                        <li><strong>Contact du conjoint(e):</strong>
                            {{ $user->candidate->partner_phone_number ?? 'N/A' }}</li>
                    @endif
                    @if ($user->candidate->sos_person_phone_number)
                        <li><strong>Contact:</strong> {{ $user->candidate->sos_person_phone_number ?? 'N/A' }}</li>
                    @endif
                </ul>
            </div>
        @endif

        <h3 class="section-title">Situation Professionnelle</h3>
        <div class="section-content">
            <ul class="info-list">
                <li><strong>Type de militaire:</strong> {{ $user->candidate->armee ?? 'N/A' }}</li>
                <li><strong>Unité de rattachement:</strong> {{ $user->candidate->unite_rattachement ?? 'N/A' }}</li>
                <li><strong>Grade:</strong> {{ $user->candidate->grade ?? 'N/A' }}</li>
                <li><strong>Statut professionnel:</strong> {{ $user->candidate->statut_prof ?? 'N/A' }}</li>
                @if ($user->candidate->date_entree)
                    <li><strong>Date d'entrée:</strong> {{ dateFr($user->candidate->date_entree) }}</li>
                @endif
                @if ($user->candidate->date_radiation)
                    <li><strong>Date de retraite:</strong> {{ dateFr($user->candidate->date_radiation) }}</li>
                @endif
            </ul>
        </div>


        @if (count($user->candidate->diplomes) > 0)
            <h3 class="section-title">Diplômes</h3>
            <div class="section-content">
                @foreach ($user->candidate->diplomes as $diplome)
                    <ul class="info-list">
                        <li><strong>{{ $diplome->type == 'civil' ? 'Diplôme Civil' : 'Diplôme Militaire' }}:</strong>
                            {{ $diplome->diplome }} ({{ $diplome->annees }})</li>
                    </ul>
                @endforeach
            </div>
        @endif


        <h3 class="section-title">Projet Professionnel</h3>
        <div class="section-content">

            @if ($user->candidate->choiceFinal)

                <h3 class="orientation-title">Choix Final</h3>
                <ul class="info-list">
                    @if ($user->candidate->choiceFinal->domaine)
                        <li><strong>Domaine :</strong> {{ $user->candidate->choiceFinal->domaine }}</li>
                    @endif
                    @if ($user->candidate->choiceFinal->specialisation)
                        <li><strong>Spécialisation :</strong> {{ $user->candidate->choiceFinal->specialisation }}</li>
                    @endif
                    @if ($user->candidate->choiceFinal->region_retraite)
                        <li><strong>Région de retraite :</strong> {{ $user->candidate->choiceFinal->region_retraite }}
                        </li>
                    @endif
                    @if ($user->candidate->choiceFinal->department)
                        <li><strong>Département :</strong> {{ $user->candidate->choiceFinal->department }}</li>
                    @endif
                    @if ($user->candidate->choiceFinal->locality)
                        <li><strong>Localité de retraite :</strong> {{ $user->candidate->choiceFinal->locality }}</li>
                    @endif
                    @if ($user->candidate->choiceFinal->adress_geo)
                        <li><strong>Adresse géographique :</strong> {{ $user->candidate->choiceFinal->adress_geo }}
                        </li>
                    @endif
                    @if ($user->candidate->choiceFinal->formation)
                        <li><strong>Formation souhaitée :</strong> {{ $user->candidate->choiceFinal->formation }}</li>
                    @endif
                    @if ($user->candidate->choiceFinal->autres_form)
                        <li><strong>Autres sollicitations :</strong> {{ $user->candidate->choiceFinal->autres_form }}
                        </li>
                    @endif
                    @if ($user->candidate->choiceFinal->partner_id)
                        <li><strong>Partenaire technique :</strong>
                            {{ $user->candidate->choiceFinal->partner->user->username ?? 'N/A' }}</li>
                    @endif
                    @if ($user->candidate->choiceFinal)
                        <li><strong>Date du profilage :</strong>
                            {{ $user->candidate->choiceFinal->profilage_date ? dateFr($user->candidate->choiceFinal->profilage_date) : 'N/A' }}
                        </li>
                    @endif
                </ul>
                <hr>
            @else
                <h4 class="orientation-title">Choix 1</h4>
                <ul class="info-list">
                    @if ($user->candidate->domaine_1c)
                        <li><strong>Domaine:</strong> {{ $user->candidate->domaine_1c }}</li>
                    @endif
                    @if ($user->candidate->specialisation_1c)
                        <li><strong>Spécialisation:</strong> {{ $user->candidate->specialisation_1c }}</li>
                    @endif
                    @if ($user->candidate->region_retraite_1c)
                        <li><strong>Région de retraite:</strong> {{ $user->candidate->region_retraite_1c }}</li>
                    @endif
                    @if ($user->candidate->adress_geo_1c)
                        <li><strong>Adresse géographique:</strong> {{ $user->candidate->adress_geo_1c }}</li>
                    @endif
                    @if ($user->candidate->formation_1c)
                        <li><strong>Formation souhaitée:</strong> {{ $user->candidate->formation_1c }}</li>
                    @endif
                    @if ($user->candidate->autres_form_1c)
                        <li><strong>Autres sollicitations:</strong> {{ $user->candidate->autres_form_1c }}</li>
                    @endif
                </ul>

                @if ($user->candidate->specialisation_2c)
                    <h4 class="orientation-title">Choix 2</h4>
                    <ul class="info-list">
                        @if ($user->candidate->domaine_2c)
                            <li><strong>Domaine:</strong> {{ $user->candidate->domaine_2c }}</li>
                        @endif
                        @if ($user->candidate->specialisation_2c)
                            <li><strong>Spécialisation:</strong> {{ $user->candidate->specialisation_2c }}</li>
                        @endif
                        @if ($user->candidate->region_retraite_2c)
                            <li><strong>Région de retraite:</strong> {{ $user->candidate->region_retraite_2c }}</li>
                        @endif
                        @if ($user->candidate->adress_geo_2c)
                            <li><strong>Adresse géographique:</strong> {{ $user->candidate->adress_geo_2c }}</li>
                        @endif
                        @if ($user->candidate->formation_2c)
                            <li><strong>Formation souhaitée:</strong> {{ $user->candidate->formation_2c }}</li>
                        @endif
                        @if ($user->candidate->autres_form_2c)
                            <li><strong>Autres sollicitations:</strong> {{ $user->candidate->autres_form_2c }}</li>
                        @endif
                    </ul>
                @endif
            @endif

        </div>

        @if ($user->candidate->condition_admin)
            <h3 class="section-title">Condition de départ</h3>
            <div class="section-content">
                <ul class="info-list">

                    <li><strong>Condition administratives:</strong> {{ $user->candidate->condition_admin }}.</li>
                    <li>
                        <strong>Condition financière:</strong>
                        @foreach (json_decode($user->candidate->condition_financiere) as $condition_financiere)
                            {{ $condition_financiere ?? 'N/A' }},
                        @endforeach
                    </li>

                </ul>



            </div>
        @endif


        @if ($user->candidate->orientation === 'auto-emploi')
            <h3 class="orientation-title">Orientation : Auto-Emploi</h3>

            @if (count($user->candidate->pas) > 0)

                <h3 class="section-title">Plans d'Affaires</h3>
                <div class="section-content">
                    @foreach ($user->candidate->pas as $key => $pa)
                        <ul class="info-list">
                            <li><strong>Plan d'Affaires {{ $key + 1 }}:</strong> {{ $pa->title }}</li>
                            <li><strong>Adresse géographique:</strong> {{ $pa->location }}</li>
                            <li><strong>Coût du projet:</strong> {{ amount($pa->amount) }} FCFA</li>
                            <li><strong>Crédit sollicité:</strong> {{ amount($pa->credit) }} FCFA</li>
                            @if ($pa->amount_awarded != 0)
                                <li><strong>Crédit accordé:</strong> {{ amount($pa->amount_awarded) }} FCFA</li>
                            @endif
                            @if ($pa->commission)
                                <li><strong>Session N°:</strong> {{ $pa->commission->number }}</li>
                                <li><strong>Date et lieu de la commission:</strong> {{ dateFr($pa->commission->date) }}
                                    - {{ $pa->commission->lieu }}</li>
                            @endif
                            <li><strong>Date de transmission:</strong> {{ dateFr($pa->created_at) }}</li>
                            <li><strong>Statut:</strong> {{ statusCandidature($pa->status) }}</li>
                        </ul>
                        <hr>
                    @endforeach
                </div>
            @endif

            @if ($user->candidate->dataCollect)
                <h3 class="section-title">Collecte de Données</h3>
                <div class="section-content">
                    <ul class="info-list">
                        <li><strong>Date de Début:</strong>
                            {{ dateFr($user->candidate->dataCollect->beging_date ?? '') }}</li>
                        <li><strong>Date de Fin:</strong> {{ dateFr($user->candidate->dataCollect->end_date ?? '') }}
                        </li>
                    </ul>
                </div>
            @endif

            @if (count($user->candidate->participations) > 0)

                <h3 class="section-title">Formations</h3>
                <div class="section-content">
                    @foreach ($user->candidate->participations as $key => $participation)
                        <ul class="info-list">
                            <li><strong>Formation {{ $key + 1 }}</strong></li>
                            <li><strong>Titre:</strong> {{ $participation->training->title }}</li>
                            <li><strong>Description:</strong> {{ $participation->training->description ?? 'N/A' }}</li>
                            <li><strong>Date de Début:</strong> {{ dateFr($participation->training->beging_date) }}
                            </li>
                            <li><strong>Date de Fin:</strong> {{ dateFr($participation->training->end_date) }}</li>
                            <li><strong>Observation:</strong> {{ $participation->training->observation ?? 'N/A' }}</li>
                            <li>
                                <span class="{{ $participation->participation ? 'text-success' : 'text-danger' }}">
                                    Adhérent {{ $participation->participation ? 'présent' : 'absent' }} à la formation
                                </span>
                            </li>
                        </ul>
                        <hr>
                    @endforeach
                </div>
            @endif
        @endif


        @if ($user->candidate->orientation === 'entreprise-privee')
            <h3 class="orientation-title">Orientation : Entreprise Privée</h3>

            @if (count($user->candidate->candidatentretiens) > 0)

                <h3 class="section-title">Entretiens</h3>
                <div class="section-content">
                    @foreach ($user->candidate->candidatentretiens as $key => $candidatentretien)
                        <ul class="info-list">
                            <li><strong>Entretien :</strong> {{ $candidatentretien->entretien->type ?? 'N/A' }}</li>
                            <li><strong>Date de tenu :</strong>
                                {{ $candidatentretien->entretien->date ? dateFr($candidatentretien->entretien->date, 'letter') : 'N/A' }}
                            </li>
                            <li><strong>Présence :</strong> <span
                                    style="color: {{ $candidatentretien->presence == '1' ? 'green' : 'red' }};">{{ $candidatentretien->presence == '1' ? 'OUI' : 'NON' }}</span>
                            </li>
                            <li><strong>Commentaire :</strong> {{ $candidatentretien->comment ?? 'N/A' }}</li>
                        </ul>
                        <hr>
                    @endforeach
                </div>
            @endif

            @if (count($user->candidate->bilancompetences) > 0)

                <h3 class="section-title">Bilans de Compétences</h3>
                <div class="section-content">
                    @foreach ($user->candidate->bilancompetences as $key => $bilancompetence)
                        <ul class="info-list">
                            <li><strong>Bilan du :</strong>
                                {{ $bilancompetence->date ? dateFr($bilancompetence->date, 'letter') : 'N/A' }}</li>
                            <li><strong>Présence :</strong> <span
                                    style="color: {{ $bilancompetence->presence == '1' ? 'green' : 'red' }};">{{ $bilancompetence->presence == '1' ? 'OUI' : 'NON' }}</span>
                            </li>
                            <li><strong>Rapport :</strong>
                                @if ($bilancompetence->rapport)
                                    <a href="{{ asset($bilancompetence->rapport) }}" download><i
                                            class="download-icon"></i> Télécharger</a>
                                @else
                                    N/A
                                @endif
                            </li>
                            <li><strong>Commentaire :</strong> {{ $bilancompetence->comment ?? 'N/A' }}</li>
                        </ul>
                        <hr>
                    @endforeach
                </div>
            @endif

            @if (count($user->candidate->formations) > 0)

                <h3 class="section-title">Formations</h3>
                <div class="section-content">
                    @foreach ($user->candidate->formations as $key => $formation)
                        <ul class="info-list">
                            <li><strong>Intitulé :</strong> {{ $formation->intitule ?? 'N/A' }}</li>
                            <li><strong>Entreprise :</strong> {{ $formation->entreprise ?? 'N/A' }}</li>
                            <li><strong>Date de début :</strong>
                                {{ $formation->date_db ? dateFr($formation->date_db, 'letter') : 'N/A' }}</li>
                            <li><strong>Date de fin :</strong>
                                {{ $formation->date_fin ? dateFr($formation->date_fin, 'letter') : 'N/A' }}</li>
                            <li><strong>Lieu :</strong> {{ $formation->lieu ?? 'N/A' }}</li>
                            <li><strong>Présence :</strong> <span
                                    style="color: {{ $formation->pivot->presence == '1' ? 'green' : 'red' }};">{{ $formation->pivot->presence == '1' ? 'OUI' : 'NON' }}</span>
                            </li>
                            <li><strong>Attestation :</strong>
                                @if ($formation->pivot->rapport)
                                    <a href="{{ asset($formation->pivot->rapport) }}" download><i
                                            class="download-icon"></i> Télécharger</a>
                                @else
                                    N/A
                                @endif
                            </li>
                            <li><strong>Commentaire :</strong> {{ $formation->pivot->commentaire ?? 'N/A' }}</li>
                        </ul>
                        <hr>
                    @endforeach
                </div>
            @endif

            @if (count($user->candidate->candidatentreprises) > 0)

                <h3 class="section-title">Candidatures Envoyées</h3>
                <div class="section-content">
                    @foreach ($user->candidate->candidatentreprises as $key => $candidatentreprise)
                        <ul class="info-list">
                            <li><strong>Entreprise :</strong> {{ $candidatentreprise->entreprise ?? 'N/A' }}</li>
                            <li><strong>Poste :</strong> {{ $candidatentreprise->poste ?? 'N/A' }}</li>
                            <li><strong>Date :</strong>
                                {{ $candidatentreprise->date_mise_disposition ? dateFr($candidatentreprise->date_mise_disposition, 'letter') : 'N/A' }}
                            </li>
                            <li><strong>Status :</strong> <span
                                    style="color: {{ $candidatentreprise->statut === 'accepted' ? 'green' : ($candidatentreprise->statut === 'refused' ? 'red' : 'aqua') }};">{{ ucfirst($candidatentreprise->statut ?? 'N/A') }}</span>
                            </li>
                            <li><strong>Type de Contrat :</strong> {{ $candidatentreprise->type_contrat ?? 'N/A' }}
                            </li>
                            <li><strong>Date de Début :</strong>
                                {{ $candidatentreprise->date_db ? dateFr($candidatentreprise->date_db, 'letter') : 'N/A' }}
                            </li>
                            <li><strong>Date de Fin :</strong>
                                {{ $candidatentreprise->date_fin ? dateFr($candidatentreprise->date_fin, 'letter') : 'N/A' }}
                            </li>
                            <li><strong>Lieu :</strong> {{ $candidatentreprise->localisation ?? 'N/A' }}</li>
                            <li><strong>Attestation de Travail :</strong>
                                @if ($candidatentreprise->contrat)
                                    <a href="{{ asset($candidatentreprise->contrat) }}" download><i
                                            class="download-icon"></i> Télécharger</a>
                                @else
                                    N/A
                                @endif
                            </li>
                            <li><strong>Commentaire :</strong> {{ $candidatentreprise->commentaire ?? 'N/A' }}</li>
                        </ul>
                        <hr>
                    @endforeach
                </div>
            @endif
        @endif


        @if ($user->candidate->orientation === 'fonction-publique')
            <h3 class="orientation-title">Orientation : Fonction Publique</h3>

            @if (count($user->candidate->candidatentretiens) > 0)

                <h3 class="section-title">Entretiens</h3>
                <div class="section-content">
                    @foreach ($user->candidate->candidatentretiens as $key => $candidatentretien)
                        <ul class="info-list">
                            <li><strong>Entretien :</strong> {{ $candidatentretien->entretien->type ?? 'N/A' }}</li>
                            <li><strong>Date de tenu :</strong>
                                {{ $candidatentretien->entretien->date ? dateFr($candidatentretien->entretien->date, 'letter') : 'N/A' }}
                            </li>
                            <li><strong>Présence :</strong> <span
                                    style="color: {{ $candidatentretien->presence == '1' ? 'green' : 'red' }};">{{ $candidatentretien->presence == '1' ? 'OUI' : 'NON' }}</span>
                            </li>
                        </ul>
                        <hr>
                    @endforeach
                </div>
            @endif

            @if (count($user->candidate->bilancompetences) > 0)

                <h3 class="section-title">Bilans de Compétences</h3>
                <div class="section-content">
                    @foreach ($user->candidate->bilancompetences as $key => $bilancompetence)
                        <ul class="info-list">
                            <li><strong>Bilan du :</strong>
                                {{ $bilancompetence->date ? dateFr($bilancompetence->date, 'letter') : 'N/A' }}</li>
                            <li><strong>Présence :</strong> <span
                                    style="color: {{ $bilancompetence->presence == '1' ? 'green' : 'red' }};">{{ $bilancompetence->presence == '1' ? 'OUI' : 'NON' }}</span>
                            </li>
                            <li><strong>Rapport :</strong>
                                @if ($bilancompetence->rapport)
                                    <a href="{{ asset($bilancompetence->rapport) }}" download><i
                                            class="download-icon"></i> Télécharger</a>
                                @else
                                    N/A
                                @endif
                            </li>
                        </ul>
                        <hr>
                    @endforeach
                </div>
            @endif

            @if (count($user->candidate->soumissiondossiers) > 0)

                <h3 class="section-title">Dépôt de Dossiers</h3>
                <div class="section-content">
                    @foreach ($user->candidate->soumissiondossiers as $key => $soumissiondossier)
                        <h4 class="section-subtitle">Dépôt de Dossiers {{ $key + 1 }}</h4>
                        <ul class="info-list">
                            <li><strong>Date de dépôt (Premier Choix) :</strong>
                                {{ $soumissiondossier->date1 ? dateFr($soumissiondossier->date1, 'letter') : 'N/A' }}
                            </li>
                            <li><strong>Type de Concours (Premier Choix) :</strong>
                                {{ $soumissiondossier->type_concours1 ?? 'N/A' }}</li>
                            <li><strong>Intitulé du Concours (Premier Choix) :</strong>
                                {{ $soumissiondossier->intitule_concours1 ?? 'N/A' }}</li>
                            <li><strong>Date de dépôt (Deuxième Choix) :</strong>
                                {{ $soumissiondossier->date2 ? dateFr($soumissiondossier->date2, 'letter') : 'N/A' }}
                            </li>
                            <li><strong>Type de Concours (Deuxième Choix) :</strong>
                                {{ $soumissiondossier->type_concours2 ?? 'N/A' }}</li>
                            <li><strong>Intitulé du Concours (Deuxième Choix) :</strong>
                                {{ $soumissiondossier->intitule_concours2 ?? 'N/A' }}</li>
                        </ul>
                        <hr>
                    @endforeach
                </div>
            @endif

            @if ($user->candidate->choixconcour)
                <h3 class="section-title">Choix Final</h3>
                <ul class="info-list">
                    <li><strong>Type de Concours :</strong>
                        {{ $user->candidate->choixconcour->type_concours ?? 'N/A' }}</li>
                    <li><strong>Intitulé du Concours :</strong>
                        {{ $user->candidate->choixconcour->intitule_concours ?? 'N/A' }}</li>
                </ul>
                <hr>
            @endif

            @if (count($user->candidate->concours) > 0)

                <h3 class="section-title">Inscriptions</h3>
                <div class="section-content">
                    @foreach ($user->candidate->concours as $key => $concour)
                        <ul class="info-list">
                            <li><strong>Inscription N°{{ $key + 1 }}</strong></li>
                            <li><strong>Date :</strong>
                                {{ $concour->date ? dateFr($concour->date, 'letter') : 'N/A' }}</li>
                            <li><strong>Type de Concours :</strong> {{ $concour->type_concours ?? 'N/A' }}</li>
                            <li><strong>Intitulé du Concours :</strong> {{ $concour->intitule_concours ?? 'N/A' }}
                            </li>
                            <li><strong>Reçu :</strong>
                                @if ($concour->recu)
                                    <a href="{{ asset($concour->recu) }}" download><i class="download-icon"></i>
                                        Télécharger</a>
                                @else
                                    N/A
                                @endif
                            </li>
                            <li><strong>Status :</strong> <span
                                    style="color: {{ $concour->status == '1' ? 'green' : 'red' }};">{{ $concour->status == '1' ? 'Accepté' : 'Refusé' }}</span>
                            </li>
                        </ul>
                        <hr>
                    @endforeach
                </div>
            @endif
        @endif


        <h3 class="section-title">Auteur</h3>
        <ul class="info-list">
            <li><strong>Date d&apos;inscription au BARM :</strong> {{ dateFr($user->candidate->date_inscription) }}
            </li>
            <li><strong>Date d&apos;édition :</strong> {{ dateFr($user->candidate->created_at, 'complet') }} par
                <strong>{{ $user->candidate->createdBy->fullName() }}</strong></li>
                @if ($user->candidate->completed_at)
                    <li><strong>Date d&apos;approbation :</strong> {{ dateFr($user->candidate->completed_at, 'complet') }} par
                <strong>{{ $user->candidate->completedBy->fullName() }}</strong></li>
                @endif
            
        </ul>
        <hr>





        <div class="footer">
            Document généré automatiquement le {{ date('d-m-Y') }}
        </div>

    </div>
</body>

</html>
