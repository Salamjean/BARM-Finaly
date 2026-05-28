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
                        <i class="bx bx-user-plus text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Gestion des candidats</div>
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
                    <i class="bx bx-group text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Candidats aux concours</h5>
                        <small class="text-muted">Suivi des inscriptions aux concours par candidat</small>
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
                            {{ $candidats->sum(function($c) { return $c->concours->count(); }) }}
                        </div>
                        <small class="text-muted d-block">Inscriptions</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $candidats->filter(function($c) { return $c->concours->count() > 0; })->count() }}
                        </div>
                        <small class="text-muted d-block">Inscrits</small>
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
                                <th>Nombre de concours</th>
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
                                                <div class="fw-medium text-dark">{{ $candidat->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>
                                                    <span>{{ $candidat->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $concoursCount = $candidat->concours->count();
                                            $badgeClass = $concoursCount > 0 ? 'bg-success' : 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} fs-6">{{ $concoursCount }}</span>
                                        @if($concoursCount > 0)
                                            <small class="text-muted d-block">
                                                @if($concoursCount === 1)
                                                    Concours inscrit
                                                @else
                                                    Concours inscrits
                                                @endif
                                            </small>
                                        @else
                                            <small class="text-muted d-block">Aucune inscription</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $candidat->user->id) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ route('inscriptionconcours.index', $candidat->id) }}"
                                               title="Voir les inscriptions">
                                                <i class="bx bx-clipboard me-1"></i>
                                                Inscriptions
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($candidats->isEmpty())
                <div class="text-center py-5">
                    <i class="bx bx-user-plus fs-1 text-muted"></i>
                    <h5 class="text-muted mt-3">Aucun candidat enregistré</h5>
                    <p class="text-muted">Aucun candidat n'est encore disponible pour les inscriptions aux concours.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection