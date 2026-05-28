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
                <th>Téléphone</th>
                <td>{{ $preregistration->phone }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $preregistration->email ?? '-' }}</td>
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

@if($preregistration->message)
<div class="mt-4">
    <h6 class="text-primary mb-3">
        <i class="bx bx-message-dots me-2"></i>Message/Motivation
    </h6>
    <div class="alert alert-info">
        {{ $preregistration->message }}
    </div>
</div>
@endif

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