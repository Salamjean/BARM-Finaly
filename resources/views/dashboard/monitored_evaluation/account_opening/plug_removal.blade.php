@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
        <style>
            .avatarr {
                width: 120px !important;
                height: 120px !important;
            }

            .adherent-card {
                transition: transform 0.2s ease-in-out;
            }

            .adherent-card:hover {
                transform: translateY(-2px);
            }
        </style>
    @endpush

    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-credit-card text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Suivi-Évaluation / Ouverture de compte / Cohorte</div>
                            <h4 class="mb-0 text-primary">{{ $cohort->reference }}</h4>
                            <small class="text-muted">{{ $cohort->title }}</small>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec statistiques -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-chart text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Ouvertures de comptes</h5>
                        <small class="text-muted">Suivi détaillé par adhérent</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ count($adherents_pending) }}
                        </div>
                        <small class="text-muted d-block">En attente</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ count($adherents_approuved) }}
                        </div>
                        <small class="text-muted d-block">Approuvés</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglets modernisés -->
        <div class="bg-white rounded-3 shadow-sm mb-4">
            <div class="p-4">
                <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active d-flex align-items-center justify-content-center" id="pending-tab"
                            data-bs-toggle="pill" data-bs-target="#pending" type="button" role="tab"
                            aria-controls="pending" aria-selected="true">
                            <i class="bx bx-time-five me-2"></i>
                            En attente
                            <span class="badge bg-warning ms-2">{{ count($adherents_pending) }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center justify-content-center" id="approved-tab"
                            data-bs-toggle="pill" data-bs-target="#approved" type="button" role="tab"
                            aria-controls="approved" aria-selected="false">
                            <i class="bx bx-check-circle me-2"></i>
                            Approuvés
                            <span class="badge bg-success ms-2">{{ count($adherents_approuved) }}</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Contenu des onglets -->
        <div class="tab-content" id="myTabContent">
            <!-- Onglet En attente -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                <!-- Barre de recherche -->
                <div class="bg-white p-4 rounded-3 shadow-sm mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bx bx-search"></i>
                                </span>
                                <input type="text" id="searchMecano" class="form-control"
                                    placeholder="Rechercher par Mecano">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cartes des adhérents en attente -->
                <div class="row" id="adherentsPendingList">
                    @foreach ($adherents_pending as $key => $adherent)
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-4 adherent-item">
                            <div class="card h-100 adherent-card shadow-sm">
                                <div class="card-body position-relative">
                                    <!-- Actions en haut à droite -->
                                    <div class="position-absolute top-0 end-0 p-3">
                                        <div class="d-flex flex-column gap-2">
                                            @if (!$adherent->imputation)
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#imputationModal" data-id="{{ $adherent->id }}"
                                                    title="Ajouter complément">
                                                    <i class="bx bx-plus"></i>
                                                </button>
                                            @else
                                                <a href="{{ route('monitored-evaluation.account_opening.file', $adherent->id) }}"
                                                    target="_blank" class="btn btn-outline-danger btn-sm"
                                                    title="Voir le PDF">
                                                    <i class="bx bx-file"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('adherent.show', $adherent->user->id) }}" target="_blank"
                                                class="btn btn-outline-info btn-sm" title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Avatar et nom -->
                                    <div class="text-center mb-4">
                                        <img class="img-fluid rounded-circle avatarr mb-3"
                                            src="{{ $adherent->image ? asset($adherent->image) : asset('default-avatar.png') }}"
                                            alt="Avatar" />
                                        <h6 class="fw-bold text-dark">{{ $adherent->user->fullName() }}</h6>
                                        <span
                                            class="badge bg-secondary adherent-mecano">{{ $adherent->user->mecano }}</span>
                                    </div>

                                    <!-- Informations -->
                                    <div class="border-top pt-3">
                                        @if ($adherent->phone_number)
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-phone text-primary me-2"></i>
                                                    <small class="text-muted">Téléphone</small>
                                                </div>
                                                <div class="fw-medium">{{ $adherent->phone_number }}</div>
                                            </div>
                                        @endif

                                        @if ($adherent->partner_technical_id)
                                            <div class="mb-3 p-2 border border-primary rounded">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="bx bx-briefcase text-primary me-2"></i>
                                                    <small class="text-muted">Partenaire technique</small>
                                                </div>
                                                <div class="fw-medium">{{ $adherent->partnerTechnical->user->username }}
                                                </div>
                                            </div>
                                        @endif

                                        @if ($adherent->partner_financial_id)
                                            <div class="mb-3 p-2 border border-secondary rounded">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="bx bx-credit-card text-secondary me-2"></i>
                                                    <small class="text-muted">Partenaire financier</small>
                                                </div>
                                                <div class="fw-medium">{{ $adherent->partnerFinancial->user->username }}
                                                </div>
                                            </div>
                                        @endif

                                        @if ($adherent->paAccepted)
                                            <div class="mb-3 p-2 border border-info rounded">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bx bx-file-doc text-info me-2"></i>
                                                    <small class="text-muted fw-bold">Plan d'affaire</small>
                                                </div>
                                                <div class="small mb-1">
                                                    <strong>Projet:</strong> {{ $adherent->paAccepted->title }}
                                                </div>
                                                <div class="small">
                                                    <strong>Montant:</strong> {{ amount($adherent->paAccepted->amount) }}
                                                    {{ DEVICE }}
                                                </div>
                                            </div>
                                        @endif

                                        @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi') && $adherent->imputation)
                                            <div class="border-top pt-3">
                                                <form class="formSubmit"
                                                    action="{{ route('monitored-evaluation.account_opening.approved_account_opening', $adherent->selfEmploymentMonitoredPayment->id) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="date{{ $key }}" class="form-label small">
                                                            <i class="bx bx-calendar text-primary me-1"></i>
                                                            Date de retrait <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="datetime-local" class="form-control form-control-sm"
                                                            id="date{{ $key }}" name="date" required />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="file{{ $key }}" class="form-label small">
                                                            <i class="bx bx-file text-primary me-1"></i>
                                                            Fiche d'ouverture <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="file" class="form-control form-control-sm"
                                                            name="file" accept=".pdf" required />
                                                    </div>
                                                    <button type="submit" class="btn btn-success btn-sm w-100">
                                                        <i class="bx bx-check me-1"></i>
                                                        Valider
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Onglet Approuvés -->
            <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                <div class="bg-white rounded-3 shadow-sm">
                    <div class="p-4">
                        <div class="table-responsive">
                            <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="border-0">
                                            <i class="bx bx-hash text-primary me-1"></i>
                                        </th>
                                        <th class="border-0">
                                            <i class=" text-primary me-1"></i>
                                            Partenaire Technique
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-user text-primary me-1"></i>
                                            Nom & Prénoms
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-file-doc text-primary me-1"></i>
                                            Titre du projet
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-credit-card text-primary me-1"></i>
                                            Moyen de financement
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-cog text-primary me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($adherents_approuved as $index => $adherent)
                                        <tr class="align-middle">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-success me-2">{{ $index + 1 }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="border-start border-info border-3 ps-2 py-1">
                                                    <div class="fw-medium text-warning"
                                                        title="{{ $adherent->partnerTechnical->user->username }}">
                                                        {{ Str::limit($adherent->partnerTechnical->user->username, 40) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $adherent->user->fullName() }}
                                                        </div>
                                                        <div class="small text-muted">
                                                            <span
                                                                class="badge bg-secondary me-1">{{ $adherent->user->mecano }}</span>
                                                            <span>{{ $adherent->phone_number }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="border-start border-info border-3 ps-2 py-1">
                                                    <div class="fw-medium text-info">{{ $adherent->paAccepted->title }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="border-start border-primary border-3 ps-2 py-1">
                                                    <div class="fw-medium text-primary">
                                                        {{ $adherent->partner_financial_id ? $adherent->partnerFinancial->user->username : $adherent->other_partner_financial }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('adherent.show', $adherent->user->id) }}"
                                                        class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'imputation -->
    <div class="modal fade" id="imputationModal" tabindex="-1" aria-labelledby="imputationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="imputationModalLabel">
                        <i class="bx bx-plus-circle me-2"></i>
                        Renseigner l'imputation
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="imputationForm" method="POST"
                        action="{{ route('monitored-evaluation.account_opening.imputation') }}">
                        @csrf
                        <input type="hidden" name="adherent_id" id="adherentId" />
                        <div class="mb-3">
                            <label for="imputation" class="form-label">
                                <i class="bx bx-text me-1"></i>
                                Imputation <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="imputation" name="imputation" required>
                        </div>
                        <div class="mb-3">
                            <label for="pensionnaire_cgrae" class="form-label">
                                <i class="bx bx-user me-1"></i>
                                Pensionnaire CGREAE <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="pensionnaire_cgrae" id="pensionnaire_cgrae" required>
                                <option value="Non">Non</option>
                                <option value="Oui">Oui</option>
                            </select>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x me-1"></i>
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i>
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#imputationModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var adherentId = button.data('id');
                    $('#adherentId').val(adherentId);
                });

                $('#searchMecano').on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    $('.adherent-item').filter(function() {
                        $(this).toggle($(this).find('.adherent-mecano').text().toLowerCase().indexOf(
                            value) > -1)
                    });
                });

                $('.formSubmit').submit(function(e) {
                    e.preventDefault();
                    var form = this;

                    Swal.fire({
                        title: 'Veuillez confirmer le retrait de la fiche',
                        icon: 'warning',
                        iconColor: '#E68200',
                        showCancelButton: true,
                        confirmButtonColor: '#6900AF',
                        cancelButtonColor: '#363636',
                        confirmButtonText: 'Confirmer',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let timerInterval
                            Swal.fire({
                                title: 'Chargement...',
                                timer: 1500,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                },
                                willClose: () => {
                                    form.submit();
                                    clearInterval(timerInterval)
                                }
                            })
                        }
                    })
                });
            });
        </script>
    @endpush
@endsection
