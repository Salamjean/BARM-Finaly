@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-map-pin text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Accueil</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-target-lock text-warning fs-3 me-3"></i>
                    <div>
                        <h4 class="mb-0 text-warning">Candidats en attente de point focal</h4>

                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $candidats->whereNotNull('partnerTechnical')->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3 shadow-none">

            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th class="border-0">
                                    <i class="bx bx-layer-group text-primary me-1"></i>
                                    Cohorte
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom / Prénoms
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-briefcase text-primary me-1"></i>
                                    Partenaire technique
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-map text-primary me-1"></i>
                                    Adresse géographique
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-folder text-primary me-1"></i>
                                    Titre du projet
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-file-blank text-primary me-1"></i>
                                    Plan d'affaire
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidats as $index => $adherent)
                                <tr class="align-middle">
                                    <td>
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="fw-bold text-info">{{ $adherent->cohort->title }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $adherent->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span
                                                        class="badge bg-secondary me-1">{{ $adherent->user->mecano }}</span>
                                                    <span>{{ $adherent->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($adherent->partnerTechnical)
                                            <div class="border-start border-primary border-3 ps-2 py-1">
                                                <div class="d-flex align-items-center">
                                                    <span
                                                        class="badge bg-primary">{{ $adherent->partnerTechnical->user->username }}</span>
                                                </div>
                                                <small class="text-muted">Partenaire technique</small>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <div class="bg-secondary rounded-circle me-2"
                                                    style="width: 8px; height: 8px;"></div>
                                                <span class="badge bg-secondary">Non assigné</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-map-pin text-success me-2"></i>
                                            <div>
                                                <div class="fw-medium">{{ $adherent->paPending->location ?? 'Non définie' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-success border-3 ps-2 py-1">
                                            <div class="fw-medium text-success">
                                                {{ $adherent->paPending->title ?? 'Projet non défini' }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-success border-3 ps-2 py-1">
                                            <a href="{{ asset($adherent->paPending->url) }}"
                                                title="Télécharger le plan d'affaire" target="_blank"
                                                class="fw-medium text-success" download><i
                                                    class="bx bx-file-blank me-1"></i></a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $adherent->user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>

                                                <button type="button" class="btn btn-outline-warning btn-sm open-modal-btn"
                                                    data-adherent-id="{{ $adherent->id }}" title="Ajouter un point focal">
                                                    <i class="bx bx-map-pin me-1"></i>
                                                    Point focal
                                                </button>
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm open-refuse-modal-btn"
                                                    data-adherent-id="{{ $adherent->id }}"
                                                    data-adherent-name="{{ $adherent->user->fullName() }}"
                                                    data-adherent-mecano="{{ $adherent->user->mecano }}"
                                                    title="Refuser le plan d'affaire">
                                                    <i class="bx bx-x me-1"></i>
                                                    Refuser
                                                </button>
                                            
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

    <div class="modal fade" id="addFocalPointModal" tabindex="-1" aria-labelledby="addFocalPointModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-none">
                <div class="modal-header text-white">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-map-pin me-2 fs-4"></i>
                        <h5 class="modal-title mb-0" id="addFocalPointModalLabel">Ajout Point Focal</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <i class="bx bx-target-lock text-warning fs-1 mb-3"></i>
                        <h6 class="text-muted">Assigner un point focal pour le suivi du projet</h6>
                    </div>

                    <form id="addFocalPointForm" action="{{ route('pre_commission.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="adherent_id" id="adherentIdInput">

                        <div class="mb-4">
                            <label for="focalPointSelect" class="form-label">
                                <i class="bx bx-map-pin text-warning me-1"></i>
                                Point Focal <span class="text-danger">*</span>
                            </label>
                            <select name="focal_point_area" id="focalPointSelect" class="form-select" required>
                                <option value="" disabled selected>Sélectionner un point focal</option>
                                @foreach (FOCAL_POINT as $focalPoint)
                                    <option value="{{ $focalPoint }}">{{ $focalPoint }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                <i class="bx bx-info-circle me-1"></i>
                                Choisissez le point focal géographique pour le suivi du projet
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x me-1"></i>
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-warning">
                                <i class="bx bx-check me-1"></i>
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="refusePlanModal" tabindex="-1" aria-labelledby="refusePlanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-none">
                <div class="modal-header text-white">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-x-circle me-2 fs-4"></i>
                        <h5 class="modal-title mb-0" id="refusePlanModalLabel">Refuser le Plan d'Affaire</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <i class="bx bx-error-circle text-danger fs-1 mb-3"></i>
                        <h6 class="text-muted">Confirmer le refus du plan d'affaire</h6>
                    </div>

                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-user-circle text-info me-2 fs-4"></i>
                            <div>
                                <strong id="refuseAdherentName"></strong>
                                <div class="small text-muted">
                                    <span class="badge bg-secondary me-1" id="refuseAdherentMecano"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="refusePlanForm" action="{{ route('pre_commission.refuse') }}" method="POST">
                        @csrf
                        <input type="hidden" name="adherent_id" id="refuseAdherentIdInput">

                        <div class="mb-4">
                            <label for="refuseReason" class="form-label">
                                <i class="bx bx-message-square-detail text-danger me-1"></i>
                                Raison du refus <span class="text-danger">*</span>
                            </label>
                            <textarea name="refuse_reason" id="refuseReason" class="form-control" rows="4"
                                placeholder="Veuillez expliquer les raisons du refus du plan d'affaire..." required></textarea>
                            <div class="form-text">
                                <i class="bx bx-info-circle me-1"></i>
                                Cette information sera enregistrée et pourra être consultée ultérieurement
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x me-1"></i>
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="bx bx-check me-1"></i>
                                Confirmer le refus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush

    @push('js-push')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('addFocalPointModal'));
                const refuseModal = new bootstrap.Modal(document.getElementById('refusePlanModal'));

                document.querySelectorAll('.open-modal-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const adherentId = this.getAttribute('data-adherent-id');
                        document.getElementById('adherentIdInput').value = adherentId;
                        modal.show();
                    });
                });

                document.querySelectorAll('.open-refuse-modal-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const adherentId = this.getAttribute('data-adherent-id');
                        const adherentName = this.getAttribute('data-adherent-name');
                        const adherentMecano = this.getAttribute('data-adherent-mecano');

                        document.getElementById('refuseAdherentIdInput').value = adherentId;
                        document.getElementById('refuseAdherentName').textContent = adherentName;
                        document.getElementById('refuseAdherentMecano').textContent = adherentMecano;

                        // Réinitialiser le formulaire
                        document.getElementById('refuseReason').value = '';

                        refuseModal.show();
                    });
                });

                document.getElementById('addFocalPointForm').addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Enregistrement...';
                    submitBtn.disabled = true;
                });

                document.getElementById('refusePlanForm').addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Traitement...';
                    submitBtn.disabled = true;
                });
            });
        </script>
    @endpush
@endsection
