@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-chart-line text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">
                                @if ($adherent->cohort)
                                    Suivi-Evaluation / Post-Suivi / Cohorte / {{ $adherent->cohort->reference }} / Adhérent
                                @else
                                    Suivi-Evaluation / Post-Suivi / Adhérent
                                @endif
                            </div>
                            <h4 class="mb-0 text-primary">{{ $adherent->user->fullName() }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-chart-line text-warning fs-3 me-3"></i>
                    <div>
                        <h4 class="mb-0 text-warning">Rapports de suivi</h4>
                        <div class="text-muted small">
                            Gestion des rapports post-financement pour {{ $adherent->user->fullName() }}
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#reportModal">
                    <i class="bx bx-plus me-2"></i>
                    Ajouter un rapport
                </button>
            </div>
        </div>

        <div class="bg-white p-4 rounded-3 shadow-none">
            <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                <i class="bx bx-file-blank text-info fs-4 me-3"></i>
                <h5 class="mb-0 text-info">Liste des rapports</h5>
                <span class="badge bg-info ms-2">{{ count($adherent->reportsPostMonitored->where('created_by', auth()->user()->id)) }}</span>
            </div>

            @if (count($adherent->reportsPostMonitored->where('created_by', auth()->user()->id)) > 0)
                <div class="row g-3">
                    @foreach ($adherent->reportsPostMonitored->where('created_by', auth()->user()->id) as $index => $report)
                        <div class="col-12">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 me-3">
                                            Rapport {{ $index + 1 }}
                                        </span>
                                        <h5 class="mb-0 text-dark">{{ $report->report_title }}</h5>
                                    </div>
                                    @if ($report->file_report)
                                        <a href="{{ asset($report->file_report) }}" class="btn btn-primary btn-sm" download>
                                            <i class="bx bx-download me-1"></i> Télécharger
                                        </a>
                                    @endif
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="border-start border-primary border-3 ps-3 py-2 bg-white bg-opacity-75">
                                            <div class="text-muted small mb-1">Date de création</div>
                                            <div class="fw-medium">{{ dateFr($report->created_at) }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="border-start border-success border-3 ps-3 py-2 bg-white bg-opacity-75">
                                            <div class="text-muted small mb-1">Date de la visite</div>
                                            <div class="fw-medium">{{ dateFr($report->date_visit) }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="border-start border-info border-3 ps-3 py-2 bg-white bg-opacity-75">
                                            <div class="text-muted small mb-1">Rapporteur</div>
                                            <div class="fw-medium">
                                                {{ $report->user_type === 'personal' ? $report->createdBy->fullName() : $report->createdBy->username }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($report->report_description)
                                    <div class="mt-3">
                                        <div class="border-start border-secondary border-3 ps-3 py-2 bg-white bg-opacity-75">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="text-muted small mb-1">Description du rapport</div>
                                                <button type="button" class="btn btn-outline-secondary btn-sm me-2" 
                                                        onclick="showDescription({{ json_encode($report->report_description) }})"
                                                        title="Voir la description complète">
                                                    <i class="bx bx-show me-1"></i> Voir plus
                                                </button>
                                            </div>
                                            <div class="fw-medium text-truncate" style="max-width: 500px;">
                                                {{ Str::limit($report->report_description, 100) }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bx bx-file-blank text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-muted mb-2">Aucun rapport disponible</h5>
                    <p class="text-muted small">Aucun rapport de suivi n'a encore été créé pour cet adhérent.</p>
                    <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#reportModal">
                        <i class="bx bx-plus me-2"></i>
                        Créer le premier rapport
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header text-white">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-plus-circle me-2 fs-4"></i>
                        <h5 class="modal-title mb-0" id="reportModalLabel">Nouveau Rapport de Suivi</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="reportForm" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="date_visit" class="form-label">
                                    <i class="bx bx-calendar text-primary me-1"></i>
                                    Date de visite <span class="text-danger">*</span>
                                </label>
                                <input type="date" max="{{ date('Y-m-d') }}" class="form-control" id="date_visit"
                                    name="date_visit" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="report_title" class="form-label">
                                    <i class="bx bx-text text-primary me-1"></i>
                                    Titre du rapport <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="report_title" name="report_title" 
                                       placeholder="Ex: Visite de suivi mensuelle" required>
                            </div>
                            
                            <div class="col-12">
                                <label for="report_file" class="form-label">
                                    <i class="bx bx-file-blank text-primary me-1"></i>
                                    Fichier rapport (PDF)
                                </label>
                                <input type="file" accept=".pdf" class="form-control" id="report_file"
                                    name="report_file">
                                <div class="form-text">
                                    <i class="bx bx-info-circle me-1"></i>
                                    Format accepté : PDF uniquement (optionnel)
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <label for="report_description" class="form-label">
                                    <i class="bx bx-edit-alt text-primary me-1"></i>
                                    Description détaillée
                                </label>
                                <textarea name="report_description" id="report_description" class="form-control" 
                                          rows="6" placeholder="Décrivez les observations, recommandations et points clés de cette visite..."></textarea>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                <i class="bx bx-x me-1"></i>
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Enregistrer le rapport
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            const url_send_report = "{{ route('monitored-evaluation.post_monitored.store', $adherent->id) }}"
            
            $('#reportForm').on('submit', function(e) {
                e.preventDefault();
                loading();

                const formData = new FormData(this);

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    }
                });

                $.ajax({
                    url: url_send_report,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        endLoading();
                        if (response.action) {
                            ToastSuccess.fire({
                                icon: 'success',
                                title: response.message,
                            });
                            $('#reportModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            ToastError.fire({
                                icon: 'error',
                                title: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        endLoading();
                        ToastError.fire({
                            icon: 'error',
                            title: 'Une erreur est survenue, veuillez réessayer.',
                        });
                    }
                });
            });

            function showDescription(description) {
                Swal.fire({
                    title: 'Description du rapport',
                    html: '<div class="text-start">' + description.replace(/\n/g, '<br>') + '</div>',
                    icon: 'info',
                    confirmButtonText: 'Fermer',
                    confirmButtonColor: '#0d6efd',
                    customClass: {
                        popup: 'swal-wide'
                    }
                });
            }

            // Réinitialiser le formulaire quand la modal se ferme
            $('#reportModal').on('hidden.bs.modal', function () {
                $('#reportForm')[0].reset();
            });
        </script>
        
        <style>
            .swal-wide {
                width: 600px !important;
            }
            
            .swal2-html-container {
                max-height: 400px;
                overflow-y: auto;
            }
        </style>
    @endpush
@endsection