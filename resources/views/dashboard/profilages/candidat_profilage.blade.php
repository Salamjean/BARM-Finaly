@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-user-check text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Profilages</div>
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
                    
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $candidatures->filter(function ($candidat) {
                                    $partenaire = $candidat->partenaires->last();
                                    return $candidat->partenaires->contains($partenaire->id) &&
                                        $candidat->partenaires->find($partenaire->id)->pivot->status == 'accepted';
                                })->count() }}
                        </div>
                        <div class="text-muted small">Acceptés</div>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-danger fs-6 px-3 py-2">
                            {{ $candidatures->filter(function ($candidat) {
                                    $partenaire = $candidat->partenaires->last();
                                    return $candidat->partenaires->contains($partenaire->id) &&
                                        $candidat->partenaires->find($partenaire->id)->pivot->status == 'refused';
                                })->count() }}
                        </div>
                        <div class="text-muted small">Refusés</div>
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
                                    <i class="bx bx-hash text-primary me-1"></i>
                                    #
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>
                                
                                <th class="border-0">
                                    <i class="bx bx-briefcase text-primary me-1"></i>
                                    Partenaire
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
                            @foreach ($candidatures as $index => $candidat)
                                @php
                                    $partenaire = $candidat->partenaires->last();
                                    $status = null;
                                    if ($candidat->partenaires->contains($partenaire->id)) {
                                        $status = $candidat->partenaires->find($partenaire->id)->pivot->status;
                                    }
                                @endphp
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $candidat->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>
                                                    <span>{{ $candidat->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary">{{ $partenaire->user->username }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($status == 'accepted')
                                                <div class="bg-success rounded-circle me-2"
                                                    style="width: 8px; height: 8px;"></div>
                                                <span class="badge bg-success">Candidature acceptée</span>
                                            @elseif ($status == 'refused')
                                                <div class="bg-danger rounded-circle me-2" style="width: 8px; height: 8px;">
                                                </div>
                                                <span class="badge bg-danger">Candidature refusée</span>
                                            @else
                                                <div class="bg-warning rounded-circle me-2"
                                                    style="width: 8px; height: 8px;"></div>
                                                <span class="badge bg-warning">En attente</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $candidat->user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>

                                            @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                                                <button type="button" class="btn btn-outline-info btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#changePartnerModal{{ $candidat->id }}"
                                                    title="Changer de partenaire">
                                                    <i class="bx bx-transfer"></i>
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

    @foreach ($candidatures as $candidat)
        @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
            <div class="modal fade" id="changePartnerModal{{ $candidat->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-none">
                        <div class="modal-header bg-info text-white">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-transfer me-2 fs-4"></i>
                                <h5 class="modal-title mb-0">Changer de partenaire technique</h5>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="text-center mb-4">
                                <i class="bx bx-user-circle text-info fs-1 mb-3"></i>
                                <h6 class="text-muted">Assignation d'un nouveau partenaire technique</h6>
                            </div>

                            <form action="{{ route('changecandidatpartner') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="bx bx-user text-info me-1"></i>
                                        Candidat
                                    </label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $candidat->user->fullName() }}">
                                    <input type="hidden" name="candidature_id" value="{{ $candidat->id }}">
                                    <input type="hidden" name="cohort_id" value="{{ $id }}">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="bx bx-briefcase text-info me-1"></i>
                                        Nouveau partenaire technique <span class="text-danger">*</span>
                                    </label>
                                    <select name="partenaire_id" class="form-select" required>
                                        <option selected disabled>Sélectionner un partenaire</option>
                                        @foreach ($partner_technicials as $partner)
                                            <option value="{{ $partner->id }}">
                                                {{ $partner->user->username }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">
                                        <i class="bx bx-info-circle me-1"></i>
                                        Choisissez le nouveau partenaire technique pour ce candidat
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="bx bx-x me-1"></i>
                                        Annuler
                                    </button>
                                    <button type="submit" class="btn btn-info">
                                        <i class="bx bx-check me-1"></i>
                                        Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush
@endsection
