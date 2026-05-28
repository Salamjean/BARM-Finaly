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
                        <i class="bx bx-file-blank text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Plan d'affaire / Cohortes</div>
                            <h4 class="mb-0 text-primary">Liste des cohortes</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-group text-primary fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Gestion des plans d'affaire</h5>
                        <small class="text-muted">Suivi des cohortes par partenaire technique</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-primary fs-6 px-3 py-2">
                            {{ $cohorts->count() }}
                        </div>
                        <small class="text-muted d-block">Cohortes</small>
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
                                    <i class="bx bx-info-circle text-primary me-1"></i>
                                    Statut
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
                                                <small class="text-muted">Cohorte</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-medium">
                                                    <span class="badge bg-success fs-6">
                                                        {{ $cohort->adhrents->where('partner_technical_id', auth()->user()->partenaire->id)->count() }}
                                                    </span>
                                                </div>
                                                <small class="text-muted">Adhérents assignés</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($cohort->status == '0')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bx bx-time me-1"></i>
                                                En cours
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="bx bx-check me-1"></i>
                                                Terminée
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('cohort.pa.cohort', $cohort->id) }}" 
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

    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05) !important;
        }
        
        .border-start.border-primary {
            border-left-color: #0d6efd !important;
        }
        
        .border-start.border-info {
            border-left-color: #0dcaf0 !important;
        }
        
        .border-start.border-warning {
            border-left-color: #ffc107 !important;
        }
        
        .border-start.border-success {
            border-left-color: #198754 !important;
        }
    </style>
@endsection
