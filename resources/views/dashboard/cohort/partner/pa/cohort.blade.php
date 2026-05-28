@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Plan d'affaire / </span> Cohorte
                    </h4>
                </nav>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-group text-primary fs-3 me-3"></i>
                    <div>
                        <h4 class="mb-0 text-primary"> {{ $cohort->title }}</h4>
                        <p class="text-muted mb-0">Liste des plans d'affaire</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-primary fs-6 px-3 py-2">
                            {{ $adherents->count() }}
                        </div>
                        <div class="small text-muted">Total candidats</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3 shadow-none">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th class="border-0">
                                    <i class="bx bx-hash text-primary me-1"></i>
                                </th>
                                
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Candidat
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-briefcase text-primary me-1"></i>
                                    Spécialisation
                                </th>
                                
                                <th class="border-0 text-center">
                                    <i class="bx bx-info-circle text-primary me-1"></i>
                                    Statut
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-money text-primary me-1"></i>
                                    Financement
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adherents as $adhrent)
                                <tr class="align-middle">
                                    <td>
                                        <div class="fw-bold text-dark">{{ $loop->index + 1 }}</div>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $adhrent->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-secondary me-1">{{ $adhrent->user->mecano }}</span>
                                                    <span>{{ $adhrent->phone_number ?? '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-warning border-3 ps-2 py-1">
                                            <div class="fw-medium text-warning">{{ $adhrent->choiceFinal->specialisation }}</div>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        @if($adhrent->pa_status == 'En cours')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bx bx-time me-1"></i>
                                                En cours
                                            </span>
                                        @elseif($adhrent->pa_status == 'Validé')
                                            <span class="badge bg-success">
                                                <i class="bx bx-check me-1"></i>
                                                Validé
                                            </span>
                                        @elseif($adhrent->pa_status == 'Rejeté')
                                            <span class="badge bg-danger">
                                                <i class="bx bx-x me-1"></i>
                                                Rejeté
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="bx bx-minus me-1"></i>
                                                {{ $adhrent->pa_status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="border-start border-success border-3 ps-2 py-1">
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-money text-success me-2"></i>
                                                <div>
                                                    <div class="fw-medium text-success">
                                                        {{ $adhrent->partner_financial_id ? $adhrent->partnerFinancial->user->username : $adhrent->other_partner_financial }}
                                                    </div>
                                                    <div class="small text-muted">Partenaire financier</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ asset($adhrent->pa_file) }}" 
                                               class="btn btn-outline-info btn-sm" 
                                               title="Télécharger le PA"
                                               download>
                                                <i class="bx bx-download"></i>
                                            </a>
                                            <a href="{{ route('adherent.show', $adhrent->user->id) }}" 
                                               class="btn btn-outline-primary btn-sm"
                                               title="Voir le profil">
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

    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05) !important;
        }
        
        .border-start.border-primary {
            border-left-color: #0d6efd !important;
        }
        
        .border-start.border-warning {
            border-left-color: #ffc107 !important;
        }
        
        .border-start.border-success {
            border-left-color: #198754 !important;
        }
        
        .border-start.border-info {
            border-left-color: #0dcaf0 !important;
        }
        
        .border-start.border-danger {
            border-left-color: #dc3545 !important;
        }
    </style>

    @push('js-push')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialisation des tooltips Bootstrap
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
    @endpush
@endsection
