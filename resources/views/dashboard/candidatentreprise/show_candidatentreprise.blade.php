@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Candidatures spontanées/{{ $title }}</span>
                </h4>
            </nav>
        </div>

        <!-- <div class="ms-auto">

            @if(can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion'))
            <div class="btn-group">
                <a href="{{ route('candidatentreprises.mise_a_disposition') }}" type="button" class="btn btn-primary">Mise à disposition</a>
            </div>
            @endif

        </div> -->

    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-start">#</th>
                            <th>Entreprise</th>
                            <th class="text-start">Date de mise à disposition</th>
                            <th class="text-start">Satut</th>
                            <th>Poste</th>
                            <th>Lettre de recommandation</th>
                            <th>Contrat</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidatentreprises as $candidatentreprise)

                        <tr>
                            <td class="text-center">{{$loop->index+1}}</td>
                            <td>{{ $candidatentreprise->entreprise }}</td>
                            <td class="text-start">{{ dateFr($candidatentreprise->date_mise_disposition) }}</td>
                            @if ($candidatentreprise->statut == 'pending')
                            <td class="text-warning">En cours de traitement</td>
                            @elseif ($candidatentreprise->statut == 'accepted')
                            <td class="text-success">Accepter</td>
                            @elseif ($candidatentreprise->statut == 'refused')
                            <td class="text-danger">Rejeter</td>
                            @elseif ($candidatentreprise->statut == 'finished')
                            <td class="text-danger">Terminer</td>
                            @endif
                            <td class="text-center">{{ $candidatentreprise->poste }}</td>
                            <td class="text-center">
                                @if ($candidatentreprise->lettre_recommandation != null)
                                <a href="{{ asset($candidatentreprise->lettre_recommandation) }}" download><i class="bx bx-cloud-download fs-2"></i></a>
                                @endif
                            </td>
                            <td class="text-start">
                                @if ($candidatentreprise->contrat != null)
                                <a href="{{ asset($candidatentreprise->contrat) }}" download><i class="bx bx-cloud-download fs-2"></i></a>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <a href="{{ route('adherent.show', $candidatentreprise->candidature->user->id) }}">
                                    <i class='bx bxs-show'></i>
                                </a>

                                @if ( $candidatentreprise->statut == 'pending')
                                <a href="#" data-bs-toggle="modal" data-bs-target="#rapportModal{{$candidatentreprise->id}}" class="badge bg-warning mb-2">Suivre le dossier</a>

                                <div id="rapportModal{{$candidatentreprise->id}}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Compte rendu mise à disposition</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{route('candidatentreprises.changestatut')}}" method="POST" class="row g-3" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">statut : </label>
                                                            <select class="form-select" data-placeholder="Choisir une option" name="statut" id="statut{{$candidatentreprise->id}}" onchange="toggleStatut({{$candidatentreprise->id}})">
                                                                <option selected>Choisir une option</option>
                                                                <option value="refused">Candidature refusée</option>
                                                                @if ($candidatentreprise->candidature->en_poste != '1')
                                                                <option value="accepted">Candidature acceptée</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="row" id="other{{$candidatentreprise->id}}" style="display: none;">
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Poste : </label>
                                                                <input class="form-control" type="texte" name="poste" disabled value="{{$candidatentreprise->poste}}">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Localisation : </label>
                                                                <input class="form-control" type="texte" name="localisation" >
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Type de contrat : </label>
                                                                <select class="form-control" name="type_contrat" id="contrat" onchange="toggleContrat()">
                                                                    <option value="" selected>Choisir</option>
                                                                    <option value="CDD">CDD</option>
                                                                    <option value="CDI">CDI</option>
                                                                    <option value="othercontrat">Autre</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3" id="othercontrat-div" style="display: none;">
                                                                <label for="type_contrat" class="form-label">Type de contrat: </label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control @error('type_contrat') is-invalid @enderror" name="type_contrat" />
                                                                </div>
                                                                @error('type_contrat')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Contrat : </label>
                                                                <input class="form-control" type="file" name="contrat" >
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">date de début : </label>
                                                                <input class="form-control" type="date" name="date_db" >
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Date de fin : </label>
                                                                <input class="form-control" type="date" name="date_fin" >
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">commentaire : </label>
                                                                <textarea name="commentaire" class="form-control" id="" cols="10" rows="5"></textarea>
                                                            </div>
                                                        </div>

                                                        <input type="text" name="candidatentreprise_id" value="{{$candidatentreprise->id}}" hidden>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-label-info me-sm-3 me-1">Enregistrer</button>
                                                    <button type="reset" class="btn btn-label-danger btn-reset" data-bs-dismiss="modal" aria-label="Close">Retour</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if ( $candidatentreprise->statut == 'accepted')
                                <a style="cursor: pointer" class="refused" data-candidat-id="{{ $candidatentreprise->id }}">
                                    <span class="badge bg-warning mb-2">Terminer le contrat</span>
                                </a>

                                <form id="refusedForm-{{ $candidatentreprise->id }}" action="{{ route('candidatentreprises.end_poste') }}" method="post">
                                    @csrf
                                    <input type="text" name="statut" value="finish" hidden>
                                    <input type="text" name="candidatentreprise_id" value="{{$candidatentreprise->id}}" hidden>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

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
                title: "Terminer cet contrat",
                text: "Voulez-vous terminer cet contrat?",
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
