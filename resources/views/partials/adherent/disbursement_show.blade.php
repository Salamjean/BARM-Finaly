<div class="container-fluid bg-white p-4">


    @if (count($adherent->selfEmploymentMonitoredPayment->disbursements) > 0)
        <div class="row g-4">
            @foreach ($adherent->selfEmploymentMonitoredPayment->disbursements as $index => $disbursement)
                <div class="col-12">
                    <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary fs-6 px-3 py-2 me-3">
                                    Décaissement #{{ $index + 1 }}
                                </span>
                                <div>
                                    <h5 class="mb-0 text-dark">{{ $disbursement->title }}</h5>
                                    <div class="text-muted small">Projet de décaissement</div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="h4 mb-0 text-success">{{ amount($disbursement->amount_disbursement) }}</div>
                                <div class="text-muted small">{{ DEVICE }}</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center">
                                <div class="text-muted small me-2">Statut :</div>
                                <span class="badge {{ status($disbursement->status, 'css') }}">
                                    {{ status($disbursement->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="row g-3">
                            @if (!can('partner-financial'))
                                <div class="col-md-4">
                                    <div class="border-start border-info border-3 ps-3 py-2 bg-white bg-opacity-75">
                                        <div class="text-muted small mb-1">Date de soumission</div>
                                        <div class="fw-medium">
                                            @if ($disbursement->date_hour_submission_document)
                                                {{ dateFr($disbursement->date_hour_submission_document) }}
                                            @else
                                                <span class="text-muted">Non définie</span>
                                            @endif
                                        </div>
                                        <div class="mt-2">
                                            @if ($disbursement->document_file)
                                                <a href="{{ asset($disbursement->document_file) }}"
                                                    class="btn btn-info btn-sm" download
                                                    title="Télécharger le formulaire">
                                                    F. non signée
                                                </a>
                                            @else
                                                <span class="text-muted small">Aucun formulaire</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-4">
                                <div class="border-start border-warning border-3 ps-3 py-2 bg-white bg-opacity-75">
                                    <div class="text-muted small mb-1">Date d'autorisation</div>
                                    <div class="fw-medium">
                                        @if ($disbursement->authorization_date)
                                            {{ dateFr($disbursement->authorization_date) }}
                                        @else
                                            <span class="text-muted">En attente</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        @if ($disbursement->authorization_file)
                                            <a href="{{ asset($disbursement->authorization_file) }}"
                                                class="btn btn-warning btn-sm" download
                                                title="Télécharger l'autorisation">
                                                F. signée
                                            </a>
                                        @else
                                            <span class="text-muted small">Pas d'autorisation</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border-start border-success border-3 ps-3 py-2 bg-white bg-opacity-75">
                                    <div class="text-muted small mb-1">Date de décaissement</div>
                                    <div class="fw-medium">
                                        @if ($disbursement->date_disbursement)
                                            {{ dateFr($disbursement->date_disbursement) }}
                                        @else
                                            <span class="text-muted">Non effectué</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if (!can('partner-financial'))
                                <div class="col-md-4">
                                    <div
                                        class="border-start border-secondary border-3 ps-3 py-2 bg-white bg-opacity-75">
                                        <div class="text-muted small mb-1">Date du rapport</div>
                                        <div class="fw-medium">
                                            @if ($disbursement->report_date)
                                                {{ dateFr($disbursement->report_date) }}
                                            @else
                                                <span class="text-muted">Pas de rapport</span>
                                            @endif
                                        </div>
                                        <div class="mt-2">
                                            @if ($disbursement->report_file)
                                                <a href="{{ asset($disbursement->report_file) }}"
                                                    class="btn btn-secondary btn-sm" download
                                                    title="Télécharger le rapport">
                                                    Rapport
                                                </a>
                                            @else
                                                <span class="text-muted small">Aucun rapport</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <div class="border-start border-secondary border-3 ps-3 py-2 bg-white bg-opacity-75">
                                    <div class="text-muted small mb-1">Date de joint du rapport signé</div>
                                    <div class="fw-medium">
                                        @if ($disbursement->report_signed_date)
                                            {{ dateFr($disbursement->report_signed_date) }}
                                        @else
                                            <span class="text-muted">Pas de rapport</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        @if ($disbursement->report_signed_file)
                                            <a href="{{ asset($disbursement->report_signed_file) }}"
                                                class="btn btn-secondary btn-sm" download
                                                title="Télécharger le rapport">
                                                Rapport
                                            </a>
                                        @else
                                            <span class="text-muted small">Aucun rapport signé</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border-start border-primary border-3 ps-3 py-2 bg-white bg-opacity-75">
                                    <div class="text-muted small mb-1">Référence</div>
                                    <div class="fw-medium text-primary">
                                        DECAISS-{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-muted small mt-1">Identifiant unique</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <div class="text-muted small mb-2">Progression du décaissement</div>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center me-4">
                                    <div class="rounded-circle {{ $disbursement->date_hour_submission_document ? 'bg-info' : 'bg-light border' }} 
                                                d-flex align-items-center justify-content-center me-2"
                                        style="width: 24px; height: 24px;">
                                        <i class="bx bx-file {{ $disbursement->date_hour_submission_document ? 'text-white' : 'text-muted' }}"
                                            style="font-size: 12px;"></i>
                                    </div>
                                    <span
                                        class="small {{ $disbursement->date_hour_submission_document ? 'text-info' : 'text-muted' }}">Soumission</span>
                                </div>

                                <div class="d-flex align-items-center me-4">
                                    <div class="rounded-circle {{ $disbursement->authorization_date ? 'bg-warning' : 'bg-light border' }} 
                                                d-flex align-items-center justify-content-center me-2"
                                        style="width: 24px; height: 24px;">
                                        <i class="bx bx-check {{ $disbursement->authorization_date ? 'text-white' : 'text-muted' }}"
                                            style="font-size: 12px;"></i>
                                    </div>
                                    <span
                                        class="small {{ $disbursement->authorization_date ? 'text-warning' : 'text-muted' }}">Autorisation</span>
                                </div>

                                <div class="d-flex align-items-center me-4">
                                    <div class="rounded-circle {{ $disbursement->date_disbursement ? 'bg-success' : 'bg-light border' }} 
                                                d-flex align-items-center justify-content-center me-2"
                                        style="width: 24px; height: 24px;">
                                        <i class="bx bx-money {{ $disbursement->date_disbursement ? 'text-white' : 'text-muted' }}"
                                            style="font-size: 12px;"></i>
                                    </div>
                                    <span
                                        class="small {{ $disbursement->date_disbursement ? 'text-success' : 'text-muted' }}">Décaissement</span>
                                </div>

                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle {{ $disbursement->report_signed_date ? 'bg-secondary' : 'bg-light border' }} 
                                                d-flex align-items-center justify-content-center me-2"
                                        style="width: 24px; height: 24px;">
                                        <i class="bx bx-chart-line {{ $disbursement->report_signed_date ? 'text-white' : 'text-muted' }}"
                                            style="font-size: 12px;"></i>
                                    </div>
                                    <span
                                        class="small {{ $disbursement->report_signed_date ? 'text-secondary' : 'text-muted' }}">Rapport</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="bx bx-wallet text-muted" style="font-size: 4rem;"></i>
            </div>
            <h5 class="text-muted mb-2">Aucun décaissement disponible</h5>
            <p class="text-muted small">Les décaissements apparaîtront ici une fois qu'ils seront traités par
                l'administration.</p>
        </div>
    @endif
</div>
