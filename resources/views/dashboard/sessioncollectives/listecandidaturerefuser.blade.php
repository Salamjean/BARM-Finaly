@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush

    <div class="container-fluid">
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-group text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Sessions collectives d'informations</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-user-plus text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Candidatures</h5>
                        <small class="text-muted">Gestion des candidatures pour la session</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $candidatures->count() }}
                        </div>
                        <small class="text-muted d-block">Candidatures</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3 mb-3">
            <div class="p-4">
                <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active d-flex align-items-center justify-content-center" id="waiting-tab"
                            data-bs-toggle="pill" data-bs-target="#waiting" type="button" role="tab"
                            aria-controls="waiting" aria-selected="true">
                            <i class="bx bx-time-five me-2"></i>
                            Candidat en attente de profilage
                            <span class="badge bg-warning ms-2" id="count-waiting">{{ $candidatures->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center justify-content-center" id="refused-tab"
                            data-bs-toggle="pill" data-bs-target="#refused" type="button" role="tab"
                            aria-controls="refused" aria-selected="false">
                            <i class="bx bx-x-circle me-2"></i>
                            Historique des refus
                            <span class="badge bg-danger ms-2"
                                id="count-refused">{{ $candidaturepartenaires->count() }}</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="waiting" role="tabpanel" aria-labelledby="waiting-tab">
                <div class="bg-white rounded-3 ">
                    <div class="p-4">
                        <div class="table-responsive">
                            <table class="dt-responsive table table-hover" id="datatable-waiting" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="border-0">
                                            <i class="bx bx-hash text-primary me-1"></i>
                                        </th>
                                        <th class="border-0">
                                            Date d'ajout
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-user text-primary me-1"></i>
                                            Nom & Prénoms
                                        </th>
                                        <th class="border-0">
                                            Cohorte
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-user-x text-primary me-1"></i>
                                            Partenaire qui a refusé
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-message-square-x text-primary me-1"></i>
                                            Ancien motif de refus
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
                                                    <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-medium">{{ dateFr($candidat->created_at) }}</div>
                                                        <small
                                                            class="text-muted">{{ dateFr($candidat->created_at, 'complet') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $candidat->user->fullName() }}
                                                        </div>
                                                        <div class="small text-muted">
                                                            <span
                                                                class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>
                                                            <span>{{ $candidat->phone_number }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="border-start border-warning border-3 ps-2 py-1">
                                                    <div class="fw-medium">{{ $candidat->cohort->title }}</div>
                                                </div>
                                            </td>

                                            <td>
                                                @php
                                                    $dernierRefus = $candidat->partenaires->first();
                                                @endphp
                                                @if ($dernierRefus)
                                                    <div class="border-start border-primary border-3 ps-2 py-1">
                                                        <div class="d-flex align-items-center">
                                                            <span
                                                                class="badge bg-primary">{{ $dernierRefus->user->username }}</span>
                                                        </div>
                                                        <small class="text-muted">Partenaire technique</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($dernierRefus)
                                                    <div class="border-start border-danger border-3 ps-2 py-1">
                                                        <div class="text-danger small">
                                                            {{ $dernierRefus->pivot->reason_rejet ?? 'Aucun motif spécifié' }}
                                                        </div>
                                                        <small class="text-muted">
                                                            Refusé le {{ dateFr($dernierRefus->pivot->updated_at) }}
                                                        </small>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button" class="btn btn-outline-success btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#modalAssignPartner"
                                                        data-candidature-id="{{ $candidat->id }}"
                                                        data-candidature-name="{{ $candidat->user->fullName() }}"
                                                        title="Assigner un nouveau partenaire">
                                                        <i class="bx bx-user-plus"></i>
                                                    </button>
                                                    <a href="{{ route('adherent.show', $candidat->user->id) }}"
                                                        class="btn btn-outline-primary btn-sm"
                                                        title="Voir le profil de l'adhérent">
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

            <div class="tab-pane fade" id="refused" role="tabpanel" aria-labelledby="refused-tab">
                <div class="bg-white rounded-3">
                    <div class="p-4">
                        <div class="table-responsive">
                            <table class="dt-responsive table table-hover" id="datatable-refused" style="width:100%">
                                <thead>
                                    <tr class="table-danger">
                                        <th class="border-0">
                                            <i class="bx bx-hash text-danger me-1"></i>
                                        </th>
                                        <th class="border-0">
                                            Date de refus
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-user text-danger me-1"></i>
                                            Nom & Prénoms
                                        </th>
                                        <th class="border-0">
                                            Cohorte
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-message-square-detail text-danger me-1"></i>
                                            Motif de refus
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-briefcase text-danger me-1"></i>
                                            Partenaire technique
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-cog text-danger me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($candidaturepartenaires as $index => $refus)
                                        <tr class="align-middle">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-danger me-2">{{ $index + 1 }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-medium">{{ dateFr($refus->updated_at) }}</div>
                                                        <small
                                                            class="text-muted">{{ dateFr($refus->updated_at, 'complet') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-bold text-dark">
                                                            {{ $refus->candidature->user->fullName() }}</div>
                                                        <div class="small text-muted">
                                                            <span
                                                                class="badge bg-secondary me-1">{{ $refus->candidature->user->mecano }}</span>
                                                            <span>{{ $refus->candidature->phone_number }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="border-start border-warning border-3 ps-2 py-1">
                                                    <div class="fw-medium">{{ $refus->candidature->cohort->title ?? '-' }}</div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="border-start border-danger border-3 ps-2 py-1">
                                                    <div class="text-danger small">
                                                        {{ $refus->reason_rejet ?? 'Aucun motif spécifié' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="border-start border-primary border-3 ps-2 py-1">
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="badge bg-primary">{{ $refus->partenaire->user->username }}</span>
                                                    </div>
                                                    <small class="text-muted">Partenaire</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button" class="btn btn-outline-success btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#modalAssignPartner"
                                                        data-candidature-id="{{ $refus->candidature->id }}"
                                                        data-candidature-name="{{ $refus->candidature->user->fullName() }}"
                                                        title="Assigner un nouveau partenaire">
                                                        <i class="bx bx-user-plus"></i>
                                                    </button>
                                                    <a href="{{ route('adherent.show', $refus->candidature->user->id) }}"
                                                        class="btn btn-outline-danger btn-sm"
                                                        title="Voir le profil de l'adhérent">
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
        </div>
    </div>

    <!-- Modal pour assigner un nouveau partenaire -->
    <div class="modal fade" id="modalAssignPartner" tabindex="-1" aria-labelledby="modalAssignPartnerLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="modalAssignPartnerLabel">
                        <i class="bx bx-user-plus me-2"></i>
                        Assigner un nouveau partenaire technique
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="formAssignPartner" method="POST" action="{{ route('sessioncollectives.assign-partner') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="candidature_id" id="candidature_id">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Candidat</label>
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <i class="bx bx-user fs-4 me-2"></i>
                                <span id="candidature_name"></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="partenaire_id" class="form-label fw-bold">
                                Sélectionner le nouveau partenaire technique <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="partenaire_id" id="partenaire_id" required>
                                <option value="">-- Choisir un partenaire --</option>
                                @foreach ($partenaires as $partenaire)
                                    <option value="{{ $partenaire->id }}">
                                        {{ $partenaire->user->username }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x me-1"></i>
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check me-1"></i>
                            Assigner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            (function() {
                function initModal() {
                    var modalEl = document.getElementById('modalAssignPartner');

                    if (!modalEl) return;

                    modalEl.addEventListener('show.bs.modal', function(event) {
                        var button = event.relatedTarget;

                        if (!button) return;

                        var candidatureId = button.getAttribute('data-candidature-id');
                        var candidatureName = button.getAttribute('data-candidature-name');

                        var inputId = document.getElementById('candidature_id');
                        var spanName = document.getElementById('candidature_name');

                        if (inputId && candidatureId) {
                            inputId.value = candidatureId;
                        }

                        if (spanName && candidatureName) {
                            spanName.textContent = candidatureName;
                        }

                        var selectPartenaire = document.getElementById('partenaire_id');
                        var textareaComment = document.getElementById('commentaire');

                        if (selectPartenaire) selectPartenaire.value = '';
                        if (textareaComment) textareaComment.value = '';
                    });
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initModal);
                } else {
                    initModal();
                }
            })();
        </script>
    @endpush
@endsection
