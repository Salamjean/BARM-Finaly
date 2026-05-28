@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Cohorte/ Collecte de données /</span> Liste en attente
                    </h4>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-start">#</th>
                                <th>Cohorte</th>
                                <th>Mecano / Matricule</th>
                                <th>Nom & Prénoms</th>
                                <th>Spécialisation</th>
                                <th class="text-center">Date début</th>
                                <th class="text-center">Date fin</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adherents as $adherent)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $adherent->cohort->reference }}</td>
                                    <td>{{ $adherent->user->mecano }}</td>
                                    <td>{{ $adherent->user->fullName() }}</td>
                                    <td>{{ $adherent->choiceFinal->specialisation }}</td>
                                    <td class="text-center">
                                        <span class="text-secondary fw-bold">
                                            {{ dateFr($adherent->dataCollect->beging_date) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary fw-bold">
                                            {{ $adherent->dataCollect->end_date ? dateFr($adherent->dataCollect->end_date) : '-' }}
                                        </span>
                                    </td>
                                    <td class="d-flex justify-content-evenly align-items-center">
                                        <a href="{{ route('adherent.show', $adherent->user->id) }}">
                                            <i class="bx bx-show me-2"></i>
                                        </a>

                                        <button type="button" class="btn btn-outline-secondary validate-btn"
                                            data-adherent-id="{{ $adherent->id }}"
                                            data-adherent-name="{{ $adherent->user->fullName() }}"
                                            data-end-date="{{ $adherent->dataCollect->end_date }}" data-bs-toggle="modal"
                                            data-bs-target="#dateModal">
                                            VALIDER
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateModalLabel">Date de fin de collecte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="dateForm">
                        <div class="mb-3">
                            <label for="endDate" class="form-label">Sélectionnez la date de fin de collecte :</label>
                            <input type="date" class="form-control" id="endDate" required>
                        </div>
                        <input type="hidden" id="adherentId" name="adherent_id">
                        <input type="hidden" id="adherentName" name="adherent_name">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="confirmDateBtn">Continuer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmation de validation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bx bx-warning me-2"></i>
                        <strong>Attention !</strong> Cette action est irréversible.
                    </div>
                    <p>Êtes-vous sûr de vouloir valider la collecte de données pour :</p>
                    <ul>
                        <li><strong>Adhérent :</strong> <span id="confirmAdherentName"></span></li>
                        <li><strong>Date de fin :</strong> <span id="confirmEndDate"></span></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success" id="finalValidateBtn">
                        <i class="bx bx-check me-1"></i>
                        Valider définitivement
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dateModal = new bootstrap.Modal(document.getElementById('dateModal'));
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));

                let currentAdherentId = null;
                let currentAdherentName = null;
                let currentEndDate = null;

                document.querySelectorAll('.validate-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        currentAdherentId = this.getAttribute('data-adherent-id');
                        currentAdherentName = this.getAttribute('data-adherent-name');
                        const existingEndDate = this.getAttribute('data-end-date');

                        document.getElementById('adherentId').value = currentAdherentId;
                        document.getElementById('adherentName').value = currentAdherentName;

                        const endDateInput = document.getElementById('endDate');
                        if (existingEndDate && existingEndDate !== '' && existingEndDate !== 'null') {
                            const date = new Date(existingEndDate);
                            const formattedDate = date.getFullYear() + '-' +
                                String(date.getMonth() + 1).padStart(2, '0') + '-' +
                                String(date.getDate()).padStart(2, '0');
                            endDateInput.value = formattedDate;
                        } else {
                            endDateInput.value = '';
                        }
                    });
                });

                document.getElementById('confirmDateBtn').addEventListener('click', function() {
                    const endDate = document.getElementById('endDate').value;

                    if (!endDate) {
                        alert('Veuillez sélectionner une date de fin.');
                        return;
                    }

                    currentEndDate = endDate;

                    dateModal.hide();

                    document.getElementById('confirmAdherentName').textContent = currentAdherentName;
                    document.getElementById('confirmEndDate').textContent = new Date(endDate)
                        .toLocaleDateString('fr-FR');

                    setTimeout(() => {
                        confirmModal.show();
                    }, 300);
                });

                document.getElementById('finalValidateBtn').addEventListener('click', function() {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('cohort.data_collect.validate') }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const adherentIdInput = document.createElement('input');
                    adherentIdInput.type = 'hidden';
                    adherentIdInput.name = 'adherent_id';
                    adherentIdInput.value = currentAdherentId;
                    form.appendChild(adherentIdInput);

                    const endDateInput = document.createElement('input');
                    endDateInput.type = 'hidden';
                    endDateInput.name = 'end_date';
                    endDateInput.value = currentEndDate;
                    form.appendChild(endDateInput);

                    document.body.appendChild(form);
                    form.submit();
                });

                document.getElementById('dateModal').addEventListener('hidden.bs.modal', function() {
                    if (!confirmModal._isShown) {
                        currentAdherentId = null;
                        currentAdherentName = null;
                        currentEndDate = null;
                    }
                });

                document.getElementById('confirmModal').addEventListener('hidden.bs.modal', function() {
                    currentAdherentId = null;
                    currentAdherentName = null;
                    currentEndDate = null;
                });
            });
        </script>
    @endpush
@endsection
