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
                        <i class="bx bx-user-plus text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Cohorte</div>
                            <h4 class="mb-0 text-primary">Ajouter des adhérents</h4>
                            <small class="text-muted">{{ $cohort->title }}</small>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec bouton retour et informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-group text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Adhérents disponibles</h5>
                        <small class="text-muted">Sélectionnez les adhérents à ajouter à la cohorte</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2" id="count-available">
                            0
                        </div>
                        <small class="text-muted d-block">Disponibles</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $cohort->number_adherent - $cohort->adhrents->count() }}
                        </div>
                        <small class="text-muted d-block">Places restantes</small>
                    </div>
                    <a href="{{ route('cohort.show', $cohort->id) }}" class="btn btn-outline-danger d-flex align-items-center">
                        <i class="bx bx-arrow-back me-2"></i>
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Tableau des adhérents disponibles -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table table-hover" id="datatable-available-adherents" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th class="border-0">
                                    #
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-briefcase text-primary me-1"></i>
                                    Spécialisation
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-map text-primary me-1"></i>
                                    Localisation
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout -->
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title">
                        <i class="bx bx-user-plus me-2"></i>
                        Choix du partenaire technique
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formSubmit" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="cohort_id" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="fullname" class="form-label">
                                    <i class="bx bx-user me-1"></i>
                                    Adhérent <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="fullname" id="fullname" class="form-control" disabled>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="partner" class="form-label">
                                    <i class="bx bx-briefcase me-1"></i>
                                    Partenaire technique <span class="text-danger">*</span>
                                </label>
                                <select name="partner_id" id="partner" class="form-select" required>
                                    <option selected disabled>Sélectionner un partenaire</option>
                                    @foreach ($partner_technicials as $partner)
                                        <option value="{{ $partner->id }}">{{ $partner->user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x me-1"></i>
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check me-1"></i>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            (function($) {
                "use strict";

                // Initialize DataTable with server-side processing
                let tableAvailableAdherents;

                $(document).ready(function() {
                    // Table for available adherents
                    tableAvailableAdherents = $('#datatable-available-adherents').DataTable({
                        processing: true,
                        serverSide: true,
                        searching: true,
                        ajax: {
                            url: '{{ route("cohort.available_adherents.data", ["cohortId" => $cohort->id]) }}',
                            type: 'GET'
                        },
                        columns: [
                            {
                                data: 'index',
                                render: function(data) {
                                    return '<span class="badge bg-info me-2">' + data + '</span>';
                                }
                            },
                            {
                                data: null,
                                render: function(data) {
                                    return '<div class="d-flex align-items-center">' +
                                           '<div>' +
                                           '<div class="fw-bold text-dark">' + data.fullname + '</div>' +
                                           '<div class="small text-muted">' +
                                           '<span class="badge bg-secondary me-1">' + data.mecano + '</span>' +
                                           '<span>+225 ' + data.phone + '</span>' +
                                           '</div>' +
                                           '</div>' +
                                           '</div>';
                                }
                            },
                            {
                                data: 'specialisation',
                                render: function(data) {
                                    return '<div class="border-start border-info border-3 ps-2 py-1">' +
                                           '<div class="fw-medium text-info">' + data + '</div>' +
                                           '</div>';
                                }
                            },
                            {
                                data: 'locality',
                                render: function(data) {
                                    return '<div class="d-flex align-items-center">' +
                                           '<i class="bx bx-map-pin text-warning fs-5 me-2"></i>' +
                                           '<div class="fw-medium">' + data + '</div>' +
                                           '</div>';
                                }
                            },
                            {
                                data: null,
                                render: function(data) {
                                    return '<div class="d-flex justify-content-center">' +
                                           '<button data-toggle="modal" class="addBtn btn btn-outline-success btn-sm" ' +
                                           'data-adherent-id="' + data.id + '" ' +
                                           'data-user-id="' + data.user_id + '" ' +
                                           'data-fullname="' + data.fullname + '" ' +
                                           'data-cohort-id="{{ $cohort->id }}" ' +
                                           'data-action="{{ route("cohort.update_adherent", "") }}/' + data.id + '" ' +
                                           'title="Ajouter à la cohorte">' +
                                           '<i class="bx bx-plus me-1"></i>Ajouter</button>' +
                                           '</div>';
                                }
                            }
                        ],
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json"
                        },
                        pageLength: 10,
                        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                        drawCallback: function(settings) {
                            $('#count-available').text(settings.json.recordsTotal);
                        }
                    });
                });

                // Handle add button clicks
                $(document).on('click', '.addBtn', function() {
                    var modal = $('#addModal');
                    var adherentId = $(this).data('adherent-id');
                    var fullname = $(this).data('fullname');
                    var cohortId = $(this).data('cohort-id');
                    var actionUrl = $(this).data('action');

                    modal.find('input[name=fullname]').val(fullname);
                    modal.find('input[name=cohort_id]').val(cohortId);
                    modal.find('form').attr('action', actionUrl);
                    modal.modal('show');
                });
            })(jQuery);
        </script>
    @endpush
@endsection