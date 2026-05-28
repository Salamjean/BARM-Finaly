<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Utilisateur</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.6; color: #333; }
        .container { padding: 20px; max-width: 800px; margin: auto; }
        .section-title { font-size: 1.2em; font-weight: bold; color: #555; border-bottom: 1px solid #ddd; margin-bottom: 10px; }
        .badge { padding: 3px 6px; background-color: #444; color: #fff; font-size: 0.85em; border-radius: 4px; }
        .info-list { list-style: none; padding: 0; margin: 0; }
        .info-list li { margin-bottom: 8px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th, .table td { padding: 8px; border: 1px solid #ddd; text-align: left; font-size: 0.9em; }
        .table th { background-color: #f5f5f5; font-weight: bold; }
        .btn { padding: 5px 10px; color: #fff; border-radius: 5px; background-color: #007bff; text-decoration: none; }
        .list-group-item { padding: 8px; border: 1px solid #ddd; }
    </style>
</head>
<body>

<div class="container">

    <!-- Informations Personnelles Section -->
    <h3 class="section-title">Informations Personnelles</h3>
    <ul class="info-list">
        <li><strong>Nom & Prénoms:</strong> {{ $user->username }}</li>
        <li><strong>Mecano:</strong> {{ $user->mecano }}</li>
        @if ($user->matricule)
            <li><strong>Matricule:</strong> {{ $user->matricule ?? 'N/A' }}</li>
        @endif
        <li><strong>Date de naissance:</strong> {{ dateFr($user->candidate->birth_date ?? '') }}</li>
        <li><strong>Genre:</strong> {{ $user->candidate->gender ?? 'N/A' }}</li>
        <li><strong>Situation matrimoniale:</strong> {{ $user->candidate->situation_matrimoniale ?? 'N/A' }}</li>
        <li><strong>Numéro de téléphone:</strong> {{ $user->candidate->phone_number ?? 'N/A' }}</li>
        <li><strong>Résidence:</strong> {{ $user->candidate->residence ?? 'N/A' }}</li>
        
    </ul>

    <!-- Informations Familiales Section -->
    @if ($user->candidate->partner_fullname)
        <h3 class="section-title">Informations Familiales</h3>
        <ul class="info-list">
            <li><strong>Nom & Prénoms du conjoint(e):</strong> {{ $user->candidate->partner_fullname ?? 'N/A' }}</li>
            <li><strong>Profession du conjoint(e):</strong> {{ $user->candidate->partner_job ?? 'N/A' }}</li>
            <li><strong>Contact du conjoint(e):</strong> {{ $user->candidate->partner_phone_number ?? 'N/A' }}</li>
            <li><strong>Contact:</strong> {{ $user->candidate->sos_person_phone_number ?? 'N/A' }}</li>
        </ul>    
    @endif
    

    <!-- Enfants Section -->
    @if (count($user->candidate->childs) > 0)
        <h3 class="section-title">Enfants</h3>
        @foreach ($user->candidate->childs as $key => $child)
            <ul class="info-list">
                <li><strong>Nom & Prénoms:</strong> {{ $child->fullname }}</li>
                <li><strong>Date de naissance:</strong> {{ dateFr($child->birth_date) }}</li>
                <li><strong>Niveau d'étude:</strong> {{ $child->level }}</li>
            </ul>
        @endforeach
    @endif

    <!-- Situation Professionnelle Section -->
    <h3 class="section-title">Situation Professionnelle</h3>
    <ul class="info-list">
        <li><strong>Type de militaire:</strong> {{ $user->candidate->armee ?? 'N/A' }}</li>
        <li><strong>Unité de rattachement:</strong> {{ $user->candidate->unite_rattachement ?? 'N/A' }}</li>
        <li><strong>Grade:</strong> {{ $user->candidate->grade ?? 'N/A' }}</li>
        <li><strong>Statut professionnel:</strong> {{ $user->candidate->statut_prof ?? 'N/A' }}</li>
    </ul>

    <!-- Diplômes Section -->
    @if (count($user->candidate->diplomes) > 0)
        <h3 class="section-title">Diplômes</h3>
        @foreach ($user->candidate->diplomes as $diplome)
            <ul class="info-list">
                <li><strong>{{ $diplome->type == 'civil' ? 'Diplôme Civil' : 'Diplôme Militaire' }}:</strong> {{ $diplome->diplome }} ({{ $diplome->annees }} ans)</li>
            </ul>
        @endforeach
    @endif

    <!-- Projet Professionnel Section -->
    <h3 class="section-title">Projet Professionnel</h3>
    <!-- Choix 1 -->
    <ul class="info-list">
        @if ($user->candidate->domaine_1c)
            <li><strong>Choix 1 {{ $user->candidate->choiceFinal->choice_number == 'one' ? '(choix final)' : '' }} - Domaine:</strong> {{ $user->candidate->domaine_1c }}</li>
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

    <!-- Choix 2 -->
    <ul class="info-list">
        @if ($user->candidate->domaine_2c)
            <li><strong>Choix 2 {{ $user->candidate->choiceFinal->choice_number == 'two' ? '(choix final)' : '' }} - Domaine:</strong> {{ $user->candidate->domaine_2c }}</li>
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


    @if ($user->candidate->orientation === 'auto-emploi')

        @if (count($user->candidate->pas) > 0)
            <!-- Plan d'Affaires Section -->
            <h3 class="section-title">Plans d'Affaires</h3>
            @foreach ($user->candidate->pas as $key => $pa)
                <ul class="info-list">
                    <li><strong>Plan d'Affaires {{ $key + 1 }}:</strong> {{ $pa->title }}</li>
                    <li><strong>Coût du projet:</strong> {{ amount($pa->amount) }} FCFA</li>
                    <li><strong>Crédit sollicité:</strong> {{ amount($pa->credit) }} FCFA</li>
                    @if ($pa->amount_awarded != 0)
                        <li><strong>Crédit accordé:</strong> {{ amount($pa->amount_awarded) }} FCFA</li>
                    @endif
                    @if ($pa->commission)
                        <li><strong>Commission N°:</strong> {{ $pa->commission->number }}</li>
                        <li><strong>Date et lieu de la commission :</strong> {{ dateFr($pa->commission->date) }} - {{ $pa->commission->lieu }}</li>
                    @endif
                    <li><strong>Date de transmission:</strong> {{ dateFr($pa->created_at) }}</li>
                    <li><strong>Statut:</strong> {{ statusCandidature($pa->status) }}</li>
                    
                </ul>
            @endforeach
        @endif
        
        @if($user->candidate->dataCollect)
            <!-- Collecte de Données Section -->
            <h3 class="section-title">Collecte de Données</h3>
            <ul class="info-list">
                <li><strong>Date de Début:</strong> {{ dateFr($user->candidate->dataCollect->beging_date ?? '') }}</li>
                <li><strong>Date de Fin:</strong> {{ dateFr($user->candidate->dataCollect->end_date ?? '') }}</li>
            </ul>
        @endif

        @if(count($user->candidate->participations) > 0)
            <!-- Formations Section -->
            <h3 class="section-title">Formations</h3>
            @foreach ($user->candidate->participations as $key => $participation)
                <ul class="info-list">
                    <li><strong>Formation {{ $key + 1 }}</strong></li>
                    <li><strong>Titre:</strong> {{ $participation->training->title }}</li>
                    <li><strong>Description:</strong> {{ $participation->training->description ?? 'N/A' }}</li>
                    <li><strong>Date de Début:</strong> {{ dateFr($participation->training->beging_date) }}</li>
                    <li><strong>Date de Fin:</strong> {{ dateFr($participation->training->end_date) }}</li>
                    <li><strong>Observation:</strong> {{ $participation->training->observation ?? 'N/A' }}</li>
                    <li>
                        <span class="{{ $participation->participation ? 'text-success' : 'text-danger' }}">
                            Adhérent {{ $participation->participation ? 'présent' : 'absent' }} à la formation
                        </span>
                    </li>
                </ul>
            @endforeach
        @endif

    @endif

    @if ($user->candidate->orientation === 'entreprise-privee')
        @if(count($user->candidate->candidatentretiens) > 0)
            <!-- Entretiens Section -->
            <h3 class="section-title">Entretiens</h3>
            @foreach ($user->candidate->candidatentretiens as $key => $candidatentretien)
                <ul class="info-list">
                    <li><strong>Entretien {{ $candidatentretien->entretien->type }}:</strong></li>
                    <li><strong>Date de tenu :</strong> {{ dateFr($candidatentretien->entretien->date, 'letter') }}</li>
                    <li><strong>Présence :</strong> <span style="color: {{ $candidatentretien->presence == '1' ? 'green' : 'red' }};">{{ $candidatentretien->presence == '1' ? 'OUI' : 'NON' }}</span></li>
                    <li><strong>Commentaire :</strong> {{ $candidatentretien->comment }}</li>
                </ul>
                <hr>
        @endforeach
        @endif

        @if(count($user->candidate->bilancompetences) > 0)
            <!-- Bilans de Compétences Section -->
            <h3 class="section-title">Bilans de Compétences</h3>
            @foreach ($user->candidate->bilancompetences as $key => $bilancompetence)
                <ul class="info-list">
                    <li><strong>Bilan du :</strong> {{ dateFr($bilancompetence->date, 'letter') }}</li>
                    <li><strong>Présence :</strong> <span style="color: {{ $bilancompetence->presence == '1' ? 'green' : 'red' }};">{{ $bilancompetence->presence == '1' ? 'OUI' : 'NON' }}</span></li>
                    <li><strong>Rapport :</strong> <a href="{{ asset($bilancompetence->rapport) }}" download><i class="download-icon"></i> Télécharger</a></li>
                    <li><strong>Commentaire :</strong> {{ $bilancompetence->comment }}</li>
                </ul>
                <hr>
            @endforeach
        @endif
        @if(count($user->candidate->formations) > 0)
            <!-- Formations Section -->
            <h3 class="section-title">Formations</h3>
            @foreach ($user->candidate->formations as $key => $formation)
                <ul class="info-list">
                    <li><strong>Intitulé :</strong> {{ $formation->intitule }}</li>
                    <li><strong>Entreprise :</strong> {{ $formation->entreprise }}</li>
                    <li><strong>Date de début :</strong> {{ dateFr($formation->date_db, 'letter') }}</li>
                    <li><strong>Date de fin :</strong> {{ dateFr($formation->date_fin, 'letter') }}</li>
                    <li><strong>Lieu :</strong> {{ $formation->lieu }}</li>
                    <li><strong>Présence :</strong> <span style="color: {{ $formation->pivot->presence == '1' ? 'green' : 'red' }};">{{ $formation->pivot->presence == '1' ? 'OUI' : 'NON' }}</span></li>
                    <li><strong>Attestation :</strong> <a href="{{ asset($formation->pivot->rapport) }}" download><i class="download-icon"></i> Télécharger</a></li>
                    <li><strong>Commentaire :</strong> {{ $formation->pivot->commentaire }}</li>
                </ul>
                <hr>
            @endforeach
        @endif

        @if(count($user->candidate->candidatentreprises) > 0)

            <!-- Candidatures Section -->
            <h3 class="section-title">Candidatures Envoyées</h3>
            @foreach ($user->candidate->candidatentreprises as $key => $candidatentreprise)
                <ul class="info-list">
                    <li><strong>Entreprise :</strong> {{ $candidatentreprise->entreprise }}</li>
                    <li><strong>Poste :</strong> {{ $candidatentreprise->poste }}</li>
                    <li><strong>Date :</strong> {{ dateFr($candidatentreprise->date_mise_disposition, 'letter') }}</li>
                    <li><strong>Status :</strong> <span style="color: {{ $candidatentreprise->statut === 'accepted' ? 'green' : ($candidatentreprise->statut === 'refused' ? 'red' : 'aqua') }};">
                        {{ ucfirst($candidatentreprise->statut) }}
                    </span></li>
                    <li><strong>Type de Contrat :</strong> {{ $candidatentreprise->type_contrat ?? 'N/A' }}</li>
                    <li><strong>Date de Début :</strong> {{ dateFr($candidatentreprise->date_db, 'letter') }}</li>
                    <li><strong>Date de Fin :</strong> {{ dateFr($candidatentreprise->date_fin, 'letter') }}</li>
                    <li><strong>Lieu :</strong> {{ $candidatentreprise->localisation ?? 'N/A' }}</li>
                    <li><strong>Attestation de Travail :</strong> <a href="{{ asset($candidatentreprise->contrat) }}" download><i class="download-icon"></i> Télécharger</a></li>
                    <li><strong>Commentaire :</strong> {{ $candidatentreprise->commentaire }}</li>
                </ul>
                <hr>
            @endforeach

            @endif
    @endif


    @if ($user->candidate->orientation === 'fonction-publique')

        <!-- Entretiens Section -->
        @if (count($user->candidate->candidatentretiens) > 0)
            <h3 class="section-title">Entretiens</h3>
            @foreach ($user->candidate->candidatentretiens as $key => $candidatentretien)
                <ul class="info-list">
                    <li><strong>Entretien :</strong> {{ $candidatentretien->entretien->type ?? 'N/A' }}</li>
                    <li><strong>Date de tenu :</strong> {{ $candidatentretien->entretien->date ? dateFr($candidatentretien->entretien->date, 'letter') : 'N/A' }}</li>
                    <li><strong>Présence :</strong> <span style="color: {{ $candidatentretien->presence == '1' ? 'green' : 'red' }};">{{ $candidatentretien->presence == '1' ? 'OUI' : 'NON' }}</span></li>
                </ul>
                <hr>
            @endforeach
        @endif

        <!-- Bilans de Compétences Section -->
        @if (count($user->candidate->bilancompetences) > 0)
            <h3 class="section-title">Bilans de Compétences</h3>
            @foreach ($user->candidate->bilancompetences as $key => $bilancompetence)
                <ul class="info-list">
                    <li><strong>Bilan du :</strong> {{ $bilancompetence->date ? dateFr($bilancompetence->date, 'letter') : 'N/A' }}</li>
                    <li><strong>Présence :</strong> <span style="color: {{ $bilancompetence->presence == '1' ? 'green' : 'red' }};">{{ $bilancompetence->presence == '1' ? 'OUI' : 'NON' }}</span></li>
                    <li><strong>Rapport :</strong> @if ($bilancompetence->rapport) <a href="{{ asset($bilancompetence->rapport) }}" download><i class="download-icon"></i> Télécharger</a> @else N/A @endif</li>
                </ul>
                <hr>
            @endforeach
        @endif

        <!-- Dépôt de Dossiers Section -->
        @if (count($user->candidate->soumissiondossiers) > 0)
            <h3 class="section-title">Dépôt de Dossiers</h3>
            @foreach ($user->candidate->soumissiondossiers as $key => $soumissiondossier)
                <h4 class="section-title">Dépôt de Dossiers {{ $key + 1 }}</h4>
                <ul class="info-list">
                    <li><strong>Date de dépôt (Premier Choix) :</strong> {{ $soumissiondossier->date1 ? dateFr($soumissiondossier->date1, 'letter') : 'N/A' }}</li>
                    <li><strong>Type de Concours (Premier Choix) :</strong> {{ $soumissiondossier->type_concours1 ?? 'N/A' }}</li>
                    <li><strong>Intitulé du Concours (Premier Choix) :</strong> {{ $soumissiondossier->intitule_concours1 ?? 'N/A' }}</li>
                    <li><strong>Date de dépôt (Deuxième Choix) :</strong> {{ $soumissiondossier->date2 ? dateFr($soumissiondossier->date2, 'letter') : 'N/A' }}</li>
                    <li><strong>Type de Concours (Deuxième Choix) :</strong> {{ $soumissiondossier->type_concours2 ?? 'N/A' }}</li>
                    <li><strong>Intitulé du Concours (Deuxième Choix) :</strong> {{ $soumissiondossier->intitule_concours2 ?? 'N/A' }}</li>
                </ul>
                <hr>
            @endforeach
        @endif

        <!-- Choix Final Section -->
        @if ($user->candidate->choixconcour)
            <h3 class="section-title">Choix Final</h3>
            <ul class="info-list">
                <li><strong>Type de Concours :</strong> {{ $user->candidate->choixconcour->type_concours ?? 'N/A' }}</li>
                <li><strong>Intitulé du Concours :</strong> {{ $user->candidate->choixconcour->intitule_concours ?? 'N/A' }}</li>
            </ul>
            <hr>
        @endif

        <!-- Inscriptions Section -->
        @if (count($user->candidate->concours) > 0)
            <h3 class="section-title">Inscriptions</h3>
            @foreach ($user->candidate->concours as $key => $concour)
                <ul class="info-list">
                    <li><strong>Inscription N°{{ $key + 1 }}</strong></li>
                    <li><strong>Date :</strong> {{ $concour->date ? dateFr($concour->date, 'letter') : 'N/A' }}</li>
                    <li><strong>Type de Concours :</strong> {{ $concour->type_concours ?? 'N/A' }}</li>
                    <li><strong>Intitulé du Concours :</strong> {{ $concour->intitule_concours ?? 'N/A' }}</li>
                    <li><strong>Reçu :</strong> @if ($concour->recu) <a href="{{ asset($concour->recu) }}" download><i class="download-icon"></i> Télécharger</a> @else N/A @endif</li>
                    <li><strong>Status :</strong> <span style="color: {{ $concour->status == '1' ? 'green' : 'red' }};">{{ $concour->status == '1' ? 'Accepté' : 'Refusé' }}</span></li>
                </ul>
                <hr>
            @endforeach
        @endif

    @endif



    <!-- Footer -->
    <div class="info-list">
        <p class="text-center" style="font-size: 0.8em; color: #777;">Document généré automatiquement le {{ date('d-m-Y') }}</p>
    </div>


</div>
</body>
</html>
