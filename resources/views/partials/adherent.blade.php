<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"
    aria-controls="staticBackdrop">
    <i class='bx bx-customize fs-2'></i>
</button>

<div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop"
    aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="staticBackdropLabel">Détail sur l'adhérent</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
            <div class=" pt-2">

                <div class="row">

                    @if (!isset($view_choice_final))
                    <div class="col-md-12 row p-2 py-4 rounded-2 choice">
                        <div class="col-md-12 d-flex justify-content-between">
                            <div class="pb-1 fs-5 fw-bold text-danger">
                                CHOIX FINAL
                            </div>
                        </div>

                        @if ($candidature->choiceFinal->domaine)
                            <div class="col-md-6">
                                <label class="form-label-choice">Domaine : </label>
                                <div class="form-control-choice">{{ $candidature->choiceFinal->domaine }}</div>
                            </div>
                        @endif
                        @if ($candidature->choiceFinal->specialisation)
                            <div class="col-md-6">
                                <label class="form-label-choice">Spécialisation : </label>
                                <div class="form-control-choice">{{ $candidature->choiceFinal->specialisation }} </div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->region_retraite)
                            <div class="col-md-6">
                                <label class="form-label-choice">Région de projet : </label>
                                <div class="form-control-choice">{{ $candidature->choiceFinal->region_retraite }}</div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->department)
                            <div class="col-md-6">
                                <label class="form-label-choice">Département : </label>
                                <div class="form-control-choice"> {{ $candidature->choiceFinal->department }} </div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->locality)
                            <div class="col-md-6">
                                <label class="form-label-choice">Localité de projet :
                                </label>
                                <div class="form-control-choice"> {{ $candidature->choiceFinal->locality }} </div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->adress_geo)
                            <div class="col-md-6">
                                <label class="form-label-choice">Adresse géographique :
                                </label>
                                <div class="form-control-choice"> {{ $candidature->choiceFinal->adress_geo }} </div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->formation)
                            <div class="col-md-6">
                                <label class="form-label-choice">Formation souhaitée :
                                </label>
                                <div class="form-control-choice"> {{ $candidature->choiceFinal->formation }} </div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->autres_form)
                            <div class="col-md-6">
                                <label class="form-label-choice">Autres solicitations :
                                </label>
                                <div class="form-control-choice"> {{ $candidature->choiceFinal->autres_form }} </div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->partner_id)
                            <div class="col-md-12">
                                <label class="form-label-choice">Partenaire technique :
                                </label>
                                <div class="form-control-choice">
                                    {{ $candidature->choiceFinal->partner->user->username }} </div>
                            </div>
                        @endif
                    </div>
                    @endif


                    <div class="col-md-12">
                        <div class="card shadow-none ms-0 mb-2">

                            <h5 class="card-header pb-2 text-uppercase">Informations sur la candidature</h5>
                            <div class="card-body mx-0 px-0 py-4">
                                <div class="row g-3">

                                    @if ($candidature->type_piece)
                                        <div class=" col-md-12 card shadow-none my-0">
                                            <div class=" card-header pb-0">
                                                <h5 class="pb-0 border-bottom text-uppercase mt-2">IDENTITé</h5>
                                            </div>
                                            <div class="card-body row">
                                                @if ($candidature->type_piece)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Type de pièce : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->type_piece }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($candidature->no_card)
                                                    <div class="col-md-6">
                                                        <label class="form-label">N° de Pièce : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->no_card }}" readonly />
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    @endif

                                    @if ($candidature->partner_fullname)
                                        <div class=" col-md-12 card shadow-none my-0">
                                            <div class=" card-header pb-0">
                                                <h5 class="pb-0 border-bottom mt-2">CONJOINT(E)</h5>
                                            </div>
                                            <div class="card-body row">
                                                @if ($candidature->partner_fullname)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nom & Prénoms du conjoint(e) :
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->partner_fullname }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($candidature->partner_job)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Profession du conjoint(e) : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->partner_job }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($candidature->partner_phone_number)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Contact du conjoint(e) : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->partner_phone_number }}"
                                                            readonly />
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if (count($candidature->childs) > 0)
                                        <div class=" col-md-12 card shadow-none my-0 mb-2">
                                            <div class=" card-header pb-0">
                                                <h5 class="pb-0 border-bottom mt-2">ENFANTS</h5>
                                            </div>
                                            @foreach ($candidature->childs as $key => $child)
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
                                                        <div
                                                            class="col-md-2 d-flex flex-column justify-content-center">
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

                                    @if ($candidature->armee)
                                        <div class=" col-md-12 card shadow-none my-0">
                                            <div class=" card-header pb-0">
                                                <h5 class="pb-0 border-bottom mt-2">SITUATION PROFESSIONNELLE</h5>
                                            </div>
                                            <div class="card-body row">
                                                <div class="col-md-12">
                                                    <li class="pb-1 text-warning">Origine</li>
                                                </div>
                                                @if ($candidature->armee)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Type de militaire : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->armee }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($candidature->unite_rattachement)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Unité de rattachement : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->unite_rattachement }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($candidature->statut_prof)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Statut professionel : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->statut_prof }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($candidature->grade)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Grade : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->grade }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($candidature->date_entree)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Date d'entrée : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ dateFr($candidature->date_entree) }}"
                                                            readonly />
                                                    </div>
                                                @endif
                                                @if ($candidature->date_radiation)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Date de radiation : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ dateFr($candidature->date_radiation) }}"
                                                            readonly />
                                                    </div>
                                                @endif
                                                @if ($candidature->date_entree && $candidature->date_radiation)
                                                    <div class="col-md-6">
                                                        @php
                                                            $service_start = new Carbon\Carbon(
                                                                $candidature->date_entree,
                                                            );
                                                            $service_end = new Carbon\Carbon(
                                                                $candidature->date_radiation,
                                                            );
                                                        @endphp
                                                        <label class="form-label">Nombre d'année de service : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $service_end->diff($service_start)->days }} Jours"
                                                            readonly />
                                                    </div>
                                                @endif
                                                @if (count($candidature->jobs) > 0)
                                                    <div class="col-md-12 pt-4 pb-2">
                                                        <li class="pb-1 text-warning">Emplois successifs</li>
                                                    </div>
                                                @endif
                                                @foreach ($candidature->jobs as $key => $job)
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
                                                @if (count($candidature->diplomes) > 0)
                                                    <div class="col-md-12 pt-4 pb-2">
                                                        <li class="pb-1 text-warning">Domaine de spécialité</li>
                                                    </div>
                                                @endif
                                                @foreach ($candidature->diplomes as $key => $diplome)
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

                                    @if ($candidature->domaine_1c)
                                        <div class=" col-md-12 card shadow-none my-0">
                                            <div class=" card-header pb-0">
                                                <h5 class="pb-0 border-bottom mt-2">PROJET PROFESSIONNEL</h5>
                                            </div>
                                            <div class="card-body row">

                                                <div class="col-md-12">
                                                    <li class="pb-1 text-warning">
                                                        CHOIX 1
                                                        @if (!isset($view_choice_final) && $candidature->choiceFinal)
                                                            <span class="text-danger fw-bold">
                                                                {{ $candidature->choiceFinal->choice_number == 'one' ? '(choix final)' : '' }}
                                                            </span>
                                                        @endif
                                                    </li>
                                                </div>

                                                @if ($candidature->domaine_1c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Domaine : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->domaine_1c }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($candidature->specialisation_1c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Spécialisation : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->specialisation_1c }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->region_retraite_1c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Région de projet : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->region_retraite_1c }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->department_1c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Département : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->department_1c }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->locality_1c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Localité de projet : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->locality_1c }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->adress_geo_1c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Adresse géographique : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->adress_geo_1c }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->formation_1c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Formation souhaitée : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->formation_1c }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->autres_form_1c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Autres solicitations : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->autres_form_1c }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($candidature->domaine_2c)
                                                    <div class="col-md-12 pt-4">
                                                        <li class="pb-1 text-warning">
                                                            CHOIX 2
                                                            @if (!isset($view_choice_final) && $candidature->choiceFinal)
                                                                <span class="text-danger fw-bold">
                                                                    {{ $candidature->choiceFinal->choice_number == 'two' ? '(choix final)' : '' }}
                                                                </span>
                                                            @endif
                                                        </li>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <label class="form-label">Domaine : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->domaine_2c }}" readonly />
                                                    </div>
                                                @endif
                                                @if ($candidature->specialisation_2c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Spécialisation : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->specialisation_2c }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->region_retraite_2c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Région de projet : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->region_retraite_2c }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->department_2c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Département : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->department_2c }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->locality_2c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Localité de projet : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->locality_2c }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->adress_geo_2c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Adresse géographique : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->adress_geo_2c }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->formation_2c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Formation souhaitée : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->formation_2c }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->autres_form_2c)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Autres solicitations : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->autres_form_2c }}" readonly />
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if ($candidature->condition_admin)
                                        <div class=" col-md-12 card shadow-none my-0">
                                            <div class=" card-header pb-0">
                                                <h5 class="pb-0 border-bottom text-uppercase mt-2">CONDITION DE DéPART
                                                </h5>
                                            </div>
                                            <div class="card-body row">
                                                @if ($candidature->condition_admin)
                                                    <div class="col-md-3">
                                                        <label class="form-label">Condition administratives : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->condition_admin }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->condition_financiere)
                                                    <div class="col-md-9">
                                                        <label class="form-label">Condition financière : </label>
                                                        <div class=" rounded-2 row gap-2 p-1 px-2">
                                                            @foreach (json_decode($candidature->condition_financiere) as $condition_financiere)
                                                                <div class="border  rounded-2 p-1 px-2 col-md-12"
                                                                    style="background-color: #7A7A7A3F">
                                                                    {{ $condition_financiere }}
                                                                </div>
                                                            @endforeach

                                                        </div>

                                                    </div>
                                                @endif

                                                @if ($candidature->condition_disciplinaire)
                                                    <div class="col-md-12">
                                                        <label class="form-label">Condition Disciplinaire : </label>
                                                        <textarea class="form-control" readonly>{{ $candidature->condition_disciplinaire }}</textarea>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    @if ($candidature->accident_maladie)
                                        <div class=" col-md-12 card shadow-none my-0">
                                            <div class=" card-header pb-0">
                                                <h5 class="pb-0 border-bottom text-uppercase mt-2">ACCIDENT / MALADIE
                                                </h5>
                                            </div>
                                            <div class="card-body row">
                                                @if ($candidature->accident_maladie)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Accident maladie : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->accident_maladie }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->demarche_nature)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nature de la demarche : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->demarche_nature }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->demarche_admin)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Administration de la démarche :
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->demarche_admin }}" readonly />
                                                    </div>
                                                @endif

                                                @if ($candidature->etat_avancement)
                                                    <div class="col-md-6">
                                                        <label class="form-label">Etat d'avancement : </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $candidature->etat_avancement }}" readonly />
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
                                        @if ($candidature->partner_card)
                                            <div class="col-md-6">
                                                <div
                                                    class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                    <div>Pièce d'identité du conjoint(e)</div>
                                                    <div>
                                                        <a href="{{ asset($candidature->partner_card) }}" download>
                                                            <i class='bx bx-cloud-download fs-2'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($candidature->marriage_certificate)
                                            <div class="col-md-6">
                                                <div
                                                    class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                    <div>Certificat de mariage</div>
                                                    <div>
                                                        <a href="{{ asset($candidature->marriage_certificate) }}"
                                                            download>
                                                            <i class='bx bx-cloud-download fs-2'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($candidature->demande_manuscrite)
                                            <div class="col-md-6">
                                                <div
                                                    class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                    <div>Demande manuscrite</div>
                                                    <div>
                                                        <a href="{{ asset($candidature->demande_manuscrite) }}"
                                                            download>
                                                            <i class='bx bx-cloud-download fs-2'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($candidature->cv)
                                            <div class="col-md-6">
                                                <div
                                                    class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                    <div>CV</div>
                                                    <div>
                                                        <a href="{{ asset($candidature->cv) }}" download>
                                                            <i class='bx bx-cloud-download fs-2'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($candidature->id_card)
                                            <div class="col-md-6">
                                                <div
                                                    class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                    <div>Pièce d'identité</div>
                                                    <div>
                                                        <a href="{{ asset($candidature->id_card) }}" download>
                                                            <i class='bx bx-cloud-download fs-2'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($candidature->carte_pro)
                                            <div class="col-md-6">
                                                <div
                                                    class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                    <div>Carte professionnelle</div>
                                                    <div>
                                                        <a href="{{ asset($candidature->carte_pro) }}" download>
                                                            <i class='bx bx-cloud-download fs-2'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($candidature->fiche_engagement)
                                            <div class="col-md-6">
                                                <div
                                                    class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                    <div>Fiche d'engagement</div>
                                                    <div>
                                                        <a href="{{ asset($candidature->fiche_engagement) }}"
                                                            download>
                                                            <i class='bx bx-cloud-download fs-2'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($candidature->fiche_individuelle)
                                            <div class="col-md-6">
                                                <div
                                                    class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                    <div>Fiche individuelle</div>
                                                    <div>
                                                        <a href="{{ asset($candidature->fiche_individuelle) }}"
                                                            download>
                                                            <i class='bx bx-cloud-download fs-2'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($candidature->arrete_radiation)
                                            <div class="col-md-6">
                                                <div
                                                    class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                    <div>Arrêté de radiation</div>
                                                    <div>
                                                        <a href="{{ asset($candidature->arrete_radiation) }}"
                                                            download>
                                                            <i class='bx bx-cloud-download fs-2'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($candidature->certificat)
                                            <div class="col-md-6">
                                                <div
                                                    class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                    <div>Certificat médical</div>
                                                    <div>
                                                        <a href="{{ asset($candidature->certificat) }}" download>
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
</div>

<style>
    .offcanvas {
        width: 50vw !important;
    }

    .choice {
        background: linear-gradient(#E8EBE47E, #C2D2D37E);
        border: 2px solid #E8EBE47;
        border-radius: 15px;
        box-shadow: 0 15px 15px -15px rgb(0 0 0 / 0.25);
        margin-bottom: 20px;
        margin-left: 1px;

    }

    .choice-2 {
        background: linear-gradient(#E8EBE47E, #D3C2C27E);
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
