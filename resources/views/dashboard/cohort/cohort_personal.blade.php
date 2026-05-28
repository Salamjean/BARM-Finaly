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
                        <i class="bx bx-layer-plus text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Gestion des groupes</div>
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
                    <i class="bx bx-group text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Cohortes de formation</h5>
                        <small class="text-muted">Gestion et suivi des groupes d'adhérents</small>
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
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $cohorts->where('status', '1')->count() }}
                        </div>
                        <small class="text-muted d-block">Terminées</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $cohorts->where('status', '0')->count() }}
                        </div>
                        <small class="text-muted d-block">En cours</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des cohortes -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Référence</th>
                                <th>Libellé</th>
                                <th class="text-center">Nombre d'adhérents</th>
                                <th>Statut</th>
                                <th>Actions</th>
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
                                                <small class="text-muted">Créé le
                                                    {{ $cohort->created_at->format('d/m/Y') ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-medium">
                                                    <span
                                                        class="badge bg-success fs-6">{{ $cohort->adhrents->count() }}</span>
                                                    <span class="text-muted mx-1">/</span>
                                                    <span
                                                        class="badge bg-warning fs-6">{{ $cohort->number_adherent }}</span>
                                                </div>
                                                <small class="text-muted">Inscrits / Capacité</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($cohort->status == '0')
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning rounded-circle me-2"
                                                    style="width: 8px; height: 8px;"></div>
                                                <span class="badge bg-warning">En cours</span>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success rounded-circle me-2"
                                                    style="width: 8px; height: 8px;"></div>
                                                <span class="badge bg-success">Terminé</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="">
                                        <a href="{{ route('cohort.show.personal.training', $cohort->id) }}"
                                            class="btn btn-primary btn-sm" title="Voir les détails de la cohorte">
                                            <i class="bx bx-show me-1"></i>
                                            Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($cohorts->isEmpty())
                    <div class="text-center py-5">
                        <i class="bx bx-layer-plus fs-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Aucune cohorte</h5>
                        <p class="text-muted">Aucune cohorte n'a encore été créée.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
