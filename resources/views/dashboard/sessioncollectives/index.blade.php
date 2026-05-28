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
                            <div class="text-muted small">Sessions collectives d'informations</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec bouton d'action -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-calendar-event text-info fs-3 me-3"></i>
                    <div>

                    </div>
                </div>
                @if (can('conseiller-auto-emploi') || can('chef-cellule-formation-et-insertion'))
                    <a href="{{ route('sessioncollectives.create') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="bx bx-plus me-2"></i>
                        Créer une session collective
                    </a>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-3 shadow-sm">


            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">

                                <th class="border-0">
                                    <i class="bx bx-calendar-plus text-primary me-1"></i>
                                    Date d'ajout
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-calendar text-primary me-1"></i>
                                    Date de tenue
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-map text-primary me-1"></i>
                                    Lieu de tenue
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-time text-primary me-1"></i>
                                    Heure de tenue
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-group text-primary me-1"></i>
                                    Partenaires
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessioncollectives as $index => $sessioncollective)
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                            <div>
                                                <div class="fw-medium">{{ dateFr($sessioncollective->created_at) }}</div>
                                                <small
                                                    class="text-muted">{{ dateFr($sessioncollective->created_at, 'complet') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-primary border-3 ps-2 py-1">
                                            <div class="fw-bold text-primary">{{ dateFr($sessioncollective->date) }}</div>
                                            <small
                                                    class="text-muted">{{ $sessioncollective->cohort->title }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-map-pin text-warning me-2"></i>
                                            <div>
                                                <div class="fw-medium">{{ $sessioncollective->lieu }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-warning border-3 ps-2 py-1">
                                            <div class="fw-bold text-warning">{{ $sessioncollective->heure }}</div>
                                        </div>
                                    </td>
                                    <td style="min-width: 200px;">
                                        <div class="d-flex flex-wrap gap-1">
                                            @forelse ($sessioncollective->partenaires as $partenaire)
                                                <span class="badge bg-secondary small">
                                                    {{ $partenaire->user->username }}
                                                </span>
                                            @empty
                                                <span class="text-muted small">Aucun partenaire</span>
                                            @endforelse
                                        </div>
                                        @if (count($sessioncollective->partenaires) > 0)
                                            <small class="text-muted">
                                                {{ count($sessioncollective->partenaires) }} partenaire(s)
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('sessioncollectives.show', $sessioncollective->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir les détails">
                                                <i class="bx bx-show"></i>
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
