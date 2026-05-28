@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush
    
    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-group text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Commissions d'approbations</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec bouton d'action -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-calendar-check text-success fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Gestion des commissions</h5>
                        <small class="text-muted">Sessions d'approbation des projets</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $commissions->count() }}
                        </div>
                        <small class="text-muted d-block">Sessions</small>
                    </div>
                    @if (can('conseiller-auto-emploi') || can('chef-cellule-formation-et-insertion'))
                        <a href="{{ route('commissions.create', $cohort->id) }}" class="btn btn-primary d-flex align-items-center">
                            <i class="bx bx-plus me-2"></i>
                            Organiser une commission
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tableau des commissions -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th class="border-0">
                                    <i class="bx bx-hash text-primary me-1"></i>
                                    Session
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-briefcase text-primary me-1"></i>
                                    Partenaires Techniques
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-credit-card text-primary me-1"></i>
                                    Partenaires Financiers
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-calendar text-primary me-1"></i>
                                    Date & Lieu
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-file-doc text-primary me-1"></i>
                                    Documents
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commissions as $commission)
                                <tr class="align-middle">
                                    <td>
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="fw-bold text-info">Session {{ $commission->number }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach ($commission->partenaires as $partenaire)
                                                @if ($commission->partenaires->find($partenaire->id)->pivot->type == 'partner_technique')
                                                        {{ $partenaire->user->username }}
                                                @endif
                                            @endforeach
                                            @if ($commission->partenaires->where('pivot.type', 'partner_technique')->isEmpty())
                                                <span class="text-muted small">Aucun partenaire technique</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach ($commission->partenaires as $partenaire)
                                                @if ($commission->partenaires->find($partenaire->id)->pivot->type == 'partner_financial')
                                                    <span class="badge bg-success">
                                                        {{ $partenaire->user->username }}
                                                    </span>
                                                @endif
                                            @endforeach
                                            @if ($commission->partenaires->where('pivot.type', 'partner_financial')->isEmpty())
                                                <span class="text-muted small">Aucun partenaire financier</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-medium">{{ dateFr($commission->date) }}</div>
                                                <small class="text-muted">
                                                    <i class="bx bx-map-pin me-1"></i>
                                                    {{ $commission->lieu }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @if ($commission->rapport)
                                                <a href="{{ asset($commission->rapport) }}" 
                                                   class="btn btn-outline-warning btn-sm" 
                                                   download
                                                   title="Télécharger le rapport">
                                                    <i class="bx bx-file-doc me-1"></i>
                                                    Rapport
                                                </a>
                                            @endif
                                            @if ($commission->file_presence)
                                                <a href="{{ asset($commission->file_presence) }}" 
                                                   class="btn btn-outline-danger btn-sm" 
                                                   download
                                                   title="Télécharger la fiche de présence">
                                                    <i class="bx bx-user-check me-1"></i>
                                                    Présence
                                                </a>
                                            @endif
                                            @if ($commission->file_presence_partner)
                                                <a href="{{ asset($commission->file_presence_partner) }}" 
                                                   class="btn btn-outline-success btn-sm" 
                                                   download
                                                   title="Télécharger la présence partenaires">
                                                    <i class="bx bx-group me-1"></i>
                                                    Partenaires
                                                </a>
                                            @endif
                                            @if (!$commission->rapport && !$commission->file_presence && !$commission->file_presence_partner)
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-warning rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                                    <span class="text-muted small">Aucun document</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('commissions.candidat_commission', $commission->id) }}"
                                               class="btn btn-outline-primary btn-sm"
                                               title="Voir les détails">
                                                <i class="bx bx-show me-1"></i>
                                                Voir
                                            </a>
                                            @if (can('responsable-suivi-evaluation|assistant-suivi-evaluation'))
                                                @if (!($commission->rapport && $commission->file_presence && $commission->file_presence_partner))
                                                    <button type="button" 
                                                            class="btn btn-outline-warning btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rapportModal{{ $commission->id }}"
                                                            title="Ajouter des documents">
                                                        <i class="bx bx-upload me-1"></i>
                                                        Ajouter
                                                    </button>
                                                @endif
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

    <!-- Modals -->
    @foreach ($commissions as $commission)
        @if (can('responsable-suivi-evaluation|assistant-suivi-evaluation'))
            @if (!($commission->rapport && $commission->file_presence && $commission->file_presence_partner))
                <div class="modal fade" id="rapportModal{{ $commission->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header text-white">
                                <h5 class="modal-title">
                                    <i class="bx bx-file-plus me-2"></i>
                                    Compte rendu - Session {{ $commission->number }}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('commissions.cr') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row g-3">
                                        @if (!$commission->rapport)
                                            <div class="col-12">
                                                <label class="form-label fw-medium">
                                                    <i class="bx bx-file-doc text-warning me-1"></i>
                                                    Rapport de commission
                                                </label>
                                                <input type="file" class="form-control" name="rapport" accept=".pdf,.doc,.docx">
                                                <small class="text-muted">Formats acceptés: PDF, DOC, DOCX</small>
                                            </div>
                                        @endif
                                        
                                        @if (!$commission->file_presence)
                                            <div class="col-12">
                                                <label class="form-label fw-medium">
                                                    <i class="bx bx-user-check text-danger me-1"></i>
                                                    Fiche de présence des adhérents
                                                </label>
                                                <input type="file" class="form-control" name="file_presence" accept=".pdf,.doc,.docx">
                                                <small class="text-muted">Formats acceptés: PDF, DOC, DOCX</small>
                                            </div>
                                        @endif
                                        
                                        @if (!$commission->file_presence_partner)
                                            <div class="col-12">
                                                <label class="form-label fw-medium">
                                                    <i class="bx bx-group text-success me-1"></i>
                                                    Fiche de présence des partenaires
                                                </label>
                                                <input type="file" class="form-control" name="file_presence_partner" accept=".pdf,.doc,.docx">
                                                <small class="text-muted">Formats acceptés: PDF, DOC, DOCX</small>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <input type="hidden" name="commission_id" value="{{ $commission->id }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        <i class="bx bx-x me-1"></i>
                                        Annuler
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save me-1"></i>
                                        Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endforeach
@endsection