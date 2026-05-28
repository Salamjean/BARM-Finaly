@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item me-2"><a href="#" class="text-decoration-none">Commissions d'approbations</a></li> /
                    <li class="ms-2 active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
            <h1 class="h2 fw-bold text-primary">{{ $title }}</h1>
        </div>
    </div>

    <div class="card shadow-none">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mb-0" id="datatable--barm">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase">#</th>
                            <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase">Candidat</th>
                            <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase">Partenaires</th>
                            <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase">Localisation</th>
                            <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase">Projet</th>
                            @if (!can('point-focal'))
                                <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase">Point Focal</th>
                            @endif
                            <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase">Statut</th>
                            <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidatures as $adhrent)
                        <tr>
                            <td class="px-4 py-3 align-middle">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $loop->index + 1 }}</span>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ $adhrent->user->fullName() }}</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary bg-opacity-10 text-white">
                                            <i class="bi bi-hash"></i>{{ $adhrent->user->mecano }}
                                        </span>
                                        <small class="text-muted">
                                            <i class="bi bi-telephone me-1"></i>{{ $adhrent->phone_number }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="d-flex flex-column gap-1">
                                    @if ($adhrent->partnerTechnical)
                                        <span class="badge bg-info bg-opacity-75 text-white">
                                            <i class="bi bi-gear me-1"></i>
                                            {{ $adhrent->partnerTechnical->user->username }}
                                        </span>
                                    @endif
                                    @if ($adhrent->pivot->partner_financial_id != null)
                                        <span class="badge bg-success bg-opacity-75 text-white">
                                            <i class="bi bi-cash me-1"></i>
                                            {{ $adhrent->partnerFinancial->user->username }}
                                        </span>
                                    @elseif ($adhrent->pivot->other_partner_financial != null)
                                        <span class="badge bg-warning bg-opacity-75 text-white">
                                            <i class="bi bi-bank me-1"></i>
                                            {{ $adhrent->pivot->other_partner_financial }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div>
                                    <div class="fw-medium text-dark">
                                        <i class="bi bi-map me-1 text-muted"></i>
                                        {{ $adhrent->choiceFinal->region_retraite }}
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        @if ($adhrent->paAccepted)
                                            {{ $adhrent->paAccepted->location }}
                                        @endif
                                        @if ($adhrent->paPending)
                                            {{ $adhrent->paPending->location }}
                                        @endif
                                    </small>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div>
                                    <h6 class="mb-0 text-truncate" style="max-width: 200px;">
                                        @if ($adhrent->paAccepted)
                                            {{ $adhrent->paAccepted->title }}
                                        @endif
                                        @if ($adhrent->paPending)
                                            {{ $adhrent->paPending->title }}
                                        @endif
                                    </h6>
                                </div>
                            </td>
                            @if (!can('point-focal'))
                                <td class="px-4 py-3 align-middle">
                                    <span class="text-muted">{{ $adhrent->focal_point_area }}</span>
                                </td>
                            @endif
                            <td class="px-4 py-3 align-middle">
                                @if ($adhrent->pivot->decision == 'accepted')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Accepté
                                    </span>
                                @elseif ($adhrent->pivot->decision == 'refused')
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i>Refusé
                                    </span>
                                @elseif ($adhrent->pivot->decision == 'missing')
                                    <span class="badge bg-warning">
                                        <i class="bi bi-person-x me-1"></i>Absent
                                    </span>
                                @elseif ($adhrent->pivot->decision == 'deferred')
                                    <span class="badge bg-info">
                                        <i class="bi bi-clock-history me-1"></i>Différé
                                    </span>
                                @elseif ($adhrent->pivot->decision == 'resignation')
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-box-arrow-right me-1"></i>Abandon
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-50">
                                        <i class="bi bi-hourglass-split me-1"></i>En attente
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('adherent.show', $adhrent->user->id) }}" 
                                       class="py-2 rounded-circle"
                                       data-bs-toggle="tooltip" 
                                       data-bs-placement="top" 
                                       title="Voir le profil">
                                       <i class=" bx bx-show">
                                       </i>
                                    </a>
                                    
                                    @if (can('responsable-suivi-evaluation|assistant-suivi-evaluation|chef-cellule-suivi-evaluation'))
                                        @if ($adhrent->pivot->decision == null)
                                            <button type="button" 
                                                    class="btn btn-warning btn-md rounded-pill px-3 text-white"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#addNewCCModal{{ $adhrent->id }}">
                                                <i class="bi bi-clipboard-check me-1"></i>
                                                Décision
                                            </button>
                                        @endif
                                        
                                    @endif
                                    @if ($adhrent->pivot->decision != null)
                                            <button type="button" 
                                                    class="btn btn-success btn-md rounded-pill px-3 text-white"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#commentModal{{ $adhrent->id }}">
                                                <i class="bi bi-chat-text me-1"></i>
                                                Détails
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

    @foreach ($candidatures as $adhrent)
        @if (can('responsable-suivi-evaluation|assistant-suivi-evaluation|chef-cellule-suivi-evaluation'))
            @if ($adhrent->pivot->decision == null)
                <div class="modal fade" id="addNewCCModal{{ $adhrent->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header border-bottom-0">
                                <h5 class="modal-title">Décision de la commission - {{ $adhrent->user->fullName() }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('commissions.decision') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-clipboard-check me-1 text-primary"></i>
                                                Décision
                                            </label>
                                            <select class="form-select" name="decision">
                                                <option value="accepted">Valider</option>
                                                <option value="refused">Rejeter</option>
                                                <option value="deferred">Différer</option>
                                                <option value="resignation">Abandon</option>
                                                <option value="missing">Absent</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-bank me-1 text-success"></i>
                                                Partenaire financier
                                            </label>
                                            <select class="form-select @error('partner_id') is-invalid @enderror"
                                                    name="partner_financial"
                                                    id="partner_financial_id{{ $adhrent->id }}" 
                                                    required>
                                                @foreach ($partner_financials as $partner_financial)
                                                    <option value="{{ $partner_financial->id }}"
                                                        {{ $adhrent->partner_financial_id == $partner_financial->id ? 'selected' : '' }}>
                                                        {{ $partner_financial->user->username }}
                                                    </option>
                                                @endforeach
                                                <option value="other" {{ $adhrent->other_partner_financial ? 'selected' : '' }}>
                                                    Autre partenaire
                                                </option>
                                            </select>
                                            @error('partner_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12" id="other_partner_div{{ $adhrent->id }}" style="display:none;">
                                            <label class="form-label fw-semibold">Précisez le partenaire</label>
                                            <input type="text" class="form-control" name="other_partner_financial" 
                                                   placeholder="Nom du partenaire financier"/>
                                        </div>

                                        <div class="col-12">
                                            <div class="alert alert-light border">
                                                <h6 class="alert-heading mb-2">
                                                    <i class="bi bi-briefcase me-1"></i>
                                                    Informations du projet
                                                </h6>
                                                <div class="row g-2">
                                                    <div class="col-md-8">
                                                        <small class="text-muted">Titre :</small>
                                                        <p class="mb-0 fw-medium">{{ $adhrent->paPending->title }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <small class="text-muted">Coût total :</small>
                                                        <p class="mb-0 fw-bold text-primary">{{ amount($adhrent->paPending->amount) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="amount" class="form-label fw-semibold">
                                                <i class="bi bi-cash-stack me-1 text-warning"></i>
                                                Crédit sollicité <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">FCFA</span>
                                                <input type="number"
                                                       class="form-control @error('amount') is-invalid @enderror"
                                                       id="amount" 
                                                       name="amount"
                                                       value="{{ old('amount') ?? $adhrent->paPending->credit }}">
                                            </div>
                                            @error('amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-chat-left-text me-1 text-info"></i>
                                                Commentaire
                                            </label>
                                            <textarea class="form-control" name="comment" rows="3" 
                                                      placeholder="Ajoutez vos observations..."></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="candidature_id" value="{{ $adhrent->id }}">
                                    <input type="hidden" name="commission_id" value="{{ $commission->id }}">
                                </div>
                                <div class="modal-footer border-top-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Annuler
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Enregistrer la décision
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        @if ($adhrent->pivot->decision != null)
                <div class="modal fade" id="commentModal{{ $adhrent->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-bottom-0">
                                <h5 class="modal-title">Détails de la décision - {{ $adhrent->user->fullName() }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-light border mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <div>
                                            <small class="text-muted">Décision prise :</small>
                                            <div class="fw-medium">
                                                @if ($adhrent->pivot->decision == 'accepted')
                                                    <span class="text-success">✓ Accepter</span>
                                                @elseif ($adhrent->pivot->decision == 'refused')
                                                    <span class="text-danger">✗ Refuser</span>
                                                @elseif ($adhrent->pivot->decision == 'deferred')
                                                    <span class="text-info">⏱ Différer</span>
                                                @elseif ($adhrent->pivot->decision == 'resignation')
                                                    <span class="text-secondary">↩ Abandon</span>
                                                @elseif ($adhrent->pivot->decision == 'missing')
                                                    <span class="text-warning">⚠ Absent</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-chat-left-text me-1"></i>
                                    Commentaire de la commission
                                </label>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0">{{ $adhrent->pivot->comment ?: 'Aucun commentaire' }}</p>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Fermer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
    @endforeach
</div>

@push('js-push')
<script>
    // Script pour chaque modal
    @foreach ($candidatures as $adhrent)
        document.getElementById('partner_financial_id{{ $adhrent->id }}')?.addEventListener('change', function() {
            var otherPartnerDiv = document.getElementById('other_partner_div{{ $adhrent->id }}');
            if (this.value === 'other') {
                otherPartnerDiv.style.display = 'block';
            } else {
                otherPartnerDiv.style.display = 'none';
            }
        });
    @endforeach
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endpush
@endsection