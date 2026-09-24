@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="d-none d-sm-flex align-items-center mb-4">
        <div class="border-start border-primary border-3 ps-3">
            <nav aria-label="breadcrumb">
                <div class="d-flex align-items-center">
                    <i class="bx bx-folder-open text-primary fs-4 me-3"></i>
                    <div>
                        <div class="text-muted small">Concours & Fonction Publique / Étape 3</div>
                        <h4 class="mb-0 text-primary">{{ $title }}</h4>
                    </div>
                </div>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('concours.dossier') }}" class="btn btn-outline-secondary rounded-pill px-3">
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
        <div class="col-12 col-xl-10">
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
                            <small class="text-muted d-block">Concours :</small>
                            <span class="fw-bold text-primary">{{ $suivi->intitule_concours }}</span>
                            <small class="badge bg-label-secondary d-block mt-1">{{ $suivi->type_concours ?? 'Concours Direct' }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire des 2 Rencontres de Prépa Dossier -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white p-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bx bx-folder-open text-primary fs-4"></i>
                        <span>Suivi des 2 Rencontres de Préparation du Dossier</span>
                    </h5>
                </div>
                <form action="{{ route('concours.dossier.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="suivi_id" value="{{ $suivi->id }}">

                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- 1ère Rencontre -->
                            <div class="col-12 col-lg-6">
                                <div class="p-4 rounded-4 border bg-light h-100">
                                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                        <h6 class="mb-0 fw-bold text-primary d-flex align-items-center gap-2">
                                            <span class="badge rounded-circle bg-primary text-white">1</span>
                                            <span>1ère Rencontre</span>
                                        </h6>
                                        @if($suivi->dossier_r1_date)
                                            <span class="badge bg-label-success">Renseignée</span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark">Date de la Rencontre 1</label>
                                        <input type="date" name="dossier_r1_date" class="form-control" value="{{ $suivi->dossier_r1_date ? \Carbon\Carbon::parse($suivi->dossier_r1_date)->format('Y-m-d') : '' }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark">Statut / Déroulement</label>
                                        <select name="dossier_r1_statut" class="form-select">
                                            <option value="">-- Sélectionner --</option>
                                            <option value="Effectuée" {{ $suivi->dossier_r1_statut === 'Effectuée' ? 'selected' : '' }}>Effectuée (Dossier en cours)</option>
                                            <option value="Pièces manquantes" {{ $suivi->dossier_r1_statut === 'Pièces manquantes' ? 'selected' : '' }}>Pièces manquantes</option>
                                            <option value="Reportée" {{ $suivi->dossier_r1_statut === 'Reportée' ? 'selected' : '' }}>Reportée</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark">Document joint (Fiche / Rapport / Pièces Rencontre 1)</label>
                                        <input type="file" name="dossier_r1_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                        <div class="form-text small">Formats acceptés : PDF, JPG, PNG, DOC, DOCX (Max: 10 Mo)</div>
                                        @if($suivi->dossier_r1_file)
                                            <div class="mt-2 p-2 bg-white rounded border d-flex align-items-center justify-content-between">
                                                <span class="small text-muted text-truncate me-2">
                                                    <i class="bx bx-file text-primary me-1"></i> {{ basename($suivi->dossier_r1_file) }}
                                                </span>
                                                <a href="{{ asset($suivi->dossier_r1_file) }}" target="_blank" class="btn btn-xs btn-outline-primary rounded-pill px-2 py-1">
                                                    <i class="bx bx-show me-1"></i> Voir le fichier
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-semibold text-dark">Observations / Pièces vérifiées</label>
                                        <textarea name="dossier_r1_obs" rows="3" class="form-control" placeholder="Liste des pièces analysées, remarques...">{{ $suivi->dossier_r1_obs }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- 2ème Rencontre -->
                            <div class="col-12 col-lg-6">
                                <div class="p-4 rounded-4 border bg-light h-100">
                                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                        <h6 class="mb-0 fw-bold text-success d-flex align-items-center gap-2">
                                            <span class="badge rounded-circle bg-success text-white">2</span>
                                            <span>2ème Rencontre</span>
                                        </h6>
                                        @if($suivi->dossier_r2_date)
                                            <span class="badge bg-label-success">Renseignée</span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark">Date de la Rencontre 2</label>
                                        <input type="date" name="dossier_r2_date" class="form-control" value="{{ $suivi->dossier_r2_date ? \Carbon\Carbon::parse($suivi->dossier_r2_date)->format('Y-m-d') : '' }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark">Statut / Avis Final</label>
                                        <select name="dossier_r2_statut" class="form-select">
                                            <option value="">-- Sélectionner --</option>
                                            <option value="Dossier conforme / Validé" {{ $suivi->dossier_r2_statut === 'Dossier conforme / Validé' ? 'selected' : '' }}>Dossier conforme / Validé</option>
                                            <option value="Dossier incomplet" {{ $suivi->dossier_r2_statut === 'Dossier incomplet' ? 'selected' : '' }}>Dossier incomplet</option>
                                            <option value="Effectuée" {{ $suivi->dossier_r2_statut === 'Effectuée' ? 'selected' : '' }}>Effectuée</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark">Document joint (Fiche / Rapport / Pièces Rencontre 2)</label>
                                        <input type="file" name="dossier_r2_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                        <div class="form-text small">Formats acceptés : PDF, JPG, PNG, DOC, DOCX (Max: 10 Mo)</div>
                                        @if($suivi->dossier_r2_file)
                                            <div class="mt-2 p-2 bg-white rounded border d-flex align-items-center justify-content-between">
                                                <span class="small text-muted text-truncate me-2">
                                                    <i class="bx bx-file text-success me-1"></i> {{ basename($suivi->dossier_r2_file) }}
                                                </span>
                                                <a href="{{ asset($suivi->dossier_r2_file) }}" target="_blank" class="btn btn-xs btn-outline-success rounded-pill px-2 py-1">
                                                    <i class="bx bx-show me-1"></i> Voir le fichier
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-semibold text-dark">Observations / Bilan Final</label>
                                        <textarea name="dossier_r2_obs" rows="3" class="form-control" placeholder="Bilan final avant le dépôt...">{{ $suivi->dossier_r2_obs }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-top p-4 d-flex justify-content-between align-items-center">
                        <a href="{{ route('concours.dossier') }}" class="btn btn-light-secondary rounded-pill px-4">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bx bx-save me-1"></i> Enregistrer les rencontres
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
