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
                        <i class="bx bx-file-plus text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Gestion des candidatures</div>
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
                    <i class="bx bx-folder-plus text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Soumissions de dossiers de candidature</h5>
                        <small class="text-muted">Suivi des dépôts de dossiers par candidat</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $candidats->count() }}
                        </div>
                        <small class="text-muted d-block">Candidats</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $candidats->sum(function ($c) {return $c->soumissiondossiers()->count();}) }}
                        </div>
                        <small class="text-muted d-block">Dossiers</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $candidats->filter(function ($c) {return $c->soumissiondossiers()->count() > 0;})->count() }}
                        </div>
                        <small class="text-muted d-block">Avec dossiers</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des candidats -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nom & Prénoms</th>
                                <th>Nombre de dossiers</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidats as $candidat)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $candidat->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span
                                                        class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>
                                                    <span>{{ $candidat->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $dossierCount = $candidat->soumissiondossiers()->count();
                                            $badgeClass = $dossierCount > 0 ? 'bg-success' : 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} fs-6">{{ $dossierCount }}</span>
                                        @if ($dossierCount > 0)
                                            <small class="text-muted d-block">
                                                @if ($dossierCount === 1)
                                                    Dossier soumis
                                                @else
                                                    Dossiers soumis
                                                @endif
                                            </small>
                                        @else
                                            <small class="text-muted d-block">Aucun dossier</small>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $candidat->user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('soumissiondossiers.index', $candidat->id) }}"
                                                title="Voir les dossiers">
                                                <i class="bx bx-folder me-1"></i>
                                                Dossiers
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
