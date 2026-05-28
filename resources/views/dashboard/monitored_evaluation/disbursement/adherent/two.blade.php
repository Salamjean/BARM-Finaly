<div class="pt-1">

    @if ($adherent->selfEmploymentMonitoredPayment->disbursement_form)
        <div class="row gap-5">
            <div class="col-md-3">
                <div class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                    <div>Fiche de décaissement</div>
                    <div>
                        <a href="{{ asset($adherent->selfEmploymentMonitoredPayment->disbursement_form) }}" download>
                            <i class='bx bxs-download '></i>
                        </a>
                    </div>
                </div>
            </div>

            @if ($adherent->selfEmploymentMonitoredPayment->signed_disbursement_document)
                <div class="col-md-3">
                    <div class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                        <div>Fiche de décaissement signé</div>
                        <div>
                            <a href="{{ asset($adherent->selfEmploymentMonitoredPayment->signed_disbursement_document) }}"
                                download>
                                <i class='bx bxs-download '></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    @endif

    @if ($add_disbursement_btn)
        <div class="text-right my-3 d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#disbursementModal">
                Faire un décaissement
            </button>
        </div>
    @endif

    <div class="table-responsive mt-1">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Montant</th>
                    <th>D. Soumission</th>
                    @if (!can('partner-financial'))
                        <th>F. Décaissement</th>
                    @endif
                    <th>D. Autorisation</th>
                    <th>F. Decaissement signé</th>
                    <th>D. Decaissement</th>
                    <th>D. Rapport</th>
                    @if (!can('partner-financial'))
                        <th>Rapport</th>
                    @endif
                    <th>Rapport signé</th>
                    <th>Statut</th>
                    @if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation') ||
                            can('partner-financial') ||
                            can('partner-technical'))
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($adherent->selfEmploymentMonitoredPayment->disbursements as $index => $disbursement)
                    <tr>
                        <td class="w-25">{{ $disbursement->title }}</td>
                        <td class="w-25">{{ amount($disbursement->amount_disbursement) . DEVICE }}</td>
                        <td>{{ dateFr($disbursement->date_hour_submission_document) }}</td>
                        @if (!can('partner-financial'))
                            <td>
                                @if ($disbursement->document_file)
                                    <a href="{{ asset($disbursement->document_file) }}" title="Fiche de décaissement"><i
                                            class="bx bxs-download"></i></a>
                                @endif
                            </td>
                        @endif
                        <td>{{ dateFr($disbursement->authorization_date) }}</td>

                        <td>
                            @if ($disbursement->authorization_file)
                                <a href="{{ asset($disbursement->authorization_file) }}"
                                    title="Fiche de decaissement signé"><i class="bx bxs-download"></i></a>
                            @endif
                        </td>

                        <td>{{ dateFr($disbursement->date_disbursement) }}</td>

                        <td>{{ dateFr($disbursement->report_date) }}</td>
                        @if (!can('partner-financial'))
                            <td>
                                @if ($disbursement->report_file)
                                    <a href="{{ asset($disbursement->report_file) }}" title="Rapport"><i
                                            class="bx bxs-download"></i></a>
                                @endif
                            </td>
                        @endif
                        <td>
                            @if ($disbursement->report_signed_file)
                                <a href="{{ asset($disbursement->report_signed_file) }}" title="Rapport signé"><i
                                        class="bx bxs-download"></i></a>
                            @endif
                        </td>
                        <td class="{{ status($disbursement->status, 'css') }}">
                            {{ status($disbursement->status) }}</td>
                        @if (can('conseiller-auto-emploi|chef-cellule-formation-et-insertion|chef-celulle-suivi-evaluation|responsable-suivi-evaluation') ||
                                can('partner-financial') ||
                                can('partner-technical'))
                            <td>
                                @if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation'))
                                    @if (!$disbursement->authorization && $disbursement->status === 'pending')
                                        <a class="authorization-link" style="cursor: pointer;"
                                            title="Autorisation le decaissement"
                                            data-action="{{ route('monitored-evaluation.disbursement.update.authorization', $disbursement->id) }}"
                                            data-disbursement-id="{{ $disbursement->id }}"
                                            data-disbursement-title="{{ $disbursement->title }}"><i
                                                class="bx bx-lock-open-alt fs-4"></i></a>
                                    @endif
                                @endif

                                @if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation') || can('partner-financial'))
                                    @if ($disbursement->authorization && $disbursement->status === 'in_progress')
                                        <a class="disbursement-link" style="cursor: pointer;"
                                            title="Validation de decaissement"
                                            data-action="{{ route('monitored-evaluation.disbursement.update.disbursement', $disbursement->id) }}"
                                            data-disbursement-id="{{ $disbursement->id }}"
                                            data-disbursement-title="{{ $disbursement->title }}">
                                            <i class="bx bx-money-withdraw fs-4"></i>
                                        </a>
                                    @endif
                                @endif
                                @if (can('partner-technical') || can('conseiller-auto-emploi|chef-cellule-formation-et-insertion|chef-celulle-suivi-evaluation|responsable-suivi-evaluation'))
                                    @if ($left_pay === 0 && !$disbursement->report_file && $disbursement->status === 'finished')
                                        <a class="last-report-link" style="cursor: pointer;"
                                            title="Joindre le rapport"
                                            data-action="{{ route('monitored-evaluation.disbursement.update.last_report', $disbursement->id) }}"
                                            data-disbursement-id="{{ $disbursement->id }}"
                                            data-disbursement-title="{{ $disbursement->title }}">
                                            <i class="bx bxs-report fs-4"></i>
                                        </a>
                                    @endif
                                @endif

                                @if (can('conseiller-auto-emploi|chef-cellule-formation-et-insertion|chef-celulle-suivi-evaluation|responsable-suivi-evaluation'))
                                    @if ($disbursement->status === 'finished' && !$disbursement->report_signed_file)
                                        <a class="file-signed-report" style="cursor: pointer;"
                                            title="Joindre le rapport signé"
                                            data-action="{{ route('monitored-evaluation.disbursement.update.file_signed_report', $disbursement->id) }}"
                                            data-disbursement-id="{{ $disbursement->id }}"
                                            data-disbursement-title="{{ $disbursement->title }}"><i
                                                class="bx bx-file fs-4"></i></a>
                                    @endif
                                @endif

                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Pas de décaissement...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@if ($add_disbursement_btn && $left_pay > 0)
    <div class="modal fade" id="disbursementModal" tabindex="-1" aria-labelledby="disbursementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disbursementModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="disbursementForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="document_file" class="form-label">Fiche de
                                décaissement <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="document_file" name="document_file"
                                accept=".pdf" required>
                        </div>
                        @if ($last_disbursement && $last_disbursement->status === 'finished')
                            <div class="mb-3">
                                <label for="report_file" class="form-label">Rapport du décaissement
                                    (Dernier décaissement)<span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="report_file" name="report_file"
                                    accept=".pdf" required>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
@if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation'))
    <div class="modal fade" id="authorizationModal" tabindex="-1" aria-labelledby="authorizationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authorizationModalLabel">Autorisation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="authorizationForm">
                        <div class="mb-3">
                            <label for="authorizationStatus" class="form-label">Voulez vous
                                autorisez ou pas la demande?<span class="text-danger">*</span></label>
                            <select class="form-control" id="authorizationStatus" name="authorizationStatus"
                                required>
                                <option value="">Selectionner</option>
                                <option value="authorized">Autorisé</option>
                                <option value="not_authorized">Rejété</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="authorization_file" class="form-label">Fiche de
                                décaissement signé (si autorisé
                                ) </label>
                            <input type="file" class="form-control" id="authorization_file"
                                name="authorization_file" accept=".pdf" required>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label">Raison (si autorisation
                                rejété)</label>
                            <input type="text" class="form-control" id="reason" name="reason">
                        </div>
                        <input type="hidden" id="disbursementId" name="disbursementId">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation') || can('partner-financial'))
    <div class="modal fade" id="_disbursementModal" tabindex="-1" aria-labelledby="_disbursementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="_disbursementModalLabel">Autorisation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="_disbursementForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="date_disbursement" class="form-label">Date décaissement<span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_disbursement"
                                name="date_disbursement" max="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="file_disbursement" class="form-label">Fiche de décaissement (optionel)</label>
                            <input type="file" class="form-control" id="file_disbursement"
                                name="file_disbursement" accept=".pdf">
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@if (can('partner-financial'))
    <div class="modal fade" id="disbursementLoanModal" tabindex="-1" aria-labelledby="disbursementLoanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disbursementLoanModalLabel">Date de mise en place du prêt
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="disbursementLoanForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="date_loan" class="form-label">Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_loan" name="date"
                                max="{{ date('Y-m-d') }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@if (can('partner-technical') || can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation'))
    <div class="modal fade" id="lastReportModal" tabindex="-1" aria-labelledby="lastReportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lastReportModalLabel">Rapport du décaissement </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="lastReportForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="report_file" class="form-label">Rapport du décaissement
                                <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="report_file" name="report_file"
                                accept=".pdf" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@if (can('partner-technical') || can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation'))
    <div class="modal fade" id="reportSignedModal" tabindex="-1" aria-labelledby="reportSignedModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportSignedModalLabel">Autorisation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reportSignedModalForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="report_signed_file" class="form-label">Rapport de décaissement signé
                                <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="report_signed_file"
                                name="report_signed_file" accept=".pdf" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@push('js-push')
    <script>
        const url_send_disbursement = "{{ route('monitored-evaluation.disbursement.store.authorization', $adherent->id) }}"
        $(document).ready(function() {
            @if (can('partner-technical'))
                //sotre disbursement
                $('#disbursementForm').on('submit', function(e) {
                    e.preventDefault();
                    loading();

                    const formData = new FormData(this);

                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        }
                    });

                    $.ajax({
                        url: url_send_disbursement,
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
                                $('#disbursementModal').modal('hide');
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

                            alert('Une erreur est survenue, veuillez réessayer.');
                        }
                    });
                });
            @endif

            @if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation'))
                $('a.authorization-link').on('click', function() {
                    const actionUrl = $(this).data('action');
                    const disbursementId = $(this).data('disbursement-id');
                    const disbursementTitle = $(this).data('disbursement-title');

                    $('#disbursementId').val(disbursementId);

                    $('#authorizationModalLabel').text(disbursementTitle);

                    $('#authorizationForm').data('action-url', actionUrl);

                    $('#authorizationModal').modal('show');
                });

                $('#authorizationForm').on('submit', function(e) {
                    e.preventDefault();
                    loading();

                    const formData = new FormData();

                    formData.append('authorizationStatus', $('#authorizationStatus').val());
                    formData.append('disbursementId', $('#disbursementId').val());
                    formData.append('reason', $('#reason').val());

                    let fileInput = document.getElementById('authorization_file');
                    if (fileInput.files.length > 0) {
                        formData.append('authorization_file', fileInput.files[0]);
                    }

                    const actionUrl = $(this).data('action-url');

                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        }
                    });

                    $.ajax({
                        url: actionUrl,
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            endLoading();
                            if (response.action) {
                                ToastSuccess.fire({
                                    icon: 'success',
                                    title: response.message,
                                });
                                $('#authorizationModal').modal('hide');
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
                            alert('Une erreur est survenue, veuillez réessayer.');
                        }
                    });
                });
            @endif

            @if (can('partner-financial'))
                $('a.disbursement-loan-link').on('click', function() {
                    const actionUrl = $(this).data('action');
                    const disbursementTitle = $(this).data('disbursement-loan-title');

                    $('#disbursementLoanModalLabel').text(disbursementTitle);
                    $('#disbursementLoanForm').data('action-url', actionUrl);

                    $('#disbursementLoanModal').modal('show');
                });

                $('#disbursementLoanForm').on('submit', function(e) {
                    e.preventDefault();
                    loading();

                    const formData = new FormData(this);

                    const actionUrl = $(this).data('action-url');

                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        }
                    });

                    $.ajax({
                        url: actionUrl,
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
                                $('#disbursementLoanModal').modal('hide');
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
                            alert('Une erreur est survenue, veuillez réessayer.');
                        }
                    });
                });
            @endif

            @if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation') || can('partner-financial'))
                $('a.disbursement-link').on('click', function() {
                    const actionUrl = $(this).data('action');
                    const disbursementTitle = $(this).data('disbursement-title');

                    $('#_disbursementModalLabel').text(disbursementTitle);
                    $('#_disbursementForm').data('action-url', actionUrl);

                    $('#_disbursementModal').modal('show');
                });

                $('#_disbursementForm').on('submit', function(e) {
                    e.preventDefault();
                    loading();

                    const formData = new FormData(this);

                    const actionUrl = $(this).data('action-url');

                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        }
                    });

                    $.ajax({
                        url: actionUrl,
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
                                $('#disbursementModal').modal('hide');
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
                            alert('Une erreur est survenue, veuillez réessayer.');
                        }
                    });
                });
            @endif

            @if (can('partner-technical') || can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation'))
                $('a.last-report-link').on('click', function() {
                    const actionUrl = $(this).data('action');
                    const disbursementTitle = $(this).data('disbursement-title');

                    $('#lastReportModalLabel').text(disbursementTitle);
                    $('#lastReportForm').data('action-url', actionUrl);

                    $('#lastReportModal').modal('show');
                });

                $('#lastReportForm').on('submit', function(e) {
                    e.preventDefault();
                    loading();

                    const formData = new FormData(this);

                    const actionUrl = $(this).data('action-url');

                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        }
                    });

                    $.ajax({
                        url: actionUrl,
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
                                $('#lastReportModal').modal('hide');
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
                            alert('Une erreur est survenue, veuillez réessayer.');
                        }
                    });
                });

                $('a.file-signed-report').on('click', function() {
                    const actionUrl = $(this).data('action');
                    const disbursementTitle = $(this).data('disbursement-title');

                    $('#reportSignedModalLabel').text(disbursementTitle);
                    $('#reportSignedModalForm').data('action-url', actionUrl);

                    $('#reportSignedModal').modal('show');
                });

                $('#reportSignedModalForm').on('submit', function(e) {
                    e.preventDefault();
                    loading();

                    const formData = new FormData(this);

                    const actionUrl = $(this).data('action-url');

                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        }
                    });

                    $.ajax({
                        url: actionUrl,
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
                                $('#reportSignedModalModal').modal('hide');
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
                            alert('Une erreur est survenue, veuillez réessayer.');
                        }
                    });
                });
            @endif

        });
    </script>
@endpush
