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
                    <i class="bx bx-conversation text-primary fs-4 me-3"></i>
                    <div>
                        <div class="text-muted small">Entretiens</div>
                        <h4 class="mb-0 text-primary">{{ $title }}</h4>
                    </div>
                </div>
            </nav>
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

        <!-- Header avec bouton d'action -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-calendar-event text-success fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Gestion des entretiens | Fonction publique</h5>
                        <small class="text-muted">
                            @if ($type == 'collectif')
                                Sessions d'entretiens collectifs
                            @else
                                Entretiens personnalisés
                            @endif
                        </small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            @if ($type == 'collectif')
                                {{ $entretiens->count() }}
                            @else
                                {{ $entretiens->sum(function($e) { return $e->candidatentretiens->count(); }) }}
                            @endif
                        </div>
                        <small class="text-muted d-block">
                            @if ($type == 'collectif')
                                Sessions
                            @else
                                Candidats
                            @endif
                        </small>
                    </div>
                    @if(can('conseiller-fonction-public') || can('chef-cellule-formation-et-insertion'))
                        <a href="{{ route('entretiens.createfp', $type) }}" class="btn btn-primary d-flex align-items-center">
                            <i class="bx bx-plus me-2"></i>
                            Organiser un entretien
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Onglets de basculement entre Collectif et Individuel -->
        <div class="mb-4">
            <ul class="nav nav-pills nav-fill bg-white p-2 rounded-3 shadow-sm border">
                <li class="nav-item me-2">
                    <a class="nav-link fw-semibold py-2 px-3 {{ $type == 'collectif' ? 'active bg-primary text-white' : 'text-secondary bg-light' }}" href="{{ route('entretiens.indexfp', 'collectif') }}">
                        <i class="bx bx-group me-2 fs-5 align-middle"></i> Sessions d'entretiens collectifs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold py-2 px-3 {{ $type == 'perso' ? 'active bg-primary text-white' : 'text-secondary bg-light' }}" href="{{ route('entretiens.indexfp', 'perso') }}">
                        <i class="bx bx-user me-2 fs-5 align-middle"></i> Entretiens individuels
                    </a>
                </li>
            </ul>
        </div>

        @if ($type == 'collectif')
            <!-- Vue Entretiens Collectifs -->
            <div class="bg-white rounded-3 shadow-sm">
                <div class="p-4">
                    <div class="table-responsive">
                        <table class="dt-responsive table table-hover align-middle" id="datatable--barm" style="width:100%">
                            <thead>
                                <tr class="table-primary">
                                    <th class="border-0">#</th>
                                    <th class="border-0">
                                        <i class="bx bx-calendar text-primary me-1"></i> Date de tenue
                                    </th>
                                    <th class="border-0">Statut / Présences</th>
                                    <th class="border-0 text-center">Nbre de candidats</th>
                                    <th class="border-0 text-center">
                                        <i class="bx bx-cog text-primary me-1"></i> Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entretiens as $index => $entretien)
                                    @php
                                        $isPast = \Carbon\Carbon::parse($entretien->date)->isPast() && !\Carbon\Carbon::parse($entretien->date)->isToday();
                                        $presents = $entretien->candidatentretiens->where('presence', '1')->count();
                                        $absents = $entretien->candidatentretiens->where('presence', '0')->count();
                                        $abandons = $entretien->candidatentretiens->where('presence', '2')->count();
                                        $attente = $entretien->candidatentretiens->whereNull('presence')->count();
                                    @endphp
                                    <tr class="align-middle">
                                        <td>
                                            <span class="badge bg-info">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="border-start border-3 {{ $isPast ? 'border-secondary' : 'border-success' }} ps-2 py-1">
                                                <div class="fw-bold {{ $isPast ? 'text-dark' : 'text-success' }}">{{ dateFr($entretien->date, 'letter') }}</div>
                                                <small class="text-muted">
                                                    @if ($isPast)
                                                        <span class="badge bg-light text-muted border">Passé</span>
                                                    @else
                                                        <span class="badge bg-light-success text-success border">À venir</span>
                                                    @endif
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-1 flex-wrap">
                                                <span class="badge bg-success" title="Présents"><i class="bx bx-check me-1"></i>{{ $presents }}</span>
                                                <span class="badge bg-danger" title="Absents"><i class="bx bx-x me-1"></i>{{ $absents }}</span>
                                                <span class="badge bg-warning text-dark" title="Abandons"><i class="bx bx-error-circle me-1"></i>{{ $abandons }}</span>
                                                @if ($attente > 0)
                                                    <span class="badge bg-light text-muted border" title="En attente">{{ $attente }} en attente</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary px-3 py-2 rounded-pill fs-6">{{ $entretien->candidatentretiens->count() }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1 flex-wrap">
                                                <a href="{{ route('entretiens.candidats', $entretien->id) }}" 
                                                   class="btn btn-primary btn-sm" 
                                                   title="Voir et évaluer les candidats">
                                                    <i class="bx bx-show me-1"></i> Voir candidats
                                                </a>

                                                <button type="button" 
                                                        class="btn btn-outline-secondary btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalEditDateCollective{{ $entretien->id }}"
                                                        title="Modifier la date de cet entretien">
                                                    <i class="bx bx-calendar-edit"></i>
                                                </button>
                                            </div>

                                            <!-- Modal Modifier Date Collectif -->
                                            <div id="modalEditDateCollective{{ $entretien->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content border-0 shadow">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title text-white">
                                                                <i class="bx bx-calendar-edit me-2"></i> Mettre à jour la date de la session
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('entretiens.update', $entretien->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body p-4 text-start">
                                                                <p class="text-muted small mb-3">
                                                                    Modifiez la date de tenue pour cette session collective ({{ $entretien->candidatentretiens->count() }} candidats).
                                                                </p>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold text-dark">
                                                                        Nouvelle date de l'entretien <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="date" 
                                                                           class="form-control form-control-lg" 
                                                                           name="date" 
                                                                           value="{{ \Carbon\Carbon::parse($entretien->date)->format('Y-m-d') }}" 
                                                                           required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                    <i class="bx bx-x me-1"></i> Annuler
                                                                </button>
                                                                <button type="submit" class="btn btn-primary px-4">
                                                                    <i class="bx bx-check me-1"></i> Enregistrer
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        @elseif ($type == 'perso')
            <!-- Vue Entretiens Personnalisés -->
            <div class="bg-white rounded-3 shadow-sm">
                <div class="p-4">
                    <div class="table-responsive">
                        <table class="dt-responsive table table-hover align-middle" id="datatable--barm" style="width:100%">
                            <thead>
                                <tr class="table-primary">
                                    <th class="border-0">#</th>
                                    <th class="border-0">
                                        <i class="bx bx-user text-primary me-1"></i> Nom & Prénoms
                                    </th>
                                    <th class="border-0">
                                        <i class="bx bx-calendar text-primary me-1"></i> Date de l'entretien
                                    </th>
                                    <th class="border-0">Présence / Statut</th>
                                    <th class="border-0 text-center">
                                        <i class="bx bx-cog text-primary me-1"></i> Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $globalIndex = 0; @endphp
                                @foreach ($entretiens as $entretien)
                                    @foreach ($entretien->candidatentretiens as $candidat)
                                        @php 
                                            $globalIndex++; 
                                            $isPast = \Carbon\Carbon::parse($entretien->date)->isPast() && !\Carbon\Carbon::parse($entretien->date)->isToday();
                                        @endphp
                                        <tr class="align-middle">
                                            <td>
                                                <span class="badge bg-info">{{ $globalIndex }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $candidat->candidature->user ? $candidat->candidature->user->fullName() : 'Candidat' }}</div>
                                                        <div class="small text-muted">
                                                            <span class="badge bg-secondary me-1">{{ $candidat->candidature->user->mecano ?? 'N/A' }}</span>
                                                            <span>{{ $candidat->candidature->phone_number }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="border-start border-3 {{ $isPast ? 'border-secondary' : 'border-success' }} ps-2 py-1">
                                                    <div class="fw-medium {{ $isPast ? 'text-dark' : 'text-success' }}">{{ dateFr($entretien->date, 'letter') }}</div>
                                                    <small class="text-muted">
                                                        @if ($isPast)
                                                            <span class="badge bg-light text-muted border">Passé</span>
                                                        @else
                                                            <span class="badge bg-light-success text-success border">À venir</span>
                                                        @endif
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($candidat->presence == 1 || $candidat->presence === '1')
                                                    <span class="badge bg-success"><i class="bx bx-check me-1"></i> Présent</span>
                                                @elseif ($candidat->presence == 2 || $candidat->presence === '2')
                                                    <span class="badge bg-warning text-dark"><i class="bx bx-error-circle me-1"></i> Abandon</span>
                                                @elseif ($candidat->presence === 0 || $candidat->presence === '0')
                                                    <span class="badge bg-danger"><i class="bx bx-x me-1"></i> Absent</span>
                                                @else
                                                    <span class="badge bg-light text-muted border"><i class="bx bx-time me-1"></i> En attente</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1 flex-wrap">
                                                    @if ($candidat->candidature->user)
                                                        <a href="{{ route('adherent.show', $candidat->candidature->user->id) }}" 
                                                           class="btn btn-outline-secondary btn-sm" 
                                                           title="Voir le profil">
                                                            <i class="bx bx-show"></i>
                                                        </a>
                                                    @endif
                                                    
                                                    @if ($candidat->comment)
                                                        <button type="button" 
                                                                class="btn btn-outline-info btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#commentModal{{ $candidat->id }}"
                                                                title="Voir commentaire">
                                                            <i class="bx bx-message-square-detail"></i>
                                                        </button>
                                                    @endif

                                                    <!-- Bouton Évaluer / Mettre à jour l'entretien -->
                                                    <button type="button" 
                                                            class="btn btn-outline-success btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#rapportModal{{ $candidat->id }}"
                                                            title="Mettre à jour le statut / Présence de l'entretien">
                                                        <i class="bx bx-check-double me-1"></i> Évaluer
                                                    </button>

                                                    <!-- Bouton Modifier la date de l'entretien -->
                                                    <button type="button" 
                                                            class="btn btn-outline-secondary btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEditDatePerso{{ $entretien->id }}"
                                                            title="Modifier la date de l'entretien">
                                                        <i class="bx bx-calendar-edit"></i>
                                                    </button>
                                                </div>

                                                <!-- Modal Commentaire -->
                                                @if ($candidat->comment)
                                                    <div id="commentModal{{ $candidat->id }}" class="modal fade" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-info text-white">
                                                                    <h5 class="modal-title text-white">
                                                                        <i class="bx bx-message-square-detail me-2"></i>
                                                                        Compte rendu de l'entretien
                                                                    </h5>
                                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-start">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-medium">
                                                                            <i class="bx bx-comment text-primary me-1"></i>
                                                                            Observations
                                                                        </label>
                                                                        <textarea class="form-control" readonly rows="5">{{ $candidat->comment }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                        <i class="bx bx-x me-1"></i>
                                                                        Fermer
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Modal Évaluer / Mettre à jour Présence -->
                                                <div id="rapportModal{{ $candidat->id }}" class="modal fade" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content border-0 shadow">
                                                            <div class="modal-header text-white bg-primary">
                                                                <h5 class="modal-title text-white">
                                                                    <i class="bx bx-slider-alt me-2"></i>
                                                                    Mettre à jour l'entretien
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('entretiens.presence') }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body p-4 text-start">
                                                                    <div class="d-flex align-items-center mb-3 p-2 bg-light rounded-3">
                                                                        <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                                                                            {{ strtoupper(substr($candidat->candidature->user->firstname ?? 'C', 0, 1) . substr($candidat->candidature->user->lastname ?? 'A', 0, 1)) }}
                                                                        </div>
                                                                        <div>
                                                                            <strong class="text-dark">{{ $candidat->candidature->user ? $candidat->candidature->user->fullName() : 'Candidat' }}</strong>
                                                                            <div class="small text-muted">Date entretien : {{ dateFr($entretien->date, 'letter') }}</div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold text-dark">
                                                                            Statut de l'entretien <span class="text-danger">*</span>
                                                                        </label>
                                                                        <select name="presence" class="form-select" required>
                                                                            <option value="1" {{ $candidat->presence == 1 ? 'selected' : '' }}>🟢 Présent (Valider l'entretien)</option>
                                                                            <option value="0" {{ ($candidat->presence === 0 || $candidat->presence === '0') ? 'selected' : '' }}>🔴 Absent</option>
                                                                            <option value="2" {{ $candidat->presence == 2 ? 'selected' : '' }}>🟠 Abandon</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold text-dark">
                                                                            <i class="bx bx-comment text-primary me-1"></i>
                                                                            Compte-rendu / Observations
                                                                        </label>
                                                                        <textarea name="comment" class="form-control" rows="4" 
                                                                                  placeholder="Ajoutez vos observations sur l'entretien...">{{ $candidat->comment }}</textarea>
                                                                    </div>

                                                                    <input type="hidden" name="candidatentretien_id" value="{{ $candidat->id }}">
                                                                    <input type="hidden" name="candidat_id" value="{{ $candidat->candidature->id }}">
                                                                    <input type="hidden" name="entretien_id" value="{{ $entretien->id }}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                        <i class="bx bx-x me-1"></i>
                                                                        Annuler
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary px-4">
                                                                        <i class="bx bx-check me-1"></i>
                                                                        Enregistrer
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal Modifier Date Perso -->
                                                <div id="modalEditDatePerso{{ $entretien->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content border-0 shadow">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title text-white">
                                                                    <i class="bx bx-calendar-edit me-2"></i> Mettre à jour la date de l'entretien
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('entretiens.update', $entretien->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body p-4 text-start">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold text-dark">
                                                                            Nouvelle date de l'entretien <span class="text-danger">*</span>
                                                                        </label>
                                                                        <input type="date" 
                                                                               class="form-control form-control-lg" 
                                                                               name="date" 
                                                                               value="{{ \Carbon\Carbon::parse($entretien->date)->format('Y-m-d') }}" 
                                                                               required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                        <i class="bx bx-x me-1"></i> Annuler
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary px-4">
                                                                        <i class="bx bx-check me-1"></i> Enregistrer
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
</div>

@push('js-push')
<script>
    (function($) {
        "use strict";

        $('.refused').on('click', function() {
            var candidatId = $(this).data('candidat-id');
            var routerefused = $('#refusedForm-' + candidatId).attr('action');
            Swal.fire({
                title: "Marquer ce candidat absent",
                text: "Voulez-vous marquer ce candidat absent?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, absent!",
                cancelButtonText: "Non, retour"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: routerefused,
                        type: 'POST',
                        data: $('#refusedForm-' + candidatId).serialize(),
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });
        });
    })(jQuery);
</script>
@endpush
@endsection