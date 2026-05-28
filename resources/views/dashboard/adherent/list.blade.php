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
                        <i class="bx bx-group text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Adhérents</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec bouton d'action -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-user-check text-success fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Gestion des adhérents</h5>
                        <small class="text-muted">Liste complète des candidatures</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $submissions->count() }}
                        </div>
                        <small class="text-muted d-block">Adhérents</small>
                    </div>
                    @if (can(
                            'conseiller-auto-emploi|conseiller-entreprise-prive|conseiller-fonction-public|point-focal|conseiller-en-reconversion') || can('chef-cellule-formation-et-insertion'))
                        <a href="{{ route('adherent.create') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="bx bx-plus me-2"></i>
                            Ajout d'un adhérent
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tableau des adhérents -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th class="border-0">
                                    <i class="bx bx-calendar-plus text-primary me-1"></i>
                                    Editer le
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-id-card text-primary me-1"></i>
                                    Mecano
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>

                                <th class="border-0">
                                    <i class="bx bx-calendar-check text-primary me-1"></i>
                                    Date d'inscription
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-compass text-primary me-1"></i>
                                    Orientation
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-check-circle text-primary me-1"></i>
                                    Statut
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($submissions as $index => $submission)
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                            <div>
                                                <div class="fw-medium">{{ dateFr($submission->created_at) }}</div>
                                                <small
                                                    class="text-muted">{{ dateFr($submission->created_at, 'complet') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="fw-bold text-info">{{ $submission->user->mecano }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $submission->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span
                                                        class="badge bg-secondary me-1">{{ $submission->user->mecano }}</span>
                                                    <span>{{ $submission->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="border-start border-success border-3 ps-2 py-1">
                                            <div class="fw-medium text-success">
                                                {{ dateFr($submission->date_inscription) }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-warning border-3 ps-2 py-1">
                                            <div class="fw-medium text-warning">{{ $submission->orientation }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $stepStatus = stepCandidature($submission->step);
                                            $stepClass = 'bg-info'; // Default

                                            if (
                                                str_contains($stepStatus, 'Terminé') ||
                                                str_contains($stepStatus, 'Complété')
                                            ) {
                                                $stepClass = 'bg-success';
                                            } elseif (
                                                str_contains($stepStatus, 'En cours') ||
                                                str_contains($stepStatus, 'Progression')
                                            ) {
                                                $stepClass = 'bg-warning';
                                            } elseif (
                                                str_contains($stepStatus, 'En attente') ||
                                                str_contains($stepStatus, 'Pending')
                                            ) {
                                                $stepClass = 'bg-secondary';
                                            }
                                        @endphp
                                        <div class="d-flex align-items-center">
                                            <div class="bg-{{ str_replace('bg-', '', $stepClass) }} rounded-circle me-2"
                                                style="width: 8px; height: 8px;"></div>
                                            <span class="badge {{ $stepClass }}">{{ $stepStatus }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $submission->user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            @if ($submission->step != 'completed')
                                                <a href="{{ route('adherent.step', [$submission->step, $submission->user->id]) }}"
                                                    class="btn btn-outline-warning btn-sm" title="Continuer l'étape">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>
                                            @endif
                                            @if (can('chef-cellule-formation-et-insertion') && !str_contains($submission->user->mecano, '-'))
                                                <button type="button" class="btn btn-outline-info btn-sm"
                                                    title="Dupliquer la candidature"
                                                    onclick="confirmDuplicate({{ $submission->id }}, '{{ $submission->user->fullName() }}', '{{ $submission->user->mecano }}', '{{ $submission->orientation }}')">
                                                    <i class="bx bx-duplicate"></i>
                                                </button>
                                            @endif
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

    @if (can('chef-cellule-formation-et-insertion') && !str_contains($submission->user->mecano, '-'))
        <!-- Modal de confirmation pour la duplication -->
        <div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-dark">
                        <h5 class="modal-title" id="duplicateModalLabel">
                            <i class="bx bx-exclamation-triangle me-2"></i>
                            Confirmation de duplication
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning" role="alert">
                            <i class="bx bx-info-circle me-2"></i>
                            <strong>Attention !</strong> Cette action est irréversible.
                        </div>

                        <!-- Informations sur la personne -->
                        <div class="card shadow-none mb-3">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-2">
                                            <strong><i class="bx bx-user-circle me-1"></i> Nom complet :</strong>
                                            <span id="candidate-name" class="text-primary fw-bold"></span>
                                        </div>
                                        <div class="mb-2">
                                            <strong><i class="bx bx-id-card me-1"></i> Mécano :</strong>
                                            <span id="candidate-mecano" class="badge bg-secondary"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <strong><i class="bx bx-compass me-1"></i> Orientation :</strong>
                                            <span id="candidate-orientation" class="badge bg-warning"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="mb-0">
                            Êtes-vous sûr de vouloir dupliquer cette candidature ?
                            Cette opération créera une copie complète de la candidature sélectionnée.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x me-1"></i>
                            Annuler
                        </button>
                        <form id="duplicateForm" method="POST" action="{{ route('adherent.duplicate') }}"
                            style="display: inline;">
                            @csrf
                            <input type="hidden" id="candidature_id" name="candidature_id" value="">
                            <button type="submit" class="btn btn-warning">
                                <i class="bx bx-duplicate me-1"></i>
                                Confirmer la duplication
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('js-push')
            <script>
                function confirmDuplicate(candidatureId, fullName, mecano, orientation) {
                    // Définir l'ID de la candidature dans le formulaire
                    document.getElementById('candidature_id').value = candidatureId;

                    // Remplir les informations de la personne dans le modal
                    document.getElementById('candidate-name').textContent = fullName;
                    document.getElementById('candidate-mecano').textContent = mecano;
                    document.getElementById('candidate-orientation').textContent = orientation;

                    // Afficher le modal
                    var modal = new bootstrap.Modal(document.getElementById('duplicateModal'));
                    modal.show();
                }
            </script>
        @endpush
    @endif
@endsection
