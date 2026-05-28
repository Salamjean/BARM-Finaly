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
        content: '\203A';
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
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Préinscriptions Retraités</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h4 class="card-title">{{ \App\Models\RetiredPreregistration::where('status', 'pending')->count() }}</h4>
                    <p class="card-text">En attente</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h4 class="card-title">{{ \App\Models\RetiredPreregistration::where('status', 'approved')->count() }}</h4>
                    <p class="card-text">Approuvées</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h4 class="card-title">{{ \App\Models\RetiredPreregistration::where('status', 'rejected')->count() }}</h4>
                    <p class="card-text">Rejetées</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h4 class="card-title">{{ \App\Models\RetiredPreregistration::count() }}</h4>
                    <p class="card-text">Total</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filtres</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="status" class="form-label">Statut</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvées</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejetées</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="verified" class="form-label">Vérification</label>
                    <select name="verified" id="verified" class="form-select">
                        <option value="">Toutes</option>
                        <option value="1" {{ request('verified') == '1' ? 'selected' : '' }}>Vérifiées</option>
                        <option value="0" {{ request('verified') == '0' ? 'selected' : '' }}>Non vérifiées</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-search"></i> Filtrer
                    </button>
                    <a href="{{ route('retired-preregistrations.index') }}" class="btn btn-secondary">
                        <i class="bx bx-reset"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bx bx-user-plus me-2"></i>
                Gestion des Préinscriptions Retraités
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="preregistrationsTable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nom & Prénom</th>
                            <th>Mécano</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Vérification</th>
                            <th>Date demande</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($preregistrations as $preregistration)
                        <tr>
                            <td>{{ $preregistration->id }}</td>
                            <td>
                                <strong>{{ $preregistration->fullname }}</strong>
                                @if($preregistration->retired)
                                    <br><small class="text-success">
                                        <i class="bx bx-check-circle"></i> Retraité trouvé
                                    </small>
                                @endif
                            </td>
                            <td>
                                <code>{{ $preregistration->mecano }}</code>
                            </td>
                            <td>{{ $preregistration->phone }}</td>
                            <td>{{ $preregistration->email ?? '-' }}</td>
                            <td>
                                @switch($preregistration->status)
                                    @case('pending')
                                        <span class="badge bg-warning">En attente</span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-success">Approuvée</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">Rejetée</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @if($preregistration->verified)
                                    <span class="badge bg-success">
                                        <i class="bx bx-check"></i> Vérifiée
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bx bx-x"></i> Non vérifiée
                                    </span>
                                @endif
                            </td>
                            <td>{{ $preregistration->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info" 
                                            onclick="showDetails({{ $preregistration->id }})"
                                            title="Voir détails">
                                        <i class="bx bx-show"></i>
                                    </button>
                                    
                                    @if($preregistration->status == 'pending')
                                        <button type="button" class="btn btn-sm btn-success" 
                                                onclick="approveRequest({{ $preregistration->id }})"
                                                title="Approuver">
                                            <i class="bx bx-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="rejectRequest({{ $preregistration->id }})"
                                                title="Rejeter">
                                            <i class="bx bx-x"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="bx bx-info-circle me-2"></i>
                                Aucune préinscription trouvée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $preregistrations->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de la préinscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approuver la préinscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="approveForm">
                    @csrf
                    <input type="hidden" id="approveId" name="id">
                    <div class="mb-3">
                        <label for="approveNotes" class="form-label">Notes (optionnel)</label>
                        <textarea class="form-control" id="approveNotes" name="admin_notes" rows="3" 
                                  placeholder="Ajouter des notes sur l'approbation..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success" onclick="confirmApprove()">
                    <i class="bx bx-check"></i> Approuver
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejeter la préinscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="rejectForm">
                    @csrf
                    <input type="hidden" id="rejectId" name="id">
                    <div class="mb-3">
                        <label for="rejectNotes" class="form-label">Motif du rejet <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejectNotes" name="admin_notes" rows="3" 
                                  placeholder="Expliquer le motif du rejet..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" onclick="confirmReject()">
                    <i class="bx bx-x"></i> Rejeter
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js-push')
<script>
let currentPreregistrationId = null;

function showDetails(id) {
    // Load details via AJAX
    fetch(`{{ route('retired-preregistrations.index') }}/${id}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('detailsContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('detailsModal')).show();
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors du chargement des détails');
        });
}

function approveRequest(id) {
    currentPreregistrationId = id;
    document.getElementById('approveId').value = id;
    document.getElementById('approveNotes').value = '';
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectRequest(id) {
    currentPreregistrationId = id;
    document.getElementById('rejectId').value = id;
    document.getElementById('rejectNotes').value = '';
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

function confirmApprove() {
    if (!currentPreregistrationId) return;
    
    const formData = new FormData(document.getElementById('approveForm'));
    
    fetch(`{{ route('retired-preregistrations.index') }}/${currentPreregistrationId}/approve`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Préinscription approuvée avec succès');
            location.reload();
        } else {
            alert('Erreur: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'approbation');
    });
}

function confirmReject() {
    if (!currentPreregistrationId) return;
    
    const notes = document.getElementById('rejectNotes').value.trim();
    if (!notes) {
        alert('Le motif du rejet est obligatoire');
        return;
    }
    
    const formData = new FormData(document.getElementById('rejectForm'));
    
    fetch(`{{ route('retired-preregistrations.index') }}/${currentPreregistrationId}/reject`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Préinscription rejetée avec succès');
            location.reload();
        } else {
            alert('Erreur: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors du rejet');
    });
}
</script>
@endpush