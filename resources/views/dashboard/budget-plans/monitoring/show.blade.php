@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            :root {
                --primary-color: #2563eb;
                --success-color: #16a34a;
                --danger-color: #dc2626;
                --warning-color: #f59e0b;
                --info-color: #0891b2;
                --dark-color: #111827;
                --component-bg: #e0f7ec;
                --subcomponent-bg: #e7f0fd;
                --section-bg: #fff7f0;
                --activity-bg: #FFFFFFFF;
            }

            .budget-header {
                background: linear-gradient(135deg, var(--dark-color) 0%, #1f2937 100%);
                color: white;
                padding: 2rem 0;
                margin-bottom: 2rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }

            .budget-header h1 {
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .add-component-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                margin-bottom: 2rem;
                overflow: hidden;
                transition: box-shadow 0.3s ease;
            }

            .add-component-card:hover {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }

            .add-component-header {
                background: var(--primary-color);
                color: white;
                padding: 1rem 1.5rem;
                font-weight: 600;
            }

            .budget-table-container {
                background: white;
                border-radius: 12px;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .budget-table {
                margin-bottom: 0;
            }

            .budget-table thead {
                background: var(--dark-color);
                color: white;
                position: sticky;
                top: 0;
                z-index: 10;
            }

            .budget-table th {
                font-weight: 600;
                padding: 1rem;
                white-space: nowrap;
                border: none;
            }

            .budget-table td {
                padding: 0.75rem 1rem;
                vertical-align: middle;
                border: none;
            }

            .component-row {
                background-color: var(--component-bg);
                border-left: 4px solid var(--success-color);
                font-weight: 600;
            }

            .subcomponent-row {
                background-color: var(--subcomponent-bg);
                border-left: 4px solid var(--primary-color);
            }

            .section-row {
                background-color: var(--section-bg);
                border-left: 4px solid var(--info-color);
            }

            .activity-row {
                background-color: var(--activity-bg);
                border-left: 4px solid #9ca3af;
            }

            .budget-table tbody tr {
                transition: all 0.2s ease;
                border-bottom: 1px solid #e5e7eb;
            }

            .budget-table tbody tr:hover {
                transform: translateX(4px);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .action-buttons {
                display: flex;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .btn-action {
                padding: 0.375rem 0.75rem;
                border-radius: 6px;
                font-size: 0.875rem;
                transition: all 0.2s ease;
                border: none;
                display: inline-flex;
                align-items: center;
                gap: 0.25rem;
            }

            .btn-action:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }

            .btn-edit {
                background: var(--warning-color);
                color: white;
            }

            .btn-delete {
                background: var(--danger-color);
                color: white;
            }

            .btn-add {
                background: var(--success-color);
                color: white;
            }

            .btn-view {
                background: var(--primary-color);
                color: white;
            }

            .activity-details {
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                padding: 1.5rem;
                margin: 0.5rem 1rem;
                box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .activity-details-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1rem;
            }

            .detail-item {
                padding: 0.75rem;
                background: #f9fafb;
                border-radius: 6px;
                border: 1px solid #e5e7eb;
            }

            .detail-label {
                font-weight: 600;
                color: #6b7280;
                font-size: 0.875rem;
                margin-bottom: 0.25rem;
            }

            .modal-content {
                border-radius: 12px;
                border: none;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            }

            .modal-header {
                color: white;
                border-radius: 12px 12px 0 0;
                border: none;
            }

            .modal-header .btn-close {
                filter: brightness(0) invert(1);
            }

            .form-control,
            .form-select {
                border-radius: 8px;
                border: 1px solid #e5e7eb;
                transition: all 0.2s ease;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            }

            .form-label {
                font-weight: 600;
                color: #374151;
                margin-bottom: 0.5rem;
            }

            @media (max-width: 768px) {
                .budget-table-container {
                    overflow-x: auto;
                }

                .budget-table {
                    min-width: 800px;
                }

                .action-buttons {
                    flex-direction: column;
                }

                .btn-action {
                    width: 100%;
                    justify-content: center;
                }

                .add-component-form {
                    flex-direction: column;
                }

                .add-component-form input,
                .add-component-form button {
                    width: 100%;
                }
            }

            .amount {
                font-weight: 600;
                color: var(--success-color);
            }

            .total-amount {
                font-size: 1.25rem;
                font-weight: 700;
                color: white;
            }

            .level-indicator {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .level-number {
                background: rgba(0, 0, 0, 0.1);
                padding: 0.25rem 0.5rem;
                border-radius: 4px;
                font-size: 0.875rem;
                font-weight: 600;
            }

            .loading {
                opacity: 0.6;
                pointer-events: none;
            }

            .swal2-container {
                z-index: 9999;
            }

            .indent-1 {
                padding-left: 2rem;
            }

            .indent-2 {
                padding-left: 3rem;
            }

            .indent-3 {
                padding-left: 4rem;
            }
        </style>
    @endpush

    <div class="budget-header">
        <div class="container">
            <h1>Détails suivi du plan : {{ $budgetPlan->name }}</h1>
            <p class="mb-0 opacity-75">
                <i class="fas fa-calendar-alt me-2"></i>Année : {{ $budgetPlan->year }}
                @if ($budgetPlan->description)
                    <span class="ms-3"><i class="fas fa-info-circle me-2"></i>{{ $budgetPlan->description }}</span>
                @endif
            </p>
        </div>
    </div>

    <div class="container">
        <div class="budget-table-container">
            <div class="table-responsive">
                <table class="table budget-table">
                    <thead>
                        <tr>
                            <th class="text-white" width="10%">N°</th>
                            <th class="text-white" width="40%">Désignation</th>
                            <th class="text-white" width="10%">Code</th>
                            <th class="text-white" width="15%">Total exécution</th>
                            <th class="text-white text-end" width="15%">
                                <div>Coût prévu</div>
                                <div class="total-amount">{{ amount($components->sum('amount'), true) }}</div>
                            </th>
                            <th class="text-white" width="20%">Actions</th>
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

                                <td class="text-end amount">{{ amount($component->amount, true) }}</td>
                                <td></td>
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

                                    <td class="text-end amount">{{ amount($subComponent->amount, true) }}</td>
                                    <td></td>
                                </tr>

                                @php $sectionIndex = 1; @endphp
                                @foreach ($subComponent->sections as $section)
                                    <tr data-id="{{ $section->id }}" class="section-row">
                                        <td>
                                            <span class="level-indicator">
                                                <span class="level-number">{{ "$componentIndex.$subComponentIndex.$sectionIndex" }}</span>
                                            </span>
                                        </td>
                                        <td class="indent-2">
                                            <i class="fas fa-angle-double-right me-2"></i>{{ $section->title }}
                                        </td>
                                        <td>{{ $section->code }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @php $activityIndex = 1; @endphp
                                    @foreach ($section->parts as $part)
                                        <tr data-id="{{ $part->id }}" class="activity-row">
                                            <td>
                                                <span class="level-indicator">
                                                    <span class="level-number">{{ "$componentIndex.$subComponentIndex.$sectionIndex.$activityIndex" }}</span>
                                                </span>
                                            </td>
                                            <td class="indent-3">
                                                <i class="fas fa-circle me-2 text-muted"
                                                    style="font-size: 0.5rem;"></i>{{ $part->title }}
                                            </td>
                                            <td>{{ $part->code }}</td>
                                            <td class="amount">
                                                {{ $part->total_execution ? amount($part->total_execution, true) : 'N/A' }}
                                            </td>
                                            <td class="text-end">{{ amount($part->cost_total_project, true) }}</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-action btn-view show-part-btn"
                                                        data-part-id="{{ $part->id }}" data-code="{{ $part->code }}"
                                                        data-title="{{ $part->title }}"
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
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @if(can('responsable-suivi-evaluation|assistant-suivi-evaluation'))
                                                        @if ($part->total_execution)
                                                            <button class="btn-action btn-edit add-execution-btn"
                                                                data-part-id="{{ $part->id }}"
                                                                data-part-code="{{ $part->code }}"
                                                                data-part-title="{{ $part->title }}"
                                                                data-current-execution="{{ $part->total_execution ?? 0 }}"
                                                                data-update-url="{{ route('budget-plans.budget-plan-parts.update_total_execution', $part) }}"
                                                                title="Modifier montant d'exécution"
                                                                data-title="Modifier le total d'exécution">
                                                                <i class="fas fa-edit"></i> Exécution
                                                            </button>
                                                        @else
                                                            <button class="btn-action btn-add add-execution-btn"
                                                                data-part-id="{{ $part->id }}"
                                                                data-part-code="{{ $part->code }}"
                                                                data-part-title="{{ $part->title }}"
                                                                data-current-execution="{{ $part->total_execution ?? 0 }}"
                                                                data-update-url="{{ route('budget-plans.budget-plan-parts.update_total_execution', $part) }}"
                                                                title="Ajouter montant d'exécution"
                                                                data-title="Ajouter le total d'exécution">
                                                                <i class="fas fa-plus"></i> Exécution
                                                            </button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="activity-details-row" style="display: none;"
                                            data-part-id="{{ $part->id }}">
                                            <td colspan="4">
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
                                                                @if ($part->percent_commitments)
                                                                    <span
                                                                        class="badge bg-info ms-2">{{ $part->percent_commitments }}%</span>
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
                                                            <div class="mt-1">
                                                                <strong>Total année:</strong> <span
                                                                    class="amount">{{ amount($part->cost_total_year ?? 0, true) }}</span>
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
                                                        <div class="detail-item bg-success text-white">
                                                            <div class="detail-label text-white">Montant d'Exécution</div>
                                                            <div class="fs-5 fw-bold execution-amount"
                                                                data-part-id="{{ $part->id }}">
                                                                {{ $part->total_execution ? amount($part->total_execution, true) : 'Non défini' }}
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

    <div class="modal fade" id="addExecutionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExecutionModalLabel">
                        <i class="fas fa-coins me-2"></i>Montant d'Exécution
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="executionForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Code :</label>
                            <div class="p-2 bg-light rounded">
                                <span id="modalPartCode" class="fw-semibold"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Titre :</label>
                            <div class="p-2 bg-light rounded">
                                <span id="modalPartTitle"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Montant d'exécution actuel :</label>
                            <div class="p-2 bg-success bg-opacity-10 rounded">
                                <span id="modalCurrentExecution" class="text-success fw-bold fs-5"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="totalExecution" class="form-label fw-bold">
                                Nouveau montant d'exécution (FCFA) :
                            </label>
                            <input type="number" class="form-control form-control-lg" id="totalExecution"
                                name="total_execution" min="0" required>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Saisissez le montant total d'exécution pour cette partie du budget.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-success" id="submitExecutionBtn">
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
            $('.show-part-btn').on('click', function() {
                const partId = $(this).data('part-id');
                const detailsRow = $(`.activity-details-row[data-part-id="${partId}"]`);

                if (detailsRow.is(':visible')) {
                    detailsRow.slideUp(300);
                    $(this).html('<i class="fas fa-eye"></i>');
                } else {
                    $('.activity-details-row:visible').slideUp(300);
                    $('.show-part-btn').html('<i class="fas fa-eye"></i>');

                    detailsRow.slideDown(300);
                    $(this).html('<i class="fas fa-eye-slash"></i>');
                }
            });

            $('.add-execution-btn').on('click', function() {
                const partId = $(this).data('part-id');
                const partCode = $(this).data('part-code');
                const partTitle = $(this).data('part-title');
                const title = $(this).data('title');
                const currentExecution = $(this).data('current-execution') || 0;
                const updateUrl = $(this).data('update-url');

                $('#addExecutionModalLabel').html('<i class="fas fa-coins me-2"></i>' + title);
                $('#modalPartCode').text(partCode);
                $('#modalPartTitle').text(partTitle);
                $('#modalCurrentExecution').text(Number(currentExecution).toLocaleString('fr-FR') +
                    ' FCFA');
                $('#totalExecution').val(currentExecution);
                $('#executionForm').attr('action', updateUrl);

                $('#addExecutionModal').modal('show');
            });

            $('#executionForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitBtn = $('#submitExecutionBtn');
                const originalBtnText = submitBtn.html();

                submitBtn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>Enregistrement...'
                );

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        $('#addExecutionModal').modal('hide');

                        ToastSuccess.fire({
                            icon: 'success',
                            title: response.message ||
                                'Montant d\'exécution mis à jour avec succès',
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'Une erreur est survenue lors de la mise à jour.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join('\n');
                        }

                        Swal.fire('Erreur!', errorMessage, 'error');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });

            $('#addExecutionModal').on('hidden.bs.modal', function() {
                $('#executionForm')[0].reset();
                $('#submitExecutionBtn').prop('disabled', false).html(
                    '<i class="fas fa-save me-2"></i>Enregistrer'
                );
            });

            $('.budget-table tbody tr').each(function(index) {
                $(this).css('opacity', '0').delay(index * 30).animate({
                    opacity: 1
                }, 300);
            });
        });
    </script>
@endsection
