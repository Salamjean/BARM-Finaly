<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="user-detail">
    

    {{-- Informations personnelles --}}
    <h5 style="text-transform: uppercase; text-align:center; color:#FF7602; text-decoration:underline; font-size: 1.3em; margin-bottom: 10px;">Fiche candidat</h5>
    <h5 style="text-transform: uppercase; font-size: 1.2em; margin-bottom: 10px;">Informations personnelles</h5>
    <div style="padding: 15px; margin-bottom: 15px; text-align: center;">
        @if ($user->candidate->image)
            <img src="{{ asset($user->candidate->image) }}" alt="User avatar"
                style="position:fixed; right:10%; top:10%; border-radius: 50%; height: 130px; width: 130px; margin-bottom: 15px;" />
        @endif
        <div style="display: flex; flex-direction: column; align-items: center;">
            <div style="display: flex; flex-wrap: wrap; justify-content: center; max-width: 600px;">
                <div style="margin-right: 20px; text-align: left;">
                    <p><strong>Nom & Prénoms:</strong> {{ $user->fullName() }}</p>
                    <p><strong>Mecano:</strong> {{ $user->mecano }}</p>
                    {{-- <p><strong>Matricule:</strong> {{ $user->matricule }}</p> --}}
                    @if ($user->candidate->birth_date)
                        <p><strong>Date de naissance:</strong> {{ dateFr($user->candidate->birth_date) }}</p>
                    @endif
                </div>
                <div style="text-align: left;">
                    @if ($user->email)
                        <p><strong>E-mail:</strong> {{ $user->email }}</p>
                    @endif
                    @if ($user->candidate->orientation)
                        <p><strong>Orientation:</strong>
                            {{ statusCandidature($user->candidate->orientation, 'orientation') }}</p>
                    @endif
                    @if ($user->candidate->cohort)
                        <p><strong>N° Cohorte:</strong> {{ $user->candidate->cohort->reference }}</p>
                    @endif
                    @if ($user->candidate->gender)
                        <p><strong>Genre:</strong> {{ $user->candidate->gender }}</p>
                    @endif
                </div>
            </div>
            <div style="display: flex; flex-wrap: wrap; justify-content: center; margin-top: 10px; max-width: 600px;">
                <div style="margin-right: 20px; text-align: left;">
                    @if ($user->candidate->religion)
                        <p><strong>Religion:</strong> {{ $user->candidate->religion }}</p>
                    @endif
                    @if ($user->candidate->ethnic)
                        <p><strong>Ethnie:</strong> {{ $user->candidate->ethnic }}</p>
                    @endif
                    @if ($user->candidate->situation_matrimoniale)
                        <p><strong>Situation matrimoniale:</strong> {{ $user->candidate->situation_matrimoniale }}</p>
                    @endif
                </div>
                <div style="text-align: left;">
                    @if ($user->candidate->phone_number)
                        <p><strong>Numéro de téléphone:</strong> {{ $user->candidate->phone_number }}
                            @if ($user->candidate->phone_number2)
                                , {{ $user->candidate->phone_number2 }}
                            @endif
                            @if ($user->candidate->phone_number3)
                                , {{ $user->candidate->phone_number3 }}
                            @endif
                        </p>
                    @endif
                    @if ($user->candidate->residence)
                        <p><strong>Résidence:</strong> {{ $user->candidate->residence }}</p>
                    @endif
                </div>
            </div>
            @if (count($user->candidate->childs) > 0)
                <p><strong>Nombre d'enfant:</strong> {{ count($user->candidate->childs) }}</p>
            @endif
            @if ($user->candidate->other_partner_financial)
                <p><strong>Source de financement:</strong> {{ $user->candidate->other_partner_financial }}</p>
            @endif
        </div>
    </div>

    {{-- Death Information --}}
    @if ($user->candidate->death == 1)
        <div style="background-color: #dc3545; padding: 15px; color: white; margin-bottom: 15px;">
            <h5 style="text-transform: uppercase; font-size: 1.2em; margin-bottom: 10px;">Adhérent décédé</h5>
            <p style="margin: 0;"><strong>Date de décès:</strong> {{ $user->candidate->death_date }}</p>
            <p style="margin: 0;"><strong>Numéro de l'acte:</strong> {{ $user->candidate->death_no_act }}</p>
            <p style="margin: 0;"><strong>Lieu de décès:</strong> {{ $user->candidate->death_city }}</p>
        </div>
    @endif

    {{-- Final Choice Information --}}
    @if ($user->candidate->choiceFinal)
        <div style="padding: 15px; margin-bottom: 15px;">
            <div style="color: #dc3545; font-size: 1.2em; font-weight: bold;">CHOIX FINAL</div>
            @foreach (['domaine', 'specialisation', 'region_retraite', 'department', 'locality', 'adress_geo', 'formation', 'autres_form'] as $field)
                @if ($user->candidate->choiceFinal->$field)
                    <p><strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong>
                        {{ $user->candidate->choiceFinal->$field }}</p>
                @endif
            @endforeach
            @if ($user->candidate->choiceFinal->partner_id)
                <p><strong>Partenaire technique:</strong> {{ $user->candidate->choiceFinal->partner->user->username }}
                </p>
            @endif
        </div>
    @endif


    {{-- Emergency Contact --}}
    @if ($user->candidate->sos_person_phone_number)
        <h5 style="text-transform: uppercase; font-size: 1.2em; margin-bottom: 10px;">Personne à contacter en cas
            d'urgence</h5>
        <div style="padding: 15px; margin-bottom: 15px;">
            <p><strong>Nom complet:</strong> {{ $user->candidate->sos_person_fullname }}</p>
            <p><strong>Contact:</strong> {{ $user->candidate->sos_person_phone_number }}</p>
            @if ($user->candidate->sos_person_phone_number2)
                <p><strong>Contact 2:</strong> {{ $user->candidate->sos_person_phone_number2 }}</p>
            @endif
        </div>
    @endif


    <h5
        style="font-size: 1.2em; text-transform: uppercase; margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
        Informations sur la candidature
    </h5>

    @if ($user->candidate->type_piece)
        <div style="margin-bottom: 15px; border: 1px solid #ccc; padding: 10px;">
            <h5
                style="font-size: 1.1em; text-transform: uppercase; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px;">
                IDENTITÉ
            </h5>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                @if ($user->candidate->type_piece)
                    <div style="width: 48%;">
                        <label style="font-weight: bold;">Type de pièce:</label>
                        <div>{{ $user->candidate->type_piece }}</div>
                    </div>
                @endif
                @if ($user->candidate->no_card)
                    <div style="width: 48%;">
                        <label style="font-weight: bold;">N° de Pièce:</label>
                        <div>{{ $user->candidate->no_card }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if ($user->candidate->partner_fullname)
        <div style="margin-bottom: 15px; border: 1px solid #ccc; padding: 10px;">
            <h5
                style="font-size: 1.1em; text-transform: uppercase; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px;">
                CONJOINT(E)
            </h5>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                @if ($user->candidate->partner_fullname)
                    <div style="width: 48%;">
                        <label style="font-weight: bold;">Nom & Prénoms du conjoint(e):</label>
                        <div>{{ $user->candidate->partner_fullname }}</div>
                    </div>
                @endif
                @if ($user->candidate->partner_job)
                    <div style="width: 48%;">
                        <label style="font-weight: bold;">Profession du conjoint(e):</label>
                        <div>{{ $user->candidate->partner_job }}</div>
                    </div>
                @endif
                @if ($user->candidate->partner_phone_number)
                    <div style="width: 48%;">
                        <label style="font-weight: bold;">Contact du conjoint(e):</label>
                        <div>{{ $user->candidate->partner_phone_number }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endif
    @if (count($user->candidate->childs) > 0)
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <h5 style="text-transform: uppercase; margin-bottom: 10px; border-bottom: 1px solid #ccc;">ENFANTS</h5>
            @foreach ($user->candidate->childs as $key => $child)
                <div style="padding: 5px 0; border-bottom: 1px solid #eee;">
                    @if ($child->fullname)
                        <div style="color: #ffcc00; font-weight: bold;">Enfant {{ $key + 1 }}</div>
                        <div style="margin-top: 5px;">
                            <strong>Nom & Prénoms:</strong> {{ $child->fullname }}
                        </div>
                    @endif
                    @if ($child->birth_date)
                        <div><strong>Date de naissance:</strong> {{ $child->birth_date }}</div>
                    @endif
                    @if ($child->level)
                        <div><strong>Niveau d'étude:</strong> {{ $child->level }}</div>
                    @endif
                    @if ($child->file)
                        <div>
                            <strong>Document J.:</strong>
                            <a href="{{ asset($child->file) }}" download>Télécharger</a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if ($user->candidate->armee)
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <h5
                style="font-size: 1.1em; text-transform: uppercase; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px;">
                SITUATION PROFESSIONNELLE
            </h5>

            @if ($user->candidate->armee)
                <div><strong>Type de militaire:</strong> {{ $user->candidate->armee }}</div>
            @endif
            @if ($user->candidate->unite_rattachement)
                <div><strong>Unité de rattachement:</strong> {{ $user->candidate->unite_rattachement }}</div>
            @endif
            @if ($user->candidate->statut_prof)
                <div><strong>Statut professionnel:</strong> {{ $user->candidate->statut_prof }}</div>
            @endif
            @if ($user->candidate->grade)
                <div><strong>Grade:</strong> {{ $user->candidate->grade }}</div>
            @endif
            @if ($user->candidate->date_entree)
                <div><strong>Date d'entrée:</strong> {{ dateFr($user->candidate->date_entree) }}</div>
            @endif
            @if ($user->candidate->date_radiation)
                <div><strong>Date de radiation:</strong> {{ dateFr($user->candidate->date_radiation) }}</div>
            @endif
            @if ($user->candidate->date_entree && $user->candidate->date_radiation)
                @php
                    $service_start = new Carbon\Carbon($user->candidate->date_entree);
                    $service_end = new Carbon\Carbon($user->candidate->date_radiation);
                @endphp
                <div><strong>Nombre d'années de service:</strong> {{ $service_end->diff($service_start)->days }} Jours
                </div>
            @endif

            @if (count($user->candidate->jobs) > 0)
                <div style="color: #ffcc00; font-weight: bold; margin-top: 10px;">Emplois successifs</div>
                @foreach ($user->candidate->jobs as $job)
                    <div style="margin-top: 5px;">
                        @if ($job->periode)
                            <div><strong>Périodes:</strong> {{ $job->periode }}</div>
                        @endif
                        @if ($job->organism)
                            <div><strong>Organisme:</strong> {{ $job->organism }}</div>
                        @endif
                        @if ($job->fonction)
                            <div><strong>Fonctions:</strong> {{ $job->fonction }}</div>
                        @endif
                    </div>
                @endforeach
            @endif

            @if (count($user->candidate->diplomes) > 0)
                <div style="color: #ffcc00; font-weight: bold; margin-top: 10px;">Domaine de spécialité</div>
                @foreach ($user->candidate->diplomes as $diplome)
                    <div style="margin-top: 5px;">
                        @if ($diplome->diplome)
                            <div>
                                <strong>{{ $diplome->type === 'civil' ? 'DIPLÔMES CIVIL' : 'DIPLÔMES MILITAIRE' }}:</strong>
                                {{ $diplome->diplome }}
                            </div>
                        @endif
                        @if ($diplome->annees)
                            <div><strong>ANNÉES:</strong> {{ $diplome->annees }}</div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    @endif
    @if ($user->candidate->specialisation_1c)
        <div style="width: 100%; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
            <div style="padding-bottom: 0;">
                <h5
                    style="font-size: 1.1em; text-transform: uppercase; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px;">
                    PROJET PROFESSIONNEL
                </h5>
            </div>
            <div style="display: flex; flex-wrap: wrap;">

                <div style="width: 100%;">
                    <li style="padding-bottom: 5px; color: #FF7602;">
                        CHOIX 1
                        {{-- @if ($user->candidate->choiceFinal)
                            <span style="color: red; font-weight: bold;">
                                {{ $user->candidate->choiceFinal->choice_number == 'one' ? '(choix final)' : '' }}
                            </span>
                        @endif --}}
                    </li>
                </div>

                @if ($user->candidate->domaine_1c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Domaine : </label>
                        <input type="text" value="{{ $user->candidate->domaine_1c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif
                @if ($user->candidate->specialisation_1c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Spécialisation : </label>
                        <input type="text" value="{{ $user->candidate->specialisation_1c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->region_retraite_1c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Région de projet : </label>
                        <input type="text" value="{{ $user->candidate->region_retraite_1c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->department_1c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Département : </label>
                        <input type="text" value="{{ $user->candidate->department_1c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->locality_1c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Localité de projet : </label>
                        <input type="text" value="{{ $user->candidate->locality_1c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->adress_geo_1c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Adresse géographique : </label>
                        <input type="text" value="{{ $user->candidate->adress_geo_1c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->formation_1c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Formation souhaitée : </label>
                        <input type="text" value="{{ $user->candidate->formation_1c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->autres_form_1c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Autres solicitations : </label>
                        <input type="text" value="{{ $user->candidate->autres_form_1c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->specialisation_2c)
                    <div style="width: 100%; padding-top: 20px;">
                        <li style="padding-bottom: 5px; color: #FF7602;">
                            CHOIX 2
                            @if ($user->candidate->choiceFinal)
                                <span style="color: red; font-weight: bold;">
                                    {{ $user->candidate->choiceFinal->choice_number == 'two' ? '(choix final)' : '' }}
                                </span>
                            @endif
                        </li>
                    </div>

                    @if ($user->candidate->domaine_2c)
                        <div style="width: 50%;">
                            <label style="font-weight: bold;">Domaine : </label>
                            <input type="text" value="{{ $user->candidate->domaine_2c }}" readonly
                                style="border: none; width: 100%;" />
                        </div>
                    @endif
                @endif
                @if ($user->candidate->specialisation_2c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Spécialisation : </label>
                        <input type="text" value="{{ $user->candidate->specialisation_2c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->region_retraite_2c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Région de projet : </label>
                        <input type="text" value="{{ $user->candidate->region_retraite_2c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->department_2c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Département : </label>
                        <input type="text" value="{{ $user->candidate->department_2c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->locality_2c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Localité de projet : </label>
                        <input type="text" value="{{ $user->candidate->locality_2c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->adress_geo_2c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Adresse géographique : </label>
                        <input type="text" value="{{ $user->candidate->adress_geo_2c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->formation_2c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Formation souhaitée : </label>
                        <input type="text" value="{{ $user->candidate->formation_2c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif

                @if ($user->candidate->autres_form_2c)
                    <div style="width: 50%;">
                        <label style="font-weight: bold;">Autres solicitations : </label>
                        <input type="text" value="{{ $user->candidate->autres_form_2c }}" readonly
                            style="border: none; width: 100%;" />
                    </div>
                @endif
            </div>
        </div>
    @endif





    @if ($user->candidate->condition_admin)
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <h5
                style="font-size: 1.1em; text-transform: uppercase; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px;">
                CONDITION DE DEPART
            </h5>
            <div>
                @if ($user->candidate->condition_admin)
                    <div>
                        <strong>Conditions administratives:</strong>
                        <div style="padding: 5px; margin: 5px 0; border-radius: 4px;">
                            {{ $user->candidate->condition_admin }}</div>
                    </div>
                @endif

                @if ($user->candidate->condition_financiere)
                    <div>
                        <strong>Conditions financières:</strong>
                        <div>
                            @foreach (json_decode($user->candidate->condition_financiere) as $condition_financiere)
                                <div style="padding: 5px; margin: 5px 0; border-radius: 4px;">
                                    {{ $condition_financiere }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($user->candidate->condition_disciplinaire)
                    <div style="margin-top: 15px;">
                        <strong>Conditions disciplinaires ou décorations:</strong>
                        <div>
                            @foreach (json_decode($user->candidate->condition_disciplinaire) as $condition_disciplinaire)
                                <div style="padding: 5px; margin: 5px 0; border-radius: 4px;">
                                    {{ dateFr($condition_disciplinaire->date_decoration) }}:
                                    <span
                                        style="color: red; font-weight: bold;">{{ $condition_disciplinaire->title_decoration }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if ($user->candidate->accident_maladie)

        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <h5
                style="font-size: 1.1em; text-transform: uppercase; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px;">
                ACCIDENT / MALADIE
            </h5>
            <div>
                @if ($user->candidate->accident_maladie)
                    <div>
                        <strong>Accident maladie:</strong>
                        <div style="padding: 5px; margin: 5px 0; border-radius: 4px;">
                            {{ $user->candidate->accident_maladie }}</div>
                    </div>
                @endif

                @if ($user->candidate->demarche_nature)
                    <div>
                        <strong>Nature de la démarche:</strong>
                        <div style="padding: 5px; margin: 5px 0; border-radius: 4px;">
                            {{ $user->candidate->demarche_nature }}</div>
                    </div>
                @endif

                @if ($user->candidate->demarche_admin)
                    <div>
                        <strong>Administration de la démarche:</strong>
                        <div style="padding: 5px; margin: 5px 0; border-radius: 4px;">
                            {{ $user->candidate->demarche_admin }}</div>
                    </div>
                @endif

                @if ($user->candidate->etat_avancement)
                    <div>
                        <strong>État d'avancement:</strong>
                        <div style="padding: 5px; margin: 5px 0; border-radius: 4px;">
                            {{ $user->candidate->etat_avancement }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endif



</div>

</body>
</html>