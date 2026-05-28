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
                        <i class="bx bx-group text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Cohortes</div>
                            <h4 class="mb-0 text-primary">Liste</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec bouton d'action -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-bookmark text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Gestion des cohortes</h5>
                        <small class="text-muted">Organisez vos groupes d'adhérents</small>
                    </div>
                </div>
                @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                    <a href="{{ route('cohort.create') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="bx bx-plus me-2"></i>
                        Ajouter une cohorte
                    </a>
                @endif
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
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('cohort.show', $cohort->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir les détails">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                                                <a href="{{ route('cohort.edit', $cohort->id) }}"
                                                    class="btn btn-outline-warning btn-sm" title="Modifier">
                                                    <i class="bx bx-edit"></i>
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
