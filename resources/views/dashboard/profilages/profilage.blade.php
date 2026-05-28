@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-group text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Profilages</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-layer-group text-info fs-3 me-3"></i>
                    <div>
                        <h4 class="mb-0 text-info">Liste des cohortes</h4>

                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $cohorts->sum(function ($cohort) {return $cohort->adhrents->count();}) }}
                        </div>
                        <div class="text-muted small">Adhérents</div>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $cohorts->sum('number_adherent') }}
                        </div>
                        <div class="text-muted small">Capacité total</div>
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
                                    Référence
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-bookmark text-primary me-1"></i>
                                    Libellé
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-users text-primary me-1"></i>
                                    Adhérents
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cohorts as $index => $cohort)
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                            <div>
                                                <div class="fw-bold text-primary">{{ $cohort->reference }}</div>
                                                <small class="text-muted">Code cohorte</small>
                                            </div>
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
                                        <div>
                                            <div class="fw-medium">
                                                <span class="badge bg-success fs-6">{{ $cohort->adhrents->count() }}</span>
                                                <span class="text-muted mx-1">/</span>
                                                <span class="badge bg-warning fs-6">{{ $cohort->number_adherent }}</span>
                                            </div>
                                            <small class="text-muted">Inscrits / Capacité</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            @if (can('conseiller-auto-emploi|point-focal'))
                                                <a href="{{ route('profilage.candidat_profilage', $cohort->id) }}"
                                                    class="btn btn-outline-info btn-sm" title="Candidats à profiler">
                                                    À profiler
                                                </a>
                                            @endif
                                            <a href="{{ route('profilage.end_candidat_profile', $cohort->id) }}"
                                                class="btn btn-outline-warning btn-sm" title="Candidats profilés">
                                                Profilés
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

    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush
@endsection
