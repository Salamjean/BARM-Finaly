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
                        <i class="bx bx-clipboard text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Suivi des inscriptions</div>
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
                    <i class="bx bx-user-check text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Inscriptions aux concours</h5>
                        <small class="text-muted">Candidats inscrits aux différents concours administratifs</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $inscriptionconcours->count() }}
                        </div>
                        <small class="text-muted d-block">Nombres</small>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Tableau des inscriptions -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Date d'inscription</th>
                                <th>Nom & Prénoms</th>
                                <th>
                                    <i class="bx bx-trophy text-warning me-2"></i>
                                    Intitulé concours
                                </th>
                                <th>Type concours</th>
                                <th>Date de concours</th>
                                <th>Reçu de paiement</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inscriptionconcours as $inscriptionconcour)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-calendar text-primary me-2"></i>
                                            <span>{{ dateFr($inscriptionconcour->created_at) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-medium text-dark">
                                                    {{ $inscriptionconcour->candidature->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span
                                                        class="badge bg-secondary me-1">{{ $inscriptionconcour->candidature->user->mecano }}</span>
                                                    <span>{{ $inscriptionconcour->candidature->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-medium">{{ $inscriptionconcour->intitule_concours }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $inscriptionconcour->type_concours }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span>{{ dateFr($inscriptionconcour->date) }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($inscriptionconcour->recu == null)
                                            <span class="text-muted">
                                                <i class="bx bx-file-blank fs-4"></i>
                                                <small class="d-block">Non disponible</small>
                                            </span>
                                        @else
                                            <a href="{{ asset($inscriptionconcour->recu) }}" download class="text-success"
                                                title="Télécharger le reçu">
                                                <i class="bx bx-cloud-download fs-3"></i>
                                                <small class="d-block">Télécharger</small>
                                            </a>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        <a href="{{ route('adherent.show', $inscriptionconcour->candidature->user->id) }}"
                                            class="btn btn-outline-primary btn-sm" title="Voir le profil détaillé">
                                            <i class="bx bx-show me-1"></i>
                                            
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($inscriptionconcours->isEmpty())
                    <div class="text-center py-5">
                        <i class="bx bx-clipboard fs-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Aucune inscription enregistrée</h5>
                        <p class="text-muted">Aucun candidat n'est encore inscrit aux concours.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
