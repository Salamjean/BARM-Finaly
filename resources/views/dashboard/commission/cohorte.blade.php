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
                        <i class="bx bx-briefcase text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Commissions</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-star text-warning fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Gestion des commissions</h5>
                        <small class="text-muted">Suivi des cohortes et commissions d'évaluation</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $cohorts->count() }}
                        </div>
                        <small class="text-muted d-block">Cohortes</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des commissions -->
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
                                    <i class="bx bx-chart text-primary me-1"></i>
                                    Adhérents
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-briefcase text-primary me-1"></i>
                                    Nombre
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cohorts as $cohort)
                                @php
                                    $percentage = $cohort->number_adherent > 0 ? 
                                        round(($cohort->adhrents->count() / $cohort->number_adherent) * 100) : 0;
                                    $progressClass = $percentage >= 80 ? 'bg-success' : ($percentage >= 50 ? 'bg-warning' : 'bg-info');
                                @endphp
                                <tr class="align-middle">
                                    <td>
                                        <div class="border-start border-secondary border-3 ps-2 py-1">
                                            <div class="fw-bold text-secondary">{{ $cohort->reference }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                           
                                            <div>
                                                <div class="fw-bold text-dark">{{ $cohort->title }}</div>
                                                <small class="text-muted">Créé le {{ $cohort->created_at->format('d/m/Y') ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
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
                                        <div class="d-flex align-items-center">
                                           
                                            <div>
                                                <div class="fw-bold text-dark">{{ count($cohort->commissions) }}</div>
                                                <small class="text-muted">Commissions organisées</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if (can('partner-financial|partner-technical'))
                                                <a href="{{ route('commissions.commissionpartner', $cohort->id) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="Voir les commissions">
                                                    <i class="bx bx-show me-1"></i>
                                                    Voir commissions
                                                </a>
                                            @else
                                                <a href="{{ route('commissions.index', $cohort->id) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="Voir les commissions">
                                                    <i class="bx bx-show me-1"></i>
                                                    Voir commissions
                                                </a>
                                            @endif
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