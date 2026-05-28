@php
    $carbon = new \Carbon\Carbon();
@endphp
<div class="table-responsive mt-1">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date de saisie</th>
                <th>Titre</th>
                <th>Montant</th>
                <th>D. Echeance</th>
                <th>D. Remboursement</th>
                <th>Statut</th>
                @if (can('responsable-suivi-evaluation|chef-celulle-suivi-evaluation|partner-financial'))
                    <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($adherent->selfEmploymentMonitoredPayment->disbursementDeadlines as $index => $disbursement)
                <tr>
                    <td class="w-25">{{ dateFr($disbursement->created_at) }}</td>
                    <td class="w-25">Echéance {{ $index+ 1  }}</td>
                    <td class="w-25">{{ amount($disbursement->amount) . DEVICE }}</td>
                    <td>
                        {{ dateFr($disbursement->date_expiry) }}

                        <div class="">
                            @php
                                $reminder_dates = json_decode($disbursement->reminder_dates);
                            @endphp
                            @if (count($reminder_dates) > 0)
                                <div>
                                    <span class="text-danger">Rappel(s) :</span>
                                    <div class="">
                                        @foreach ($reminder_dates as $reminder_date)
                                            <div>
                                                <span class="text-danger">{{ dateFr($reminder_date->date) }}</span>
                                                @if ($reminder_date->file)
                                                    <a href="{{ asset($reminder_date->file) }}" class="text-dark"
                                                        download>
                                                        <i class='bx bxs-download '></i>
                                                    </a>
                                            </div>
                                        @endif
                                    </div>
                            @endforeach
                        </div>
            @endif
</div>
</td>
<td>{{ dateFr($disbursement->date_refund) }}</td>
@if ($carbon::parse($disbursement->date_expiry)->lt($carbon::today()) && $disbursement->status === 'pending')
    <td class="{{ status('nopaid', 'css') }}">
        Impayé
    </td>
@else
    <td class="{{ status($disbursement->status, 'css') }}">
        {{ status($disbursement->status) }}
    </td>
@endif
@if (can('responsable-suivi-evaluation|chef-celulle-suivi-evaluation|partner-financial'))
    <td class="gap-5">
        @if ($disbursement->status === 'pending')
            <a class="deadline-status-link" title="renseigné date de remboursement" style="cursor: pointer;"
                data-action="{{ route('monitored-evaluation.disbursement_deadline.update', $disbursement->id) }}"
                data-disbursement-title="Validation du remboursement : {{ $disbursement->title }}">
                <i class="bx bxs-check-circle fs-4"></i>
            </a>
        @endif

        @if ($carbon::parse($disbursement->date_expiry)->lt($carbon::today()) && $disbursement->status === 'pending')
            <a class="deadline-reminder-link text-danger" title="renseigné un rappel impayé" style="cursor: pointer;"
                data-action="{{ route('monitored-evaluation.disbursement_deadline.reminder', $disbursement->id) }}"
                data-disbursement-reminder-title="Rélance impayé : {{ $disbursement->title }}">
                <i class="bx bxs-calendar-x fs-4"></i>
            </a>
        @endif
    </td>
@endif
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">Vide...</td>
</tr>
@endforelse
</tbody>
</table>
</div>


@if (can('responsable-suivi-evaluation|chef-celulle-suivi-evaluation|partner-financial'))
    <div class="modal fade" id="addDisbursementDeadlineModal" tabindex="-1"
        aria-labelledby="addDisbursementDeadlineModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDisbursementDeadlineModalLabel">Ajout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="disbursementDeadlineForm" enctype="multipart/form-data">
                        <input type="hidden" name="adherent" value="{{ $adherent->id }}">
                        <div class="mb-3">
                            <label for="date_expiry" class="form-label">Date d&apos;écheance<span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_expiry" name="date_expiry" required>
                        </div>
                        <div class="mb-3">
                            <label for="amount_deadline" class="form-label">Montant<span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="amount_deadline" name="amount_deadline"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deadlineStatusModal" tabindex="-1" aria-labelledby="deadlineStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deadlineStatusModalLabel">
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deadlineStatusForm">
                        <div class="mb-3">
                            <label for="date_refund" class="form-label">Date de remboursement
                                <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_refund" name="date_refund" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deadlineReminderModal" tabindex="-1" aria-labelledby="deadlineReminderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deadlineReminderModalLabel">
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deadlineReminderForm">
                        <div class="mb-3">
                            <label for="date_reminder" class="form-label">Date de rélance
                                <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_reminder" name="date_reminder"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="proof_file" class="form-label">Document justificatif</label>
                            <input type="file" class="form-control" id="proof_file" name="proof_file"
                                accept=".pdf">
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
        @if (can('responsable-suivi-evaluation|chef-celulle-suivi-evaluation|partner-financial'))

            $('#disbursementDeadlineForm').on('submit', function(e) {
                e.preventDefault();
                loading();

                const formData = new FormData(this);

                const actionUrl = "{{ route('monitored-evaluation.disbursement_deadline.store') }}";

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
                            $('#addDisbursementDeadlineModal').modal('hide');
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


            $('a.deadline-status-link').on('click', function() {
                const actionUrl = $(this).data('action');
                const disbursementTitle = $(this).data('disbursement-title');

                $('#deadlineStatusModalLabel').text(disbursementTitle);
                $('#deadlineStatusForm').data('action-url', actionUrl);

                $('#deadlineStatusModal').modal('show');
            });

            $('#deadlineStatusForm').on('submit', function(e) {
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
                            $('#deadlineStatusModal').modal('hide');
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

            $('a.deadline-reminder-link').on('click', function() {
                const actionUrl = $(this).data('action');
                const disbursementTitle = $(this).data('disbursement-reminder-title');

                $('#deadlineReminderModalLabel').text(disbursementTitle);
                $('#deadlineReminderForm').data('action-url', actionUrl);

                $('#deadlineReminderModal').modal('show');
            });

            $('#deadlineReminderForm').on('submit', function(e) {
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
                            $('#deadlineReminderModal').modal('hide');
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
    </script>
@endpush
