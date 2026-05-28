<div class="budget-header">
    <div class="container">
        <h1>{{ $budgetPlan->name }}</h1>
        <p class="mb-0 opacity-75">
            <i class="fas fa-calendar-alt me-2"></i>Année : {{ $budgetPlan->year }}
            @if ($budgetPlan->description)
                <span class="ms-3"><i class="fas fa-info-circle me-2"></i>{{ $budgetPlan->description }}</span>
            @endif
        </p>
    </div>
</div>

<div class="container">
    @if(can('responsable-suivi-evaluation|assistant-suivi-evaluation'))
    <div class="add-component-card">
        <div class="add-component-header">
            <i class="fas fa-plus-circle me-2"></i>Ajouter une Composante
        </div>
        <div class="card-body p-3">
            <form id="add-component-form" action="{{ route('budget-plans.budget-plan-components.store', $budgetPlan) }}"
                method="POST">
                @csrf
                <div class="row g-3 align-items-end add-component-form">
                    <div class="col-md-7">
                        <input type="text" name="title" class="form-control" placeholder="Titre de la composante"
                            required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="amount" class="form-control" placeholder="Montant" min="0"
                            required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-plus me-2"></i>Ajouter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <div class="budget-table-container">
        <div class="table-responsive">
            <table class="table budget-table">
                <thead>
                    <tr>
                        <th class="text-white" width="5%">N°</th>
                        <th class="text-white" width="35%">Composante</th>
                        <th class="text-white" width="8%">Code</th>
                        <th class="text-white" width="12%">Coût total</th>
                        <th class="text-white" width="10%">Cumul</th>
                        <th class="text-white" width="10%">Coût prévu</th>
                        <th class="text-white" width="10%" class="text-end">
                            <div>Coût initial</div>
                            <div class="total-amount">{{ amount($components->sum('amount'), true) }}</div>
                        </th>
                        <th class="text-white" width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $componentIndex = 1; @endphp
                    @foreach ($components as $component)
                        <tr data-id="{{ $component->id }}" class="component-row">
                            <td>
                                <span class="level-indicator">
                                    <span class="level-number">{{ $componentIndex }}</span>
                                </span>
                            </td>
                            <td><strong>{{ $component->title }}</strong></td>
                            <td>{{ $component->code }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-end amount">{{ amount($component->amount, true) }}</td>
                            <td>
                                <div class="action-buttons">
                                    @if(can('responsable-suivi-evaluation|assistant-suivi-evaluation'))
                                    <button class="btn-action btn-edit update-component-btn"
                                        data-url="{{ route('budget-plans.budget-plan-components.update', $component) }}"
                                        data-title="{{ $component->title }}" data-amount="{{ $component->amount }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete delete-component-btn"
                                        data-url="{{ route('budget-plans.budget-plan-components.destroy', $component) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn-action btn-add add-subcomponent-btn"
                                        data-component-id="{{ $component->id }}"
                                        data-url="{{ route('budget-plans.budget-plan-sub-components.store', $component) }}">
                                        <i class="fas fa-plus"></i> Sous
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        @php $subComponentIndex = 1; @endphp
                        @foreach ($component->subComponents as $subComponent)
                            <tr data-id="{{ $subComponent->id }}" class="subcomponent-row">
                                <td>
                                    <span class="level-indicator">
                                        <span class="level-number">{{ "$componentIndex.$subComponentIndex" }}</span>
                                    </span>
                                </td>
                                <td class="indent-1">
                                    <i class="fas fa-angle-right me-2"></i>{{ $subComponent->title }}
                                </td>
                                <td>{{ $subComponent->code }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-end amount">{{ amount($subComponent->amount, true) }}</td>
                                <td>
                                    <div class="action-buttons">
                                        @if(can('responsable-suivi-evaluation|assistant-suivi-evaluation'))
                                        <button class="btn-action btn-edit update-subcomponent-btn"
                                            data-url="{{ route('budget-plans.budget-plan-sub-components.update', $subComponent) }}"
                                            data-title="{{ $subComponent->title }}"
                                            data-amount="{{ $subComponent->amount }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-action btn-delete delete-subcomponent-btn"
                                            data-url="{{ route('budget-plans.budget-plan-sub-components.destroy', $subComponent) }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button class="btn-action btn-add add-section-btn"
                                            data-subcomponent-id="{{ $subComponent->id }}"
                                            data-url="{{ route('budget-plans.budget-plan-sections.store', $subComponent) }}">
                                            <i class="fas fa-plus"></i> Volet
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @php $sectionIndex = 1; @endphp
                            @foreach ($subComponent->sections as $section)
                                <tr data-id="{{ $section->id }}" class="section-row">
                                    <td>
                                        <span class="level-indicator">
                                            <span
                                                class="level-number">{{ "$componentIndex.$subComponentIndex.$sectionIndex" }}</span>
                                        </span>
                                    </td>
                                    <td class="indent-2">
                                        <i class="fas fa-angle-double-right me-2"></i>{{ $section->title }}
                                    </td>
                                    <td>{{ $section->code }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="action-buttons">
                                            @if(can('responsable-suivi-evaluation|assistant-suivi-evaluation'))
                                            <button class="btn-action btn-edit update-section-btn"
                                                data-url="{{ route('budget-plans.budget-plan-sections.update', $section) }}"
                                                data-title="{{ $section->title }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-action btn-delete delete-section-btn"
                                                data-url="{{ route('budget-plans.budget-plan-sections.destroy', $section) }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn-action btn-add add-part-btn"
                                                data-section-id="{{ $section->id }}"
                                                data-url="{{ route('budget-plans.budget-plan-parts.store', $section) }}">
                                                <i class="fas fa-plus"></i> Activité
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                @php $activityIndex = 1; @endphp
                                @foreach ($section->parts as $part)
                                    <tr data-id="{{ $part->id }}" class="activity-row">
                                        <td>
                                            <span class="level-indicator">
                                                <span
                                                    class="level-number">{{ "$componentIndex.$subComponentIndex.$sectionIndex.$activityIndex" }}</span>
                                            </span>
                                        </td>
                                        <td class="indent-3">
                                            <i class="fas fa-circle me-2"
                                                style="font-size: 0.5rem;"></i>{{ $part->title }}
                                        </td>
                                        <td>{{ $part->code }}</td>
                                        <td class="amount">{{ amount((int)$part->cost_total_project) }}</td>
                                        <td class="amount">{{ amount((int)$part->commitments) }}</td>
                                        <td class="amount">{{ amount((int)$part->cost_q1 + (int)$part->cost_q2 + (int)$part->cost_q3 + (int)$part->cost_q4) }}
                                        </td>
                                        <td class="text-end amount">{{ amount($part->cost_total_project, true) }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-action btn-view show-part-btn"
                                                    data-part-id="{{ $part->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if(can('responsable-suivi-evaluation|assistant-suivi-evaluation'))
                                                <button class="btn-action btn-edit update-part-btn"
                                                    data-url="{{ route('budget-plans.budget-plan-parts.update', $part) }}"
                                                    data-code="{{ $part->code }}" data-title="{{ $part->title }}"
                                                    data-details="{{ $part->details }}"
                                                    data-cost_total_project="{{ $part->cost_total_project }}"
                                                    data-commitments="{{ $part->commitments }}"
                                                    data-cost_q1="{{ $part->cost_q1 }}"
                                                    data-cost_q2="{{ $part->cost_q2 }}"
                                                    data-cost_q3="{{ $part->cost_q3 }}"
                                                    data-cost_q4="{{ $part->cost_q4 }}"
                                                    data-chronogram_q1="{{ $part->chronogram_q1 }}"
                                                    data-chronogram_q2="{{ $part->chronogram_q2 }}"
                                                    data-chronogram_q3="{{ $part->chronogram_q3 }}"
                                                    data-chronogram_q4="{{ $part->chronogram_q4 }}"
                                                    data-comments="{{ $part->comments }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn-action btn-delete delete-part-btn"
                                                    data-url="{{ route('budget-plans.budget-plan-parts.destroy', $part) }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="activity-details-row" style="display: none;"
                                        data-part-id="{{ $part->id }}">
                                        <td colspan="8">
                                            <div class="activity-details">
                                                <div class="activity-details-grid">
                                                    <div class="detail-item">
                                                        <div class="detail-label">Détails</div>
                                                        <div>{{ $part->details ?? 'Non spécifié' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-label">Coût Total Projet</div>
                                                        <div class="amount">
                                                            {{ amount($part->cost_total_project ?? 0, true) }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-label">Engagements</div>
                                                        <div>
                                                            <span
                                                                class="amount">{{ amount($part->commitments ?? 0, true) }}</span>
                                                            @if ($part->commitments && $part->cost_total_project && $part->commitments > 0 && $part->cost_total_project > 0)
                                                                <span class="badge bg-info ms-2">
                                                                    {{ number_format(($part->commitments / $part->cost_total_project) * 100, 1) }}%
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-label">Coûts par Trimestre</div>
                                                        <div class="d-flex gap-2 flex-wrap">
                                                            <span class="badge bg-secondary">T1:
                                                                {{ amount($part->cost_q1 ?? 0) }}</span>
                                                            <span class="badge bg-secondary">T2:
                                                                {{ amount($part->cost_q2 ?? 0) }}</span>
                                                            <span class="badge bg-secondary">T3:
                                                                {{ amount($part->cost_q3 ?? 0) }}</span>
                                                            <span class="badge bg-secondary">T4:
                                                                {{ amount($part->cost_q4 ?? 0) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-label">Chronogramme</div>
                                                        <div class="d-flex gap-2 flex-wrap">
                                                            @if ($part->chronogram_q1)
                                                                <span class="badge bg-primary">T1:
                                                                    {{ $part->chronogram_q1 }}</span>
                                                            @endif
                                                            @if ($part->chronogram_q2)
                                                                <span class="badge bg-primary">T2:
                                                                    {{ $part->chronogram_q2 }}</span>
                                                            @endif
                                                            @if ($part->chronogram_q3)
                                                                <span class="badge bg-primary">T3:
                                                                    {{ $part->chronogram_q3 }}</span>
                                                            @endif
                                                            @if ($part->chronogram_q4)
                                                                <span class="badge bg-primary">T4:
                                                                    {{ $part->chronogram_q4 }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if ($part->comments)
                                                        <div class="detail-item" style="grid-column: span 2;">
                                                            <div class="detail-label">Commentaires</div>
                                                            <div>{{ $part->comments }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php $activityIndex++; @endphp
                                @endforeach
                                @php $sectionIndex++; @endphp
                            @endforeach
                            @php $subComponentIndex++; @endphp
                        @endforeach
                        @php $componentIndex++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addSubcomponentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Ajouter une Sous-composante
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-subcomponent-form" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Titre</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Montant</label>
                        <input type="number" name="amount" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addSectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-folder-plus me-2"></i>Ajouter un Volet
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-section-form" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Titre</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-check me-2"></i>Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addPartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-tasks me-2"></i>Ajouter une Activité
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-part-form" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Code</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Titre</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Coût Total</label>
                            <input type="number" name="cost_total_project" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Engagements</label>
                            <input type="number" name="commitments" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <label class="form-label">Détails</label>
                            <textarea name="details" class="form-control" rows="2" placeholder="Services impliqués, description..."></textarea>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <label class="form-label">Coût T1</label>
                            <input type="number" name="cost_q1" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Coût T2</label>
                            <input type="number" name="cost_q2" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Coût T3</label>
                            <input type="number" name="cost_q3" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Coût T4</label>
                            <input type="number" name="cost_q4" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <label class="form-label">Chrono T1</label>
                            <select name="chronogram_q1" class="form-select">
                                <option value="">--</option>
                                <option value="préparation">Préparation</option>
                                <option value="sélection">Sélection</option>
                                <option value="exécution">Exécution</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Chrono T2</label>
                            <select name="chronogram_q2" class="form-select">
                                <option value="">--</option>
                                <option value="préparation">Préparation</option>
                                <option value="sélection">Sélection</option>
                                <option value="exécution">Exécution</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Chrono T3</label>
                            <select name="chronogram_q3" class="form-select">
                                <option value="">--</option>
                                <option value="préparation">Préparation</option>
                                <option value="sélection">Sélection</option>
                                <option value="exécution">Exécution</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Chrono T4</label>
                            <select name="chronogram_q4" class="form-select">
                                <option value="">--</option>
                                <option value="préparation">Préparation</option>
                                <option value="sélection">Sélection</option>
                                <option value="exécution">Exécution</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <label class="form-label">Commentaires</label>
                            <textarea name="comments" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">
                    <i class="fas fa-edit me-2"></i>Modifier
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="update-modal-form" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="update-title" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="update-title" name="title" required>
                    </div>

                    <div id="amount-fields" class="d-none">
                        <div class="mb-3">
                            <label for="update-amount" class="form-label">Montant</label>
                            <input type="number" class="form-control" id="update-amount" name="amount">
                        </div>
                    </div>

                    <div id="part-fields" class="d-none">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Code</label>
                                <input type="text" id="update-code" name="code" class="form-control">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Coût Total Projet</label>
                                <input type="number" id="update-cost-total-project" name="cost_total_project"
                                    class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Engagements</label>
                                <input type="number" id="update-commitments" name="commitments"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row g-3 mt-2">
                            <div class="col-12">
                                <label class="form-label">Détails</label>
                                <textarea id="update-details" name="details" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row g-3 mt-2">
                            <div class="col-md-3">
                                <label class="form-label">Coût T1</label>
                                <input type="number" id="update-cost-q1" name="cost_q1" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Coût T2</label>
                                <input type="number" id="update-cost-q2" name="cost_q2" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Coût T3</label>
                                <input type="number" id="update-cost-q3" name="cost_q3" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Coût T4</label>
                                <input type="number" id="update-cost-q4" name="cost_q4" class="form-control">
                            </div>
                        </div>
                        <div class="row g-3 mt-2">
                            <div class="col-md-3">
                                <label class="form-label">Chrono T1</label>
                                <select id="update-chronogram-q1" name="chronogram_q1" class="form-select">
                                    <option value="">--</option>
                                    <option value="préparation">Préparation</option>
                                    <option value="sélection">Sélection</option>
                                    <option value="exécution">Exécution</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Chrono T2</label>
                                <select id="update-chronogram-q2" name="chronogram_q2" class="form-select">
                                    <option value="">--</option>
                                    <option value="préparation">Préparation</option>
                                    <option value="sélection">Sélection</option>
                                    <option value="exécution">Exécution</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Chrono T3</label>
                                <select id="update-chronogram-q3" name="chronogram_q3" class="form-select">
                                    <option value="">--</option>
                                    <option value="préparation">Préparation</option>
                                    <option value="sélection">Sélection</option>
                                    <option value="exécution">Exécution</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Chrono T4</label>
                                <select id="update-chronogram-q4" name="chronogram_q4" class="form-select">
                                    <option value="">--</option>
                                    <option value="préparation">Préparation</option>
                                    <option value="sélection">Sélection</option>
                                    <option value="exécution">Exécution</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mt-2">
                            <div class="col-12">
                                <label class="form-label">Commentaires</label>
                                <textarea id="update-comments" name="comments" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Configuration Toast
    const ToastSuccess = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    $(document).ready(function() {
        // Initialisation des modaux Bootstrap
        const addSubcomponentModal = new bootstrap.Modal(document.getElementById('addSubcomponentModal'));
        const addSectionModal = new bootstrap.Modal(document.getElementById('addSectionModal'));
        const addPartModal = new bootstrap.Modal(document.getElementById('addPartModal'));
        const updateModal = new bootstrap.Modal(document.getElementById('updateModal'));

        // Gestion de l'ajout de composante
        $('#add-component-form').on('submit', function(e) {
            e.preventDefault();
            submitForm($(this), 'Composante ajoutée avec succès');
        });

        // Gestion des boutons d'ajout de sous-composante
        $(document).on('click', '.add-subcomponent-btn', function() {
            const url = $(this).data('url');
            $('#add-subcomponent-form').attr('action', url);
            addSubcomponentModal.show();
        });

        // Gestion du formulaire d'ajout de sous-composante
        $('#add-subcomponent-form').on('submit', function(e) {
            e.preventDefault();
            submitForm($(this), 'Sous-composante ajoutée avec succès');
        });

        // Gestion des boutons d'ajout de volet
        $(document).on('click', '.add-section-btn', function() {
            const url = $(this).data('url');
            $('#add-section-form').attr('action', url);
            addSectionModal.show();
        });

        // Gestion du formulaire d'ajout de volet
        $('#add-section-form').on('submit', function(e) {
            e.preventDefault();
            submitForm($(this), 'Volet ajouté avec succès');
        });

        // Gestion des boutons d'ajout d'activité
        $(document).on('click', '.add-part-btn', function() {
            const url = $(this).data('url');
            $('#add-part-form').attr('action', url);
            addPartModal.show();
        });

        // Gestion du formulaire d'ajout d'activité
        $('#add-part-form').on('submit', function(e) {
            e.preventDefault();
            submitForm($(this), 'Activité ajoutée avec succès');
        });

        // Gestion des boutons de suppression
        $(document).on('click',
            '.delete-component-btn, .delete-subcomponent-btn, .delete-section-btn, .delete-part-btn',
            function() {
                const button = $(this);
                Swal.fire({
                    title: 'Êtes-vous sûr?',
                    text: "Cette action est irréversible!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Oui, supprimer!',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: button.data('url'),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                ToastSuccess.fire({
                                    icon: 'success',
                                    title: response.message ||
                                        'Élément supprimé avec succès',
                                });
                                button.closest('tr').fadeOut(300, function() {
                                    $(this).remove();
                                });
                            },
                            error: function() {
                                Swal.fire('Erreur!',
                                    'Une erreur est survenue lors de la suppression.',
                                    'error');
                            }
                        });
                    }
                });
            });

        // Gestion des boutons de modification
        $(document).on('click', '.update-component-btn', function() {
            openUpdateModal({
                url: $(this).data('url'),
                title: $(this).data('title'),
                amount: $(this).data('amount'),
                type: 'component'
            });
        });

        $(document).on('click', '.update-subcomponent-btn', function() {
            openUpdateModal({
                url: $(this).data('url'),
                title: $(this).data('title'),
                amount: $(this).data('amount'),
                type: 'subcomponent'
            });
        });

        $(document).on('click', '.update-section-btn', function() {
            openUpdateModal({
                url: $(this).data('url'),
                title: $(this).data('title'),
                type: 'section'
            });
        });

        $(document).on('click', '.update-part-btn', function() {
            openUpdateModal({
                url: $(this).data('url'),
                code: $(this).data('code'),
                title: $(this).data('title'),
                details: $(this).data('details'),
                cost_total_project: $(this).data('cost_total_project'),
                commitments: $(this).data('commitments'),
                cost_q1: $(this).data('cost_q1'),
                cost_q2: $(this).data('cost_q2'),
                cost_q3: $(this).data('cost_q3'),
                cost_q4: $(this).data('cost_q4'),
                chronogram_q1: $(this).data('chronogram_q1'),
                chronogram_q2: $(this).data('chronogram_q2'),
                chronogram_q3: $(this).data('chronogram_q3'),
                chronogram_q4: $(this).data('chronogram_q4'),
                comments: $(this).data('comments'),
                type: 'part'
            });
        });

        // Gestion du formulaire de modification
        $('#update-modal-form').on('submit', function(e) {
            e.preventDefault();
            submitForm($(this), 'Modification enregistrée avec succès');
        });

        // Fonction pour soumettre un formulaire
        function submitForm(form, successMessage) {
            const submitBtn = form.find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Chargement...').prop(
                'disabled', true);

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    ToastSuccess.fire({
                        icon: 'success',
                        title: successMessage,
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    let errorMessage = 'Une erreur est survenue';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire('Erreur!', errorMessage, 'error');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        }

        // Fonction pour ouvrir le modal de modification
        function openUpdateModal(data) {
            $('#update-modal-form').trigger('reset');
            $('#part-fields').addClass('d-none');
            $('#amount-fields').addClass('d-none');

            $('#update-modal-form').attr('action', data.url);
            $('#update-title').val(data.title);

            if (data.type === 'component' || data.type === 'subcomponent') {
                $('#amount-fields').removeClass('d-none');
                $('#update-amount').val(data.amount);
            }

            if (data.type === 'part') {
                $('#part-fields').removeClass('d-none');
                $('#update-code').val(data.code);
                $('#update-cost-total-project').val(data.cost_total_project);
                $('#update-commitments').val(data.commitments);
                $('#update-details').val(data.details);
                $('#update-cost-q1').val(data.cost_q1);
                $('#update-cost-q2').val(data.cost_q2);
                $('#update-cost-q3').val(data.cost_q3);
                $('#update-cost-q4').val(data.cost_q4);
                $('#update-chronogram-q1').val(data.chronogram_q1);
                $('#update-chronogram-q2').val(data.chronogram_q2);
                $('#update-chronogram-q3').val(data.chronogram_q3);
                $('#update-chronogram-q4').val(data.chronogram_q4);
                $('#update-comments').val(data.comments);
            }

            updateModal.show();
        }

        // Affichage des détails des activités
        $(document).on('click', '.show-part-btn', function() {
            const partId = $(this).data('part-id');
            const detailsRow = $(`.activity-details-row[data-part-id="${partId}"]`);

            if (detailsRow.is(':visible')) {
                detailsRow.slideUp(300);
                $(this).html('<i class="fas fa-eye"></i>');
            } else {
                // Fermer les autres détails ouverts
                $('.activity-details-row:visible').slideUp(300);
                $('.show-part-btn').html('<i class="fas fa-eye"></i>');

                detailsRow.slideDown(300);
                $(this).html('<i class="fas fa-eye-slash"></i>');
            }
        });

        // Animation au chargement
        $('.budget-table tbody tr').each(function(index) {
            $(this).css('opacity', '0').delay(index * 30).animate({
                opacity: 1
            }, 300);
        });
    });
</script>
