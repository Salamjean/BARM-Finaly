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
                        <i class="bx bx-check-double text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Décisions finales</div>
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
                    <i class="bx bx-trophy text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Choix final des candidats aux concours</h5>
                        <small class="text-muted">Candidats ayant effectué leur choix définitif de concours</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $candidats->count() }}
                        </div>
                        <small class="text-muted d-block">Candidats</small>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tableau des candidats avec choix final -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nom & Prénoms</th>
                                <th>
                                    <i class="bx bx-trophy text-warning me-2"></i>
                                    Intitulé concours
                                </th>
                                <th>Type concours</th>
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
                                                <div class="fw-bold text-dark">
                                                    {{ $candidat->candidature->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span
                                                        class="badge bg-secondary me-1">{{ $candidat->candidature->user->mecano }}</span>
                                                    <span>{{ $candidat->candidature->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-medium">{{ $candidat->intitule_concours }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $candidat->type_concours }}</span>
                                    </td>
                                    <td style="text-align: center">
                                        <a href="{{ route('adherent.show', $candidat->candidature->user->id) }}"
                                            class="btn btn-outline-primary btn-sm" title="Voir le profil détaillé">
                                            <i class="bx bx-show me-1"></i>
                                            
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($candidats->isEmpty())
                    <div class="text-center py-5">
                        <i class="bx bx-list-check fs-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Aucun choix final enregistré</h5>
                        <p class="text-muted">Aucun candidat n'a encore effectué son choix final de concours.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
