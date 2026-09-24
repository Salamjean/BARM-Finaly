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
                        <i class="bx bx-check-shield text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Profilage &bull; Entreprise Privée</div>
                            <h4 class="mb-0 text-primary">Rendez-vous 3 : Validation / Décision</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3">
                        <i class="bx bx-badge-check fs-3"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 text-dark">Candidats prêts pour la décision</h5>
                        <small class="text-muted">Candidats ayant complété l'entretien (RDV 1) et le bilan de compétences (RDV 2)</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-primary fs-6 px-3 py-2">
                            {{ $candidats->count() }}
                        </div>
                        <small class="text-muted d-block">Candidats éligibles</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des candidats éligibles à la décision -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th class="border-0">#</th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i> Candidat
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-calendar-check text-primary me-1"></i> RDV 1 : Entretien
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-chart text-primary me-1"></i> RDV 2 : Bilan
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-gavel text-primary me-1"></i> Décision de Profilage
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i> Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($candidats as $index => $candidat)
                                @php
                                    $entretiensCount = $candidat->candidatentretiens()->where('presence', 1)->count();
                                    $bilansCount = $candidat->bilancompetences()->where('presence', 1)->count();
                                @endphp
                                <tr class="align-middle">
                                    <td>
                                        <span class="badge bg-light text-secondary border">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
                                                {{ strtoupper(substr($candidat->user->firstname ?? 'C', 0, 1) . substr($candidat->user->lastname ?? 'A', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $candidat->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-secondary me-1">Matricule: {{ $candidat->user->mecano ?? 'N/A' }}</span>
                                                    <span>{{ $candidat->phone_number ?? $candidat->user->phone ?? '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success px-2 py-1">
                                            <i class="bx bx-check me-1"></i> Effectué ({{ $entretiensCount }})
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success px-2 py-1">
                                            <i class="bx bx-check me-1"></i> Effectué ({{ $bilansCount }})
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" 
                                                class="btn btn-sm btn-primary px-3 shadow-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#decisionModal{{ $candidat->id }}">
                                            <i class="bx bx-gavel me-1"></i> Donner la décision
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('candidatentreprises.synthese_parcours', $candidat->id) }}" 
                                           class="btn btn-outline-primary btn-sm shadow-sm" 
                                           title="Consulter toute la synthèse du parcours du candidat">
                                            <i class="bx bx-folder-open me-1"></i> Voir dossier
                                        </a>
                                    </td>
                                </tr>

                                <!-- Modal Décision pour le candidat -->
                                <div class="modal fade" id="decisionModal{{ $candidat->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title text-white">
                                                    <i class="bx bx-shield-quarter me-1"></i> Décision de Profilage : {{ $candidat->user->fullName() }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="text-center mb-3">
                                                    <p class="text-muted mb-1 small">Parcours initial : <strong>Entreprise Privée</strong></p>
                                                    <p class="small text-secondary mb-2">
                                                        Après examen de l'entretien et du bilan de compétences, quelle est la décision d'orientation pour ce candidat ?
                                                    </p>
                                                    <a href="{{ route('candidatentreprises.synthese_parcours', $candidat->id) }}" 
                                                       class="btn btn-outline-primary btn-sm mb-1">
                                                        <i class="bx bx-folder-open me-1"></i> Ouvrir la synthèse du parcours
                                                    </a>
                                                </div>

                                                <!-- Option 1 : Confirmer -->
                                                <form action="{{ route('adherent.decision.profilage', $candidat->id) }}" method="POST" class="mb-3">
                                                    @csrf
                                                    <input type="hidden" name="decision" value="confirm">
                                                    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold shadow-sm">
                                                        <i class="bx bx-check-circle me-1 fs-5 align-middle"></i> Confirmer en Entreprise Privée
                                                    </button>
                                                </form>

                                                <div class="d-flex align-items-center my-3">
                                                    <hr class="flex-grow-1">
                                                    <span class="px-2 text-muted small fw-semibold">OU REFUSER & RÉORIENTER</span>
                                                    <hr class="flex-grow-1">
                                                </div>

                                                <!-- Option 2 : Refuser & Réorienter -->
                                                <form action="{{ route('adherent.decision.profilage', $candidat->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="decision" value="reject">

                                                    <div class="mb-3 text-start">
                                                        <label class="form-label fw-semibold text-dark small">
                                                             Nouvelle orientation <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="new_orientation" class="form-select" required>
                                                            <option value="" disabled selected>-- Choisir le nouveau parcours --</option>
                                                            <option value="auto-emploi">🌱 Auto-Emploi</option>
                                                            <option value="fonction-publique">🏛️ Fonction Publique</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3 text-start">
                                                        <label class="form-label fw-semibold text-dark small">
                                                            Motif de la réorientation
                                                        </label>
                                                        <textarea name="motif" rows="2" class="form-control" placeholder="Indiquez le motif ou les remarques sur le profil..."></textarea>
                                                    </div>

                                                    <button type="submit" class="btn btn-warning w-100 py-2 fw-semibold text-dark shadow-sm">
                                                        <i class="bx bx-transfer-alt me-1 fs-5 align-middle"></i> Refuser & Réattribuer le candidat
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bx bx-info-circle fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                        <p class="mb-1 fw-bold">Aucun candidat prêt pour la décision de profilage</p>
                                        <small class="text-muted">Les candidats doivent d'abord valider leur Entretien (RDV 1) puis leur Bilan de compétences (RDV 2) pour apparaître ici.</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
