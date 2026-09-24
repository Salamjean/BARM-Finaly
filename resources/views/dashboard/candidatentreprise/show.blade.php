@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush

    <div class="container-fluid flex-grow-1 container-p-y px-4">
        <!-- Breadcrumb & Bouton Retour -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-buildings text-primary fs-3 me-3"></i>
                        <div>
                            <div class="text-muted small">Mise à disposition &bull; Détail Entreprise</div>
                            <h4 class="mb-0 text-primary fw-bold">{{ $entreprise }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="{{ $type === 'integre' ? route('candidatentreprises.integres') : route('candidatentreprises.envoi') }}" 
                   class="btn btn-outline-secondary shadow-sm">
                    <i class="bx bx-arrow-back me-1"></i> Retour à la liste
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bx bx-check-circle me-2 fs-5 align-middle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bx bx-error-circle me-2 fs-5 align-middle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- En-tête / Cartes récapitulatives -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 p-3 bg-light-primary text-primary me-3">
                            <i class="bx bx-building fs-2"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold text-dark">{{ $entreprise }}</h4>
                            <p class="text-muted small mb-0">
                                @if ($date && $date !== 'all')
                                    <i class="bx bx-calendar me-1"></i> Mise à disposition du : <strong>{{ dateFr($date, 'letter') }}</strong>
                                @else
                                    <i class="bx bx-layer me-1"></i> Tous les candidats associés à cette structure
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="text-center px-3 py-2 bg-light rounded-3 border">
                            <h5 class="mb-0 fw-bold text-primary">{{ $candidatentreprises->count() }}</h5>
                            <small class="text-muted">Total Candidats</small>
                        </div>
                        <div class="text-center px-3 py-2 bg-light rounded-3 border">
                            <h5 class="mb-0 fw-bold text-warning">{{ $candidatentreprises->where('statut', 'pending')->count() }}</h5>
                            <small class="text-muted">En attente</small>
                        </div>
                        <div class="text-center px-3 py-2 bg-light rounded-3 border">
                            <h5 class="mb-0 fw-bold text-success">{{ $candidatentreprises->where('statut', 'accepted')->count() }}</h5>
                            <small class="text-muted">Intégrés / En poste</small>
                        </div>
                        <div class="text-center px-3 py-2 bg-light rounded-3 border">
                            <h5 class="mb-0 fw-bold text-danger">{{ $candidatentreprises->where('statut', 'refused')->count() }}</h5>
                            <small class="text-muted">Refusés</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des candidats de cette entreprise -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bx bx-group text-primary me-2"></i> Liste des candidats
                </h5>
                <span class="badge bg-primary rounded-pill">{{ $candidatentreprises->count() }} candidat(s)</span>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped table-hover align-middle" id="datatable-candidats-entreprise" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 25%;">Candidat</th>
                                <th style="width: 15%;">Poste</th>
                                <th style="width: 15%;">Statut</th>
                                <th style="width: 15%;">Contrat & Période</th>
                                <th style="width: 10%;">Date mise à dispo</th>
                                <th style="width: 15%;" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($candidatentreprises as $item)
                                <tr>
                                    <td class="text-muted">{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->candidature->user ? $item->candidature->user->fullName() : 'Candidat' }}</div>
                                        <div class="small text-muted">
                                            <span class="badge bg-secondary me-1">{{ $item->candidature->user->mecano ?? 'N/A' }}</span>
                                            <span>{{ $item->candidature->phone_number ?? ($item->candidature->user->phone ?? '') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $item->poste ?: 'Non précisé' }}</span>
                                        @if ($item->service)
                                            <div class="small text-muted mt-1"><i class="bx bx-layer me-1"></i> {{ $item->service }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->statut === 'pending')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bx bx-time me-1"></i> En cours de traitement
                                            </span>
                                        @elseif ($item->statut === 'accepted')
                                            <span class="badge bg-success">
                                                <i class="bx bx-check-circle me-1"></i> Accepté / En poste
                                            </span>
                                        @elseif ($item->statut === 'refused')
                                            <span class="badge bg-danger">
                                                <i class="bx bx-x me-1"></i> Rejeté
                                            </span>
                                        @elseif ($item->statut === 'finished')
                                            <span class="badge bg-secondary">
                                                <i class="bx bx-stop-circle me-1"></i> Terminé
                                            </span>
                                        @else
                                            <span class="badge bg-light text-dark">{{ $item->statut }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->type_contrat || $item->contrat)
                                            <div class="d-flex align-items-center gap-1">
                                                <span class="badge bg-info text-white">{{ $item->type_contrat ?: 'Contrat' }}</span>
                                                @if ($item->contrat)
                                                    <a href="{{ asset($item->contrat) }}" 
                                                       class="btn btn-xs btn-outline-success" 
                                                       download 
                                                       target="_blank" 
                                                       title="Télécharger le contrat">
                                                        <i class="bx bx-download"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                        @if ($item->date_db)
                                            <div class="small text-muted mt-1">
                                                Du {{ dateFr($item->date_db, 'dayMonthYear') }} {{ $item->date_fin ? 'au ' . dateFr($item->date_fin, 'dayMonthYear') : '' }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small text-muted">
                                            <i class="bx bx-calendar me-1"></i> {{ dateFr($item->date_mise_disposition, 'letter') }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                                            <!-- Bouton Suivre / Changer Statut (modal) -->
                                            @if ((can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion')) && $item->statut == 'pending')
                                                <button type="button" 
                                                        class="btn btn-warning btn-sm shadow-sm"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#rapportModal{{ $item->id }}"
                                                        title="Évaluer / Décision de l'entreprise">
                                                    <i class="bx bx-edit me-1"></i> Suivre
                                                </button>
                                            @endif

                                            <!-- Bouton Dossier Synthèse -->
                                            <a href="{{ route('candidatentreprises.synthese_parcours', $item->candidature_id) }}" 
                                               class="btn btn-outline-info btn-sm shadow-sm" 
                                               title="Voir le dossier / parcours du candidat">
                                                <i class="bx bx-folder-open me-1"></i> Dossier
                                            </a>

                                            <!-- Bouton Fiche Adhérent -->
                                            @if ($item->candidature->user)
                                                <a href="{{ route('adherent.show', $item->candidature->user->id) }}" 
                                                   class="btn btn-outline-secondary btn-sm shadow-sm" 
                                                   title="Fiche profil">
                                                    <i class="bx bx-user"></i>
                                                </a>
                                            @endif

                                            <!-- Bouton Suivre (Suivi post-insertion) pour les candidats intégrés -->
                                            @if ($item->statut == 'accepted')
                                                <a href="{{ route('monitored-evaluation.post_monitored.adherent', $item->candidature_id) }}" 
                                                   class="btn btn-success btn-sm shadow-sm" 
                                                   title="Ouvrir le suivi post-insertion">
                                                    <i class="bx bx-check-shield me-1"></i> Suivre
                                                </a>
                                            @endif
                                        </div>

                                        <!-- Modal Suivi & Décision -->
                                        @if ((can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion')) && $item->statut == 'pending')
                                            <div id="rapportModal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content border-0 shadow">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title text-white">
                                                                <i class="bx bx-briefcase me-1"></i> Compte rendu & Décision : {{ $item->candidature->user ? $item->candidature->user->fullName() : 'Candidat' }}
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('candidatentreprises.changestatut') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="candidatentreprise_id" value="{{ $item->id }}">
                                                            <div class="modal-body p-4 text-start">
                                                                <div class="alert alert-info py-2 small mb-3">
                                                                    <strong>Entreprise :</strong> {{ $item->entreprise }} &bull; <strong>Poste initial :</strong> {{ $item->poste }} &bull; <strong>Date :</strong> {{ dateFr($item->date_mise_disposition, 'letter') }}
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold text-dark">Décision de l'entreprise <span class="text-danger">*</span> : </label>
                                                                    <select class="form-select" name="statut" id="statut{{ $item->id }}" onchange="toggleStatut({{ $item->id }})" required>
                                                                        <option value="" disabled selected>-- Choisir une décision --</option>
                                                                        <option value="accepted">🟢 Candidature acceptée (Intégrer le candidat en poste)</option>
                                                                        <option value="refused">🔴 Candidature refusée / non retenue</option>
                                                                    </select>
                                                                </div>

                                                                <div id="other{{ $item->id }}" style="display: none;">
                                                                    <div class="row g-3">
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Poste confirmé : </label>
                                                                            <input class="form-control" type="text" name="poste_confirme" value="{{ $item->poste }}" placeholder="Poste occupé">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Lieu d'affectation : </label>
                                                                            <input class="form-control" type="text" name="localisation" placeholder="Ex: Abidjan, Bouaké...">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Service / Département : </label>
                                                                            <input class="form-control" type="text" name="service" placeholder="Ex: Maintenance, Logistique...">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Type de contrat : </label>
                                                                            <select class="form-select" name="type_contrat">
                                                                                <option value="CDI">CDI</option>
                                                                                <option value="CDD">CDD</option>
                                                                                <option value="Stage">Stage / Période d'essai</option>
                                                                                <option value="Autre">Autre</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Date de début : </label>
                                                                            <input class="form-control" type="date" name="date_db" value="{{ date('Y-m-d') }}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Date de fin (optionnel) : </label>
                                                                            <input class="form-control" type="date" name="date_fin">
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label class="form-label fw-semibold text-dark">Contrat / Attestation de travail (fichier) : </label>
                                                                            <input class="form-control" type="file" name="contrat">
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label class="form-label fw-semibold text-dark">Commentaires / Observations : </label>
                                                                            <textarea name="commentaire" class="form-control" rows="3" placeholder="Remarques et conditions de travail..."></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Enregistrer la décision</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bx bx-group fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                        <h6 class="fw-bold mb-1">Aucun candidat pour cette entreprise</h6>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            function toggleStatut(id) {
                var statutSelect = document.getElementById("statut" + id);
                var otherDiv = document.getElementById("other" + id);
                if (statutSelect && otherDiv) {
                    if (statutSelect.value === "accepted") {
                        otherDiv.style.display = "block";
                    } else {
                        otherDiv.style.display = "none";
                    }
                }
            }

            (function($) {
                "use strict";

                if ($('#datatable-candidats-entreprise').length) {
                    $('#datatable-candidats-entreprise').DataTable({
                        responsive: true,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
                        }
                    });
                }

                // Confirmation pour terminer le poste d'un candidat intégré
                $('.end-poste-btn').on('click', function(e) {
                    e.preventDefault();
                    var candidatId = $(this).data('candidat-id');
                    var candidatNom = $(this).data('candidat-nom');

                    Swal.fire({
                        title: "Terminer le poste ?",
                        text: "Voulez-vous clôturer la période de placement de " + candidatNom + " dans cette entreprise ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Oui, terminer",
                        cancelButtonText: "Annuler"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#endPosteForm-' + candidatId).submit();
                        }
                    });
                });
            })(jQuery);
        </script>
    @endpush
@endsection