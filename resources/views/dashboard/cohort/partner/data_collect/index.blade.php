@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Cohorte/ Collecte de données /</span> Liste
                    </h4>
                </nav>
            </div>

        </div>
        <div class="card">
            <div class="card-body">
                <div class="ms-auto mb-2">
                    <div class="d-flex " style="gap:10px;">
                        <a href="{{ route('cohort.partner.show', $cohort->id) }}" class="btn btn-danger">
                            <i class="fa fa-arrow-circle-left me-2"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-start">#</th>
                                <th>Mecano / Matricule</th>
                                <th>Nom & Prénoms</th>
                                <th>Spécialisation</th>
                                <th class="text-center">Date début et fin</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adherents as $adherent)
                                @if ($adherent->participations->count() > 0)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td>{{ $adherent->user->mecano }}</td>
                                        <td>{{ $adherent->user->fullName() }}</td>
                                        <td>{{ $adherent->choiceFinal->specialisation }}</td>
                                        <td class="text-center">
                                            @if ($adherent->data_collect || $adherent->dataCollect)
                                                <span class="text-secondary fw-bold">
                                                    {{ dateFr($adherent->dataCollect->beging_date) }}
                                                    -
                                                    {{ $adherent->dataCollect->end_date ? dateFr($adherent->dataCollect->end_date) : 'N/A' }}
                                                </span>
                                            @else
                                                <span class="text-warning">Insertion du PA</span>
                                            @endif
                                        </td>
                                        <td class="d-flex justify-content-evenly align-items-center">
                                            <a href="{{ route('adherent.show', $adherent->user->id) }}">
                                                <i class=" bx bx-show me-2"></i>
                                            </a>
                                            @if (!$adherent->dataCollect)
                                                <button data-toggle="modal" data-target="#edit-adherent"
                                                    class="addBtn btn btn-secondary" data-counter="{{ $adherent }}"
                                                    data-action="{{ route('cohort.data_collect.store', $adherent->id) }}">
                                                    Plannifier
                                                    <i class="bx bx-right-arrow-alt ms-2"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Collecte de données</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="beging_date" class="form-label">Date de début de la collecte<span
                                            class="text-danger">*</span> :
                                    </label>
                                    <input type="date" class="form-control @error('beging_date') is-invalid @enderror"
                                        id="beging_date" name="beging_date" value="{{ old('beging_date') }}" required>
                                    @error('beging_date')
                                        <span class="invalid-feedback" besoin="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="end_date" class="form-label">Date de fin de la collecte :
                                    </label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                        id="end_date" name="end_date" value="{{ old('end_date') }}">
                                    @error('end_date')
                                        <span class="invalid-feedback" besoin="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('js-push')
        <script>
            (function($) {
                "use strict";
                $('.addBtn').on('click', function() {
                    var modal = $('#addModal');
                    var adherent = $(this).data('adherent');
                    console.log(adherent);
                    modal.find('form').attr('action', $(this).data('action'));
                    // modal.find('textarea[name=location]').val(counter.location);
                    modal.modal('show');
                });
            })(jQuery);
        </script>
    @endpush
@endsection
