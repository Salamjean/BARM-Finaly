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
                        <h5 class="mb-1">Candidats marqués comme absents</h5>
                        <p class="text-muted mb-0">Liste des candidats qui n'étaient pas présents lors du profilage</p>
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
                                    <i class="bx bx-briefcase text-primary me-1"></i>
                                    Partenaire technique
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-calendar text-primary me-1"></i>
                                    Date d'absence
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-message text-primary me-1"></i>
                                    Motif
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($candidatures as $index => $candidat)
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
                                                    <span>{{ $candidat->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-warning border-3 ps-2 py-1">
                                            <div class="fw-bold text-primary">{{ $candidat->cohort->reference ?? 'Non assigné' }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($candidat->partnerTechnical)
                                                <span class="badge bg-info">{{ $candidat->partnerTechnical->user->username }}</span>
                                            @else
                                                <span class="badge bg-secondary">Non assigné</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <div class="fw-bold text-dark">{{ $candidat->absent_date ? \Carbon\Carbon::parse($candidat->absent_date)->format('d/m/Y') : 'N/A' }}</div>
                                            @if($candidat->absent_date)
                                                <div class="small text-muted">{{ \Carbon\Carbon::parse($candidat->absent_date)->diffForHumans() }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-wrap" style="max-width: 200px;">
                                            @if($candidat->absent_justification)
                                                <small class="text-muted">{{ $candidat->absent_justification }}</small>
                                            @else
                                                <span class="text-muted fst-italic">Aucun motif spécifié</span>
                                            @endif
                                        </div>
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
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bx bx-user-check fs-1 text-success mb-3"></i>
                                            <h5 class="text-muted">Aucun candidat absent</h5>
                                            <p class="text-muted mb-0">Tous les candidats étaient présents lors des profilages</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
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