@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-warning border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-time text-warning fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Cohorte / Plan d'affaire</div>
                            <h4 class="mb-0 text-warning">{{ $title ?? 'Liste en attente' }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-time text-warning fs-3 me-3"></i>
                    <div>
                        <h4 class="mb-0 text-warning">Plans d'affaire en attente</h4>
                        <p class="text-muted mb-0">Candidats en attente de soumission de plan d'affaire</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $adherents->count() }}
                        </div>
                        <div class="small text-muted">Total en attente</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3 shadow-none">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-warning">
                                <th class="border-0">
                                    <i class="bx bx-hash text-warning me-1"></i>
                                    #
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-layer-group text-warning me-1"></i>
                                    Cohorte
                                </th>
                                @if (can('partner-financial'))
                                    <th class="border-0">
                                        <i class="bx bx-briefcase text-warning me-1"></i>
                                        Partenaire technique
                                    </th>
                                @endif
                                <th class="border-0">
                                    <i class="bx bx-user text-warning me-1"></i>
                                    Candidat
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-target-lock text-warning me-1"></i>
                                    Spécialisation
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-money text-warning me-1"></i>
                                    Financement
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-calendar text-warning me-1"></i>
                                    Période de collecte
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-warning me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adherents as $adherent)
                                <tr class="align-middle">
                                    <td>
                                        <div class="fw-bold text-dark">{{ $loop->index + 1 }}</div>
                                    </td>
                                    <td>
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="fw-bold text-info">{{ $adherent->cohort->reference }}</div>
                                        </div>
                                    </td>
                                    @if (can('partner-financial'))
                                        <td>
                                            <div class="border-start border-primary border-3 ps-2 py-1">
                                                <div class="d-flex align-items-center">
                                                    <span
                                                        class="badge bg-primary">{{ $adherent->partnerTechnical->user->username }}</span>
                                                </div>
                                                <small class="text-muted">Partenaire technique</small>
                                            </div>
                                        </td>
                                    @endif
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $adherent->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span
                                                        class="badge bg-secondary me-1">{{ $adherent->user->mecano }}</span>
                                                    <span>{{ $adherent->phone_number ?? '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-warning border-3 ps-2 py-1">
                                            <div class="fw-medium text-warning">{{ $adherent->choiceFinal->specialisation }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-success border-3 ps-2 py-1">
                                            <div class="fw-medium text-success">
                                                {{ $adherent->partner_financial_id ? $adherent->partnerFinancial->user->username : $adherent->other_partner_financial }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-calendar text-info me-2"></i>
                                            <div>
                                                <div class="fw-medium">{{ dateFr($adherent->dataCollect->beging_date) }}
                                                </div>
                                                <div class="small text-muted">au
                                                    {{ dateFr($adherent->dataCollect->end_date) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-flex justify-content-evenly align-items-center">
                                        <a href="{{ route('adherent.show', $adherent->user->id) }}">
                                            <i class=" bx bx-show me-2"></i>
                                        </a>
                                        @if (can('partner-technical'))
                                            <button data-toggle="modal" data-target="#edit-adherent"
                                                class="addBtn btn btn-secondary" data-counter="{{ $adherent }}"
                                                data-action="{{ route('cohort.pa.store', $adherent->id) }}">
                                                Ajout du PA
                                                <i class="bx bx-upload ms-2"></i></button>

                                            <div id="addModal{{ $adherent->id }}" class="modal fade" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Insertion du Plan d'affaire</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-3">
                                                                        <label for="title" class="form-label">Titre
                                                                            du
                                                                            plan d'affaire<span class="text-danger">*</span>
                                                                            :
                                                                        </label>
                                                                        <input type="text"
                                                                            class="form-control @error('title') is-invalid @enderror"
                                                                            id="title" name="title"
                                                                            value="{{ $adherent->choiceFinal->specialisation ?? old('title') }}"
                                                                            required>
                                                                        @error('title')
                                                                            <span class="invalid-feedback" besoin="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="amount" class="form-label">Coût
                                                                            du
                                                                            projet (Fcfa)<span class="text-danger">*</span>
                                                                            :
                                                                        </label>
                                                                        <input type="text"
                                                                            class="form-control @error('amount') is-invalid @enderror"
                                                                            id="amount" name="amount"
                                                                            value="{{ old('amount') }}" required>
                                                                        @error('amount')
                                                                            <span class="invalid-feedback" besoin="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="credit" class="form-label">Crédit
                                                                            solicilité (Fcfa)<span
                                                                                class="text-danger">*</span> :
                                                                        </label>
                                                                        <input type="text"
                                                                            class="form-control @error('credit') is-invalid @enderror"
                                                                            id="credit" name="credit"
                                                                            value="{{ old('credit') }}" required>
                                                                        @error('credit')
                                                                            <span class="invalid-feedback" besoin="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-12 mb-3">
                                                                        <label for="location" class="form-label">Lieu
                                                                            de
                                                                            réalisation du projet<span
                                                                                class="text-danger">*</span> :
                                                                        </label>
                                                                        <input type="text"
                                                                            class="form-control @error('location') is-invalid @enderror"
                                                                            id="location" name="location"
                                                                            value="{{ $adherent->choiceFinal->adress_geo ?? old('location') }}"
                                                                            required>
                                                                        @error('location')
                                                                            <span class="invalid-feedback" besoin="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="form-label">Partenaire financier
                                                                            :
                                                                        </label>
                                                                        <select
                                                                            class="form-control @error('partner_id') is-invalid @enderror"
                                                                            aria-label="Default select example"
                                                                            name="partner_financial"
                                                                            id="partner_financial_id_{{ $adherent->id }}"
                                                                            required>

                                                                            @foreach ($partner_financials as $partner_financial)
                                                                                <option
                                                                                    value="{{ $partner_financial->id }}"
                                                                                    {{ $adherent->partner_financial_id == $partner_financial->id ? 'selected' : '' }}>
                                                                                    {{ $partner_financial->user->username }}
                                                                                </option>
                                                                            @endforeach

                                                                            <option value="other"
                                                                                {{ $adherent->other_partner_financial ? 'selected' : '' }}>
                                                                                Autre</option>
                                                                        </select>
                                                                        @error('partner_financial_id')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-12 mb-3"
                                                                        id="other_partner_div_{{ $adherent->id }}"
                                                                        style="display:{{ $adherent->other_partner_financial ? 'block' : 'none' }};">
                                                                        <label class="form-label">Precisez : </label>
                                                                        <input type="text" class="form-control"
                                                                            name="other_partner_financial"
                                                                            value="{{ $adherent->other_partner_financial ?? '' }}" />
                                                                    </div>
                                                                    <div class="col-md-12 mb-3">
                                                                        <label for="url" class="form-label">Plan
                                                                            d'affaire<span class="text-danger">*</span>
                                                                            :
                                                                        </label>
                                                                        <input type="file"
                                                                            class="form-control @error('url') is-invalid @enderror"
                                                                            id="url" name="url"
                                                                            value="{{ old('url') }}" accept=".pdf"
                                                                            required>
                                                                        @error('url')
                                                                            <span class="invalid-feedback" besoin="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Enregistrer</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif (can('partner-financial'))
                                            @php($count = $adherent->pas->count())
                                            <a href="{{ asset($adherent->pas[$count - 1]->url) }}" download>
                                                <i class='bx bx-cloud-download fs-2'></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    
    </div>

    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
        <style>
            .table-hover tbody tr:hover {
                background-color: rgba(255, 193, 7, 0.05) !important;
            }

            .border-start.border-warning {
                border-left-color: #ffc107 !important;
            }

            .border-start.border-info {
                border-left-color: #0dcaf0 !important;
            }

            .border-start.border-primary {
                border-left-color: #0d6efd !important;
            }

            .border-start.border-success {
                border-left-color: #198754 !important;
            }
        </style>
    @endpush

    @push('js-push')
        <script>
            @if (can('partner-technical'))

                (function($) {
                    "use strict";
                    $('.addBtn').on('click', function() {
                        var modal = $('#addModal' + $(this).data('counter').id);
                        var adherent = $(this).data('adherent');
                        modal.find('form').attr('action', $(this).data('action'));
                        modal.modal('show');
                    });
                })(jQuery);
            @endif
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @foreach ($adherents as $adherentc)
                    (function(adherentId) {
                        var partnerSelect = document.getElementById('partner_financial_id_' + adherentId);
                        var otherPartnerDiv = document.getElementById('other_partner_div_' + adherentId);

                        partnerSelect.addEventListener('change', function() {
                            if (this.value === 'other') {
                                otherPartnerDiv.style.display = 'block';
                            } else {
                                otherPartnerDiv.style.display = 'none';
                            }
                        });

                        if (partnerSelect.value === 'other') {
                            otherPartnerDiv.style.display = 'block';
                        } else {
                            otherPartnerDiv.style.display = 'none';
                        }
                    })({{ $adherentc->id }});
                @endforeach
            });
        </script>
    @endpush
@endsection
