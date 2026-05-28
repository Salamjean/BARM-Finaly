<div class="container-fluid bg-white p-4">
    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
        <i class="bx bx-chart-line text-warning fs-4 me-3"></i>
        <h4 class="mb-0 text-warning">Rapports de suivi</h4>
    </div>

    @if (!can('partner-financial') && count($adherent->reportsPostMonitored) > 0)
        <div class="row g-3">
            @foreach ($adherent->reportsPostMonitored as $index => $report)
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
                            <div class="col-md-4">
                                <div class="border-start border-primary border-3 ps-3 py-2 bg-white bg-opacity-75">
                                    <div class="text-muted small mb-1">Date de création</div>
                                    <div class="fw-medium">{{ dateFr($report->created_at) }}</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border-start border-success border-3 ps-3 py-2 bg-white bg-opacity-75">
                                    <div class="text-muted small mb-1">Date de la visite</div>
                                    <div class="fw-medium">{{ dateFr($report->date_visit) }}</div>
                                </div>
                            </div>

                            <div class="col-md-4">
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
                                        <button type="button" class="btn btn-secondary btn-sm me-2"
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
    @elseif (can('partner-financial') && count($adherent->reportsPostMonitored->where('created_by', auth()->user()->id)) > 0)
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
                            <div class="col-md-4">
                                <div class="border-start border-primary border-3 ps-3 py-2 bg-white bg-opacity-75">
                                    <div class="text-muted small mb-1">Date de création</div>
                                    <div class="fw-medium">{{ dateFr($report->created_at) }}</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border-start border-success border-3 ps-3 py-2 bg-white bg-opacity-75">
                                    <div class="text-muted small mb-1">Date de la visite</div>
                                    <div class="fw-medium">{{ dateFr($report->date_visit) }}</div>
                                </div>
                            </div>

                            <div class="col-md-4">
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
                                        <button type="button" class="btn btn-secondary btn-sm me-2"
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
        </div>
    @endif
</div>

<script>
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
