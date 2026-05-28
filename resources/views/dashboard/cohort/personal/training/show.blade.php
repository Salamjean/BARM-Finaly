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
                        <i class="bx bx-book-reader text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Cohorte / Formation</div>
                            <h4 class="mb-0 text-primary">Détails</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-info-circle text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">{{ $training->title }}</h5>
                        <small class="text-muted">
                            Formation du {{ dateFr($training->beging_date) }}
                            @if ($training->status == 'finished' && $training->end_date)
                                au {{ dateFr($training->end_date) }}
                            @endif
                        </small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $training->participations->count() }}
                        </div>
                        <small class="text-muted d-block">Participants</small>
                    </div>
                    @if ($training->status == 'finished')
                        <div class="text-center">
                            <div class="badge bg-success fs-6 px-3 py-2">
                                <i class="bx bx-check"></i>
                            </div>
                            <small class="text-muted d-block">Terminée</small>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="badge bg-warning fs-6 px-3 py-2">
                                <i class="bx bx-time"></i>
                            </div>
                            <small class="text-muted d-block">En cours</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Description (si disponible) -->
        @if ($training->description)
            <div class="bg-white p-4 rounded-3 shadow-none mb-4">
                <h6 class="text-primary mb-3">
                    <i class="bx bx-file-doc me-2"></i>
                    Description de la formation
                </h6>
                <p class="mb-0">{{ $training->description }}</p>
            </div>
        @endif

        <!-- Observations finales (si formation terminée) -->
        @if ($training->status == 'finished' && $training->observation)
            <div class="bg-white p-4 rounded-3 shadow-none mb-4">
                <h6 class="text-success mb-3">
                    <i class="bx bx-note me-2"></i>
                    Observations finales
                </h6>
                <div class="alert alert-success mb-0">
                    {{ $training->observation }}
                </div>
            </div>
        @endif

        <!-- Tableau des participants -->
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
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>
                                <th class="border-0">
                                    Présence
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($training->participations as $index => $participation)
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">
                                                    {{ $participation->candidature->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span
                                                        class="badge bg-secondary me-1">{{ $participation->candidature->user->mecano }}</span>
                                                    <span>{{ $participation->candidature->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-medium">
                                                @if ($participation->participation)
                                                    Présent
                                                @else
                                                    Absent
                                                @endif
                                            </span>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('adherent.show', $participation->candidature->user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir le profil détaillé">
                                                <i class="bx bx-show"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($training->participations->isEmpty())
                    <div class="text-center py-5">
                        <i class="bx bx-user-x fs-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Aucun participant</h5>
                        <p class="text-muted">Cette formation n'a pas encore de participants inscrits.</p>
                    </div>
                @endif
            </div>
        </div>

        
    </div>

    
@endsection
