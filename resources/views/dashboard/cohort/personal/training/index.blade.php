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
                            <div class="text-muted small">Cohorte / Formations</div>
                            <h4 class="mb-0 text-primary">Liste des formations</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-graduation text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Formations de la cohorte ({{ $cohort->title }})</h5>
                        <small class="text-muted">Suivi et gestion des sessions de formation</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $trainings->count() }}
                        </div>
                        <small class="text-muted d-block">Formations</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $trainings->where('status', 'finished')->count() }}
                        </div>
                        <small class="text-muted d-block">Terminées</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $trainings->where('status', 'pending')->count() }}
                        </div>
                        <small class="text-muted d-block">En cours</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des formations -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>
                                    Partenaire technique
                                </th>
                                <th>
                                    <i class="bx bx-calendar-check text-success me-2"></i>
                                    Date de début
                                </th>
                                <th>
                                    <i class="bx bx-calendar text-primary me-2"></i>
                                    Date de fin
                                </th>
                                <th>
                                    <i class="bx bx-book-open text-warning me-2"></i>
                                    Intitulé
                                </th>
                                <th>Participants</th>
                                <th>Feuille de présence</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainings as $training)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span>{{ $training->partner->user->username }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span>{{ dateFr($training->beging_date) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($training->status == 'pending')
                                            <span class="text-muted">
                                                <i class="bx bx-time me-1"></i>
                                                En cours...
                                            </span>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <span>{{ dateFr($training->end_date) }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-medium">{{ $training->title }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info fs-6">{{ $training->participations->count() }}</span>
                                        <small class="text-muted d-block">
                                            @if ($training->participations->count() === 1)
                                                Participant
                                            @else
                                                Participants
                                            @endif
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        @if ($training->file_presence)
                                            <a href="{{ asset($training->file_presence) }}" target="_blank"
                                                class="btn btn-outline-success btn-sm" title="Voir la feuille de présence">
                                                <i class="bx bx-file-pdf me-1"></i>
                                                Voir
                                            </a>
                                        @else
                                            <span class="text-muted">
                                                <i class="bx bx-file-blank fs-4"></i>
                                                <small class="d-block">Non disponible</small>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($training->status == 'pending')
                                            <span class="badge bg-warning">
                                                <i class="bx bx-time me-1"></i>
                                                En cours
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="bx bx-check me-1"></i>
                                                Terminée
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('cohort.personal.training.show', $training->id) }}"
                                            class="btn btn-primary btn-sm" title="Voir les détails">
                                            <i class="bx bx-show me-1"></i>
                                            Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($trainings->isEmpty())
                    <div class="text-center py-5">
                        <i class="bx bx-book-reader fs-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Aucune formation</h5>
                        <p class="text-muted">Cette cohorte n'a pas encore de formations programmées.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
