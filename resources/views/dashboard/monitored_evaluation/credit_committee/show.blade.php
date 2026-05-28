@extends('layouts.app')
@section('content')
                    <style>
                    .custom-breadcrumb {
                        background: #f8f9fa;
                        border-radius: 0.5rem;
                        padding: 0.75rem 1.5rem;
                        font-size: 1.08rem;
                        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
                    }
                    .custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
                        content: '\203A'; /* chevron » */
                        color: #6c757d;
                        font-weight: bold;
                        margin: 0 0.5rem;
                    }
                    .custom-breadcrumb .breadcrumb-item a {
                        color: #0d6efd;
                        text-decoration: none;
                        transition: color 0.2s;
                    }
                    .custom-breadcrumb .breadcrumb-item a:hover {
                        color: #084298;
                        text-decoration: underline;
                    }
                    .custom-breadcrumb .breadcrumb-item.active {
                        color: #495057;
                        font-weight: 600;
                    }
                </style>
    <div class="container-fluid">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb custom-breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('monitored-evaluation.credit_committee.index') }}">Suivi-Evaluation</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('monitored-evaluation.credit_committee.index') }}">PV Comité</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $pv->reference }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="mb-10">
            <div class="card-body">
                <!-- Nav -->
                <div class="text-center">
                    <ul id="myTab" class="nav nav-segment nav-pills scrollbar-horizontal mb-2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-one-code-features-example1-tab" data-bs-toggle="pill"
                                href="#pills-one-code-features-example1" role="tab"
                                aria-controls="pills-one-code-features-example1" aria-selected="true">
                                En attente <span
                                    class="text-info px-2">{{ count($pv->creditCommittees->where('status', 'pending')) }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-two-code-features-example1-tab" data-bs-toggle="pill"
                                href="#pills-two-code-features-example1" role="tab"
                                aria-controls="pills-two-code-features-example1" aria-selected="false">
                                Approuvé <span
                                    class="text-info px-2">{{ count($pv->creditCommittees->where('status', 'finished')) }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-three-code-features-example1-tab" data-bs-toggle="pill"
                                href="#pills-three-code-features-example1" role="tab"
                                aria-controls="pills-three-code-features-example1" aria-selected="false">
                                Ajournés <span
                                    class="text-warning px-2">{{ count($pv->creditCommittees->where('status', 'ajourne')) }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Tab Content -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-one-code-features-example1" role="tabpanel"
                        aria-labelledby="pills-one-code-features-example1-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-datatable table-responsive text-nowrap">
                                    <table class="dt-responsive table table-striped" id="datatable--barm"
                                        style="width:100%">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Nom & Prénoms</th>
                                                <th>Titre du projet</th>
                                                <th>Partenaire technique</th>
                                                <th>Localisation</th>
                                                <th>Montant solicité</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pv->creditCommittees->where('status', 'pending') as $committee)
                                                <tr>
                                                    <td>
                                                        <div>{{ $committee->candidature->user->fullName() }}</div>
                                                        <div class="fs-7">
                                                            <span
                                                                class="text-primary">{{ $committee->candidature->user->mecano }}</span>,
                                                            <span>{{ $committee->candidature->phone_number }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $committee->candidature->paAccepted->title }}
                                                    </td>
                                                    <td>{{ $committee->candidature->choiceFinal->specialisation }}</td>
                                                    <td class="">
                                                        {{ $committee->candidature->choiceFinal->locality }}
                                                    </td>
                                                    <td>{{ amount($committee->candidature->paAccepted->credit) }} F CFA
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-around gap-3">
                                                            <a href="{{ route('adherent.show', $committee->candidature->user->id) }}"
                                                                class="">
                                                                <i class=" bx bx-show">
                                                                </i>
                                                            </a>

                                                            @if(can('partner-financial'))
                                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#validationModal"
                                                                data-amount="{{ $committee->candidature->paAccepted->credit }}"
                                                                data-fullname="{{ $committee->candidature->user->fullName() }}"
                                                                data-id="{{ $committee->id }}">Validation</button>

                                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                                data-bs-target="#ajournerModal"
                                                                data-id="{{ $committee->id }}">
                                                                <i class="bx bx-time-five"></i> Ajourner
                                                            </button>
                                                            @endif
        <!-- Modal Ajourner -->
        <div class="modal fade" id="ajournerModal" tabindex="-1" aria-labelledby="ajournerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ajournerModalLabel">Motif d'ajournement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="ajournerForm" method="POST" action="{{ route('monitored-evaluation.credit_committee.ajourner') }}">
                        @csrf
                        <input type="hidden" name="committee_id" id="ajournerCommitteeId">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="motif" class="form-label">Motif</label>
                                <textarea class="form-control" id="motif" name="motif" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-danger">Confirmer l'ajournement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ajournerModal = document.getElementById('ajournerModal');
        if (ajournerModal) {
            ajournerModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var committeeId = button.getAttribute('data-id');
                var inputCommitteeId = document.getElementById('ajournerCommitteeId');
                
                console.log('Committee ID:', committeeId); // Debug
                
                if (inputCommitteeId && committeeId) {
                    inputCommitteeId.value = committeeId;
                } else {
                    console.error('Erreur: ID du comité non trouvé');
                }
            });
        }
    });
</script>
@endpush

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-two-code-features-example1" role="tabpanel"
                        aria-labelledby="pills-two-code-features-example1-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-datatable table-responsive text-nowrap">
                                    <table class="dt-responsive table table-striped" id="datatable--barm2"
                                        style="width:100%">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Nom & Prénoms</th>
                                                <th>Titre du projet</th>
                                                <th>Partenaire technique</th>
                                                <th>Localisation</th>
                                                <th>Montant solicité</th>
                                                <th>Agence</th>
                                                <th>Montant accordé</th>
                                                <th>Mois différés</th>
                                                <th>Durée du prêt</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pv->creditCommittees->where('status', 'finished') as $committee)
                                                <tr>
                                                    <td>
                                                        <div>{{ $committee->candidature->user->fullName() }}</div>
                                                        <div class="fs-7">
                                                            <span
                                                                class="text-primary">{{ $committee->candidature->user->mecano }}</span>,
                                                            <span>{{ $committee->candidature->phone_number }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $committee->candidature->choiceFinal->specialisation }}</td>
                                                    <td>{{ $committee->candidature->partnerTechnical->user->username }}
                                                    </td>
                                                    <td class="">
                                                        {{ $committee->candidature->choiceFinal->locality }}
                                                    </td>
                                                    <td>{{ amount($committee->candidature->paAccepted->credit) }} F CFA
                                                    <td class="">
                                                        {{ $committee->agency }}
                                                    </td>
                                                    <td>
                                                        {{ amount($committee->amount_agreed) }} F CFA
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $committee->deferred_months }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $committee->loan_duration }} mois
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-around gap-3">
                                                            <a href="{{ route('adherent.show', $committee->candidature->user->id) }}"
                                                                class="">
                                                                <i class=" bx bx-show">
                                                                </i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Onglet Ajournés -->
                    <div class="tab-pane fade" id="pills-three-code-features-example1" role="tabpanel"
                        aria-labelledby="pills-three-code-features-example1-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-datatable table-responsive text-nowrap">
                                    <table class="dt-responsive table table-striped" id="datatable--barm3"
                                        style="width:100%">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Nom & Prénoms</th>
                                                <th>Titre du projet</th>
                                                <th>Partenaire technique</th>
                                                <th>Localisation</th>
                                                <th>Montant sollicité</th>
                                                <th>Motif d'ajournement</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pv->creditCommittees->where('status', 'ajourne') as $committee)
                                                <tr>
                                                    <td>
                                                        <div>{{ $committee->candidature->user->fullName() }}</div>
                                                        <div class="fs-7">
                                                            <span
                                                                class="text-primary">{{ $committee->candidature->user->mecano }}</span>,
                                                            <span>{{ $committee->candidature->phone_number }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $committee->candidature->choiceFinal->specialisation }}</td>
                                                    <td>{{ $committee->candidature->partnerTechnical->user->username }}
                                                    </td>
                                                    <td class="">
                                                        {{ $committee->candidature->choiceFinal->locality }}
                                                    </td>
                                                    <td>{{ amount($committee->candidature->paAccepted->credit) }} F CFA</td>
                                                    <td>
                                                        <span class="badge bg-warning text-dark">
                                                            {{ $committee->motif_ajournement ?? 'Motif non spécifié' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-around gap-2">
                                                            <a href="{{ route('adherent.show', $committee->candidature->user->id) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="bx bx-show"></i> Voir
                                                            </a>
                                                            @if(can('partner-financial'))
                                                            <!-- Bouton pour remettre en attente -->
                                                            <button class="btn btn-sm btn-success" 
                                                                onclick="remettre_en_attente({{ $committee->id }})">
                                                                <i class="bx bx-undo"></i> Remettre en attente
                                                            </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="validationModalLabel">Valider la demande</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="validationForm" method="POST"
                                    action="{{ route('monitored-evaluation.credit_committee.validation') }}">
                                    @csrf
                                    <input type="hidden" name="committee_id" id="committeeId">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="fullname" class="form-label">Nom & Prénoms</label>
                                            <input type="text" class="form-control" id="fullname" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="amountt" class="form-label">Montant souhaité</label>
                                            <input type="text" class="form-control" id="amountt" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Montant accordé</label>
                                            <input type="number" class="form-control" id="amount" name="amount"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="agency" class="form-label">Agence de retrait des fonds</label>
                                            <input type="text" class="form-control" id="agency" name="agency"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deferred_months" class="form-label">Mois différé</label>
                                            <input type="text" class="form-control" id="deferred_months"
                                                name="deferred_months" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="loan_duration" class="form-label">Durée du prêt (par mois)</label>
                                            <input type="text" class="form-control" id="loan_duration"
                                                name="loan_duration" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="pension" class="form-label">Pension</label>
                                            <select class="form-select" id="pension" name="pension" required>
                                                <option value="" disabled>Sélectionnez </option>
                                                <option value="oui">Oui</option>
                                                <option value="non" selected>Non</option>
                                            </select>

                                        </div>

                                        <div class="mb-3">
                                            <label for="pension_partner_financial" class="form-label">Pension domiciliée au FIDRA</label>
                                            <select class="form-select" id="pension_partner_financial" name="pension_partner_financial" required>
                                                <option value="" disabled>Sélectionnez </option>
                                                <option value="oui">Oui</option>
                                                <option value="non" selected>Non</option>
                                            </select>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Valider</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ajourner -->
    <div class="modal fade" id="ajournerModal" tabindex="-1" aria-labelledby="ajournerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajournerModalLabel">Motif d'ajournement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="ajournerForm" method="POST" action="{{ route('monitored-evaluation.credit_committee.ajourner') }}">
                    @csrf
                    <input type="hidden" name="committee_id" id="ajournerCommitteeId">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="motif" class="form-label">Motif</label>
                            <textarea class="form-control" id="motif" name="motif" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Confirmer l'ajournement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            // Modal de validation existant
            $('#validationModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var committeeId = button.data('id');
                var amount = button.data('amount');
                var fullname = button.data('fullname');
                $('#amountt').val(amount + ' ' + 'FCFA');
                $('#committeeId').val(committeeId);
                $('#fullname').val(fullname);
            });

            // Modal d'ajournement avec jQuery pour cohérence
            $('#ajournerModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var committeeId = button.data('id');
                console.log('Committee ID reçu:', committeeId);
                $('#ajournerCommitteeId').val(committeeId);
            });
        </script>

        <script>
            // Fonction pour remettre en attente un candidat ajourné
            function remettre_en_attente(committeeId) {
                if (confirm('Êtes-vous sûr de vouloir remettre ce candidat en attente ?')) {
                    // Créer un formulaire temporaire pour envoyer la requête POST
                    var form = $('<form method="POST" action="{{ route("monitored-evaluation.credit_committee.remettre_en_attente") }}">' +
                        '@csrf' +
                        '<input type="hidden" name="committee_id" value="' + committeeId + '">' +
                        '</form>');
                    $('body').append(form);
                    form.submit();
                }
            }
        </script>
    @endpush
@endsection
