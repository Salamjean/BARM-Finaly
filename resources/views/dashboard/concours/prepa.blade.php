@extends('layouts.app')

@section('content')
@push('css-push')
<link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
<style>
    .avatar-initial-concour {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
    }
    #datatable--barm th, #datatable--barm td {
        vertical-align: middle !important;
    }
</style>
@endpush

<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="d-none d-sm-flex align-items-center mb-4">
        <div class="border-start border-primary border-3 ps-3">
            <nav aria-label="breadcrumb">
                <div class="d-flex align-items-center">
                    <i class="bx bx-book-reader text-primary fs-4 me-3"></i>
                    <div>
                        <div class="text-muted small">Concours & Fonction Publique</div>
                        <h4 class="mb-0 text-primary">{{ $title }}</h4>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Messages Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3" role="alert">
            <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3" role="alert">
            <i class="bx bx-error-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tableau & Filtres -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white p-4 border-bottom">
            <form method="GET" action="{{ route('concours.prepa') }}" class="row g-3 align-items-center">
                <div class="col-12 col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">Filtrer par Cohorte</label>
                    <select name="cohort_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Toutes les cohortes</option>
                        @foreach($cohorts as $cohort)
                            <option value="{{ $cohort->id }}" {{ request('cohort_id') == $cohort->id ? 'selected' : '' }}>
                                {{ $cohort->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">Filtrer par Statut Prépa</label>
                    <select name="statut" class="form-select" onchange="this.form.submit()">
                        <option value="">Tous les statuts</option>
                        <option value="present" {{ request('statut') == 'present' ? 'selected' : '' }}>Présent</option>
                        <option value="absent" {{ request('statut') == 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="abandon" {{ request('statut') == 'abandon' ? 'selected' : '' }}>Abandon</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente d'évaluation</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label small fw-semibold text-muted mb-1">Recherche (Nom, Prénom, Matricule)</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher un candidat..." value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bx bx-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-2 text-md-end mt-md-auto">
                    @if(request('cohort_id') || request('statut') || request('search'))
                        <a href="{{ route('concours.prepa') }}" class="btn btn-light-secondary text-secondary w-100">
                            <i class="bx bx-reset me-1"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatable--barm">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Candidat</th>
                            <th class="text-center">Concours Choisi</th>
                            <th class="text-center">Période de Prépa</th>
                            <th class="text-center">Statut Prépa</th>
                            <th class="text-center">Observations</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suivis as $suivi)
                            @php
                                $candidat = $suivi->candidature;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <div class="avatar-initial-concour bg-label-primary text-primary">
                                            {{ strtoupper(substr($candidat->user->name ?? 'C', 0, 1) . substr($candidat->user->first_name ?? '', 0, 1)) }}
                                        </div>
                                        <div class="text-start">
                                            <span class="fw-bold text-dark d-block">{{ $candidat->user ? $candidat->user->fullName() : 'Candidat #' . $candidat->id }}</span>
                                            <div class="small text-muted">
                                                <span class="badge bg-secondary me-1">{{ $candidat->user->matricule ?? ($candidat->user->mecano ?? 'N/A') }}</span>
                                                <span>{{ $candidat->cohort->title ?? '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-primary d-block">{{ $suivi->intitule_concours }}</span>
                                    <small class="badge bg-label-secondary">{{ $suivi->type_concours ?? 'Concours Direct' }}</small>
                                </td>
                                <td class="text-center">
                                    @if($suivi->prepa_date_debut || $suivi->prepa_date_fin)
                                        <div class="small">
                                            <div><i class="bx bx-calendar text-muted me-1"></i>Début : <strong>{{ $suivi->prepa_date_debut ? \Carbon\Carbon::parse($suivi->prepa_date_debut)->format('d/m/Y') : 'N/A' }}</strong></div>
                                            <div><i class="bx bx-calendar-check text-muted me-1"></i>Fin : <strong>{{ $suivi->prepa_date_fin ? \Carbon\Carbon::parse($suivi->prepa_date_fin)->format('d/m/Y') : 'N/A' }}</strong></div>
                                        </div>
                                    @else
                                        <span class="badge bg-label-secondary">Non renseignée</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($suivi->prepa_statut === 'present')
                                        <span class="badge bg-success px-3 py-2 fs-7"><i class="bx bx-check-circle me-1"></i>Présent</span>
                                    @elseif($suivi->prepa_statut === 'absent')
                                        <span class="badge bg-warning text-dark px-3 py-2 fs-7"><i class="bx bx-x-circle me-1"></i>Absent</span>
                                    @elseif($suivi->prepa_statut === 'abandon')
                                        <span class="badge bg-danger px-3 py-2 fs-7"><i class="bx bx-user-x me-1"></i>Abandon</span>
                                    @else
                                        <span class="badge bg-label-warning px-3 py-2 fs-7">En attente</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="small text-muted text-truncate d-inline-block" style="max-width: 200px;">
                                        {{ $suivi->prepa_obs ?: '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('concours.prepa.edit', $suivi->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-none">
                                            <i class="bx bx-edit me-1"></i>
                                            {{ $suivi->prepa_statut ? 'Mettre à jour' : 'Renseigner Prépa' }}
                                        </a>
                                        @if($candidat->user)
                                            <a href="{{ route('concours.dossier', ['search' => $candidat->user->name]) }}" class="btn btn-sm btn-icon btn-label-info rounded-circle" title="Aller à Prépa Dossier">
                                                <i class="bx bx-right-arrow-alt fs-5"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
