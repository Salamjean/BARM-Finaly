@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-user-x text-primary fs-4 me-3"></i>
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
                    <i class="bx bx-user-x text-warning fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-1">Candidats jamais profilés</h5>
                        <p class="text-muted mb-0">Liste des candidats qui n'ont jamais été profilés</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="badge bg-warning fs-6 px-3 py-2">
                        {{ $candidatures->count() }}
                    </div>
                    <div class="text-muted small">Total</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3 shadow-none">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-warning">
                                <th class="border-0">
                                    <i class="bx bx-hash text-primary me-1"></i>
                                    #
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-layer text-primary me-1"></i>
                                    Cohorte
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-buildings text-primary me-1"></i>
                                    Partenaire affecté
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-phone text-primary me-1"></i>
                                    Téléphone
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-check-shield text-primary me-1"></i>
                                    Statut
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidatures as $index => $candidat)
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-warning me-2">{{ $index + 1 }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $candidat->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-warning border-3 ps-2 py-1">
                                            <div class="fw-bold text-primary">{{ $candidat->cohort->title ?? $candidat->cohort->reference ?? $candidat->cohort->name ?? 'Cohorte ' . $candidat->cohort_id }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($candidat->partnerTechnical && $candidat->partnerTechnical->user)
                                            <span class="badge bg-label-info fw-bold">
                                                {{ $candidat->partnerTechnical->user->username }}
                                            </span>
                                        @else
                                            <span class="badge bg-label-secondary">Non assigné</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span>{{ $candidat->phone_number }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($candidat->status == 'accepted')
                                            <span class="badge bg-success">Accepté</span>
                                        @elseif ($candidat->status == 'refused')
                                            <span class="badge bg-danger">Refusé</span>
                                        @else
                                            <span class="badge bg-warning">En attente de profilage</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $candidat->user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir le profil">
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

    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush
@endsection
