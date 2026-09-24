@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="d-none d-sm-flex align-items-center mb-4">
        <div class="border-start border-primary border-3 ps-3">
            <nav aria-label="breadcrumb">
                <div class="d-flex align-items-center">
                    <i class="bx bx-book-reader text-primary fs-4 me-3"></i>
                    <div>
                        <div class="text-muted small">Concours & Fonction Publique / Étape 2</div>
                        <h4 class="mb-0 text-primary">{{ $title }}</h4>
                    </div>
                </div>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('concours.prepa') }}" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="bx bx-arrow-back me-1"></i> Retour à la liste
            </a>
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

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <!-- Carte Candidat -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar bg-label-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; font-size: 1.25rem; font-weight: bold;">
                                {{ strtoupper(substr($candidat->user->name ?? 'C', 0, 1) . substr($candidat->user->first_name ?? '', 0, 1)) }}
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold text-dark">{{ $candidat->user ? $candidat->user->fullName() : 'Candidat #' . $candidat->id }}</h5>
                                <div class="d-flex flex-wrap align-items-center gap-2 small text-muted">
                                    <span class="badge bg-secondary">{{ $candidat->user->matricule ?? ($candidat->user->mecano ?? 'Sans matricule') }}</span>
                                    <span><i class="bx bx-phone me-1"></i>{{ $candidat->phone_number }}</span>
                                    <span class="badge bg-label-info">{{ $candidat->cohort->title ?? 'Cohorte N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-md-end">
                            <small class="text-muted d-block">Concours Choisi :</small>
                            <span class="fw-bold text-primary">{{ $suivi->intitule_concours }}</span>
                            <small class="badge bg-label-secondary d-block mt-1">{{ $suivi->type_concours ?? 'Concours Direct' }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire Prépa Concours -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white p-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bx bx-edit text-primary fs-4"></i>
                        <span>Évaluation & Suivi de la Prépa Concours</span>
                    </h5>
                </div>
                <form action="{{ route('concours.prepa.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="suivi_id" value="{{ $suivi->id }}">

                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-dark">Date Début de Prépa</label>
                                <input type="date" name="prepa_date_debut" class="form-control form-control-lg" value="{{ $suivi->prepa_date_debut ? \Carbon\Carbon::parse($suivi->prepa_date_debut)->format('Y-m-d') : '' }}">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-dark">Date Fin de Prépa</label>
                                <input type="date" name="prepa_date_fin" class="form-control form-control-lg" value="{{ $suivi->prepa_date_fin ? \Carbon\Carbon::parse($suivi->prepa_date_fin)->format('Y-m-d') : '' }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Statut de la Préparation <span class="text-danger">*</span></label>
                            <select name="prepa_statut" class="form-select form-select-lg" required>
                                <option value="">-- Sélectionner le statut --</option>
                                <option value="present" {{ $suivi->prepa_statut === 'present' ? 'selected' : '' }}>Présent</option>
                                <option value="absent" {{ $suivi->prepa_statut === 'absent' ? 'selected' : '' }}>Absent</option>
                                <option value="abandon" {{ $suivi->prepa_statut === 'abandon' ? 'selected' : '' }}>Abandon</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Observations / Assiduité</label>
                            <textarea name="prepa_obs" rows="4" class="form-control" placeholder="Observations sur la participation du candidat, points forts, assiduité...">{{ $suivi->prepa_obs }}</textarea>
                        </div>

                        <div class="alert alert-info border-0 rounded-3 small mb-0">
                            <i class="bx bx-info-circle me-1"></i>
                            Une fois cette étape renseignée, vous pourrez poursuivre le suivi dans le sous-onglet <strong>Prépa de dossier (2 rencontres)</strong>.
                        </div>
                    </div>

                    <div class="card-footer bg-light border-top p-4 d-flex justify-content-between align-items-center">
                        <a href="{{ route('concours.prepa') }}" class="btn btn-light-secondary rounded-pill px-4">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bx bx-save me-1"></i> Sauvegarder la Prépa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
