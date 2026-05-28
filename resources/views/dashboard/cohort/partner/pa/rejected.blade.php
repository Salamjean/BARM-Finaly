@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Cohorte/ Plan d&apos;affaire /</span> Différés
                    </h4>
                </nav>
            </div>

        </div>
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-x-circle text-danger fs-3 me-3"></i>
                    <div>
                        <h4 class="mb-0 text-danger">Plans d'affaire rejetés</h4>
                        <p class="text-muted mb-0">Gestion des plans d'affaire refusés</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-danger fs-6 px-3 py-2">
                            {{ $adherents->count() }}
                        </div>
                        <div class="small text-muted">Total rejetés</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3 shadow-none">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-danger">
                                <th class="border-0">
                                    <i class="bx bx-hash text-danger me-1"></i>
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-layer-group text-danger me-1"></i>
                                    Cohorte
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-danger me-1"></i>
                                    Candidat
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-file-blank text-danger me-1"></i>
                                    Dernier Plan d'Affaire
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-message-square-detail text-danger me-1"></i>
                                    Raison du Rejet
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-gavel text-danger me-1"></i>
                                    Décision
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-danger me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adherents as $adherent)
                                @php
                                    $lastPa = $adherent->pas->whereIn('status', ['refused', 'deferred', 'rejected'])->sortByDesc('created_at')->first();
                                    $commission = $lastPa->commission ? $lastPa->commission->candidatures->find($adherent->id)->pivot : null;
                                    $comment = $commission ? $commission->comment : null;
                                @endphp
                                <tr class="align-middle">
                                    <td>
                                        <div class="fw-bold text-dark">{{ $loop->index + 1 }}</div>
                                    </td>
                                    <td>
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="fw-bold text-info">{{ $adherent->cohort->reference }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $adherent->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-secondary me-1">{{ $adherent->user->mecano }}</span>
                                                    <span>{{ $adherent->phone_number ?? '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($lastPa)
                                            <div class="border-start border-warning border-3 ps-2 py-1">
                                                <div class="fw-medium text-warning">{{ $lastPa->title }}</div>
                                                <div class="small text-muted">
                                                    <i class="bx bx-money me-1"></i>
                                                    {{ amount($lastPa->amount, true) }}
                                                </div>
                                                @if($lastPa->url)
                                                    <a href="{{ asset($lastPa->url) }}" target="_blank" class="btn btn-outline-primary btn-sm mt-1">
                                                        <i class="bx bx-download me-1"></i>
                                                        Télécharger
                                                    </a>
                                                @endif
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">Aucun PA</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lastPa && $lastPa->sentence_reason)
                                            <div class="border-start border-danger border-3 ps-2 py-1">
                                                <div class="fw-medium text-danger">
                                                    {{ Str::limit($comment ?? $lastPa->sentence_reason, 100) }}
                                                </div>
                                                @if(strlen($lastPa->sentence_reason) > 100)
                                                    <button type="button" class="btn btn-link btn-sm p-0" 
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top" 
                                                            title="{{ $comment ?? $lastPa->sentence_reason }}">
                                                        Voir plus...
                                                    </button>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">Aucune raison</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lastPa)
                                            <div class="border-start border-danger border-3 ps-2 py-1">
                                                @if($lastPa->sentence_at)
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="bx bx-calendar text-danger me-2"></i>
                                                        <div>
                                                            <div class="fw-medium text-danger">{{ dateFr($lastPa->sentence_at) }}</div>
                                                            <div class="small text-muted">{{ dateFr($lastPa->sentence_at, 'hour') }}</div>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($lastPa->commission)
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="bx bx-gavel text-danger me-2"></i>
                                                        <div>
                                                            <div class="fw-medium text-danger">{{ $lastPa->commission->number }}</div>
                                                            <div class="small text-muted">{{ dateFr($lastPa->commission->date) }}</div>
                                                            <div class="small text-muted">{{ $lastPa->commission->lieu }}</div>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($lastPa->sentenceBy)
                                                    <div class="d-flex align-items-center">
                                                        <i class="bx bx-user-check text-danger me-2"></i>
                                                        <div>
                                                            <div class="fw-medium text-danger">{{ $lastPa->sentenceBy->fullName() }}</div>
                                                            <div class="small text-muted">{{ $lastPa->sentenceBy->username }}</div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">Aucune décision</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $adherent->user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>

                                            <button type="button" 
                                                    class="btn btn-outline-warning btn-sm addBtn" 
                                                    data-counter="{{ $adherent }}"
                                                    data-action="{{ route('cohort.pa.store', $adherent->id) }}"
                                                    data-last-pa="{{ $lastPa ? json_encode([
                                                        'title' => $lastPa->title,
                                                        'amount' => $lastPa->amount,
                                                        'credit' => $lastPa->credit,
                                                        'location' => $lastPa->location,
                                                        'partner_financial_id' => $lastPa->partner_financial_id,
                                                        'other_partner_financial' => $lastPa->other_partner_financial
                                                    ]) : '{}' }}"
                                                    title="Ajouter un nouveau PA">
                                                <i class="bx bx-plus me-1"></i>
                                                Nouveau PA
                                            </button>
                                        </div>
                                    </td>

                                        <div id="addModal{{ $adherent->id }}" class="modal fade" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="d-flex align-items-center">
                                                            <i class="bx bx-file-plus text-primary me-2 fs-4"></i>
                                                            <div>
                                                                <h5 class="modal-title mb-0">Nouveau Plan d'Affaire</h5>
                                                                <small class="text-muted">Basé sur le dernier plan rejeté</small>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="alert alert-info mb-4" id="prefill-alert_{{ $adherent->id }}" style="display: none;">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="bx bx-info-circle text-info me-2 fs-4"></i>
                                                                    <div>
                                                                        <strong>Données pré-remplies</strong>
                                                                        <div class="small">Les champs ont été remplis avec les données du dernier plan d'affaire rejeté. Vous pouvez les modifier selon vos besoins.</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="title_{{ $adherent->id }}" class="form-label">Titre du
                                                                        plan d'affaire<span class="text-danger">*</span>
                                                                        :
                                                                    </label>
                                                                    <input type="text"
                                                                        class="form-control @error('title') is-invalid @enderror"
                                                                        id="title_{{ $adherent->id }}" name="title"
                                                                        value="{{ old('title') }}" required>
                                                                    @error('title')
                                                                        <span class="invalid-feedback" besoin="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="amount_{{ $adherent->id }}" class="form-label">Coût du
                                                                        projet (Fcfa)<span class="text-danger">*</span>
                                                                        :
                                                                    </label>
                                                                    <input type="text"
                                                                        class="form-control @error('amount') is-invalid @enderror"
                                                                        id="amount_{{ $adherent->id }}" name="amount"
                                                                        value="{{ old('amount') }}" required>
                                                                    @error('amount')
                                                                        <span class="invalid-feedback" besoin="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="credit_{{ $adherent->id }}" class="form-label">Crédit
                                                                        solicilité (Fcfa)<span class="text-danger">*</span>
                                                                        :
                                                                    </label>
                                                                    <input type="text"
                                                                        class="form-control @error('credit') is-invalid @enderror"
                                                                        id="credit_{{ $adherent->id }}" name="credit"
                                                                        value="{{ old('credit') }}" required>
                                                                    @error('credit')
                                                                        <span class="invalid-feedback" besoin="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="location_{{ $adherent->id }}" class="form-label">Lieu de
                                                                        réalisation du projet<span
                                                                            class="text-danger">*</span> :
                                                                    </label>
                                                                    <input type="text"
                                                                        class="form-control @error('location') is-invalid @enderror"
                                                                        id="location_{{ $adherent->id }}" name="location"
                                                                        value="{{ old('location') }}" required>
                                                                    @error('location')
                                                                        <span class="invalid-feedback" besoin="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label">Partenaire financier :
                                                                    </label>
                                                                    <select
                                                                        class="form-control @error('partner_id') is-invalid @enderror"
                                                                        aria-label="Default select example"
                                                                        name="partner_financial"
                                                                        id="partner_financial_id_{{ $adherent->id }}"
                                                                        required>

                                                                        @foreach ($partner_financials as $partner_financial)
                                                                            <option value="{{ $partner_financial->id }}"
                                                                                {{ $adherent->partner_financial_id == $partner_financial->id ? 'selected' : '' }}>
                                                                                {{ $partner_financial->user->username }}
                                                                            </option>
                                                                        @endforeach

                                                                        <option value="other"
                                                                            {{ $adherent->other_partner_financial ? 'selected' : '' }}>
                                                                            Autre</option>
                                                                    </select>
                                                                    @error('partner_financial_id')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-12 mb-3"
                                                                    id="other_partner_div_{{ $adherent->id }}"
                                                                    style="display:{{ $adherent->other_partner_financial ? 'block' : 'none' }};">
                                                                    <label for="other_partner_financial_{{ $adherent->id }}" class="form-label">Precisez : </label>
                                                                    <input type="text" class="form-control"
                                                                        id="other_partner_financial_{{ $adherent->id }}"
                                                                        name="other_partner_financial"
                                                                        value="{{ $adherent->other_partner_financial ?? '' }}" />
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="url" class="form-label">Plan
                                                                        d'affaire<span class="text-danger">*</span> :
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
                background-color: rgba(220, 53, 69, 0.05) !important;
            }
            .border-start.border-danger {
                border-left-color: #dc3545 !important;
            }
            .border-start.border-warning {
                border-left-color: #ffc107 !important;
            }
            .border-start.border-info {
                border-left-color: #0dcaf0 !important;
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
                        var lastPaData = $(this).data('last-pa');
                        
                        // Définir l'action du formulaire
                        modal.find('form').attr('action', $(this).data('action'));
                        
                        // Pré-remplir les champs avec les données du dernier PA
                        if (lastPaData && Object.keys(lastPaData).length > 0) {
                            var adherentId = $(this).data('counter').id;
                            
                            // Pré-remplir les champs
                            $('#title_' + adherentId).val(lastPaData.title || '');
                            $('#amount_' + adherentId).val(lastPaData.amount || '');
                            $('#credit_' + adherentId).val(lastPaData.credit || '');
                            $('#location_' + adherentId).val(lastPaData.location || '');
                            
                            // Gérer le partenaire financier
                            if (lastPaData.partner_financial_id) {
                                $('#partner_financial_id_' + adherentId).val(lastPaData.partner_financial_id);
                            }
                            
                            // Gérer l'autre partenaire financier
                            if (lastPaData.other_partner_financial) {
                                $('#other_partner_financial_' + adherentId).val(lastPaData.other_partner_financial);
                                $('#other_partner_div_' + adherentId).show();
                            } else {
                                $('#other_partner_div_' + adherentId).hide();
                            }
                            
                            // Afficher l'alerte informative
                            $('#prefill-alert_' + adherentId).show();
                        }
                        
                        modal.modal('show');
                    });
                })(jQuery);
            @endif
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialiser les tooltips Bootstrap
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                @foreach ($adherents as $adherentc)
                    (function(adherentId) {
                        var partnerSelect = document.getElementById('partner_financial_id_' + adherentId);
                        var otherPartnerDiv = document.getElementById('other_partner_div_' + adherentId);

                        if (partnerSelect) {
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
                        }
                    })({{ $adherentc->id }});
                @endforeach
            });
        </script>
    @endpush
@endsection
