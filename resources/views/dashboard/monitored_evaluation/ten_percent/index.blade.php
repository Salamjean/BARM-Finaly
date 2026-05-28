@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Accueil/</span>{{ $title }}
                    </h4>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group">
                </div>
            </div>

        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Nom & Prénoms</th>
                                <th>Titre du projet</th>
                                <th>Adresse géographique</th>
                                <th>Montant solicité</th>
                                <th>Agence</th>
                                <th>Montant accordé</th>
                                <th>Mois différés</th>
                                <th>Durée du prêt</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidatures as $adhrent)
                                <tr>
                                    <td>
                                        <div>{{ $adhrent->user->fullName() }}</div>
                                        <div class="fs-7">
                                            <span class="text-primary">{{ $adhrent->user->mecano }}</span>,
                                            <span>{{ $adhrent->phone_number }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $adhrent->paAccepted->title }}</td>
                                    <td class="">
                                        {{ $adhrent->paAccepted->location }}
                                    </td>
                                    <td>{{ amount($adhrent->paAccepted->credit) }} F CFA
                                    <td class="">
                                        {{ $adhrent->creditCommittee->agency }}
                                    </td>
                                    <td>
                                        {{ amount($adhrent->creditCommittee->amount_agreed) }} F CFA
                                    </td>
                                    <td class="text-center">
                                        {{ $adhrent->creditCommittee->deferred_months }}
                                    </td>
                                    <td class="text-center">
                                        {{ $adhrent->creditCommittee->loan_duration }} mois
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-around gap-3">
                                            <a href="{{ route('adherent.show', $adhrent->user->id) }}" class="">
                                                <i class=" bx bx-show">
                                                </i>
                                            </a>

                                            <button class="btn btn-sm btn-secondary open-modal-btn"
                                                data-adherent-id="{{ $adhrent->id }}">
                                                Autorisé
                                            </button>

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

    <!-- Modal -->
    <div class="modal fade" id="addTenPercentModal" tabindex="-1" aria-labelledby="addTenPercentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTenPercentModalLabel">Versement des 10%</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addTenPercentForm" action="{{ route('monitored-evaluation.ten_percent.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="adherent_id" id="adherentIdInput">

                        <div class="mb-3">
                            <label for="TenPercentInput" class="form-label">Montant 10%</label>
                            <input type="number" class="form-control" id="TenPercentInput" name="amount" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('addTenPercentModal'));

                document.querySelectorAll('.open-modal-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const adherentId = this.getAttribute('data-adherent-id');
                        document.getElementById('adherentIdInput').value = adherentId;
                        modal.show();
                    });
                });
            });
        </script>
    @endpush
@endsection
