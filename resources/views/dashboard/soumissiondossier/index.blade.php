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
                        <i class="bx bx-file-plus text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Soumissions de dossiers</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="ms-auto">
                @if (can('conseiller-fonction-public') || can('chef-cellule-formation-et-insertion'))
                    <div class="btn-group">
                        <a href="{{ route('soumissiondossiers.create', $candidat->id) }}" type="button"
                            class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i>
                            Dépôt de dossier
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-user text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">{{ $candidat->user->fullName() }}</h5>
                        <small class="text-muted">
                            <span class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>
                            <span>{{ $candidat->phone_number }}</span>
                        </small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $soumissiondossiers->count() }}
                        </div>
                        <small class="text-muted d-block">Dossiers</small>
                    </div>
                    @if ($candidat->choixconcour)
                        <div class="text-center">
                            <div class="badge bg-success fs-6 px-3 py-2">
                                <i class="bx bx-check"></i>
                            </div>
                            <small class="text-muted d-block">Choix fait</small>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="badge bg-warning fs-6 px-3 py-2">
                                <i class="bx bx-time"></i>
                            </div>
                            <small class="text-muted d-block">En attente</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tableau des dossiers amélioré -->
        <div class="bg-white rounded-3 shadow-none">
            <div class="p-4">
                @foreach ($soumissiondossiers as $soumissiondossier)
                    <div class="card border shadow-none mb-4">
                        <div class="card-header bg-light mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="bx bx-file-doc text-primary me-2"></i>
                                    Dossier #{{ $loop->index + 1 }}
                                </h6>
                                @if ($candidat->choixconcour == null)
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#commentModal{{ $soumissiondossier->id }}">
                                        <i class="bx bx-check-circle me-1"></i>
                                        Faire le choix final
                                    </button>
                                @else
                                    <span class="badge bg-success">Choix effectué</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Choix 1 -->
                                <div class="col-md-6">
                                    <div class="border-end pe-3">
                                        <h6 class="text-primary mb-3">
                                            <i class="bx bx-star text-warning me-2"></i>
                                            Premier Choix
                                        </h6>
                                        <div class="mb-2">
                                            <strong>Intitulé :</strong>
                                            <span class="text-dark">{{ $soumissiondossier->intitule_concours1 }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Type :</strong>
                                            <span class="badge bg-info">{{ $soumissiondossier->type_concours1 }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Date :</strong>
                                            <span class="text-muted">
                                                <i class="bx bx-calendar me-1"></i>
                                                {{ dateFr($soumissiondossier->date1) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Choix 2 -->
                                <div class="col-md-6">
                                    <div class="ps-3">
                                        <h6 class="text-secondary mb-3">
                                            <i class="bx bx-star text-muted me-2"></i>
                                            Deuxième Choix
                                        </h6>
                                        <div class="mb-2">
                                            <strong>Intitulé :</strong>
                                            <span class="text-dark">{{ $soumissiondossier->intitule_concours2 }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Type :</strong>
                                            <span
                                                class="badge bg-secondary">{{ $soumissiondossier->type_concours2 }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Date :</strong>
                                            <span class="text-muted">
                                                <i class="bx bx-calendar me-1"></i>
                                                {{ dateFr($soumissiondossier->date2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal pour choix final -->
                    <div id="commentModal{{ $soumissiondossier->id }}" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <i class="bx bx-check-circle text-success me-2"></i>
                                        Choix final du concours
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('soumissiondossiers.choixfinal') }}" method="POST" class="row g-3"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Sélectionnez votre choix final :</label>
                                                <select class="form-select" name="intitule_concours"
                                                    onchange="toggleIntitule()" id="intitule">
                                                    <option value="">-- Choisir une option --</option>
                                                    <option value="choix1">
                                                        Premier choix : {{ $soumissiondossier->intitule_concours1 }}
                                                    </option>
                                                    <option value="choix2">
                                                        Deuxième choix : {{ $soumissiondossier->intitule_concours2 }}
                                                    </option>
                                                    <option value="other">Autre concours</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="candidature_id"
                                                value="{{ $soumissiondossier->candidature_id }}">
                                            <input type="hidden" name="soumissiondossier_id"
                                                value="{{ $soumissiondossier->id }}">
                                        </div>

                                        <div class="row" id="otherintitule-div" style="display: none;">
                                            <div class="col-12">
                                                <div class="alert alert-info">
                                                    <i class="bx bx-info-circle me-2"></i>
                                                    Vous avez choisi un autre concours. Veuillez remplir les informations
                                                    ci-dessous.
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="intitule_concours" class="form-label">Intitulé du concours
                                                    :</label>
                                                <select class="form-select" name="other_intitule_concours">
                                                    <option value="">-- Choisir un intitulé --</option>
                                                    @foreach ($intituleconcours as $intituleconcour)
                                                        <option value="{{ $intituleconcour->libelle }}">
                                                            {{ $intituleconcour->libelle }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="type_concours" class="form-label">Type du concours :</label>
                                                <select class="form-select" name="other_type_concours">
                                                    <option value="">-- Choisir un type --</option>
                                                    @foreach ($typeconcours as $typeconcour)
                                                        <option value="{{ $typeconcour->libelle }}">
                                                            {{ $typeconcour->libelle }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success me-2">
                                            <i class="bx bx-check me-1"></i>
                                            Confirmer le choix
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="bx bx-x me-1"></i>
                                            Annuler
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($soumissiondossiers->isEmpty())
                    <div class="text-center py-5">
                        <i class="bx bx-file-blank fs-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Aucun dossier soumis</h5>
                        <p class="text-muted">Ce candidat n'a pas encore soumis de dossier de candidature.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            function toggleIntitule() {
                var select = document.getElementById('intitule');
                var other = document.getElementById('otherintitule-div');
                if (select.value === 'other') {
                    other.style.display = 'block';
                } else {
                    other.style.display = 'none';
                }
            }
        </script>
    @endpush
@endsection
