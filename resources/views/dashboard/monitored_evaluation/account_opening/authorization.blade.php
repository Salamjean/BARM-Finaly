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
                        <i class="bx bx-credit-card text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Suivi-Évaluation / Ouverture de compte</div>
                            <h4 class="mb-0 text-primary">Cohortes</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-chart text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Suivi des ouvertures de comptes</h5>
                        <small class="text-muted">Progression par cohorte</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $cohorts->count() }}
                        </div>
                        <small class="text-muted d-block">Cohortes</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $cohorts->sum('adherents_account_opening_pending') }}
                        </div>
                        <small class="text-muted d-block">En attente</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des cohortes -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th class="border-0">
                                    <i class="bx bx-hash text-primary me-1"></i>
                                    Référence
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-bookmark text-primary me-1"></i>
                                    Libellé
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-group text-primary me-1"></i>
                                    Nombre d'adhérents
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-credit-card text-primary me-1"></i>
                                    Ouverture de compte
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cohorts as $cohort)
                                
                                <tr class="align-middle">
                                    <td>
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="fw-bold text-info">{{ $cohort->reference }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $cohort->title }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-medium">
                                                    <span class="badge bg-success fs-6">{{ $cohort->adhrents->count() }}</span>
                                                    <span class="text-muted mx-1">/</span>
                                                    <span class="badge bg-warning fs-6">{{ $cohort->number_adherent }}</span>
                                                </div>
                                                <small class="text-muted">Inscrits / Capacité</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <span class="badge bg-success">{{ $cohort->adherents_authorization_approved }}</span>
                                                <span class="text-muted small">terminés</span>
                                                <span class="badge bg-warning">{{ $cohort->adherents_authorization_approved_pending }}</span>
                                                <span class="text-muted small">en attente</span>
                                            </div>
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('monitored-evaluation.account_opening.cohort.authorization', $cohort->id) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Voir les détails">
                                                <i class="bx bx-show me-1"></i>
                                                Voir détails
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
@endsection