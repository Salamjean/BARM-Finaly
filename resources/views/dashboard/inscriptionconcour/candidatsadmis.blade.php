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
                        <i class="bx bx-medal text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Suivi des résultats</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-trophy text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Résultats aux concours administratifs</h5>
                        <small class="text-muted">Candidats admis et leurs affectations</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $candidats->count() }}
                        </div>
                        <small class="text-muted d-block">Admis</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $candidats->whereNotNull('affectation')->count() }}
                        </div>
                        <small class="text-muted d-block">Affectés</small>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tableau des résultats -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Date d'admission</th>
                                <th>Nom & Prénoms</th>
                                <th>
                                    <i class="bx bx-trophy text-warning me-2"></i>
                                    Intitulé concours
                                </th>
                                <th>Type concours</th>
                                <th>Attestation admission</th>
                                <th>Affectation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidats as $candidat)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-calendar text-primary me-2"></i>
                                            <span>{{ dateFr($candidat->created_at) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-medium text-dark">
                                                    {{ $candidat->candidature->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span
                                                        class="badge bg-secondary me-1">{{ $candidat->candidature->user->mecano }}</span>
                                                    <span>{{ $candidat->candidature->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-medium">{{ $candidat->intitule_concours }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $candidat->type_concours }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($candidat->attestation == null)
                                            <span class="text-muted">
                                                <i class="bx bx-file-blank fs-4"></i>
                                                <small class="d-block">Non disponible</small>
                                            </span>
                                        @else
                                            <a href="{{ asset($candidat->attestation) }}" download class="text-success"
                                                title="Télécharger l'attestation">
                                                <i class="bx bx-cloud-download fs-3"></i>
                                                <small class="d-block">Télécharger</small>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($candidat->affectation)
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-map-pin text-success me-2"></i>
                                                <span class="text-success fw-medium">{{ $candidat->affectation }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">
                                                <i class="bx bx-time-five me-1"></i>
                                                En attente
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $candidat->candidature->user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>

                                            @if ($candidat->affectation == null)
                                                @if (can('conseiller-fonction-public') || can('chef-cellule-formation-et-insertion'))
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rapportModal{{ $candidat->id }}"
                                                        title="Définir l'affectation">
                                                        <i class="bx bx-map-pin me-1"></i>
                                                        Affecter
                                                    </button>
                                                @endif
                                            @endif
                                        </div>

                                        <!-- Modal d'affectation -->
                                        <div id="rapportModal{{ $candidat->id }}" class="modal fade" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="bx bx-map-pin text-warning me-2"></i>
                                                            Lieu d'affectation
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('inscriptionconcours.affectation') }}"
                                                        method="POST" class="row g-3" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12 mb-3">
                                                                    <div class="alert alert-info">
                                                                        <strong>Candidat :</strong>
                                                                        {{ $candidat->candidature->user->fullName() }}<br>
                                                                        <strong>Concours :</strong>
                                                                        {{ $candidat->intitule_concours }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label">Lieu d'affectation :</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i
                                                                                class="bx bx-map"></i></span>
                                                                        <input type="text" name="affectation"
                                                                            class="form-control"
                                                                            placeholder="Saisir le lieu d'affectation"
                                                                            required />
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="candidatsadmi_id"
                                                                    value="{{ $candidat->id }}">
                                                                <input type="hidden" name="candidature_id"
                                                                    value="{{ $candidat->candidature->id }}">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success me-2">
                                                                <i class="bx bx-check me-1"></i>
                                                                Enregistrer l'affectation
                                                            </button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="bx bx-x me-1"></i>
                                                                Annuler
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

                @if ($candidats->isEmpty())
                    <div class="text-center py-5">
                        <i class="bx bx-medal fs-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Aucun résultat enregistré</h5>
                        <p class="text-muted">Aucun candidat admis aux concours n'a encore été enregistré.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
