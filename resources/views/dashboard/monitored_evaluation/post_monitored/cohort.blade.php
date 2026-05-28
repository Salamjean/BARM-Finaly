@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush
    
    <div class="container-fluid">
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-search-alt text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Suivi-Évaluation / Post-Suivi / Cohorte</div>
                            <h4 class="mb-0 text-primary">{{ $cohort->reference }}</h4>
                            <small class="text-muted">{{ $cohort->title }}</small>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-chart-line text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Post-suivi de la cohorte</h5>
                        <small class="text-muted">Évaluation des projets post-formation</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $adherents->count() }}
                        </div>
                        <small class="text-muted d-block">Adhérents</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $adherents->sum(function($adherent) { return count($adherent->reportsPostMonitored); }) }}
                        </div>
                        <small class="text-muted d-block">Rapports</small>
                    </div>
                </div>
            </div>
        </div>

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
                                    <i class="bx bx-file-doc text-primary me-1"></i>
                                    Partenaire Technique
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-file-doc text-primary me-1"></i>
                                    Titre du projet
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-file-text text-primary me-1"></i>
                                    Nombre de rapports
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adherents as $index => $adherent)
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="fw-medium text-warning" title="{{ $adherent->partnerTechnical->user->username }}">
                                                {{ Str::limit($adherent->partnerTechnical->user->username, 40) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="fw-medium text-info" title="{{ $adherent->paAccepted->title }}">
                                                {{ Str::limit($adherent->paAccepted->title, 40) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $adherent->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-secondary me-1">{{ $adherent->user->mecano }}</span>
                                                    <span>{{ $adherent->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @php
                                                if(can('partner-financial'))
                                                $reportCount = count($adherent->reportsPostMonitored->where('created_by', auth()->user()->id));
                                                else
                                                $reportCount =  count($adherent->reportsPostMonitored);
                                                $badgeClass = $reportCount >= 3 ? 'bg-success' : ($reportCount >= 1 ? 'bg-warning' : 'bg-secondary');
                                            @endphp
                                            <span class="badge {{ $badgeClass }} fs-6">
                                                {{ $reportCount }}
                                            </span>
                                            @if($reportCount > 0)
                                                <small class="text-muted d-block">
                                                    Rapport(s)
                                                </small>
                                            @else
                                                <small class="text-muted d-block">Aucun rapport</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $adherent->user->id) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a href="{{ route('monitored-evaluation.post_monitored.adherent', $adherent->id) }}" 
                                               class="btn btn-primary btn-sm"
                                               title="Voir plus de détails">
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

    @push('js-push')
        <script>
            $(document).ready(function() {
                // Initialisation des tooltips si nécessaire
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            });
        </script>
    @endpush
@endsection