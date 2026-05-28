@extends('layouts.app')
@section('content')
    <div class="container-fuild mx-5 flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Utilisateur /</span> Profil
        </h4>
        <div class="row gy-4">
            <div class="col-xl-3 col-lg-4 col-md-4 order-1 order-md-0">
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body bg-light bg-opacity-50 p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <a href="{{ route('export.adherent', $user->id) }}" class="btn btn-primary btn-sm">
                                <i class="bx bx-export me-1"></i> Export
                            </a>

                            @if (can(
                                    'chef-cellule-formation-et-insertion|conseiller-auto-emploi|conseiller-entreprise-prive|conseiller-fonction-public'))
                                <a href="{{ route('adherent.edit', $user->id) }}" class="btn btn-secondary btn-sm">
                                    <i class="bx bx-edit-alt me-1"></i> Modifier
                                </a>
                            @endif
                        </div>

                        <div class="user-avatar-section mb-4">
                            <div class="d-flex align-items-center flex-column text-center">
                                <div class="position-relative mb-3">
                                    @if ($user->candidate->image)
                                        <img class="img-fluid rounded-circle border border-3 border-white shadow"
                                            src="{{ asset($user->candidate->image) }}"
                                            height="120" width="120" alt="Avatar utilisateur"
                                            style="width: 120px; height: 120px; object-fit: cover;" />
                                    @else
                                        <img class="img-fluid rounded-circle border border-3 border-white shadow"
                                            src="#" height="120" width="120" alt="Avatar utilisateur"
                                            style="width: 120px; height: 120px; object-fit: cover; display: none;" />
                                    @endif
                                </div>

                                <div class="user-info">
                                    <h4 class="mb-2 text-dark">{{ $user->fullName() }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="border-top pt-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bx bx-user-circle text-primary fs-5 me-2"></i>
                                <h5 class="mb-0 text-primary">Informations Personnelles</h5>
                            </div>

                            <div class="info-container">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div
                                            class="border-start border-primary border-3 ps-3 py-2 bg-white bg-opacity-75 rounded-end">
                                            <div class="text-muted small mb-1">Mecano</div>
                                            <div class="fw-bold text-dark">{{ $user->mecano }}</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div
                                            class="border-start border-secondary border-3 ps-3 py-2 bg-white bg-opacity-75 rounded-end">
                                            <div class="text-muted small mb-1">Matricule</div>
                                            <div class="fw-bold text-dark">{{ $user->matricule }}</div>
                                        </div>
                                    </div>

                                    @if ($user->candidate->birth_date)
                                        <div class="col-12">
                                            <div
                                                class="border-start border-info border-3 ps-3 py-2 bg-white bg-opacity-75 rounded-end">
                                                <div class="text-muted small mb-1">Date de naissance</div>
                                                <div class="fw-bold text-dark">{{ dateFr($user->candidate->birth_date) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->candidate->orientation)
                                        <div class="col-12">
                                            <div
                                                class="border-start border-success border-3 ps-3 py-2 bg-white bg-opacity-75 rounded-end">
                                                <div class="text-muted small mb-1">Orientation</div>
                                                <div class="fw-bold text-success">
                                                    {{ statusCandidature($user->candidate->orientation, 'orientation') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->candidate->cohort)
                                        <div class="col-12">
                                            <div
                                                class="border-start border-warning border-3 ps-3 py-2 bg-white bg-opacity-75 rounded-end">
                                                <div class="text-muted small mb-1">N° Cohorte</div>
                                                <div class="fw-bold text-warning">{{ $user->candidate->cohort->reference }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->candidate->gender)
                                        <div class="col-12">
                                            <div
                                                class="border-start border-info border-3 ps-3 py-2 bg-white bg-opacity-75 rounded-end">
                                                <div class="text-muted small mb-1">Genre</div>
                                                <div class="fw-bold text-dark">{{ $user->candidate->gender }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->candidate->religion)
                                        <div class="col-12">
                                            <div
                                                class="border-start border-secondary border-3 ps-3 py-2 bg-white bg-opacity-75 rounded-end">
                                                <div class="text-muted small mb-1">Religion</div>
                                                <div class="fw-bold text-dark">{{ $user->candidate->religion }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->candidate->ethnic)
                                        <div class="col-12">
                                            <div
                                                class="border-start border-info border-3 ps-3 py-2 bg-white bg-opacity-75 rounded-end">
                                                <div class="text-muted small mb-1">Ethnie</div>
                                                <div class="fw-bold text-dark">{{ $user->candidate->ethnic }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->candidate->situation_matrimoniale)
                                        <div class="col-12">
                                            <div
                                                class="border-start border-warning border-3 ps-3 py-2 bg-white bg-opacity-75 rounded-end">
                                                <div class="text-muted small mb-1">Situation matrimoniale</div>
                                                <div class="fw-bold text-dark">
                                                    {{ $user->candidate->situation_matrimoniale }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->candidate->phone_number)
                                        <div class="col-12">
                                            <div
                                                class="border-start border-success border-3 ps-3 py-2 bg-white bg-opacity-75 rounded-end">
                                                <div class="text-muted small mb-1">Numéros de téléphone</div>
                                                <div class="fw-bold text-dark">
                                                    <div>{{ $user->candidate->phone_number }}</div>
                                                    @if ($user->candidate->phone_number2)
                                                        <div class="small text-muted">{{ $user->candidate->phone_number2 }}
                                                        </div>
                                                    @endif
                                                    @if ($user->candidate->phone_number3)
                                                        <div class="small text-muted">{{ $user->candidate->phone_number3 }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->candidate->residence)
                                        <div class="col-12">
                                            <div
                                                class="border-start border-primary border-3 ps-3 py-2 bg-white bg-opacity-75 rounded-end">
                                                <div class="text-muted small mb-1">Résidence</div>
                                                <div class="fw-bold text-dark">{{ $user->candidate->residence }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if (count($user->candidate->childs) > 0)
                                        <div class="col-12">
                                            <div
                                                class="border-start border-info border-3 ps-3 py-2 bg-white bg-opacity-75 rounded-end">
                                                <div class="text-muted small mb-1">Nombre d'enfants</div>
                                                <div class="fw-bold text-dark">

                                                    {{ count($user->candidate->childs) }} enfant(s)
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        @if (
                            $user->candidate->partner_technical_id ||
                                $user->candidate->partner_financial_id ||
                                $user->candidate->other_partner_financial)
                            <div class="border-top pt-4 mt-4">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-group text-warning fs-5 me-2"></i>
                                    <h5 class="mb-0 text-warning">Partenaires</h5>
                                </div>

                                <div class="row g-3">
                                    @if ($user->candidate->partner_technical_id)
                                        <div class="col-12">
                                            <div class=" rounded-3 p-3 bg-warning bg-opacity-10">
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-cog text-warning fs-5 me-2"></i>
                                                    <div>
                                                        <div class="text-muted small">Partenaire technique</div>
                                                        <div class="fw-bold text-dark">
                                                            {{ $user->candidate->partnerTechnical->user->username }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->candidate->partner_financial_id)
                                        <div class="col-12">
                                            <div class=" rounded-3 p-3 bg-success bg-opacity-10">
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-money text-success fs-5 me-2"></i>
                                                    <div>
                                                        <div class="text-muted small">Partenaire financier</div>
                                                        <div class="fw-bold text-dark">
                                                            {{ $user->candidate->partnerFinancial->user->username }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->candidate->other_partner_financial)
                                        <div class="col-12">
                                            <div class=" rounded-3 p-3 bg-info bg-opacity-10">
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-credit-card text-info fs-5 me-2"></i>
                                                    <div>
                                                        <div class="text-muted small">Source de financement</div>
                                                        <div class="fw-bold text-dark">
                                                            {{ $user->candidate->other_partner_financial }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if (can(
                                'chef-cellule-formation-et-insertion'))
                            <div class="border-top pt-4 mt-4">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-shield-quarter text-danger fs-5 me-2"></i>
                                    <h5 class="mb-0 text-danger">Actions Sensibles</h5>
                                </div>

                                <div class="row g-3">
                                    @if ($user->candidate->death != 1)
                                        <div class="col-12">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#deathModal"
                                                class="btn btn-danger w-100 fw-bold">
                                                <i class="bx bx-x-circle me-2"></i>
                                                DÉCLARER LE DÉCÈS
                                            </button>
                                        </div>
                                    @endif

                                    @if ($user->candidate->resignation != 1)
                                        <div class="col-12">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#resignationModal" class="btn btn-warning w-100 fw-bold">
                                                <i class="bx bx-log-out me-2"></i>
                                                DÉCLARER ABANDON
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-8 order-0 order-md-1">


                <ul class="nav nav-tabs mb-4" id="ex-with-icons" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a data-mdb-tab-init
                            class="nav-link {{ (Session::get('step') ?? 'profile') == 'profile' ? 'active' : '' }}"
                            id="ex-with-icons-tab-1" href="#ex-with-icons-tabs-1" role="tab"
                            aria-controls="ex-with-icons-tabs-1" aria-selected="true">
                            <i class="bx bx-user text-primary me-2"></i>
                            <span class="text-primary">Informations personnelles</span>
                        </a>
                    </li>


                    @if ($user->candidate->orientation === 'auto-emploi')
                        @if (count($user->candidate->participations) > 0)
                            <li class="nav-item" role="presentation">
                                <a data-mdb-tab-init class="nav-link" id="ex-with-icons-tab-2"
                                    href="#ex-with-icons-tabs-2" role="tab" aria-controls="ex-with-icons-tabs-2"
                                    aria-selected="true">
                                    <i class="bx bx-graduation text-success me-2"></i>
                                    <span class="text-success">Formations</span>
                                    <span
                                        class="badge bg-success ms-2">{{ count($user->candidate->participations) }}</span>

                                    @if ($user->candidate->dataCollect)
                                        <span class="text-muted mx-2">|</span>
                                        <i class="bx bx-data text-info me-1"></i>
                                        <span class="text-info small">Collecte de données</span>
                                    @endif

                                    @if ($user->candidate->pas)
                                        <span class="text-muted mx-2">|</span>
                                        <i class="bx bx-briefcase text-warning me-1"></i>
                                        <span class="text-warning small">Plans d'affaires</span>
                                        <span
                                            class="badge bg-warning text-dark ms-1">{{ count($user->candidate->pas) }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif

                        @if (
                            $user->candidate->selfEmploymentMonitoredPayment &&
                                count($user->candidate->selfEmploymentMonitoredPayment->disbursements) > 0)
                            <li class="nav-item" role="presentation">
                                <a data-mdb-tab-init class="nav-link" id="ex-with-icons-tab-3"
                                    href="#ex-with-icons-tabs-3" role="tab" aria-controls="ex-with-icons-tabs-3"
                                    aria-selected="true">
                                    <i class="bx bx-money text-primary me-2"></i>
                                    <span class="text-primary">Décaissements</span>
                                    <span
                                        class="badge bg-primary ms-2">{{ count($user->candidate->selfEmploymentMonitoredPayment->disbursements) }}</span>
                                </a>
                            </li>
                        @endif
                    @endif
                    
                    @if (!can('partner-financial'))

                        @if ($user->candidate->orientation === 'fonction-publique')
                            <li class="nav-item" role="presentation">
                                <a data-mdb-tab-init class="nav-link" href="#ex-with-icons-tabs-2" role="tab"
                                    aria-controls="ex-with-icons-tabs-2" aria-selected="true">
                                    <i class="bx bx-file-blank text-info me-2"></i>
                                    <span class="text-info">Suivi de dossiers</span>
                                </a>
                            </li>
                        @endif

                        @if ($user->candidate->orientation === 'entreprise-privee')
                            <li class="nav-item" role="presentation">
                                <a data-mdb-tab-init class="nav-link" href="#ex-with-icons-tabs-2" role="tab"
                                    aria-controls="ex-with-icons-tabs-2" aria-selected="true">
                                    <i class="bx bx-building text-secondary me-2"></i>
                                    <span class="text-secondary">Suivi de dossiers</span>
                                </a>
                            </li>
                        @endif
                    @endif

                        @if (count($user->candidate->reportsPostMonitored) > 0)
                            <li class="nav-item" role="presentation">
                                <a data-mdb-tab-init class="nav-link" id="ex-with-icons-tab-4"
                                    href="#ex-with-icons-tabs-4" role="tab" aria-controls="ex-with-icons-tabs-4"
                                    aria-selected="true">
                                    <i class="bx bx-chart-line text-warning me-2"></i>
                                    <span class="text-warning">
                                        @if ($user->candidate->orientation === 'auto-emploi')
                                            Rapports post-financement
                                        @else
                                            Rapports de suivi
                                        @endif
                                    </span>
                                    <span
                                        class="badge bg-warning text-dark ms-2">{{ count($user->candidate->reportsPostMonitored) }}</span>
                                </a>
                            </li>
                        @endif
                </ul>

                <div class="tab-content" id="ex-with-icons-content">

                    @include('dashboard.adherent.detail.detail')

                        @if ($user->candidate->orientation === 'auto-emploi')
                            @include('dashboard.adherent.detail.self-employment')
                        @endif

                    @if (!can('partner-financial'))
                        @if ($user->candidate->orientation === 'entreprise-privee')
                            @include('dashboard.adherent.detail.private-company')
                        @endif

                        @if ($user->candidate->orientation === 'fonction-publique')
                            @include('dashboard.adherent.detail.public-company')
                        @endif
                    @endif

                    @if (count($user->candidate->reportsPostMonitored) > 0)
                        <div class="tab-pane fade" id="ex-with-icons-tabs-4" role="tabpanel"
                            aria-labelledby="ex-with-icons-tab-4">
                            @include('partials.adherent.report', ['adherent' => $user->candidate])
                        </div>
                    @endif

                </div>



            </div>
        </div>
    </div>

    <div class="modal fade" id="deathModal" tabindex="-1" aria-labelledby="deathModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deathModalLabel">Déclaration du décès de l'adherent</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('adherent.death', $user->candidate->id) }}" method="post"
                    class="d-flex justify-content-center">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="death_date">Date de décès :</label>
                                <input type="date" id="death_date" name="death_date" max="{{ date('Y-m-d') }}"
                                    class="form-control" required />
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="death_no_act">Numéro de l'acte :</label>
                                <input type="text" id="death_no_act" name="death_no_act" class="form-control"
                                    required />
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="death_city">Lieu du décès :</label>
                                <input type="text" id="death_city" name="death_city" class="form-control" required />
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="death_justification">Numéro de l'acte :</label>
                                <textarea id="death_justification" name="death_justification" class="form-control" rows="5" required></textarea>
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-end" style="gap: 10px;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-danger">Enregistrer</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resignationModal" tabindex="-1" aria-labelledby="resignationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="resignationModalLabel">Déclaration d'abandon de l'adherent</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('adherent.resignation', $user->candidate->id) }}" method="post"
                    class="d-flex justify-content-center">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="resignation_date">Date de la demande :</label>
                                <input type="date" id="resignation_date" name="resignation_date"
                                    max="{{ date('Y-m-d') }}" class="form-control" required />
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="resignation_justification">Pièce justificatif :</label>
                                <input type="file" id="resignation_justification" name="resignation_justification"
                                    class="form-control" required />
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-end" style="gap: 10px;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-danger">Enregistrer</button>
                        </div>
                    </div>

                </form>
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

    <script type="text/javascript" src="{{ asset('assets/js/mdb.umd.min.js') }}"></script>
@endsection
