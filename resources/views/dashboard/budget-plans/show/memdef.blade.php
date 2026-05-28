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
                <i class="fas fa-plus-circle me-2"></i>Ajouter un Effet
            </div>
            <div class="card-body p-3">
                <form id="add-component-form"
                    action="{{ route('budget-plans.budget-plan-components.store', $budgetPlan) }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end add-component-form">
                        <div class="col-md-10">
                            <input type="text" name="title" class="form-control" placeholder="Titre de l'effet"
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
                            <th class="text-white" width="15%">Indicateur</th>
                            <th class="text-white" width="65%">Désignation</th>
                            <th class="text-white" width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($components as $component)
                            <tr data-id="{{ $component->id }}" class="component-row">
                                <td>
                                    <span class="level-indicator">
                                        <span class="level-number">{{ $component->code }}</span>
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $component->title }}</strong>
                                </td>
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
                                            <i class="fas fa-plus"></i> Produit
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @foreach ($component->subComponents as $subComponent)
                                <tr data-id="{{ $subComponent->id }}" class="subcomponent-row">
                                    <td>
                                        <span class="level-indicator">
                                            <span class="level-number">{{ $subComponent->code }}</span>
                                        </span>
                                    </td>
                                    <td class="indent-1">
                                        <i class="fas fa-angle-right me-2"></i>{{ $subComponent->title }}
                                    </td>
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
                                                <i class="fas fa-plus"></i> Action
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                @foreach ($subComponent->sections as $section)
                                    <tr data-id="{{ $section->id }}" class="section-row">
                                        <td>
                                            <span class="level-indicator">
                                                <span class="level-number">{{ $section->code }}</span>
                                            </span>
                                        </td>
                                        <td class="indent-2">
                                            <i class="fas fa-angle-double-right me-2"></i>{{ $section->title }}
                                        </td>
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
                                                <button class="btn-action btn-add add-activity-btn"
                                                    data-section-id="{{ $section->id }}"
                                                    data-url="{{ route('budget-plans.budget-plan-activities.store', $section) }}">
                                                    <i class="fas fa-plus"></i> Activité
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    @foreach ($section->activities as $activity)
                                        <tr data-id="{{ $activity->id }}" class="activity-row">
                                            <td>
                                                <span class="level-indicator">
                                                    <span class="level-number"
                                                        title="{{ $activity->code }}">{{ mb_strimwidth($activity->code, 0, 12, '...') }}</span>
                                                </span>
                                            </td>
                                            <td class="indent-3">
                                                <i class="fas fa-circle me-2"
                                                    style="font-size: 0.5rem;"></i>{{ $activity->title }}
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-action btn-view show-activity-btn"
                                                        data-activity-id="{{ $activity->id }}"
                                                        data-code="{{ $activity->code }}"
                                                        data-title="{{ $activity->title }}"
                                                        data-p_objective_q1="{{ $activity->p_objective_q1 }}"
                                                        data-p_objective_q2="{{ $activity->p_objective_q2 }}"
                                                        data-p_objective_q3="{{ $activity->p_objective_q3 }}"
                                                        data-p_objective_q4="{{ $activity->p_objective_q4 }}"
                                                        data-p_objective_annual="{{ $activity->p_objective_annual }}"
                                                        data-execution_zone="{{ $activity->execution_zone }}"
                                                        data-company="{{ $activity->company }}"
                                                        data-ca_investment="{{ $activity->ca_investment }}"
                                                        data-ca_service="{{ $activity->ca_service }}"
                                                        data-ca_transfer="{{ $activity->ca_transfer }}"
                                                        data-ca_personal="{{ $activity->ca_personal }}"
                                                        data-ca_total="{{ $activity->ca_total }}"
                                                        data-entity="{{ $activity->entity }}"
                                                        data-observation="{{ $activity->observation }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @if(can('responsable-suivi-evaluation|assistant-suivi-evaluation'))
                                                    <button class="btn-action btn-edit update-activity-btn"
                                                        data-url="{{ route('budget-plans.budget-plan-activities.update', $activity) }}"
                                                        data-code="{{ $activity->code }}"
                                                        data-title="{{ $activity->title }}"
                                                        data-p_objective_q1="{{ $activity->p_objective_q1 }}"
                                                        data-p_objective_q2="{{ $activity->p_objective_q2 }}"
                                                        data-p_objective_q3="{{ $activity->p_objective_q3 }}"
                                                        data-p_objective_q4="{{ $activity->p_objective_q4 }}"
                                                        data-p_objective_annual="{{ $activity->p_objective_annual }}"
                                                        data-execution_zone="{{ $activity->execution_zone }}"
                                                        data-company="{{ $activity->company }}"
                                                        data-ca_investment="{{ $activity->ca_investment }}"
                                                        data-ca_service="{{ $activity->ca_service }}"
                                                        data-ca_transfer="{{ $activity->ca_transfer }}"
                                                        data-ca_personal="{{ $activity->ca_personal }}"
                                                        data-ca_total="{{ $activity->ca_total }}"
                                                        data-entity="{{ $activity->entity }}"
                                                        data-observation="{{ $activity->observation }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn-action btn-delete delete-activity-btn"
                                                        data-url="{{ route('budget-plans.budget-plan-activities.destroy', $activity) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="activity-details-row" style="display: none;"
                                            data-activity-id="{{ $activity->id }}">
                                            <td colspan="3">
                                                <div class="activity-details">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <h6 class="text-primary mb-3"><i
                                                                    class="fas fa-chart-line me-2"></i>Objectifs et
                                                                Période</h6>
                                                            <div class="activity-details-grid">
                                                                <div class="detail-item">
                                                                    <div class="detail-label">Objectifs Trimestriels
                                                                    </div>
                                                                    <div class="d-flex gap-2 flex-wrap">
                                                                        <span class="badge bg-secondary">T1:
                                                                            {{ $activity->p_objective_q1 ?? 'N/A' }}</span>
                                                                        <span class="badge bg-secondary">T2:
                                                                            {{ $activity->p_objective_q2 ?? 'N/A' }}</span>
                                                                        <span class="badge bg-secondary">T3:
                                                                            {{ $activity->p_objective_q3 ?? 'N/A' }}</span>
                                                                        <span class="badge bg-secondary">T4:
                                                                            {{ $activity->p_objective_q4 ?? 'N/A' }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <div class="detail-label">Objectif Annuel</div>
                                                                    <div class="amount">
                                                                        {{ $activity->p_objective_annual ?? 'N/A' }}
                                                                    </div>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <div class="detail-label">Zone d'exécution</div>
                                                                    <div>{{ $activity->execution_zone ?? 'N/A' }}</div>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <div class="detail-label">Structure responsable
                                                                    </div>
                                                                    <div>{{ $activity->company ?? 'N/A' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <h6 class="text-primary mb-3"><i
                                                                    class="fas fa-money-bill-wave me-2"></i>Coûts
                                                                Annuels (FCFA)</h6>
                                                            <div class="activity-details-grid">
                                                                <div class="detail-item">
                                                                    <div class="detail-label">Investissement</div>
                                                                    <div class="amount">
                                                                        {{ $activity->ca_investment ? number_format($activity->ca_investment) : 'N/A' }}
                                                                    </div>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <div class="detail-label">Biens & Services</div>
                                                                    <div class="amount">
                                                                        {{ $activity->ca_service ? number_format($activity->ca_service) : 'N/A' }}
                                                                    </div>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <div class="detail-label">Transfert</div>
                                                                    <div class="amount">
                                                                        {{ $activity->ca_transfer ? number_format($activity->ca_transfer) : 'N/A' }}
                                                                    </div>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <div class="detail-label">Personnel</div>
                                                                    <div class="amount">
                                                                        {{ $activity->ca_personal ? number_format($activity->ca_personal) : 'N/A' }}
                                                                    </div>
                                                                </div>
                                                                <div class="detail-item bg-primary text-white">
                                                                    <div class="detail-label text-white">TOTAL</div>
                                                                    <div class="fs-5 fw-bold">
                                                                        {{ $activity->ca_total ? number_format($activity->ca_total) : 'N/A' }}
                                                                        FCFA</div>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <div class="detail-label">Entité</div>
                                                                    <div>{{ $activity->entity ?? 'N/A' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($activity->observation)
                                                        <div class="mt-3 p-3 bg-light rounded">
                                                            <h6 class="text-muted mb-2"><i
                                                                    class="fas fa-comment-alt me-2"></i>Observation
                                                            </h6>
                                                            <p class="mb-0">{{ $activity->observation }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
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
                        Ajouter un Produit
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="add-subcomponent-form" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Titre du produit</label>
                            <input type="text" name="title" class="form-control" required>
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
                        Ajouter une Action
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="add-section-form" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Titre de l'action</label>
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

    <div class="modal fade" id="addActivityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Ajouter une Activité
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="add-activity-form" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <h6 class="text-primary mb-2">Informations
                                    générales</h6>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Titre de l'activité</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Indicateur</label>
                                <input type="text" name="code" class="form-control">
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-12">
                                <h6 class="text-primary mb-2">Objectifs</h6>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">T1</label>
                                <input type="text" name="p_objective_q1" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">T2</label>
                                <input type="text" name="p_objective_q2" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">T3</label>
                                <input type="text" name="p_objective_q3" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">T4</label>
                                <input type="text" name="p_objective_q4" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Objectif Annuel</label>
                                <input type="text" name="p_objective_annual" class="form-control">
                            </div>
                        </div>

                        <div class="row g-3 mt-1 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Zone d'exécution</label>
                                <input type="text" name="execution_zone" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Structure responsable</label>
                                <input type="text" name="company" class="form-control">
                            </div>
                        </div>

                        <div class="row g-3 my-3">
                            <div class="col-12">
                                <h6 class="text-primary mb-2">Coûts annuels
                                    (FCFA)</h6>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Investissement</label>
                                <input type="number" name="ca_investment" class="form-control" min="0">
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Biens & Services</label>
                                <input type="number" name="ca_service" class="form-control" min="0">
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Transfert</label>
                                <input type="number" name="ca_transfer" class="form-control" min="0">
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Personnel</label>
                                <input type="number" name="ca_personal" class="form-control" min="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Total</label>
                                <input type="number" name="ca_total" class="form-control" min="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Entité</label>
                                <input type="text" name="entity" class="form-control">
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-12">
                                <label class="form-label">Observation</label>
                                <textarea name="observation" class="form-control" rows="3" placeholder="Remarques ou observations..."></textarea>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">
                        Modifier
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

                        <div id="activity-fields" class="d-none">
                            <div class="row g-3 my-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-2">Informations
                                        générales</h6>
                                </div>
                                <div class="col-md-12">
                                    <label for="update-activity-code" class="form-label">Indicateur</label>
                                    <input type="text" class="form-control" id="update-activity-code"
                                        name="code">
                                </div>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-2">Objectifs</h6>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">T1</label>
                                    <input type="text" name="p_objective_q1" id="update-p_objective_q1"
                                        class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">T2</label>
                                    <input type="text" name="p_objective_q2" id="update-p_objective_q2"
                                        class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">T3</label>
                                    <input type="text" name="p_objective_q3" id="update-p_objective_q3"
                                        class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">T4</label>
                                    <input type="text" name="p_objective_q4" id="update-p_objective_q4"
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Objectif Annuel</label>
                                    <input type="text" name="p_objective_annual" id="update-p_objective_annual"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="row g-3 mt-1 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Zone d'exécution</label>
                                    <input type="text" name="execution_zone" id="update-execution_zone"
                                        class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Structure responsable</label>
                                    <input type="text" name="company" id="update-company" class="form-control">
                                </div>
                            </div>

                            <div class="row g-3 my-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-2">Coûts
                                        annuels (FCFA)</h6>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label class="form-label">Investissement</label>
                                    <input type="number" name="ca_investment" id="update-ca_investment"
                                        class="form-control" min="0">
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label class="form-label">Biens & Services</label>
                                    <input type="number" name="ca_service" id="update-ca_service"
                                        class="form-control" min="0">
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label class="form-label">Transfert</label>
                                    <input type="number" name="ca_transfer" id="update-ca_transfer"
                                        class="form-control" min="0">
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label class="form-label">Personnel</label>
                                    <input type="number" name="ca_personal" id="update-ca_personal"
                                        class="form-control" min="0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Total</label>
                                    <input type="number" name="ca_total" id="update-ca_total" class="form-control"
                                        min="0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Entité</label>
                                    <input type="text" name="entity" id="update-entity" class="form-control">
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-12">
                                    <label class="form-label">Observation</label>
                                    <textarea name="observation" id="update-observation" class="form-control" rows="3"></textarea>
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
            console.log('test')
            const addSubcomponentModal = new bootstrap.Modal(document.getElementById('addSubcomponentModal'));
            const addSectionModal = new bootstrap.Modal(document.getElementById('addSectionModal'));
            const addActivityModal = new bootstrap.Modal(document.getElementById('addActivityModal'));
            const updateModal = new bootstrap.Modal(document.getElementById('updateModal'));

            $('#add-component-form').on('submit', function(e) {
                e.preventDefault();
                submitForm($(this), 'Effet ajouté avec succès');
            });

            $(document).on('click', '.add-subcomponent-btn', function() {
                const url = $(this).data('url');
                $('#add-subcomponent-form').attr('action', url);
                addSubcomponentModal.show();
            });

            $('#add-subcomponent-form').on('submit', function(e) {
                e.preventDefault();
                submitForm($(this), 'Produit ajouté avec succès');
            });

            // Gestion des boutons d'ajout de action
            $(document).on('click', '.add-section-btn', function() {
                const url = $(this).data('url');
                $('#add-section-form').attr('action', url);
                addSectionModal.show();
            });

            // Gestion du formulaire d'ajout de action
            $('#add-section-form').on('submit', function(e) {
                e.preventDefault();
                submitForm($(this), 'Action ajoutée avec succès');
            });

            // Gestion des boutons d'ajout d'activité
            $(document).on('click', '.add-activity-btn', function() {
                const url = $(this).data('url');
                $('#add-activity-form').attr('action', url);
                addActivityModal.show();
            });

            // Gestion du formulaire d'ajout d'activité
            $('#add-activity-form').on('submit', function(e) {
                e.preventDefault();
                submitForm($(this), 'Activité ajoutée avec succès');
            });

            // Gestion des boutons de suppression
            $(document).on('click',
                '.delete-component-btn, .delete-subcomponent-btn, .delete-section-btn, .delete-activity-btn',
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

            $(document).on('click', '.update-activity-btn', function() {
                console.log($(this).data('url'))
                openUpdateModal({
                    url: $(this).data('url'),
                    code: $(this).data('code'),
                    title: $(this).data('title'),
                    p_objective_q1: $(this).data('p_objective_q1'),
                    p_objective_q2: $(this).data('p_objective_q2'),
                    p_objective_q3: $(this).data('p_objective_q3'),
                    p_objective_q4: $(this).data('p_objective_q4'),
                    p_objective_annual: $(this).data('p_objective_annual'),
                    execution_zone: $(this).data('execution_zone'),
                    company: $(this).data('company'),
                    ca_investment: $(this).data('ca_investment'),
                    ca_service: $(this).data('ca_service'),
                    ca_transfer: $(this).data('ca_transfer'),
                    ca_personal: $(this).data('ca_personal'),
                    ca_total: $(this).data('ca_total'),
                    entity: $(this).data('entity'),
                    observation: $(this).data('observation'),
                    type: 'activity'
                });
            });

            // Gestion du formulaire de modification
            $('#update-modal-form').on('submit', function(e) {
                e.preventDefault();
                submitForm($(this), 'Modification enregistrée avec succès');
            });

            // Fonction pour soumettre un formulaire
            function submitForm(form, successMessage) {
                console.log(form.serialize())
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
                // Réinitialiser les champs
                $('#update-modal-form').trigger('reset');
                $('#activity-fields').addClass('d-none');
                $('#amount-fields').addClass('d-none');

                // Remplir les champs selon le type
                $('#update-modal-form').attr('action', data.url);
                $('#update-title').val(data.title);

                if (data.amount) {
                    $('#amount-fields').removeClass('d-none');
                    $('#update-amount').val(data.amount);
                }

                if (data.type === 'activity') {
                    $('#activity-fields').removeClass('d-none');
                    $('#update-activity-form').attr('action', data.url);
                    $('#update-activity-code').val(data.code);
                    $('#update-p_objective_q1').val(data.p_objective_q1);
                    $('#update-p_objective_q2').val(data.p_objective_q2);
                    $('#update-p_objective_q3').val(data.p_objective_q3);
                    $('#update-p_objective_q4').val(data.p_objective_q4);
                    $('#update-p_objective_annual').val(data.p_objective_annual);
                    $('#update-execution_zone').val(data.execution_zone);
                    $('#update-company').val(data.company);
                    $('#update-ca_investment').val(data.ca_investment);
                    $('#update-ca_service').val(data.ca_service);
                    $('#update-ca_transfer').val(data.ca_transfer);
                    $('#update-ca_personal').val(data.ca_personal);
                    $('#update-ca_total').val(data.ca_total);
                    $('#update-entity').val(data.entity);
                    $('#update-observation').val(data.observation);
                }

                updateModal.show();
            }

            // Affichage des détails des activités
            $(document).on('click', '.show-activity-btn', function() {
                const activityId = $(this).data('activity-id');
                const detailsRow = $(`.activity-details-row[data-activity-id="${activityId}"]`);

                if (detailsRow.is(':visible')) {
                    detailsRow.slideUp(300);
                    $(this).html('<i class="fas fa-eye"></i>');
                } else {
                    // Fermer les autres détails ouverts
                    $('.activity-details-row:visible').slideUp(300);
                    $('.show-activity-btn').html('<i class="fas fa-eye"></i>');

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
