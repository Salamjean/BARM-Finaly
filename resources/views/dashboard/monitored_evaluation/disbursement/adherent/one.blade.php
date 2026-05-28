<div class=" mt-1">
    <div class="p-4">
        @if (count($adherent->selfEmploymentMonitoredPayment->disbursements) > 0)
            <h2 class="text-center mb-4">
                Formulaire de Décaissement
                <span class="fs-6 {{ status($adherent->selfEmploymentMonitoredPayment->status_disbursement, 'css') }}">
                    {{ status($adherent->selfEmploymentMonitoredPayment->status_disbursement) }}
                </span>
            </h2>
        @else
            <h2 class="text-center text-warning mb-4">
                En attente de la fiche de décaissement
            </h2>
        @endif
        <div class="cardd"></div>
        <form id="decaissementForm" class="row" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{ $adherent->id }}" />
            @if ($adherent->selfEmploymentMonitoredPayment->disbursement_form)
                <div class="d-flex justify-content-center">
                    <div
                        class="bg-white rounded-2 fs-4 d-flex justify-content-between gap-4 align-items-center p-2 px-2">
                        <div class="text-primary">Fiche de décaissement</div>
                        <div>
                            <a href="{{ asset($adherent->selfEmploymentMonitoredPayment->disbursement_form) }}"
                                download>
                                <i class='bx bx-cloud-download fs-2'></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if (can('partner-technical'))
                
                <div class="col-md-9">
                    <div class="form-group mb-2">
                        <label for="nombreDecaissement" class="form-label fw-bold">Nombre de décaissements
                            :</label>
                        <input type="number" id="nombreDecaissement" class="form-control form-control-lg"
                            min="1" required
                            value="{{ count($adherent->selfEmploymentMonitoredPayment->disbursements) }}"
                            placeholder="Indiquez le nombre de décaissements">
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="button" id="generateInputs"
                        class="btn btn-secondary btn-lg w-100 mt-4">Générer</button>
                </div>
            @endif

            @if (can('partner-technical'))
                <div id="decaissementInputs" class="row g-3">
                    @foreach ($adherent->selfEmploymentMonitoredPayment->disbursements as $key => $disbursement)
                        <div class="col-md-6">
                            <label for="nom_decaissement_{{ $key }}}" class="form-label">Nom du décaissement
                                {{ $key + 1 }} :</label>
                            <input type="text" id="nom_decaissement_{{ $key }}}" name="name[]"
                                class="form-control form-control-lg" placeholder="Nom du décaissement"
                                value="{{ $disbursement->title }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="montant_{{ $key }}}" class="form-label">Montant du décaissement
                                {{ $key + 1 }} :</label>
                            <input type="number" id="montant_{{ $key }}}" name="amount[]"
                                class="form-control form-control-lg" value="{{ $disbursement->amount_disbursement }}"
                                placeholder="Montant" required>
                        </div>
                    @endforeach
                </div>
            @else
                <div id="decaissementInputs" class="row g-3">
                    @foreach ($adherent->selfEmploymentMonitoredPayment->disbursements as $key => $disbursement)
                        <div class="col-md-6">
                            <label for="nom_decaissement_{{ $key }}}" class="form-label">Nom du décaissement
                                {{ $key + 1 }} :</label>
                            <input type="text" id="nom_decaissement_{{ $key }}}" name="name[]"
                                class="form-control form-control-lg" value="{{ $disbursement->title }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="montant_{{ $key }}}" class="form-label">Montant du décaissement
                                {{ $key + 1 }} :</label>
                            <input type="number" id="montant_{{ $key }}}" name="amount[]"
                                class="form-control form-control-lg" value="{{ $disbursement->amount_disbursement }}"
                                disabled>
                        </div>
                    @endforeach
                </div>
            @endif

            @if (can('partner-technical'))
                <input type="hidden" name="option" value="send_personal_barm" />
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">Valider les
                        décaissements</button>
                </div>
            @endif

            @if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation') &&
                    $adherent->selfEmploymentMonitoredPayment->status_disbursement == 'pending')
                <input type="hidden" name="option" value="send_validated_or_cancelled" />
                <div class="d-flex justify-content-end gap-3">
                    <div class="col-md-2">
                        <input type="submit" name="submit" value="Rejeter" class="btn btn-danger btn-lg w-100 mt-4" />
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary btn-lg w-100 mt-4" data-bs-toggle="modal"
                            data-bs-target="#fileModal">
                            Valider
                        </button>

                    </div>
                </div>

                <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="fileModalLabel">Autorisé la demande</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="mb-3">
                                    <input type="hidden" name="submit" value="approved"
                                        class="btn btn-primary btn-lg w-100 mt-4" />

                                    <div class="fs-4">
                                        Voulez vous vraiment approuver les modalités de decaisssement? 
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Valider</button>

                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </form>
    </div>
</div>

@push('css-push')
    <style>
        .card {
            border-radius: 15px;
            background-color: #f8f9fa;
        }

        .form-control-lg {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #4A90E2;
            border-color: #4A90E2;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #357ABD;
        }

        .form-label {
            font-weight: 500;
        }

        input::placeholder {
            font-style: italic;
            color: #adb5bd;
        }
    </style>
@endpush
@push('js-push')
    <script>
        const route_validated = "{{ route('monitored-evaluation.disbursement.store') }}"
        @if (can('partner-technical'))

            document.getElementById('generateInputs').addEventListener('click', function() {
                let nombre = document.getElementById('nombreDecaissement').value;
                let inputContainer = document.getElementById('decaissementInputs');
                inputContainer.innerHTML = '';

                for (let i = 0; i < nombre; i++) {
                    let html = `
                        <div class="col-md-6">
                            <label for="nom_decaissement_${i}" class="form-label">Nom du décaissement ${i+1} :</label>
                            <input type="text" id="nom_decaissement_${i}" name="name[]" class="form-control form-control-lg" placeholder="Nom du décaissement" required>
                        </div>
                        <div class="col-md-6">
                            <label for="montant_${i}" class="form-label">Montant du décaissement ${i+1} :</label>
                            <input type="number" id="montant_${i}" name="amount[]" class="form-control form-control-lg" placeholder="Montant" required>
                        </div>
                    `;
                    inputContainer.insertAdjacentHTML('beforeend', html);
                }
            });


            document.getElementById('decaissementForm').addEventListener('submit', function(e) {
                e.preventDefault();

                let montants = Array.from(document.querySelectorAll('input[name="amount[]"]')).map(input =>
                    parseFloat(input.value));
                let totalDecaissement = montants.reduce((total, montant) => total + montant, 0);
                let amount_awarded = {{ $adherent->creditCommittee->amount_agreed }};

                loading();

                if (totalDecaissement != amount_awarded) {
                    if (totalDecaissement > amount_awarded) {
                        showAlert('Le montant total des décaissements dépasse le montant accordé.', 'danger');
                    } else {
                        showAlert('Le montant total des décaissements doit être égal au montant accordé.',
                            'danger')
                    }
                    endLoading();
                    return;
                }

                let formData = new FormData(this);
                // let fileInput = document.getElementById('disbursement_file');
                // if (fileInput.files.length > 0) {
                //     formData.append('disbursement_file', fileInput.files[0]);
                // }
                fetch(route_validated, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.action) {

                            ToastSuccess.fire({
                                icon: 'success',
                                title: data.message,
                            });

                            setTimeout(function() {
                                location.reload();
                            }, 2000);

                        } else {

                            showAlert('Une erreur s\'est produite.', 'danger');
                        }
                    })
                    .catch(error => {

                        showAlert('Une erreur  s\'est produite.', 'danger');
                    });
                endLoading();

            });
        @endif

        @if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation') &&
                $adherent->selfEmploymentMonitoredPayment->status_disbursement == 'pending')
            document.getElementById('decaissementForm').addEventListener('submit', function(e) {
                e.preventDefault();
                loading();

                const submitValue = document.activeElement.value;

                let formData = new FormData(this);

                if (submitValue === "Rejeter")
                    formData.append('submit', 'cancelled');

                fetch(route_validated, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.action) {

                            ToastSuccess.fire({
                                icon: 'success',
                                title: data.message,
                            });

                            setTimeout(function() {
                                location.reload();
                            }, 2000);

                        } else {
                                                console.log(data);

                            showAlert(data.message ?? 'Une erreur s\'est produite.', 'danger');
                        }
                    })
                    .catch(error => {
                        showAlert('Une erreur  s\'est produite.', 'danger');
                    });
                endLoading();

            });
        @endif

        function showAlert(message, type) {
            let alertBox = document.createElement('div');
            alertBox.className = `alert alert-${type} fs-4 mt-3`;
            alertBox.innerText = message;
            document.querySelector('.cardd').prepend(alertBox);
            setTimeout(() => alertBox.remove(), 5000);
        }
    </script>
@endpush
