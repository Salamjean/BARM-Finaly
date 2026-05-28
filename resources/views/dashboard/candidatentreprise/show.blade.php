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
                        <i class="bx bx-transfer text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Mise à disposition</div>
                            <h4 class="mb-0 text-primary">{{ dateFr($date, 'letter') }} - {{ $entreprise }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-building text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">{{ $entreprise }}</h5>
                        <small class="text-muted">Mise à disposition du {{ dateFr($date, 'letter') }}</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $candidatentreprises->count() }}
                        </div>
                        <small class="text-muted d-block">Candidats</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $candidatentreprises->where('statut', 'accepted')->count() }}
                        </div>
                        <small class="text-muted d-block">Acceptés</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $candidatentreprises->where('statut', 'pending')->count() }}
                        </div>
                        <small class="text-muted d-block">En cours</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des candidats -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nom & Prénoms</th>
                                <th class="text-start">Statut</th>
                                <th>Poste</th>
                                <th class="text-start">Contrat</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidatentreprises as $candidatentreprise)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div>{{ $candidatentreprise->candidature->user->fullName() }}</div>
                                        <div class="fs-7">
                                               <span class="badge bg-secondary me-1">{{ $candidatentreprise->candidature->user->mecano }}</span>
                                            <span>{{ $candidatentreprise->candidature->phone_number }}</span>
                                        </div>
                                    </td>
                                    @if ($candidatentreprise->statut == 'pending')
                                        <td class="text-warning">En cours de traitement</td>
                                    @elseif ($candidatentreprise->statut == 'accepted')
                                        <td class="text-success">Accepté</td>
                                    @elseif ($candidatentreprise->statut == 'refused')
                                        <td class="text-danger">Rejeté</td>
                                    @elseif ($candidatentreprise->statut == 'finished')
                                        <td class="text-danger">Terminé</td>
                                    @endif
                                    <td class="text-start">{{ $candidatentreprise->poste }}</td>
                                    <td class="text-start">
                                        @if ($candidatentreprise->contrat != null)
                                            <a href="{{ asset($candidatentreprise->contrat) }}" download><i
                                                    class="bx bx-cloud-download fs-2"></i></a>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $candidatentreprise->candidature->user->id) }}"
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>
                

                                            @if ((can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion')) && $candidatentreprise->statut == 'pending')
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#rapportModal{{ $candidatentreprise->id }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bx bx-edit me-1"></i>
                                                    Suivre
                                                </a>

                                                <div id="rapportModal{{ $candidatentreprise->id }}" class="modal fade"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Compte rendu mise à disposition</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('candidatentreprises.changestatut') }}"
                                                                method="POST" class="row g-3" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                            <label class="form-label">Statut : </label>
                                                                            <select class="form-select"
                                                                                data-placeholder="Choisir une option"
                                                                                name="statut"
                                                                                id="statut{{ $candidatentreprise->id }}"
                                                                                onchange="toggleStatut({{ $candidatentreprise->id }})">
                                                                                <option selected>Choisir une option</option>
                                                                                <option value="refused">Candidature refusée
                                                                                </option>
                                                                                @if ($candidatentreprise->candidature->en_poste != '1')
                                                                                    <option value="accepted">Candidature
                                                                                        acceptée</option>
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                        <div class="row"
                                                                            id="other{{ $candidatentreprise->id }}"
                                                                            style="display: none;">
                                                                            <div class="col-md-12 mb-3">
                                                                                <label class="form-label">Poste : </label>
                                                                                <input class="form-control" type="texte"
                                                                                    name="poste" disabled
                                                                                    value="{{ $candidatentreprise->poste }}">
                                                                            </div>
                                                                            <div class="col-md-12 mb-3">
                                                                                <label class="form-label">Lieu d'affectation :
                                                                                </label>
                                                                                <input class="form-control" type="text"
                                                                                    name="localisation">
                                                                            </div>
                                                                            <div class="col-md-12 mb-3">
                                                                                <label class="form-label">Service : </label>
                                                                                <input class="form-control" type="text"
                                                                                    name="service">
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label">Type de contrat :
                                                                                </label>
                                                                                <select class="form-control" name="type_contrat"
                                                                                    id="contrat" onchange="toggleContrat()">
                                                                                    <option value="" selected>Choisir
                                                                                    </option>
                                                                                    <option value="CDD">CDD</option>
                                                                                    <option value="CDI">CDI</option>
                                                                                    <option value="othercontrat">Autre</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6 mb-3" id="othercontrat-div"
                                                                                style="display: none;">
                                                                                <label for="type_contrat"
                                                                                    class="form-label">Type de contrat: </label>
                                                                                <div class="input-group">
                                                                                    <input type="text"
                                                                                        class="form-control @error('type_contrat') is-invalid @enderror"
                                                                                        name="type_contrat" />
                                                                                </div>
                                                                                @error('type_contrat')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label">Attestation de
                                                                                    travail : </label>
                                                                                <input class="form-control" type="file"
                                                                                    name="contrat">
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label">Date de début :
                                                                                </label>
                                                                                <input class="form-control" type="date"
                                                                                    name="date_db">
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label">Date de fin :
                                                                                </label>
                                                                                <input class="form-control" type="date"
                                                                                    name="date_fin">
                                                                            </div>
                                                                            <div class="col-md-12 mb-3">
                                                                                <label class="form-label">Commentaire :
                                                                                </label>
                                                                                <textarea name="commentaire" class="form-control" id="" cols="10" rows="5"></textarea>
                                                                            </div>
                                                                        </div>

                                                                        <input type="text" name="candidatentreprise_id"
                                                                            value="{{ $candidatentreprise->id }}" hidden>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-label-info me-sm-3 me-1">Enregistrer</button>
                                                                    <button type="reset"
                                                                        class="btn btn-label-danger btn-reset"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close">Retour</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ((can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion')) && $candidatentreprise->statut == 'accepted')
                                                <a style="cursor: pointer" class="refused btn btn-warning text-white btn-sm"
                                                    data-candidat-id="{{ $candidatentreprise->id }}">
                                                    <i class="bx bx-stop-circle me-1"></i>
                                                    Terminer
                                                </a>

                                                <form id="refusedForm-{{ $candidatentreprise->id }}"
                                                    action="{{ route('candidatentreprises.end_poste') }}" method="post">
                                                    @csrf
                                                    <input type="text" name="statut" value="finish" hidden>
                                                    <input type="text" name="candidatentreprise_id"
                                                        value="{{ $candidatentreprise->id }}" hidden>
                                                </form>
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

    @push('js-push')
        <script>
            function toggleStatut(id) {
                var select = document.getElementById('statut' + id);
                var nomEntrepriseDiv = document.getElementById('other' + id);
                if (select.value === 'accepted') {
                    nomEntrepriseDiv.style.display = '';
                } else {
                    nomEntrepriseDiv.style.display = 'none';
                }
            }
        </script>

        <script>
            function toggleContrat() {
                var selectcontract = document.getElementById('contrat');
                var othercontrat = document.getElementById('othercontrat-div');
                if (selectcontract.value === 'othercontrat') {
                    othercontrat.style.display = 'block';
                } else {
                    othercontrat.style.display = 'none';
                }
            }
        </script>

        <script>
            (function($) {
                "use strict";
                $('.refused').on('click', function() {
                    var candidatId = $(this).data('candidat-id');
                    var routerefused = $('#refusedForm-' + candidatId).attr('action');
                    Swal.fire({
                        title: "Terminer ce contrat",
                        text: "Voulez-vous terminer ce contrat?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Oui, terminer!",
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

                $('.validated').on('click', function() {
                    var candidatId = $(this).data('candidat-id');
                    var routevalidated = $('#validatedForm-' + candidatId).attr('action');
                    Swal.fire({
                        title: "Marquer ce candidat présent",
                        text: "Voulez-vous marquer ce candidat présent?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Oui, présent!",
                        cancelButtonText: "Non, retour"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: routevalidated,
                                type: 'POST',
                                data: $('#validatedForm-' + candidatId).serialize(),
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