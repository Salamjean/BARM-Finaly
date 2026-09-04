@if($preregistration)
<div class="row">
    <div class="col-md-6">
        <h6 class="text-primary mb-3">
            <i class="bx bx-user me-2"></i>Informations du demandeur
        </h6>
        <table class="table table-bordered table-sm">
            <tr>
                <th style="width: 40%;">Nom complet</th>
                <td>{{ $preregistration->fullname }}</td>
            </tr>
            <tr>
                <th>Mécano</th>
                <td><code>{{ $preregistration->mecano }}</code></td>
            </tr>
            <tr>
                <th>Téléphone 1</th>
                <td>{{ $preregistration->phone }}</td>
            </tr>
            <tr>
                <th>Téléphone 2</th>
                <td>{{ $preregistration->phone2 ?? '-' }}</td>
            </tr>
            <tr>
                <th>Lieu de résidence</th>
                <td>{{ $preregistration->residence ?? '-' }}</td>
            </tr>
            <tr>
                <th>Date de demande</th>
                <td>{{ $preregistration->created_at->format('d/m/Y à H:i') }}</td>
            </tr>
        </table>
    </div>
    
    <div class="col-md-6">
        <h6 class="text-primary mb-3">
            <i class="bx bx-cog me-2"></i>Statut et vérification
        </h6>
        <table class="table table-bordered table-sm">
            <tr>
                <th style="width: 40%;">Statut</th>
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
            </tr>
            <tr>
                <th>Vérification</th>
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
            </tr>
            @if($preregistration->processed_at)
            <tr>
                <th>Date de traitement</th>
                <td>{{ $preregistration->processed_at->format('d/m/Y à H:i') }}</td>
            </tr>
            @endif
            @if($preregistration->processedBy)
            <tr>
                <th>Traité par</th>
                <td>{{ $preregistration->processedBy->name ?? 'N/A' }}</td>
            </tr>
            @endif
        </table>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h6 class="text-danger fw-bold text-center mb-3">
            <i class="bx bx-target-lock me-2"></i>Axe d'insertion
        </h6>
        <div class="row g-3">
            <!-- Auto Emploi -->
            <div class="col-md-4">
                <div class="card h-100 border shadow-none">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                        <strong class="text-dark">Auto emploi</strong>
                        @if($preregistration->axe_auto_emploi)
                            <span class="badge bg-success"><i class="bx bx-check"></i> Coché</span>
                        @else
                            <span class="badge bg-secondary">Non coché</span>
                        @endif
                    </div>
                    <div class="card-body p-3 text-sm">
                        <p class="mb-2"><strong>Projet 1 :</strong> {{ $preregistration->auto_emploi_projet1 ?: '-' }}</p>
                        <p class="mb-0"><strong>Projet 2 :</strong> {{ $preregistration->auto_emploi_projet2 ?: '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Entreprise Privée -->
            <div class="col-md-4">
                <div class="card h-100 border shadow-none">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                        <strong class="text-dark">Entreprise privée</strong>
                        @if($preregistration->axe_entreprise_privee)
                            <span class="badge bg-success"><i class="bx bx-check"></i> Coché</span>
                        @else
                            <span class="badge bg-secondary">Non coché</span>
                        @endif
                    </div>
                    <div class="card-body p-3 text-sm">
                        <p class="mb-2"><strong>Emploi souhaité :</strong> {{ $preregistration->entreprise_privee_emploi ?: '-' }}</p>
                        <p class="mb-1"><strong>Formation souhaitée :</strong></p>
                        <ul class="ps-3 mb-0">
                            <li>1. {{ $preregistration->entreprise_privee_formation1 ?: '-' }}</li>
                            <li>2. {{ $preregistration->entreprise_privee_formation2 ?: '-' }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Fonction Publique -->
            <div class="col-md-4">
                <div class="card h-100 border shadow-none">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                        <strong class="text-dark">Fonction publique</strong>
                        @if($preregistration->axe_fonction_publique)
                            <span class="badge bg-success"><i class="bx bx-check"></i> Coché</span>
                        @else
                            <span class="badge bg-secondary">Non coché</span>
                        @endif
                    </div>
                    <div class="card-body p-3 text-sm">
                        <p class="mb-2"><strong>Diplôme civil :</strong> {{ $preregistration->fonction_publique_diplome ?: '-' }}</p>
                        <p class="mb-2"><strong>Emploi 1 :</strong> {{ $preregistration->fonction_publique_emploi1 ?: '-' }}</p>
                        <p class="mb-0"><strong>Emploi 2 :</strong> {{ $preregistration->fonction_publique_emploi2 ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($preregistration->admin_notes)
<div class="mt-4">
    <h6 class="text-primary mb-3">
        <i class="bx bx-note me-2"></i>Notes administratives
    </h6>
    <div class="alert alert-secondary">
        {{ $preregistration->admin_notes }}
    </div>
</div>
@endif

@if($preregistration->retired)
<div class="mt-4">
    <h6 class="text-success mb-3">
        <i class="bx bx-check-circle me-2"></i>Informations du retraité trouvé
    </h6>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered table-sm">
                <tr>
                    <th style="width: 40%;">Nom complet</th>
                    <td>{{ $preregistration->retired->firstname }} {{ $preregistration->retired->lastname }}</td>
                </tr>
                <tr>
                    <th>Matricule</th>
                    <td>{{ $preregistration->retired->matricule }}</td>
                </tr>
                <tr>
                    <th>Unité</th>
                    <td>{{ $preregistration->retired->unit ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Armée</th>
                    <td>{{ $preregistration->retired->army ?? '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered table-sm">
                <tr>
                    <th style="width: 40%;">Grade</th>
                    <td>{{ $preregistration->retired->grade ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Date de naissance</th>
                    <td>{{ $preregistration->retired->birth_date ? \Carbon\Carbon::parse($preregistration->retired->birth_date)->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Date de retraite</th>
                    <td>{{ $preregistration->retired->retired_date ? \Carbon\Carbon::parse($preregistration->retired->retired_date)->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Statut adhésion</th>
                    <td>
                        @if($preregistration->retired->used === 'yes')
                            <span class="badge bg-danger">Déjà adhérent</span>
                        @else
                            <span class="badge bg-success">Disponible</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@else
<div class="mt-4">
    <div class="alert alert-warning">
        <i class="bx bx-info-circle me-2"></i>
        <strong>Attention:</strong> Aucun retraité correspondant trouvé dans la base de données.
    </div>
</div>
@endif

<div class="mt-4 text-center">
    @if($preregistration->status == 'pending')
        <button type="button" class="btn btn-success me-2" onclick="approveRequest({{ $preregistration->id }})">
            <i class="bx bx-check"></i> Approuver
        </button>
        <button type="button" class="btn btn-danger" onclick="rejectRequest({{ $preregistration->id }})">
            <i class="bx bx-x"></i> Rejeter
        </button>
    @else
        <p class="text-muted mb-0">
            <i class="bx bx-info-circle"></i>
            Cette préinscription a déjà été traitée le {{ $preregistration->processed_at->format('d/m/Y à H:i') }}
        </p>
    @endif
</div>
@else
<div class="alert alert-danger">
    <i class="bx bx-error me-2"></i>
    Préinscription introuvable.
</div>
@endif