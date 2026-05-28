@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush

    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-money text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Suivi-Évaluation / Décaissement / Cohorte</div>
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
                    <i class="bx bx-credit-card text-warning fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Décaissements de la cohorte</h5>
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
                        <small class="text-muted d-block">Terminés</small>
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
                        <button class="nav-link d-flex align-items-center justify-content-center" id="completed-tab"
                            data-bs-toggle="pill" data-bs-target="#completed" type="button" role="tab"
                            aria-controls="completed" aria-selected="false">
                            <i class="bx bx-check-circle me-2"></i>
                            Terminés
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
                <div class="bg-white rounded-3 shadow-sm">
                    <div class="p-4">
                        <div class="table-responsive">
                            <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="border-0">
                                            <i class="bx bx-user text-primary me-1"></i>
                                            Nom & Prénoms
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-briefcase text-primary me-1"></i>
                                            Partenaire Technique
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-file-doc text-primary me-1"></i>
                                            Titre du projet
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-map text-primary me-1"></i>
                                            Adresse géographique
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-building text-primary me-1"></i>
                                            Agence
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-money text-primary me-1"></i>
                                            Montant accordé
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-calculator text-primary me-1"></i>
                                            10%
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-calendar text-primary me-1"></i>
                                            Mois différés
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-time text-primary me-1"></i>
                                            Durée du prêt
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-user-check text-primary me-1"></i>
                                            Pensionnaire
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-user-check text-primary me-1"></i>
                                            Pension domeciliée au FIDRA
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-hash text-primary me-1"></i>
                                            Nb D
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-check-circle text-primary me-1"></i>
                                            Statut
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-cog text-primary me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($adherents_pending as $adherent)
                                        <tr class="align-middle">
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
                                                    <div class="fw-medium text-info"
                                                        title="{{ $adherent->partnerTechnical->user->username }}">
                                                        {{ $adherent->partnerTechnical->user->username }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="border-start border-info border-3 ps-2 py-1">
                                                    <div class="fw-medium text-info"
                                                        title="{{ $adherent->paAccepted->title }}">
                                                        {{ Str::limit($adherent->paAccepted->title, 30) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-map-pin text-warning fs-5 me-2"></i>
                                                    <div class="fw-medium">{{ $adherent->paAccepted->location }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="border-start border-secondary border-3 ps-2 py-1">
                                                    <div class="fw-medium text-secondary">
                                                        {{ $adherent->creditCommittee->agency }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <div class="fw-bold text-success fs-6">
                                                        {{ amount($adherent->creditCommittee->amount_agreed) }}
                                                    </div>
                                                    <small class="text-muted">FCFA</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <div class="fw-medium text-warning">
                                                        {{ amount($adherent->creditCommittee->amount_agreed * 0.1) }}
                                                    </div>
                                                    <small class="text-muted">FCFA</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <span class="badge bg-info fs-6">
                                                        {{ $adherent->creditCommittee->deferred_months }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <span class="badge bg-primary fs-6">
                                                        {{ $adherent->creditCommittee->loan_duration }}
                                                    </span>
                                                    <small class="text-muted d-block">mois</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    @if ($adherent->creditCommittee->pension)
                                                        <span class="badge bg-success">
                                                            <i class="bx bx-check me-1"></i>Oui
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">
                                                            <i class="bx bx-x me-1"></i>Non
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    @if ($adherent->creditCommittee->pension_partner_financial)
                                                        <span class="badge bg-success">
                                                            <i class="bx bx-check me-1"></i>Oui
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">
                                                            <i class="bx bx-x me-1"></i>Non
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <span class="badge bg-warning fs-6">
                                                        {{ count($adherent->selfEmploymentMonitoredPayment->disbursements) }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $status =
                                                        $adherent->selfEmploymentMonitoredPayment->status_disbursement;
                                                @endphp
                                                @if (in_array($status, ['init']))
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-secondary rounded-circle me-2"
                                                            style="width: 8px; height: 8px;"></div>
                                                        <span class="badge bg-secondary">En attente</span>
                                                    </div>
                                                @elseif ($status == 'pending')
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-warning rounded-circle me-2"
                                                            style="width: 8px; height: 8px;"></div>
                                                        <span class="badge bg-warning">En validation</span>
                                                    </div>
                                                @elseif ($status == 'approved')
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-info rounded-circle me-2"
                                                            style="width: 8px; height: 8px;"></div>
                                                        <span class="badge bg-info">En cours</span>
                                                    </div>
                                                @else
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-danger rounded-circle me-2"
                                                            style="width: 8px; height: 8px;"></div>
                                                        <span class="badge bg-danger">Annulé</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('adherent.show', $adherent->user->id) }}"
                                                        class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('monitored-evaluation.disbursement.adherent', $adherent->id) }}"
                                                        class="btn btn-primary btn-sm" title="Voir plus de détails">
                                                        <i class="bx bx-detail me-1"></i>
                                                        Détails
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

            <!-- Onglet Terminés -->
            <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                <div class="bg-white rounded-3 shadow-sm">
                    <div class="p-4">
                        <div class="table-responsive">
                            <table class="dt-responsive table table-hover" id="datatable--barm2" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="border-0">
                                            <i class="bx bx-user text-primary me-1"></i>
                                            Nom & Prénoms
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-briefcase text-primary me-1"></i>
                                            Partenaire Technique
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-file-doc text-primary me-1"></i>
                                            Titre du projet
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-map text-primary me-1"></i>
                                            Adresse géographique
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-building text-primary me-1"></i>
                                            Agence
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-money text-primary me-1"></i>
                                            Montant accordé
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-calculator text-primary me-1"></i>
                                            10%
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-calendar text-primary me-1"></i>
                                            Mois différés
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-time text-primary me-1"></i>
                                            Durée du prêt
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-user-check text-primary me-1"></i>
                                            Pensionnaire
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-user-check text-primary me-1"></i>
                                            Pension domeciliée au FIDRA
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-hash text-primary me-1"></i>
                                            Nb décaissements
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-cog text-primary me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($adherents_approuved as $adherent)
                                        <tr class="align-middle">
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
                                                    <div class="fw-medium text-info"
                                                        title="{{ $adherent->partnerTechnical->user->username }}">
                                                        {{ $adherent->partnerTechnical->user->username }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="border-start border-info border-3 ps-2 py-1">
                                                    <div class="fw-medium text-info"
                                                        title="{{ $adherent->paAccepted->title }}">
                                                        {{ Str::limit($adherent->paAccepted->title, 30) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-map-pin text-warning fs-5 me-2"></i>
                                                    <div class="fw-medium">{{ $adherent->paAccepted->location }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="border-start border-secondary border-3 ps-2 py-1">
                                                    <div class="fw-medium text-secondary">
                                                        {{ $adherent->creditCommittee->agency }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <div class="fw-bold text-success fs-6">
                                                        {{ amount($adherent->creditCommittee->amount_agreed) }}
                                                    </div>
                                                    <small class="text-muted">FCFA</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <div class="fw-medium text-warning">
                                                        {{ amount($adherent->creditCommittee->amount_agreed * 0.1) }}
                                                    </div>
                                                    <small class="text-muted">FCFA</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <span class="badge bg-info fs-6">
                                                        {{ $adherent->creditCommittee->deferred_months }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <span class="badge bg-primary fs-6">
                                                        {{ $adherent->creditCommittee->loan_duration }}
                                                    </span>
                                                    <small class="text-muted d-block">mois</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    @if ($adherent->pensionnaire_cgrae == 'Oui')
                                                        <span class="badge bg-success">
                                                            <i class="bx bx-check me-1"></i>Oui
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">
                                                            <i class="bx bx-x me-1"></i>Non
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    @if ($adherent->creditCommittee->pension_partner_financial)
                                                        <span class="badge bg-success">
                                                            <i class="bx bx-check me-1"></i>Oui
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">
                                                            <i class="bx bx-x me-1"></i>Non
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <span class="badge bg-success fs-6">
                                                        {{ count($adherent->selfEmploymentMonitoredPayment->disbursements) }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('adherent.show', $adherent->user->id) }}"
                                                        class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('monitored-evaluation.disbursement.adherent', $adherent->id) }}"
                                                        class="btn btn-primary btn-sm" title="Voir plus de détails">
                                                        <i class="bx bx-detail me-1"></i>
                                                        Détails
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

    @push('js-push')
        <script>
            $(document).ready(function() {
                // Initialisation des tooltips si nécessaire
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            });
        </script>
    @endpush
@endsection
