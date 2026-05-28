@if (count($user->candidate->participations) > 0)
    <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="ex-with-icons-tab-2">
        <div class="container-fluid bg-white p-4">

            @if ($user->candidate->pas)
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                        <i class="bx bx-briefcase text-primary fs-4 me-3"></i>
                        <h4 class="mb-0 text-primary">Plans d'Affaires</h4>
                    </div>

                    <div class="row g-4">
                        @foreach ($user->candidate->pas as $key => $pa)
                            <div class="col-lg-6">
                                <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">PA
                                            {{ $key + 1 }}</span>
                                        <a href="{{ asset($pa->url) }}" class="btn btn-primary btn-sm" download>
                                            <i class="bx bx-download me-1"></i> Télécharger
                                        </a>
                                    </div>

                                    <h5 class="mb-2 text-dark">{{ $pa->title }}</h5>
                                    <h6 class="mb-4 text-dark text-italic">{{ $pa->location }}</h6>
                                    <h6 class="mb-2 text-dark text-italic"><span class="text-warning">Point focal: </span>{{ $user->candidate->focal_point_area }}</h6>

                                    <div class="table-responsive mb-3">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                                <tr class="border-bottom">
                                                    <td class="text-muted">Coût du projet</td>
                                                    <td class="text-end"><strong>{{ amount($pa->amount) }} FCFA</strong>
                                                    </td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <td class="text-muted">Crédit sollicité</td>
                                                    <td class="text-end"><strong class="text-info">{{ amount($pa->credit) }} FCFA</strong>
                                                    </td>
                                                </tr>
                                                @if ($pa->amount_awarded != 0)
                                                    <tr class="border-bottom">
                                                        <td class="text-muted">Crédit accordé</td>
                                                        <td class="text-end"><strong
                                                                class="text-success">{{ amount($pa->amount_awarded) }}
                                                                FCFA</strong></td>
                                                    </tr>
                                                @endif
                                                <tr class="border-bottom">
                                                    <td class="text-muted">Date de transmission</td>
                                                    <td class="text-end">{{ dateFr($pa->created_at) }}</td>
                                                </tr>
                                                @if ($pa->commission)
                                                    <tr class="border-bottom">
                                                        <td class="text-muted">Session N°</td>
                                                        <td class="text-end"><span
                                                                class="badge bg-secondary">{{ $pa->commission->number }}</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr class="border-bottom">
                                                    <td class="text-muted">Statut</td>
                                                    <td class="text-end">
                                                        <span @php echo statusCandidature($pa->status, 'css') @endphp>
                                                            {{ statusCandidature($pa->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @if ($pa->sentence_by)
                                                    <tr class="border-bottom">
                                                        <td class="text-muted">{{ statusCandidature($pa->status) }} par
                                                        </td>
                                                        <td class="text-end">
                                                            <span>
                                                                {{ $pa->sentenceBy->fullName() }} le
                                                                {{ dateFr($pa->sentence_at) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($pa->sentence_reason)
                                                    <tr class="border-bottom">
                                                        <td class="text-muted">Raison</td>
                                                        <td class="text-end">{{ $pa->sentence_reason }}</td>
                                                    </tr>

                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($user->candidate->dataCollect)
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                        <i class="bx bx-data text-info fs-4 me-3"></i>
                        <h4 class="mb-0 text-info">Collecte de Données</h4>
                    </div>

                    <div class="row g-3 ">
                        <div class="col-md-6">
                            <div class="border-start bg-light bg-opacity-50 border-success border-3 ps-3 py-2">
                                <div class="text-muted small mb-1">Date de Début</div>
                                <h6 class="mb-0">{{ dateFr($user->candidate->dataCollect->beging_date) }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-start bg-light bg-opacity-50 border-danger border-3 ps-3 py-2">
                                <div class="text-muted small mb-1">Date de Fin</div>
                                <h6 class="mb-0">{{ dateFr($user->candidate->dataCollect->end_date) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($user->candidate->participations)
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                        <i class="bx bx-graduation text-success fs-4 me-3"></i>
                        <h4 class="mb-0 text-success">Formations <span
                                class="badge bg-secondary ms-2">{{ count($user->candidate->participations) }}</span>
                        </h4>
                    </div>

                    <div class="row g-3">
                        @foreach ($user->candidate->participations as $key => $participation)
                            <div class="col-12">
                                <div
                                    class="border-start {{ $participation->participation ? 'border-success' : 'border-danger' }} border-3 ps-4 py-3 mb-3 bg-light bg-opacity-25">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="bx {{ $participation->participation ? 'bx-check-circle text-success' : 'bx-x-circle text-danger' }} fs-5 me-2"></i>
                                            <h5 class="mb-0">{{ $participation->training->title }}</h5>
                                        </div>
                                        <span
                                            class="badge {{ $participation->participation ? 'bg-success' : 'bg-danger' }}">
                                            {{ $participation->participation ? 'Présent' : 'Absent' }}
                                        </span>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="small text-muted mb-1">Description</div>
                                            <p class="mb-0">
                                                {{ $participation->training->description ?? 'Non spécifiée' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="small text-muted mb-1">Période de formation</div>
                                            <div>
                                                <div><strong>Du:</strong>
                                                    {{ dateFr($participation->training->beging_date) }}</div>
                                                <div><strong>Au:</strong>
                                                    {{ dateFr($participation->training->end_date) }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            @if ($participation->training->observation)
                                                <div class="small text-muted mb-1">Observation</div>
                                                <div class="text-info">{{ $participation->training->observation }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($user->candidate->favorable_opinion && $user->candidate->selfEmploymentMonitoredPayment)
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                        <i class="bx bx-file-blank text-warning fs-4 me-3"></i>
                        <h4 class="mb-0 text-warning">Autorisation d'ouverture de compte</h4>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="border-start border-primary border-3 ps-3 py-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted small mb-1">Document d'autorisation</div>
                                        <h6 class="mb-0">Fiche favorable</h6>
                                    </div>
                                    <a href="{{ asset($user->candidate->selfEmploymentMonitoredPayment->file) }}"
                                        class="btn btn-primary btn-sm" download>
                                        <i class="bx bx-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-start border-success border-3 ps-3 py-2">
                                <div class="text-muted small mb-1">Date d'ouverture</div>
                                <h6 class="mb-0 text-success">
                                    {{ dateFr($user->candidate->selfEmploymentMonitoredPayment->created_at) }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif

@if (
    $user->candidate->selfEmploymentMonitoredPayment &&
        count($user->candidate->selfEmploymentMonitoredPayment->disbursements) > 0)
    <div class="tab-pane fade" id="ex-with-icons-tabs-3" role="tabpanel" aria-labelledby="ex-with-icons-tab-3">
        <div class="container-fluid p-4">
            <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                <i class="bx bx-money text-primary fs-4 me-3"></i>
                <h4 class="mb-0 text-primary">Décaissements</h4>
            </div>

            @include('partials.adherent.disbursement_show', [
                'adherent' => $user->candidate,
                'show_adherent' => true,
            ])
        </div>
    </div>
@endif
