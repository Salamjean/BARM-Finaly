@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
        <style>
            .avatarr {
                width: 150px !important;
                height: 150px !important;
            }
        </style>
    @endpush

    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-line-chart text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Suivi-Évaluation / Post-Suivi</div>
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
                    <i class="bx bx-chart-line-up text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Suivi post-formation des adhérents</h5>
                        <small class="text-muted">Évaluation et suivi après placement professionnel</small>
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
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $adherents->sum(function ($a) {return count($a->reportsPostMonitored);}) }}
                        </div>
                        <small class="text-muted d-block">Rapports</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des adhérents -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nom & Prénoms</th>
                                <th>Spécialisation</th>
                                <th>Lieu d'affectation</th>
                                <th class="text-center">Nombre de rapports</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adherents as $adhrent)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $adhrent->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span
                                                        class="badge bg-secondary me-1">{{ $adhrent->user->mecano }}</span>
                                                    <span>{{ $adhrent->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($adhrent->choiceFinal)
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-graduation text-primary me-2"></i>
                                                <span>{{ $adhrent->choiceFinal->specialisation }}</span>
                                            </div>
                                        @elseif ($adhrent->poste)
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-briefcase text-success me-2"></i>
                                                <span>{{ $adhrent->poste->poste }} chez
                                                    {{ $adhrent->poste->entreprise }}</span>
                                            </div>
                                        @elseif ($adhrent->candidatadmi)
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-trophy text-warning me-2"></i>
                                                <span>{{ $adhrent->candidatadmi->intitule_concours }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        @if ($adhrent->affectation)
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-map text-info me-2"></i>
                                                <span>{{ $adhrent->affectation }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">Non renseigné</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
                                        @php
                                            $reportCount = count($adhrent->reportsPostMonitored);
                                            $badgeClass = $reportCount > 0 ? 'bg-success' : 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} fs-6">{{ $reportCount }}</span>
                                        @if ($reportCount > 0)
                                            <small class="text-muted d-block">
                                                @if ($reportCount === 1)
                                                    Rapport disponible
                                                @else
                                                    Rapports disponibles
                                                @endif
                                            </small>
                                        @else
                                            <small class="text-muted d-block">Aucun rapport</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $adhrent->user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('monitored-evaluation.post_monitored.adherent', $adhrent->id) }}"
                                                title="Voir les rapports">
                                                <i class="bx bx-file-find me-1"></i>
                                                Voir plus
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
                // Scripts spécifiques à cette page si nécessaire
            });
        </script>
    @endpush
@endsection
