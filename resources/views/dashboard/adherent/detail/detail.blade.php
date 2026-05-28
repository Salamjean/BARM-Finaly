<div class="tab-pane fade {{ (Session::get('step') ?? 'profile') == 'profile' ? 'show active' : '' }}"
    id="ex-with-icons-tabs-1" role="tabpanel" aria-labelledby="ex-with-icons-tab-1">

    <div class="container-fluid bg-white p-4">

        @if (!can('partner-financial'))

            @if ($user->candidate->death == 1)
                <div class="alert alert-danger border-0 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bx bx-error-circle text-danger fs-4 me-3"></i>
                        <h5 class="mb-0 text-danger text-uppercase">Adhérent décédé</h5>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Date de décès</div>
                            <strong>{{ $user->candidate->death_date }}</strong>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Numéro de l'acte</div>
                            <strong>{{ $user->candidate->death_no_act }}</strong>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Lieu de décès</div>
                            <strong>{{ $user->candidate->death_city }}</strong>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        @if ($user->candidate->choiceFinal)
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-star text-danger fs-4 me-3"></i>
                    <h4 class="mb-0 text-danger">CHOIX FINAL</h4>
                </div>

                <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                    <div class="row g-3">
                        @if ($user->candidate->choiceFinal->domaine)
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Domaine</div>
                                <div class="fw-medium">{{ $user->candidate->choiceFinal->domaine }}</div>
                            </div>
                        @endif
                        @if ($user->candidate->choiceFinal->specialisation)
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Spécialisation</div>
                                <div class="fw-medium">{{ $user->candidate->choiceFinal->specialisation }}</div>
                            </div>
                        @endif

                        @if ($user->candidate->choiceFinal->region_retraite)
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Région de projet</div>
                                <div class="fw-medium">{{ $user->candidate->choiceFinal->region_retraite }}</div>
                            </div>
                        @endif

                        @if ($user->candidate->choiceFinal->department)
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Département</div>
                                <div class="fw-medium">{{ $user->candidate->choiceFinal->department }}</div>
                            </div>
                        @endif

                        @if ($user->candidate->choiceFinal->locality)
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Localité de projet</div>
                                <div class="fw-medium">{{ $user->candidate->choiceFinal->locality }}</div>
                            </div>
                        @endif

                        @if ($user->candidate->choiceFinal->adress_geo)
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Adresse géographique</div>
                                <div class="fw-medium">{{ $user->candidate->choiceFinal->adress_geo }}</div>
                            </div>
                        @endif

                        @if ($user->candidate->choiceFinal->formation)
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Formation souhaitée</div>
                                <div class="fw-medium">{{ $user->candidate->choiceFinal->formation }}</div>
                            </div>
                        @endif

                        @if ($user->candidate->choiceFinal->autres_form)
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Autres solicitations</div>
                                <div class="fw-medium">{{ $user->candidate->choiceFinal->autres_form }}</div>
                            </div>
                        @endif

                        @if ($user->candidate->choiceFinal->partner_id)
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Partenaire technique</div>
                                <div class="fw-medium">{{ $user->candidate->choiceFinal->partner->user->username }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Date du profilage</div>
                                <div class="fw-medium">
                                    {{ $user->candidate->choiceFinal->profilage_date
                                        ? dateFr($user->candidate->choiceFinal->profilage_date)
                                        : dateFr($user->candidate->choiceFinal->created_at, 'complet') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if (!can('partner-financial'))

            <!-- Informations personnelles -->
            @if ($user->email)
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                        <i class="bx bx-user text-primary fs-4 me-3"></i>
                        <h4 class="mb-0 text-primary">Informations personnelles</h4>
                    </div>

                    <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="text-muted small mb-1">E-mail</div>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-envelope text-muted me-2"></i>
                                    <span class="fw-medium">{{ $user->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Personne à contacter en cas d'urgence -->
            @if ($user->candidate->sos_person_phone_number)
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                        <i class="bx bx-phone text-danger fs-4 me-3"></i>
                        <h4 class="mb-0 text-danger">Personne à contacter en cas d'urgence</h4>
                    </div>

                    <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Nom complet</div>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-user text-muted me-2"></i>
                                    <span class="fw-medium">{{ $user->candidate->sos_person_fullname }}</span>
                                </div>
                            </div>

                            <div class="{{ $user->candidate->sos_person_phone_number2 ? 'col-md-3' : 'col-md-6' }}">
                                <div class="text-muted small mb-1">Contact</div>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-phone text-muted me-2"></i>
                                    <span class="fw-medium">{{ $user->candidate->sos_person_phone_number }}</span>
                                </div>
                            </div>

                            @if ($user->candidate->sos_person_phone_number2)
                                <div class="col-md-3">
                                    <div class="text-muted small mb-1">Contact 2</div>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-phone text-muted me-2"></i>
                                        <span class="fw-medium">{{ $user->candidate->sos_person_phone_number2 }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Informations sur la candidature -->
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-file-blank text-info fs-4 me-3"></i>
                    <h4 class="mb-0 text-info">Informations sur la candidature</h4>
                </div>

                <div class="row g-4">
                    <!-- IDENTITÉ -->
                    @if ($user->candidate->type_piece)
                        <div class="col-12">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-25">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-id-card text-primary fs-5 me-2"></i>
                                    <h5 class="mb-0 text-primary">IDENTITÉ</h5>
                                </div>
                                <div class="row g-3">
                                    @if ($user->candidate->type_piece)
                                        <div class="col-md-6">
                                            <div class="text-muted small mb-1">Type de pièce</div>
                                            <div class="fw-medium">{{ $user->candidate->type_piece }}</div>
                                        </div>
                                    @endif
                                    @if ($user->candidate->no_card)
                                        <div class="col-md-6">
                                            <div class="text-muted small mb-1">N° de Pièce</div>
                                            <div class="fw-medium">{{ $user->candidate->no_card }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- CONJOINT(E) -->
                    @if ($user->candidate->partner_fullname)
                        <div class="col-12">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-25">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-heart text-info fs-5 me-2"></i>
                                    <h5 class="mb-0 text-info">CONJOINT(E)</h5>
                                </div>
                                <div class="row g-3">
                                    @if ($user->candidate->partner_fullname)
                                        <div class="col-md-6">
                                            <div class="text-muted small mb-1">Nom & Prénoms du conjoint(e)</div>
                                            <div class="fw-medium">{{ $user->candidate->partner_fullname }}</div>
                                        </div>
                                    @endif
                                    @if ($user->candidate->partner_job)
                                        <div class="col-md-6">
                                            <div class="text-muted small mb-1">Profession du conjoint(e)</div>
                                            <div class="fw-medium">{{ $user->candidate->partner_job }}</div>
                                        </div>
                                    @endif
                                    @if ($user->candidate->partner_phone_number)
                                        <div class="col-md-6">
                                            <div class="text-muted small mb-1">Contact du conjoint(e)</div>
                                            <div class="fw-medium">{{ $user->candidate->partner_phone_number }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- ENFANTS -->
                    @if (count($user->candidate->childs) > 0)
                        <div class="col-12">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-25">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-group text-warning fs-5 me-2"></i>
                                    <h5 class="mb-0 text-warning">ENFANTS</h5>
                                </div>
                                @foreach ($user->candidate->childs as $key => $child)
                                    <div class="border-start border-warning border-3 ps-3 py-3 mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-warning text-dark me-2">Enfant
                                                {{ $key + 1 }}</span>
                                        </div>
                                        <div class="row g-3">
                                            @if ($child->fullname)
                                                <div class="col-md-4">
                                                    <div class="text-muted small mb-1">Nom & Prénoms</div>
                                                    <div class="fw-medium">{{ $child->fullname }}</div>
                                                </div>
                                            @endif
                                            @if ($child->birth_date)
                                                <div class="col-md-3">
                                                    <div class="text-muted small mb-1">Date de naissance</div>
                                                    <div class="fw-medium">{{ $child->birth_date }}</div>
                                                </div>
                                            @endif
                                            @if ($child->level)
                                                <div class="col-md-3">
                                                    <div class="text-muted small mb-1">Niveau d'étude</div>
                                                    <div class="fw-medium">{{ $child->level }}</div>
                                                </div>
                                            @endif
                                            @if ($child->file)
                                                <div class="col-md-2">
                                                    <div class="text-muted small mb-1">Document J.</div>
                                                    <a href="{{ asset($child->file) }}"
                                                        class="btn btn-outline-primary btn-sm" download>
                                                        <i class="bx bx-download me-1"></i> Télécharger
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- SITUATION PROFESSIONNELLE -->
                    @if ($user->candidate->armee)
                        <div class="col-12">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-25">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-briefcase text-success fs-5 me-2"></i>
                                    <h5 class="mb-0 text-success">SITUATION PROFESSIONNELLE</h5>
                                </div>

                                <!-- Origine -->
                                <div class="mb-4">
                                    <h6 class="text-warning mb-3">Origine</h6>
                                    <div class="row g-3">
                                        @if ($user->candidate->armee)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Type de militaire</div>
                                                <div class="fw-medium">{{ $user->candidate->armee }}</div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->unite_rattachement)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Unité de rattachement</div>
                                                <div class="fw-medium">{{ $user->candidate->unite_rattachement }}
                                                </div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->statut_prof)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Statut professionel</div>
                                                <div class="fw-medium">{{ $user->candidate->statut_prof }}</div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->grade)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Grade</div>
                                                <div class="fw-medium">{{ $user->candidate->grade }}</div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->date_entree)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Date d'entrée</div>
                                                <div class="fw-medium">{{ dateFr($user->candidate->date_entree) }}
                                                </div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->date_radiation)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Date de radiation</div>
                                                <div class="fw-medium">{{ dateFr($user->candidate->date_radiation) }}
                                                </div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->date_entree && $user->candidate->date_radiation)
                                            <div class="col-md-6">
                                                @php
                                                    $service_start = new Carbon\Carbon($user->candidate->date_entree);
                                                    $service_end = new Carbon\Carbon($user->candidate->date_radiation);
                                                @endphp
                                                <div class="text-muted small mb-1">Nombre d'année de service</div>
                                                <div class="fw-medium text-info">
                                                    @php
                                                        $diff = $service_end->diff($service_start);
                                                    @endphp
                                                    {{ $diff->y }} an(s), {{ $diff->m }} mois, {{ $diff->d }} jour(s)
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Emplois successifs -->
                                @if (count($user->candidate->jobs) > 0)
                                    <div class="mb-4">
                                        <h6 class="text-warning mb-3">Emplois successifs</h6>
                                        @foreach ($user->candidate->jobs as $key => $job)
                                            <div class="border-start border-info border-3 ps-3 py-2 mb-3">
                                                <div class="row g-3">
                                                    @if ($job->periode)
                                                        <div class="col-md-4">
                                                            <div class="text-muted small mb-1">Périodes</div>
                                                            <div class="fw-medium">{{ $job->periode }}</div>
                                                        </div>
                                                    @endif
                                                    @if ($job->organism)
                                                        <div class="col-md-4">
                                                            <div class="text-muted small mb-1">Organisme</div>
                                                            <div class="fw-medium">{{ $job->organism }}</div>
                                                        </div>
                                                    @endif
                                                    @if ($job->fonction)
                                                        <div class="col-md-4">
                                                            <div class="text-muted small mb-1">Fonctions</div>
                                                            <div class="fw-medium">{{ $job->fonction }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Domaine de spécialité -->
                                @if (count($user->candidate->diplomes) > 0)
                                    <div class="mb-4">
                                        <h6 class="text-warning mb-3">Domaine de spécialité</h6>
                                        @foreach ($user->candidate->diplomes as $key => $diplome)
                                            <div class="border-start border-secondary border-3 ps-3 py-2 mb-3">
                                                <div class="row g-3">
                                                    @if ($diplome->diplome)
                                                        <div class="col-10">
                                                            <div class="text-muted small mb-1">
                                                                {{ $diplome->type === 'civil' ? 'DIPLÔMES CIVIL' : 'DIPLÔMES MILITAIRE' }}
                                                            </div>
                                                            <div class="fw-medium">{{ $diplome->diplome }}</div>
                                                        </div>
                                                    @endif
                                                    @if ($diplome->annees)
                                                        <div class="col-2">
                                                            <div class="text-muted small mb-1">ANNÉES</div>
                                                            <div class="fw-medium text-center">{{ $diplome->annees }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- PROJET PROFESSIONNEL -->
                    @if ($user->candidate->specialisation_1c)
                        <div class="col-12">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-25">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-target-lock text-primary fs-5 me-2"></i>
                                    <h5 class="mb-0 text-primary">PROJET PROFESSIONNEL</h5>
                                </div>

                                <!-- CHOIX 1 -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="badge bg-primary me-2">CHOIX 1</span>
                                        @if ($user->candidate->choiceFinal && $user->candidate->choiceFinal->choice_number == 'one')
                                            <span class="badge bg-danger">choix final</span>
                                        @endif
                                    </div>
                                    <div class="row g-3">
                                        @if ($user->candidate->domaine_1c)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Domaine</div>
                                                <div class="fw-medium">{{ $user->candidate->domaine_1c }}</div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->specialisation_1c)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Spécialisation</div>
                                                <div class="fw-medium">{{ $user->candidate->specialisation_1c }}</div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->region_retraite_1c)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Région de projet</div>
                                                <div class="fw-medium">{{ $user->candidate->region_retraite_1c }}
                                                </div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->department_1c)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Département</div>
                                                <div class="fw-medium">{{ $user->candidate->department_1c }}</div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->locality_1c)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Localité de projet</div>
                                                <div class="fw-medium">{{ $user->candidate->locality_1c }}</div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->adress_geo_1c)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Adresse géographique</div>
                                                <div class="fw-medium">{{ $user->candidate->adress_geo_1c }}</div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->formation_1c)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Formation souhaitée</div>
                                                <div class="fw-medium">{{ $user->candidate->formation_1c }}</div>
                                            </div>
                                        @endif
                                        @if ($user->candidate->autres_form_1c)
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Autres solicitations</div>
                                                <div class="fw-medium">{{ $user->candidate->autres_form_1c }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- CHOIX 2 -->
                                @if ($user->candidate->specialisation_2c)
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="badge bg-secondary me-2">CHOIX 2</span>
                                            @if ($user->candidate->choiceFinal && $user->candidate->choiceFinal->choice_number == 'two')
                                                <span class="badge bg-danger">choix final</span>
                                            @endif
                                        </div>
                                        <div class="row g-3">
                                            @if ($user->candidate->domaine_2c)
                                                <div class="col-md-6">
                                                    <div class="text-muted small mb-1">Domaine</div>
                                                    <div class="fw-medium">{{ $user->candidate->domaine_2c }}</div>
                                                </div>
                                            @endif
                                            @if ($user->candidate->specialisation_2c)
                                                <div class="col-md-6">
                                                    <div class="text-muted small mb-1">Spécialisation</div>
                                                    <div class="fw-medium">{{ $user->candidate->specialisation_2c }}
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($user->candidate->region_retraite_2c)
                                                <div class="col-md-6">
                                                    <div class="text-muted small mb-1">Région de projet</div>
                                                    <div class="fw-medium">{{ $user->candidate->region_retraite_2c }}
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($user->candidate->department_2c)
                                                <div class="col-md-6">
                                                    <div class="text-muted small mb-1">Département</div>
                                                    <div class="fw-medium">{{ $user->candidate->department_2c }}</div>
                                                </div>
                                            @endif
                                            @if ($user->candidate->locality_2c)
                                                <div class="col-md-6">
                                                    <div class="text-muted small mb-1">Localité de projet</div>
                                                    <div class="fw-medium">{{ $user->candidate->locality_2c }}</div>
                                                </div>
                                            @endif
                                            @if ($user->candidate->adress_geo_2c)
                                                <div class="col-md-6">
                                                    <div class="text-muted small mb-1">Adresse géographique</div>
                                                    <div class="fw-medium">{{ $user->candidate->adress_geo_2c }}</div>
                                                </div>
                                            @endif
                                            @if ($user->candidate->formation_2c)
                                                <div class="col-md-6">
                                                    <div class="text-muted small mb-1">Formation souhaitée</div>
                                                    <div class="fw-medium">{{ $user->candidate->formation_2c }}</div>
                                                </div>
                                            @endif
                                            @if ($user->candidate->autres_form_2c)
                                                <div class="col-md-6">
                                                    <div class="text-muted small mb-1">Autres solicitations</div>
                                                    <div class="fw-medium">{{ $user->candidate->autres_form_2c }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- CONDITION DE DÉPART -->
                    @if ($user->candidate->condition_admin)
                        <div class="col-12">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-25">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-exit text-warning fs-5 me-2"></i>
                                    <h5 class="mb-0 text-warning">CONDITION DE DÉPART</h5>
                                </div>
                                <div class="row g-3">
                                    @if ($user->candidate->condition_admin)
                                        <div class="col-md-3">
                                            <div class="text-muted small mb-1">Condition administratives</div>
                                            <div class="fw-medium">{{ $user->candidate->condition_admin }}</div>
                                        </div>
                                    @endif

                                    @if ($user->candidate->condition_financiere)
                                        <div class="col-md-9">
                                            <div class="text-muted small mb-1">Condition financière</div>
                                            <div class="row g-2">
                                                @foreach (json_decode($user->candidate->condition_financiere) as $condition_financiere)
                                                    <div class="col-12">
                                                        <div class="border rounded-2 p-2 bg-white bg-opacity-75">
                                                            {{ $condition_financiere }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->candidate->condition_disciplinaire)
                                        <div class="col-md-12">
                                            <div class="text-muted small mb-1">Condition Disciplinaire ou décorations
                                            </div>
                                            <div class="row g-2">
                                                @foreach (json_decode($user->candidate->condition_disciplinaire) as $condition_disciplinaire)
                                                    <div class="col-12">
                                                        <div class="border rounded-2 p-2 bg-white bg-opacity-75">
                                                            <span
                                                                class="text-muted">{{ dateFr($condition_disciplinaire->date_decoration) }}</span>
                                                            : <span
                                                                class="text-danger fw-bold">{{ $condition_disciplinaire->title_decoration }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- ACCIDENT / MALADIE -->
                    @if ($user->candidate->accident_maladie)
                        <div class="col-12">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-25">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-first-aid text-danger fs-5 me-2"></i>
                                    <h5 class="mb-0 text-danger">ACCIDENT / MALADIE</h5>
                                </div>
                                <div class="row g-3">
                                    @if ($user->candidate->accident_maladie)
                                        <div class="col-md-6">
                                            <div class="text-muted small mb-1">Accident maladie</div>
                                            <div class="fw-medium">{{ $user->candidate->accident_maladie }}</div>
                                        </div>
                                    @endif
                                    @if ($user->candidate->maladie_supp)
                                        <div class="col-md-12">
                                            <div class="text-muted small mb-1">Indication de l'accident ou maladie
                                            </div>
                                            <div class="fw-medium">{{ $user->candidate->maladie_supp }}</div>
                                        </div>
                                    @endif
                                    @if ($user->candidate->demarche_nature)
                                        <div class="col-md-6">
                                            <div class="text-muted small mb-1">Nature de la demarche</div>
                                            <div class="fw-medium">{{ $user->candidate->demarche_nature }}</div>
                                        </div>
                                    @endif
                                    @if ($user->candidate->demarche_admin)
                                        <div class="col-md-6">
                                            <div class="text-muted small mb-1">Administration de la démarche</div>
                                            <div class="fw-medium">{{ $user->candidate->demarche_admin }}</div>
                                        </div>
                                    @endif
                                    @if ($user->candidate->etat_avancement)
                                        <div class="col-md-6">
                                            <div class="text-muted small mb-1">Etat d'avancement</div>
                                            <div class="fw-medium">{{ $user->candidate->etat_avancement }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pièces jointes -->
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-paperclip text-secondary fs-4 me-3"></i>
                    <h4 class="mb-0 text-secondary">Pièces jointes</h4>
                </div>

                <div class="row g-3">
                    @if ($user->candidate->fiche_inscription)
                        <div class="col-md-6">
                            <div
                                class="border rounded-3 p-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-file text-primary fs-5 me-2"></i>
                                    <span>Fiche d'inscription</span>
                                </div>
                                <a href="{{ asset($user->candidate->fiche_inscription) }}"
                                    class="btn btn-primary btn-sm" download>
                                    <i class="bx bx-download me-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($user->candidate->partner_card)
                        <div class="col-md-6">
                            <div
                                class="border rounded-3 p-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-id-card text-info fs-5 me-2"></i>
                                    <span>Pièce d'identité du conjoint(e)</span>
                                </div>
                                <a href="{{ asset($user->candidate->partner_card) }}" class="btn btn-primary btn-sm"
                                    download>
                                    <i class="bx bx-download me-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($user->candidate->marriage_certificate)
                        <div class="col-md-6">
                            <div
                                class="border rounded-3 p-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-heart text-danger fs-5 me-2"></i>
                                    <span>Certificat de mariage</span>
                                </div>
                                <a href="{{ asset($user->candidate->marriage_certificate) }}"
                                    class="btn btn-primary btn-sm" download>
                                    <i class="bx bx-download me-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($user->candidate->demande_manuscrite)
                        <div class="col-md-6">
                            <div
                                class="border rounded-3 p-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-edit text-warning fs-5 me-2"></i>
                                    <span>Demande manuscrite</span>
                                </div>
                                <a href="{{ asset($user->candidate->demande_manuscrite) }}"
                                    class="btn btn-primary btn-sm" download>
                                    <i class="bx bx-download me-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($user->candidate->cv)
                        <div class="col-md-6">
                            <div
                                class="border rounded-3 p-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-user-circle text-success fs-5 me-2"></i>
                                    <span>CV</span>
                                </div>
                                <a href="{{ asset($user->candidate->cv) }}" class="btn btn-primary btn-sm" download>
                                    <i class="bx bx-download me-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($user->candidate->id_card)
                        <div class="col-md-6">
                            <div
                                class="border rounded-3 p-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-id-card text-primary fs-5 me-2"></i>
                                    <span>Pièce d'identité</span>
                                </div>
                                <a href="{{ asset($user->candidate->id_card) }}" class="btn btn-primary btn-sm"
                                    download>
                                    <i class="bx bx-download me-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($user->candidate->carte_pro)
                        <div class="col-md-6">
                            <div
                                class="border rounded-3 p-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-briefcase text-info fs-5 me-2"></i>
                                    <span>Carte professionnelle</span>
                                </div>
                                <a href="{{ asset($user->candidate->carte_pro) }}" class="btn btn-primary btn-sm"
                                    download>
                                    <i class="bx bx-download me-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($user->candidate->fiche_engagement)
                        <div class="col-md-6">
                            <div
                                class="border rounded-3 p-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-file-blank text-secondary fs-5 me-2"></i>
                                    <span>Fiche d'engagement</span>
                                </div>
                                <a href="{{ asset($user->candidate->fiche_engagement) }}"
                                    class="btn btn-primary btn-sm" download>
                                    <i class="bx bx-download me-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($user->candidate->fiche_individuelle)
                        <div class="col-md-6">
                            <div
                                class="border rounded-3 p-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-user text-warning fs-5 me-2"></i>
                                    <span>Fiche individuelle</span>
                                </div>
                                <a href="{{ asset($user->candidate->fiche_individuelle) }}"
                                    class="btn btn-primary btn-sm" download>
                                    <i class="bx bx-download me-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($user->candidate->arrete_radiation)
                        <div class="col-md-6">
                            <div
                                class="border rounded-3 p-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-file text-danger fs-5 me-2"></i>
                                    <span>Arrêté de radiation</span>
                                </div>
                                <a href="{{ asset($user->candidate->arrete_radiation) }}"
                                    class="btn btn-primary btn-sm" download>
                                    <i class="bx bx-download me-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($user->candidate->certificat)
                        <div class="col-md-6">
                            <div
                                class="border rounded-3 p-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-plus-medical text-success fs-5 me-2"></i>
                                    <span>Certificat médical</span>
                                </div>
                                <a href="{{ asset($user->candidate->certificat) }}" class="btn btn-primary btn-sm"
                                    download>
                                    <i class="bx bx-download me-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Auteur -->
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-user-check text-info fs-4 me-3"></i>
                    <h4 class="mb-0 text-info">Auteur</h4>
                </div>

                <div class="row g-3">
                    @if ($user->candidate->date_inscription)
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light bg-opacity-50">
                                <div class="text-muted small mb-1">Inscrit au barm le</div>
                                <div class="fw-bold text-success">{{ dateFr($user->candidate->date_inscription) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                    @endif

                    @if ($user->candidate)
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light bg-opacity-50">
                                <div class="text-muted small mb-1">Editer le</div>
                                <div class="fw-bold">{{ dateFr($user->candidate->created_at, 'complet') }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light bg-opacity-50">
                                <div class="text-muted small mb-1">Par</div>
                                <div class="fw-bold">{{ $user->candidate->createdBy->fullName() }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($user->candidate->completed_by)
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light bg-opacity-50">
                                <div class="text-muted small mb-1">Approuvé le</div>
                                <div class="fw-bold text-success">
                                    {{ dateFr($user->candidate->completed_at, 'complet') }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light bg-opacity-50">
                                <div class="text-muted small mb-1">Par</div>
                                <div class="fw-bold">{{ $user->candidate->completedBy->fullName() }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif


    </div>
</div>
