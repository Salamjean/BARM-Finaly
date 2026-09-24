@extends('layouts.app')
@section('content')
    <div class="container-fluid py-3">
        <!-- En-tête / Fil d'ariane -->
        <div class="d-none d-sm-flex align-items-center justify-content-between mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-shield-quarter text-primary fs-3 me-3"></i>
                        <div>
                            <div class="text-muted small">
                                @if ($adherent->cohort)
                                    Suivi-Évaluation / Post-Suivi / Cohorte {{ $adherent->cohort->reference ?? $adherent->cohort->name }} / Suivi Candidat
                                @else
                                    Suivi-Évaluation / Suivi Post-Insertion
                                @endif
                            </div>
                            <h4 class="mb-0 text-dark fw-bold">{{ $adherent->user ? $adherent->user->fullName() : 'Candidat' }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if ($adherent->orientation === 'entreprise-privee')
                    <a href="{{ route('candidatentreprises.integres') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                        <i class="bx bx-arrow-back me-1"></i> Retour à Mise à disposition
                    </a>
                @elseif ($adherent->cohort)
                    <a href="{{ route('monitored-evaluation.post_monitored.cohort', $adherent->cohort->id) }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                        <i class="bx bx-arrow-back me-1"></i> Retour à la cohorte
                    </a>
                @else
                    <a href="javascript:history.back();" class="btn btn-outline-secondary btn-sm shadow-sm">
                        <i class="bx bx-arrow-back me-1"></i> Retour
                    </a>
                @endif
                <a href="{{ route('export.pdf.adherent', $adherent->user->id) }}" class="btn btn-outline-danger btn-sm shadow-sm">
                    <i class="bx bxs-file-pdf me-1"></i> Fiche PDF
                </a>
            </div>
        </div>

        <!-- Profil Candidat & Statut Global -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <div class="col-auto">
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 68px; height: 68px; min-width: 68px; background-color: #2b5cb7; color: #ffffff !important; font-weight: 700; font-size: 1.65rem; border: 3px solid #e0e7ff;">
                            {{ $adherent->user ? strtoupper(substr($adherent->user->nom ?? 'C', 0, 1) . substr($adherent->user->prenom ?? '', 0, 1)) : 'CA' }}
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <h4 class="mb-0 text-dark fw-bold">{{ $adherent->user ? $adherent->user->fullName() : 'N/A' }}</h4>
                            @if ($adherent->post_insertion_status === 'en_service')
                                <span class="badge bg-success px-3 py-2 fs-6 rounded-pill"><i class="bx bx-check-circle me-1"></i> En service</span>
                            @elseif ($adherent->post_insertion_status === 'revoque')
                                <span class="badge bg-danger px-3 py-2 fs-6 rounded-pill"><i class="bx bx-x-circle me-1"></i> Révoqué</span>
                            @elseif ($adherent->post_insertion_status === 'demission')
                                <span class="badge bg-warning text-dark px-3 py-2 fs-6 rounded-pill"><i class="bx bx-log-out-circle me-1"></i> Démission</span>
                            @elseif ($adherent->post_insertion_status === 'indisponible')
                                <span class="badge bg-info px-3 py-2 fs-6 rounded-pill"><i class="bx bx-time-five me-1"></i> Indisponibilité</span>
                            @else
                                <span class="badge bg-secondary px-3 py-2 fs-6 rounded-pill"><i class="bx bx-loader me-1"></i> Suivi en cours</span>
                            @endif
                        </div>
                        <div class="row g-2 text-muted small mt-1">
                            <div class="col-sm-auto pe-3 border-end">
                                <i class="bx bx-id-card text-primary me-1"></i>
                                <strong>Matricule / Mécano :</strong> {{ $adherent->user->personnel->matricule ?? ($adherent->user->code ?? 'N/A') }}
                            </div>
                            <div class="col-sm-auto pe-3 border-end">
                                <i class="bx bx-phone text-primary me-1"></i>
                                <strong>Téléphone :</strong> {{ $adherent->user->telephone ?? $adherent->user->phone ?? 'N/A' }}
                            </div>
                            <div class="col-sm-auto pe-3 border-end">
                                <i class="bx bx-buildings text-primary me-1"></i>
                                <strong>Entreprise / Orientation :</strong> 
                                {{ $adherent->candidatentreprise->entreprise ?? (ucwords(str_replace('-', ' ', $adherent->orientation ?? 'N/A'))) }}
                            </div>
                            @if ($adherent->cohort)
                                <div class="col-sm-auto">
                                    <i class="bx bx-layer text-primary me-1"></i>
                                    <strong>Cohorte :</strong> {{ $adherent->cohort->reference ?? $adherent->cohort->name }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Barre de progression des 4 étapes -->
                @php
                    $step1Done = !empty($adherent->suivi_1_date);
                    $step2Done = !empty($adherent->suivi_2_date);
                    $step3Done = !empty($adherent->suivi_3_date);
                    $decisionDone = !empty($adherent->post_insertion_status);

                    $progressPct = 0;
                    if ($step1Done) $progressPct += 25;
                    if ($step2Done) $progressPct += 25;
                    if ($step3Done) $progressPct += 25;
                    if ($decisionDone) $progressPct += 25;
                @endphp

                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold text-dark small"><i class="bx bx-trending-up text-primary me-1"></i> Progression du parcours de suivi :</span>
                        <span class="fw-bold text-primary small">{{ $progressPct }}%</span>
                    </div>
                    <div class="progress" style="height: 10px; border-radius: 6px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated {{ $progressPct == 100 ? 'bg-success' : 'bg-primary' }}" 
                             role="progressbar" style="width: {{ $progressPct }}%"></div>
                    </div>

                    <div class="row text-center mt-3 g-2">
                        <div class="col-3">
                            <div class="p-2 rounded-3" style="background-color: {{ $step1Done ? '#f0fdf4' : '#f8fafc' }}; border: 1.5px solid {{ $step1Done ? '#22c55e' : '#cbd5e1' }};">
                                <i class="bx {{ $step1Done ? 'bx-check-circle text-success' : 'bx-circle text-muted' }} fs-5"></i>
                                <div class="fw-bold small mt-1 text-dark" style="color: #0f172a !important;">1. Suivi 1</div>
                                <div class="fw-semibold" style="font-size: 0.75rem; color: {{ $step1Done ? '#16a34a' : '#64748b' }};">
                                    {{ $step1Done ? dateFr($adherent->suivi_1_date) : 'À renseigner' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2 rounded-3" style="background-color: {{ $step2Done ? '#f0fdf4' : ($step1Done ? '#ffffff' : '#f1f5f9') }}; border: 1.5px {{ $step2Done ? 'solid #22c55e' : ($step1Done ? 'dashed #3b82f6' : 'solid #e2e8f0') }};">
                                <i class="bx {{ $step2Done ? 'bx-check-circle text-success' : ($step1Done ? 'bx-time text-primary' : 'bx-lock-alt text-muted') }} fs-5"></i>
                                <div class="fw-bold small mt-1 text-dark" style="color: {{ !$step1Done ? '#64748b' : '#0f172a' }} !important;">2. Suivi 2</div>
                                <div class="fw-semibold" style="font-size: 0.75rem; color: {{ $step2Done ? '#16a34a' : ($step1Done ? '#2563eb' : '#94a3b8') }};">
                                    {{ $step2Done ? dateFr($adherent->suivi_2_date) : ($step1Done ? 'Disponible' : 'Verrouillé') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2 rounded-3" style="background-color: {{ $step3Done ? '#f0fdf4' : ($step2Done ? '#ffffff' : '#f1f5f9') }}; border: 1.5px {{ $step3Done ? 'solid #22c55e' : ($step2Done ? 'dashed #3b82f6' : 'solid #e2e8f0') }};">
                                <i class="bx {{ $step3Done ? 'bx-check-circle text-success' : ($step2Done ? 'bx-time text-primary' : 'bx-lock-alt text-muted') }} fs-5"></i>
                                <div class="fw-bold small mt-1 text-dark" style="color: {{ !$step2Done ? '#64748b' : '#0f172a' }} !important;">3. Suivi 3</div>
                                <div class="fw-semibold" style="font-size: 0.75rem; color: {{ $step3Done ? '#16a34a' : ($step2Done ? '#2563eb' : '#94a3b8') }};">
                                    {{ $step3Done ? dateFr($adherent->suivi_3_date) : ($step2Done ? 'Disponible' : 'Verrouillé') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2 rounded-3" style="background-color: {{ $decisionDone ? '#eff6ff' : ($step3Done ? '#ffffff' : '#f1f5f9') }}; border: 1.5px {{ $decisionDone ? 'solid #2563eb' : ($step3Done ? 'dashed #f59e0b' : 'solid #e2e8f0') }};">
                                <i class="bx {{ $decisionDone ? 'bx-badge-check text-primary' : ($step3Done ? 'bx-time text-warning' : 'bx-lock-alt text-muted') }} fs-5"></i>
                                <div class="fw-bold small mt-1 text-dark" style="color: {{ !$step3Done ? '#64748b' : '#0f172a' }} !important;">4. Décision Finale</div>
                                <div class="fw-bold" style="font-size: 0.75rem; color: {{ $decisionDone ? '#1d4ed8' : ($step3Done ? '#d97706' : '#94a3b8') }};">
                                    {{ $decisionDone ? ucwords(str_replace('_', ' ', $adherent->post_insertion_status)) : ($step3Done ? 'À décider' : 'Verrouillé') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Les 4 cartes de Suivi séquentiel -->
        <div class="row g-4 mb-4">
            
            <!-- ÉTAPE 1 : SUIVI 1 -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle {{ $step1Done ? 'bg-success text-white' : 'bg-primary text-white' }} d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-weight: bold;">
                                1
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">Premier Suivi (Suivi 1)</h5>
                        </div>
                        @if ($step1Done)
                            <span class="badge bg-success"><i class="bx bx-check me-1"></i> Validé</span>
                        @else
                            <span class="badge bg-primary">En attente</span>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        @if ($step1Done)
                            <!-- Affichage du Suivi 1 validé -->
                            <div class="bg-light bg-opacity-50 p-3 rounded-3 border mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <div class="text-muted small">Date du suivi 1 :</div>
                                        <div class="fw-bold text-dark fs-6"><i class="bx bx-calendar text-primary me-1"></i> {{ dateFr($adherent->suivi_1_date) }}</div>
                                    </div>
                                    @if ($adherent->suivi1User)
                                        <div class="text-end">
                                            <div class="text-muted small">Enregistré par :</div>
                                            <div class="small fw-semibold text-dark">{{ $adherent->suivi1User->fullName() }}</div>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-2 pt-2 border-top">
                                    <div class="text-muted small mb-1">Commentaire / Observations :</div>
                                    <div class="text-dark bg-white p-2 rounded border small mb-2">
                                        {{ $adherent->suivi_1_commentaire ?: 'Aucun commentaire enregistré.' }}
                                    </div>
                                </div>

                                @if ($adherent->suivi_1_file)
                                    <div class="mt-2 pt-2 border-top d-flex align-items-center justify-content-between">
                                        <div class="small text-muted"><i class="bx bx-paperclip text-primary me-1"></i> Document joint :</div>
                                        <a href="{{ asset($adherent->suivi_1_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-download me-1"></i> Télécharger le document
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="$('#editSuivi1Form').slideToggle()">
                                <i class="bx bx-edit me-1"></i> Modifier le Suivi 1
                            </button>
                        @endif

                        <!-- Formulaire Suivi 1 (visible si pas fait ou si toggle) -->
                        <div id="editSuivi1Form" style="{{ $step1Done ? 'display: none;' : '' }}" class="{{ $step1Done ? 'mt-3 pt-3 border-top' : '' }}">
                            <form class="suivi-form" data-step="1" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label text-dark fw-semibold">
                                        Date du suivi <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" name="date" value="{{ $adherent->suivi_1_date ?? date('Y-m-d') }}" required max="{{ date('Y-m-d') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-dark fw-semibold">
                                        Commentaire <span class="text-muted small">(Optionnel)</span>
                                    </label>
                                    <textarea class="form-control" name="commentaire" rows="3" placeholder="Saisir vos remarques, points d'attention ou retours d'échange...">{{ $adherent->suivi_1_commentaire }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-dark fw-semibold">
                                        <i class="bx bx-paperclip text-primary me-1"></i> Joindre un document <span class="text-muted small">(Optionnel : PDF, DOC, Images - max 10 Mo)</span>
                                    </label>
                                    <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bx bx-save me-1"></i> {{ $step1Done ? 'Mettre à jour le Suivi 1' : 'Enregistrer le Suivi 1' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ÉTAPE 2 : SUIVI 2 -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden {{ !$step1Done ? 'opacity-75' : '' }}">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle {{ $step2Done ? 'bg-success text-white' : ($step1Done ? 'bg-primary text-white' : 'bg-secondary text-white') }} d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-weight: bold;">
                                2
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">Deuxième Suivi (Suivi 2)</h5>
                        </div>
                        @if ($step2Done)
                            <span class="badge bg-success"><i class="bx bx-check me-1"></i> Validé</span>
                        @elseif ($step1Done)
                            <span class="badge bg-primary">En attente</span>
                        @else
                            <span class="badge bg-secondary"><i class="bx bx-lock-alt me-1"></i> Verrouillé</span>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        @if (!$step1Done)
                            <div class="text-center py-4">
                                <i class="bx bx-lock-alt text-muted fs-1 mb-2"></i>
                                <h6 class="text-dark fw-bold">Étape 2 verrouillée</h6>
                                <p class="text-muted small mb-0">Vous devez obligatoirement renseigner et valider le <strong>Suivi 1</strong> pour débloquer cette étape.</p>
                            </div>
                        @else
                            @if ($step2Done)
                                <div class="bg-light bg-opacity-50 p-3 rounded-3 border mb-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <div class="text-muted small">Date du suivi 2 :</div>
                                            <div class="fw-bold text-dark fs-6"><i class="bx bx-calendar text-primary me-1"></i> {{ dateFr($adherent->suivi_2_date) }}</div>
                                        </div>
                                        @if ($adherent->suivi2User)
                                            <div class="text-end">
                                                <div class="text-muted small">Enregistré par :</div>
                                                <div class="small fw-semibold text-dark">{{ $adherent->suivi2User->fullName() }}</div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-2 pt-2 border-top">
                                        <div class="text-muted small mb-1">Commentaire / Observations :</div>
                                        <div class="text-dark bg-white p-2 rounded border small mb-2">
                                            {{ $adherent->suivi_2_commentaire ?: 'Aucun commentaire enregistré.' }}
                                        </div>
                                    </div>

                                    @if ($adherent->suivi_2_file)
                                        <div class="mt-2 pt-2 border-top d-flex align-items-center justify-content-between">
                                            <div class="small text-muted"><i class="bx bx-paperclip text-primary me-1"></i> Document joint :</div>
                                            <a href="{{ asset($adherent->suivi_2_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="bx bx-download me-1"></i> Télécharger le document
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="$('#editSuivi2Form').slideToggle()">
                                    <i class="bx bx-edit me-1"></i> Modifier le Suivi 2
                                </button>
                            @endif

                            <!-- Formulaire Suivi 2 -->
                            <div id="editSuivi2Form" style="{{ $step2Done ? 'display: none;' : '' }}" class="{{ $step2Done ? 'mt-3 pt-3 border-top' : '' }}">
                                <form class="suivi-form" data-step="2" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label text-dark fw-semibold">
                                            Date du suivi <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" name="date" value="{{ $adherent->suivi_2_date ?? date('Y-m-d') }}" required max="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-dark fw-semibold">
                                            Commentaire <span class="text-muted small">(Optionnel)</span>
                                        </label>
                                        <textarea class="form-control" name="commentaire" rows="3" placeholder="Saisir vos remarques, points d'attention ou retours d'échange...">{{ $adherent->suivi_2_commentaire }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-dark fw-semibold">
                                            <i class="bx bx-paperclip text-primary me-1"></i> Joindre un document <span class="text-muted small">(Optionnel : PDF, DOC, Images - max 10 Mo)</span>
                                        </label>
                                        <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bx bx-save me-1"></i> {{ $step2Done ? 'Mettre à jour le Suivi 2' : 'Enregistrer le Suivi 2' }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- ÉTAPE 3 : SUIVI 3 -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden {{ !$step2Done ? 'opacity-75' : '' }}">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle {{ $step3Done ? 'bg-success text-white' : ($step2Done ? 'bg-primary text-white' : 'bg-secondary text-white') }} d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-weight: bold;">
                                3
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">Troisième Suivi (Suivi 3)</h5>
                        </div>
                        @if ($step3Done)
                            <span class="badge bg-success"><i class="bx bx-check me-1"></i> Validé</span>
                        @elseif ($step2Done)
                            <span class="badge bg-primary">En attente</span>
                        @else
                            <span class="badge bg-secondary"><i class="bx bx-lock-alt me-1"></i> Verrouillé</span>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        @if (!$step2Done)
                            <div class="text-center py-4">
                                <i class="bx bx-lock-alt text-muted fs-1 mb-2"></i>
                                <h6 class="text-dark fw-bold">Étape 3 verrouillée</h6>
                                <p class="text-muted small mb-0">Vous devez obligatoirement renseigner et valider le <strong>Suivi 2</strong> pour débloquer cette étape.</p>
                            </div>
                        @else
                            @if ($step3Done)
                                <div class="bg-light bg-opacity-50 p-3 rounded-3 border mb-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <div class="text-muted small">Date du suivi 3 :</div>
                                            <div class="fw-bold text-dark fs-6"><i class="bx bx-calendar text-primary me-1"></i> {{ dateFr($adherent->suivi_3_date) }}</div>
                                        </div>
                                        @if ($adherent->suivi3User)
                                            <div class="text-end">
                                                <div class="text-muted small">Enregistré par :</div>
                                                <div class="small fw-semibold text-dark">{{ $adherent->suivi3User->fullName() }}</div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-2 pt-2 border-top">
                                        <div class="text-muted small mb-1">Commentaire / Observations :</div>
                                        <div class="text-dark bg-white p-2 rounded border small mb-2">
                                            {{ $adherent->suivi_3_commentaire ?: 'Aucun commentaire enregistré.' }}
                                        </div>
                                    </div>

                                    @if ($adherent->suivi_3_file)
                                        <div class="mt-2 pt-2 border-top d-flex align-items-center justify-content-between">
                                            <div class="small text-muted"><i class="bx bx-paperclip text-primary me-1"></i> Document joint :</div>
                                            <a href="{{ asset($adherent->suivi_3_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="bx bx-download me-1"></i> Télécharger le document
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="$('#editSuivi3Form').slideToggle()">
                                    <i class="bx bx-edit me-1"></i> Modifier le Suivi 3
                                </button>
                            @endif

                            <!-- Formulaire Suivi 3 -->
                            <div id="editSuivi3Form" style="{{ $step3Done ? 'display: none;' : '' }}" class="{{ $step3Done ? 'mt-3 pt-3 border-top' : '' }}">
                                <form class="suivi-form" data-step="3" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label text-dark fw-semibold">
                                            Date du suivi <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" name="date" value="{{ $adherent->suivi_3_date ?? date('Y-m-d') }}" required max="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-dark fw-semibold">
                                            Commentaire <span class="text-muted small">(Optionnel)</span>
                                        </label>
                                        <textarea class="form-control" name="commentaire" rows="3" placeholder="Saisir vos remarques, points d'attention ou retours d'échange...">{{ $adherent->suivi_3_commentaire }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-dark fw-semibold">
                                            <i class="bx bx-paperclip text-primary me-1"></i> Joindre un document <span class="text-muted small">(Optionnel : PDF, DOC, Images - max 10 Mo)</span>
                                        </label>
                                        <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bx bx-save me-1"></i> {{ $step3Done ? 'Mettre à jour le Suivi 3' : 'Enregistrer le Suivi 3' }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- ÉTAPE 4 : DÉCISION FINALE -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden {{ !$step3Done ? 'opacity-75' : '' }}">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle {{ $decisionDone ? 'bg-primary text-white' : ($step3Done ? 'bg-warning text-dark' : 'bg-secondary text-white') }} d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-weight: bold;">
                                4
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">Décision Finale</h5>
                        </div>
                        @if ($decisionDone)
                            <span class="badge bg-primary"><i class="bx bx-badge-check me-1"></i> Décision actée</span>
                        @elseif ($step3Done)
                            <span class="badge bg-warning text-dark"><i class="bx bx-time me-1"></i> En attente</span>
                        @else
                            <span class="badge bg-secondary"><i class="bx bx-lock-alt me-1"></i> Verrouillé</span>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        @if (!$step3Done)
                            <div class="text-center py-4">
                                <i class="bx bx-lock-alt text-muted fs-1 mb-2"></i>
                                <h6 class="text-dark fw-bold">Décision Finale verrouillée</h6>
                                <p class="text-muted small mb-0">Vous devez obligatoirement renseigner et valider les <strong>3 étapes de suivi</strong> avant d'enregistrer la décision finale.</p>
                            </div>
                        @else
                            @if ($decisionDone)
                                <div class="bg-light bg-opacity-50 p-3 rounded-3 border mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="text-muted small">Statut final retenu :</div>
                                        <div>
                                            @if ($adherent->post_insertion_status === 'en_service')
                                                <span class="badge bg-success fs-6"><i class="bx bx-check-circle me-1"></i> En service</span>
                                            @elseif ($adherent->post_insertion_status === 'revoque')
                                                <span class="badge bg-danger fs-6"><i class="bx bx-x-circle me-1"></i> Révoqué</span>
                                            @elseif ($adherent->post_insertion_status === 'demission')
                                                <span class="badge bg-warning text-dark fs-6"><i class="bx bx-log-out-circle me-1"></i> Démission</span>
                                            @elseif ($adherent->post_insertion_status === 'indisponible')
                                                <span class="badge bg-info fs-6"><i class="bx bx-time-five me-1"></i> Indisponibilité</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row g-2 mt-2 pt-2 border-top small">
                                        @if ($adherent->post_insertion_date)
                                            <div class="col-sm-6">
                                                <span class="text-muted">Date :</span>
                                                <strong class="text-dark">{{ dateFr($adherent->post_insertion_date) }}</strong>
                                            </div>
                                        @endif
                                        @if ($adherent->post_insertion_date_fin)
                                            <div class="col-sm-6">
                                                <span class="text-muted">Date fin :</span>
                                                <strong class="text-dark">{{ dateFr($adherent->post_insertion_date_fin) }}</strong>
                                            </div>
                                        @endif
                                        @if ($adherent->postInsertionUser)
                                            <div class="col-12">
                                                <span class="text-muted">Enregistré par :</span>
                                                <strong class="text-dark">{{ $adherent->postInsertionUser->fullName() }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    @if ($adherent->post_insertion_motif)
                                        <div class="mt-2 pt-2 border-top">
                                            <div class="text-muted small mb-1">Motif / Justification :</div>
                                            <div class="text-dark bg-white p-2 rounded border small mb-2">
                                                {{ $adherent->post_insertion_motif }}
                                            </div>
                                        </div>
                                    @endif

                                    @if ($adherent->post_insertion_file)
                                        <div class="mt-2 pt-2 border-top d-flex align-items-center justify-content-between">
                                            <div class="small text-muted"><i class="bx bx-paperclip text-primary me-1"></i> Document justificatif :</div>
                                            <a href="{{ asset($adherent->post_insertion_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="bx bx-download me-1"></i> Télécharger le document
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="$('#editDecisionForm').slideToggle()">
                                    <i class="bx bx-edit me-1"></i> Modifier la décision finale
                                </button>
                            @endif

                            <!-- Formulaire Décision Finale -->
                            <div id="editDecisionForm" style="{{ $decisionDone ? 'display: none;' : '' }}" class="{{ $decisionDone ? 'mt-3 pt-3 border-top' : '' }}">
                                <form id="decisionForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label text-dark fw-semibold">
                                            Sélectionner le statut final <span class="text-danger">*</span>
                                        </label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <input type="radio" class="btn-check" name="status" id="status_en_service" value="en_service" {{ ($adherent->post_insertion_status == 'en_service' || empty($adherent->post_insertion_status)) ? 'checked' : '' }}>
                                                <label class="btn btn-outline-success w-100 text-start py-2" for="status_en_service">
                                                    <i class="bx bx-check-circle me-1"></i> <strong>En service</strong>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <input type="radio" class="btn-check" name="status" id="status_revoque" value="revoque" {{ $adherent->post_insertion_status == 'revoque' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger w-100 text-start py-2" for="status_revoque">
                                                    <i class="bx bx-x-circle me-1"></i> <strong>Révoqué</strong>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <input type="radio" class="btn-check" name="status" id="status_demission" value="demission" {{ $adherent->post_insertion_status == 'demission' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-warning w-100 text-start py-2 text-dark" for="status_demission">
                                                    <i class="bx bx-log-out-circle me-1"></i> <strong>Démission</strong>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <input type="radio" class="btn-check" name="status" id="status_indisponible" value="indisponible" {{ $adherent->post_insertion_status == 'indisponible' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-info w-100 text-start py-2" for="status_indisponible">
                                                    <i class="bx bx-time-five me-1"></i> <strong>Indisponibilité</strong>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Champs conditionnels selon le statut -->
                                    <div id="statusFieldsContainer" class="p-3 bg-light rounded-3 border mb-3">
                                        <!-- En service -->
                                        <div class="status-fields" id="fields_en_service">
                                            <div class="mb-2">
                                                <label class="form-label text-dark small fw-semibold">Date de confirmation en service</label>
                                                <input type="date" class="form-control form-control-sm" name="date_en_service" value="{{ $adherent->post_insertion_status == 'en_service' ? ($adherent->post_insertion_date ?? date('Y-m-d')) : date('Y-m-d') }}">
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label text-dark small fw-semibold">Note / Observation (optionnel)</label>
                                                <textarea class="form-control form-control-sm" name="motif_en_service" rows="2" placeholder="Commentaire sur la confirmation en poste...">{{ $adherent->post_insertion_status == 'en_service' ? $adherent->post_insertion_motif : '' }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Révoqué -->
                                        <div class="status-fields" id="fields_revoque" style="display: none;">
                                            <div class="mb-2">
                                                <label class="form-label text-dark small fw-semibold">Date de révocation <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control form-control-sm" name="date_revoque" value="{{ $adherent->post_insertion_status == 'revoque' ? $adherent->post_insertion_date : date('Y-m-d') }}">
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label text-dark small fw-semibold">Motif de révocation <span class="text-danger">*</span></label>
                                                <textarea class="form-control form-control-sm" name="motif_revoque" rows="2" placeholder="Précisez la raison de la révocation...">{{ $adherent->post_insertion_status == 'revoque' ? $adherent->post_insertion_motif : '' }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Démission -->
                                        <div class="status-fields" id="fields_demission" style="display: none;">
                                            <div class="mb-2">
                                                <label class="form-label text-dark small fw-semibold">Date de démission <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control form-control-sm" name="date_demission" value="{{ $adherent->post_insertion_status == 'demission' ? $adherent->post_insertion_date : date('Y-m-d') }}">
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label text-dark small fw-semibold">Motif de démission <span class="text-danger">*</span></label>
                                                <textarea class="form-control form-control-sm" name="motif_demission" rows="2" placeholder="Précisez la raison de la démission...">{{ $adherent->post_insertion_status == 'demission' ? $adherent->post_insertion_motif : '' }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Indisponibilité -->
                                        <div class="status-fields" id="fields_indisponible" style="display: none;">
                                            <div class="row g-2 mb-2">
                                                <div class="col-6">
                                                    <label class="form-label text-dark small fw-semibold">Date début <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control form-control-sm" name="date_indisponible" value="{{ $adherent->post_insertion_status == 'indisponible' ? $adherent->post_insertion_date : date('Y-m-d') }}">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label text-dark small fw-semibold">Date fin <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control form-control-sm" name="date_fin_indisponible" value="{{ $adherent->post_insertion_status == 'indisponible' ? $adherent->post_insertion_date_fin : '' }}">
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label text-dark small fw-semibold">Motif d'indisponibilité <span class="text-danger">*</span></label>
                                                <textarea class="form-control form-control-sm" name="motif_indisponible" rows="2" placeholder="Ex: Congé maladie, convenance personnelle, formation...">{{ $adherent->post_insertion_status == 'indisponible' ? $adherent->post_insertion_motif : '' }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Document justificatif optionnel pour la décision finale -->
                                        <div class="mt-3 pt-2 border-top">
                                            <label class="form-label text-dark small fw-semibold">
                                                <i class="bx bx-paperclip text-primary me-1"></i> Document justificatif <span class="text-muted small">(Optionnel : Lettre, contrat, certificat - max 10 Mo)</span>
                                            </label>
                                            <input type="file" class="form-control form-control-sm" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bx bx-check-shield me-1"></i> Valider la décision finale
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('js-push')
    <script>
        $(document).ready(function() {
            // Configuration CSRF pour AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Gestion du changement de statut pour la Décision Finale
            $('input[name="status"]').on('change', function() {
                const selected = $(this).val();
                $('.status-fields').hide();
                $('#fields_' + selected).fadeIn(200);
            });

            // Déclencher l'affichage du bon groupe de champs au chargement
            const initialStatus = $('input[name="status"]:checked').val() || 'en_service';
            $('.status-fields').hide();
            $('#fields_' + initialStatus).show();

            // Soumission des formulaires de Suivi (Étape 1, 2, 3) avec support FormData (fichiers)
            $('.suivi-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                const step = $(form).data('step');
                const submitBtn = $(form).find('button[type="submit"]');
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Enregistrement...');

                const formData = new FormData(form);
                const url = "{{ url('monitored-evaluation/post_monitored/adherent/' . $adherent->id . '/suivi') }}/" + step;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.action) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            submitBtn.prop('disabled', false).html(originalText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Attention',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalText);
                        let msg = "Une erreur est survenue lors de l'enregistrement.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: msg
                        });
                    }
                });
            });

            // Soumission du formulaire de Décision Finale avec FormData
            $('#decisionForm').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                const submitBtn = $(form).find('button[type="submit"]');
                const originalText = submitBtn.html();

                const status = $('input[name="status"]:checked').val();
                let dateVal = '';
                let dateFinVal = '';
                let motifVal = '';

                if (status === 'en_service') {
                    dateVal = $('input[name="date_en_service"]').val();
                    motifVal = $('textarea[name="motif_en_service"]').val();
                } else if (status === 'revoque') {
                    dateVal = $('input[name="date_revoque"]').val();
                    motifVal = $('textarea[name="motif_revoque"]').val();
                    if (!dateVal || !motifVal.trim()) {
                        Swal.fire({ icon: 'warning', title: 'Champs requis', text: 'Veuillez saisir la date et le motif de révocation.' });
                        return;
                    }
                } else if (status === 'demission') {
                    dateVal = $('input[name="date_demission"]').val();
                    motifVal = $('textarea[name="motif_demission"]').val();
                    if (!dateVal || !motifVal.trim()) {
                        Swal.fire({ icon: 'warning', title: 'Champs requis', text: 'Veuillez saisir la date et le motif de démission.' });
                        return;
                    }
                } else if (status === 'indisponible') {
                    dateVal = $('input[name="date_indisponible"]').val();
                    dateFinVal = $('input[name="date_fin_indisponible"]').val();
                    motifVal = $('textarea[name="motif_indisponible"]').val();
                    if (!dateVal || !dateFinVal || !motifVal.trim()) {
                        Swal.fire({ icon: 'warning', title: 'Champs requis', text: 'Veuillez renseigner la date début, la date fin et le motif d\'indisponibilité.' });
                        return;
                    }
                }

                const formData = new FormData(form);
                formData.set('status', status);
                formData.set('date', dateVal);
                formData.set('date_fin', dateFinVal);
                formData.set('motif', motifVal);

                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Enregistrement...');

                const url = "{{ route('monitored-evaluation.post_monitored.save_decision', $adherent->id) }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.action) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            submitBtn.prop('disabled', false).html(originalText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Attention',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalText);
                        let msg = "Une erreur est survenue lors de l'enregistrement de la décision.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: msg
                        });
                    }
                });
            });
        });
    </script>
@endpush