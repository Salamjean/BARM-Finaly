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
                    <i class="bx bx-check-circle text-success fs-3 me-3"></i>
                    <div>
                        <h4 class="mb-0 text-success">Plans d'affaire validés</h4>
                        <p class="text-muted mb-0">Candidats avec des plans d'affaire approuvés par commission</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $candidats->count() }}
                        </div>
                        <div class="small text-muted">Total validés</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3 shadow-none">

            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-success">
                                <th class="border-0">
                                    <i class="bx bx-layer-group text-success me-1"></i>
                                    Cohorte
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-map-pin text-success me-1"></i>
                                    Point Focal
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-gavel text-success me-1"></i>
                                    Commission
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-success me-1"></i>
                                    Candidat
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-briefcase text-success me-1"></i>
                                    Partenaire technique
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-map text-success me-1"></i>
                                    Localisation
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-folder text-success me-1"></i>
                                    Projet
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-file-blank text-success me-1"></i>
                                    Plan d'affaire
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-success me-1"></i>
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
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-bold text-info">
                                                        {{ $adherent->focal_point_area ?? 'Non assigné' }}</div>
                                                    <div class="small text-muted">Point focal géographique</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($adherent->paAccepted && $adherent->paAccepted->commission)
                                            <div class="border-start border-success border-3 ps-2 py-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-gavel text-success me-2"></i>
                                                    <div>
                                                        <div class="fw-bold text-success">
                                                            {{ $adherent->paAccepted->commission->number }}</div>
                                                        <div class="small text-muted">
                                                            {{ dateFr($adherent->paAccepted->commission->date) }}</div>
                                                        <div class="small text-muted">
                                                            {{ $adherent->paAccepted->commission->lieu }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-gavel text-muted me-2"></i>
                                                <span class="text-muted">Non définie</span>
                                            </div>
                                        @endif
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
                                                <div class="fw-medium">
                                                    {{ $adherent->paAccepted->location ?? 'Non définie' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-success border-3 ps-2 py-1">
                                            <div class="fw-medium text-success">
                                                {{ $adherent->paAccepted->title ?? 'Projet non défini' }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($adherent->paAccepted && $adherent->paAccepted->url)
                                            <div class="border-start border-success border-3 ps-2 py-1">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-medium text-success">
                                                            <a href="{{ asset($adherent->paAccepted->url) }}"
                                                                title="Télécharger le plan d'affaire" target="_blank"
                                                                class="text-success text-decoration-none">
                                                                <i class="bx bx-download me-1"></i>
                                                                Télécharger
                                                            </a>
                                                        </div>
                                                        @if ($adherent->paAccepted->credit)
                                                            <div class="small text-muted">
                                                                <i class="bx bx-money me-1"></i>
                                                                {{ amount($adherent->paAccepted->credit, true) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Non disponible</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $adherent->user->id) }}"
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
