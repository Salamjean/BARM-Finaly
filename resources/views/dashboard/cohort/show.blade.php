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
                        <i class="bx bx-bookmark text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Cohorte</div>
                            <h4 class="mb-0 text-primary">Détail {{ $cohort->title }}</h4>
                            <small class="text-muted">Créée le {{ $cohort->created_at->format('d-m-Y') }}</small>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec bouton d'action et statistiques -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-group text-success fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Adhérents de la cohorte</h5>
                        <small class="text-muted">Liste des membres inscrits</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $cohort->adhrents->count() }}
                        </div>
                        <small class="text-muted d-block">Adhérents</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $cohort->number_adherent }}
                        </div>
                        <small class="text-muted d-block">Capacité</small>
                    </div>
                    @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                        @if ($cohort->status != '1')
                            <a href="{{ route('cohort.add_adherent', $cohort->id) }}"
                                class="btn btn-primary d-flex align-items-center">
                                <i class="bx bx-user-plus me-2"></i>
                                Ajouter des adhérents
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabs des adhérents -->
        <div class="bg-white rounded-3 shadow-sm mb-3">
            <div class="p-4">
                <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active d-flex align-items-center justify-content-center" id="all-tab"
                            data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab" aria-controls="all"
                            aria-selected="true">
                            <i class="bx bx-group me-2"></i>
                            Dans une session collective
                            <span class="badge bg-primary ms-2" id="count-session-collective">0</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center justify-content-center" id="active-tab"
                            data-bs-toggle="pill" data-bs-target="#active" type="button" role="tab"
                            aria-controls="active" aria-selected="false">
                            <i class="bx bx-check-circle me-2"></i>
                            Nouveaux dans la colorte
                            <span class="badge bg-success ms-2" id="count-new-cohort">0</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Contenu des tabs -->
        <div class="tab-content" id="myTabContent">
            <!-- Tab 1: Tous les adhérents -->
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <div class="bg-white rounded-3 shadow-sm">
                    <div class="p-4">
                        <div class="table-responsive">
                            
                            <table class="table table-hover" id="datatable-session-collective" style="width:100%">
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
                                        <th class="border-0">
                                            <i class="bx bx-user-check text-primary me-1"></i>
                                            Partenaire
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

            <!-- Tab 2: Adhérents actifs -->
            <div class="tab-pane fade" id="active" role="tabpanel" aria-labelledby="active-tab">
                <div class="bg-white rounded-3 shadow-sm">
                    <div class="p-4">
                        <div class="table-responsive">
                            
                            <table class="table table-hover" id="datatable-new-cohort" style="width:100%">
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
                                        <th class="border-0">
                                            <i class="bx bx-user-check text-primary me-1"></i>
                                            Partenaire
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
        </div>
    </div>

    @if (can('conseiller-auto-emploi|chef-cellule-formation-et-insertion'))
        <!-- Modal d'ajout -->
        <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white">
                        <h5 class="modal-title">
                            <i class="bx bx-user-plus me-2"></i>
                            Changement du partenaire technique
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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
    @endif

        @push('js-push')
            <script>
                (function($) {
                    "use strict";
                    
                    // Initialize DataTables with server-side processing
                    let tableSessionCollective, tableNewCohort;
                    
                    $(document).ready(function() {
                        // Table for session collective adherents
                        tableSessionCollective = $('#datatable-session-collective').DataTable({
                            processing: true,
                            serverSide: true,
                            searching: true,
                            ajax: {
                                url: '{{ route("cohort.adherents.data", ["cohortId" => $cohort->id, "type" => "session_collective"]) }}',
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
                                               '<span>' + data.phone + '</span>' +
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
                                    data: 'partner',
                                    render: function(data) {
                                        return '<div class="border-start border-primary border-3 ps-2 py-1">' +
                                               '<div class="d-flex align-items-center">' +
                                               '<span class="badge bg-primary">' + data + '</div>' +
                                               '<small class="text-muted">Partenaire assigné</small>' +
                                               '</div>';
                                    }
                                },
                                { 
                                    data: null,
                                    render: function(data) {
                                        return '<div class="d-flex justify-content-center">' +
                                               '<a href="/adherent/show/' + data.user_id + '" class="btn btn-outline-primary btn-sm" title="Voir le profil de l\'adhérent">' +
                                               '<i class="bx bx-show"></i>' +
                                               '</a>' +
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
                                $('#count-session-collective').text(settings.json.recordsTotal);
                            }
                        });

                        // Table for new cohort adherents
                        tableNewCohort = $('#datatable-new-cohort').DataTable({
                            processing: true,
                            serverSide: true,
                            searching: true,
                            ajax: {
                                url: '{{ route("cohort.adherents.data", ["cohortId" => $cohort->id, "type" => "new_cohort"]) }}',
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
                                               '<span>' + data.phone + '</span>' +
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
                                    data: 'partner',
                                    render: function(data) {
                                        return '<div class="border-start border-primary border-3 ps-2 py-1">' +
                                               '<div class="d-flex align-items-center">' +
                                               '<span class="badge bg-primary">' + data + '</div>' +
                                               '<small class="text-muted">Partenaire assigné</small>' +
                                               '</div>';
                                    }
                                },
                                { 
                                    data: null,
                                    render: function(data) {
                                        let buttons = '<div class="d-flex justify-content-center gap-1">' +
                                               '<a href="/adherent/show/' + data.user_id + '" class="btn btn-outline-primary btn-sm" title="Voir le profil de l\'adhérent">' +
                                               '<i class="bx bx-show"></i>' +
                                               '</a>';
                                        
                                        @if (can('conseiller-auto-emploi|chef-cellule-formation-et-insertion'))
                                        buttons += '<button data-toggle="modal" class="addBtn btn btn-outline-success btn-sm" ' +
                                               'data-adherent-id="' + data.user_id + '" ' +
                                               'data-cohort-id="{{ $cohort->id }}" ' +
                                               'data-action="{{ route("cohort.update_adherent", "") }}/' + data.id + '" ' +
                                               'title="Changer de partenaire technique">' +
                                               '<i class="bx bx-plus me-1"></i>Modifier</button>';
                                        @endif
                                        
                                        buttons += '</div>';
                                        return buttons;
                                    }
                                }
                            ],
                            language: {
                                url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json"
                            },
                            pageLength: 10,
                            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                            drawCallback: function(settings) {
                                $('#count-new-cohort').text(settings.json.recordsTotal);
                            }
                        });
                    });

                    // Handle add button clicks
                    $(document).on('click', '.addBtn', function() {
                        var modal = $('#addModal');
                        var adherentId = $(this).data('adherent-id');
                        var cohortId = $(this).data('cohort-id');
                        var actionUrl = $(this).data('action');
                        
                        // Fetch adherent data via AJAX to avoid memory issues
                        $.get('/adherent/' + adherentId + '/data', function(adherent) {
                            modal.find('input[name=fullname]').val(adherent.user.firstname + ' ' + adherent.user.lastname);
                            modal.find('input[name=cohort_id]').val(cohortId);
                            modal.find('form').attr('action', actionUrl);
                            modal.modal('show');
                        }).fail(function() {
                            console.error('Erreur lors de la récupération des données de l\'adhérent');
                        });
                    });

                    // Connect custom search fields to DataTables
                    $('#search-session-collective').on('keyup', function() {
                        tableSessionCollective.search(this.value).draw();
                    });

                    $('#search-new-cohort').on('keyup', function() {
                        tableNewCohort.search(this.value).draw();
                    });
                })(jQuery);
            </script>
        @endpush
@endsection
