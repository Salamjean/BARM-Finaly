@extends('layouts.app')

@section('content')
    @push('css-push')
        <style>
            :root {
                --primary-color: #2563eb;
                --success-color: #16a34a;
                --danger-color: #dc2626;
                --warning-color: #f59e0b;
                --info-color: #0891b2;
                --dark-color: #111827;
            }

            .budget-header {
                background: linear-gradient(135deg, var(--dark-color) 0%, #1f2937 100%);
                color: white;
                padding: 3rem 0;
                margin: 0rem -12px 2rem -12px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }

            .budget-header h1 {
                font-weight: 700;
                margin-bottom: 0;
                font-size: 2.5rem;
            }

            .btn-new-plan {
                background: var(--primary-color);
                color: white;
                border: none;
                padding: 0.75rem 1.5rem;
                border-radius: 8px;
                font-weight: 600;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .btn-new-plan:hover {
                background: #1d4ed8;
                transform: translateY(-2px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }

            .budget-table-container {
                background: white;
                border-radius: 12px;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                overflow: hidden;
                margin-top: 2rem;
            }

            .budget-table {
                margin-bottom: 0;
            }

            .budget-table thead {
                background: #f3f4f6;
                border-bottom: 2px solid #e5e7eb;
            }

            .budget-table th {
                font-weight: 700;
                color: #374151;
                padding: 1rem 1.5rem;
                text-transform: uppercase;
                font-size: 0.875rem;
                letter-spacing: 0.05em;
                border: none;
            }

            .budget-table td {
                padding: 1rem 1.5rem;
                vertical-align: middle;
                border: none;
                color: #1f2937;
            }

            .budget-table tbody tr {
                transition: all 0.2s ease;
                border-bottom: 1px solid #f3f4f6;
            }

            .budget-table tbody tr:hover {
                background-color: #f9fafb;
                transform: translateX(4px);
            }

            .status-badge {
                padding: 0.375rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.875rem;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 0.375rem;
            }

            .status-badge.pending {
                background-color: #fef3c7;
                color: #92400e;
            }

            .status-badge.approved {
                background-color: #d1fae5;
                color: #065f46;
            }

            .type-badge {
                background: var(--dark-color);
                color: white;
                padding: 0.25rem 0.75rem;
                border-radius: 6px;
                font-size: 0.75rem;
                font-weight: 700;
                letter-spacing: 0.05em;
            }

            .action-buttons {
                display: flex;
                gap: 0.5rem;
                justify-content: flex-end;
                flex-wrap: wrap;
            }

            .btn-action {
                padding: 0.5rem 1rem;
                border-radius: 6px;
                font-size: 0.875rem;
                font-weight: 600;
                transition: all 0.2s ease;
                border: none;
                display: inline-flex;
                align-items: center;
                gap: 0.375rem;
            }

            .btn-action:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }

            .btn-view {
                background: var(--info-color);
                color: white;
            }

            .btn-edit {
                background: var(--warning-color);
                color: white;
            }

            .btn-export {
                background: var(--primary-color);
                color: white;
            }

            .btn-delete {
                background: var(--danger-color);
                color: white;
            }

            .year-badge {
                background: #e5e7eb;
                color: #374151;
                padding: 0.375rem 0.75rem;
                border-radius: 6px;
                font-weight: 600;
                font-size: 0.875rem;
            }

            .conversion-rate {
                font-family: 'Monaco', 'Courier New', monospace;
                background: #f3f4f6;
                padding: 0.25rem 0.5rem;
                border-radius: 4px;
                font-size: 0.875rem;
                color: #059669;
                font-weight: 600;
            }

            .plan-name {
                font-weight: 600;
                color: #111827;
                font-size: 1rem;
            }

            .empty-state {
                text-align: center;
                padding: 4rem 2rem;
                color: #6b7280;
            }

            .empty-state i {
                font-size: 4rem;
                margin-bottom: 1rem;
                opacity: 0.3;
            }

            @media (max-width: 768px) {
                .budget-header {
                    padding: 2rem 1rem;
                }

                .budget-header h1 {
                    font-size: 1.75rem;
                }

                .action-buttons {
                    flex-direction: column;
                }

                .btn-action {
                    width: 100%;
                    justify-content: center;
                }

                .budget-table-container {
                    overflow-x: auto;
                }

                .budget-table {
                    min-width: 800px;
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .budget-table tbody tr {
                animation: fadeInUp 0.3s ease forwards;
                opacity: 0;
            }

            .budget-table tbody tr:nth-child(1) { animation-delay: 0.05s; }
            .budget-table tbody tr:nth-child(2) { animation-delay: 0.1s; }
            .budget-table tbody tr:nth-child(3) { animation-delay: 0.15s; }
            .budget-table tbody tr:nth-child(4) { animation-delay: 0.2s; }
            .budget-table tbody tr:nth-child(5) { animation-delay: 0.25s; }
            .budget-table tbody tr:nth-child(6) { animation-delay: 0.3s; }
            .budget-table tbody tr:nth-child(7) { animation-delay: 0.35s; }
            .budget-table tbody tr:nth-child(8) { animation-delay: 0.4s; }
            .budget-table tbody tr:nth-child(9) { animation-delay: 0.45s; }
            .budget-table tbody tr:nth-child(10) { animation-delay: 0.5s; }
        </style>
    @endpush
    
    @push('js-push')
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

    <div class="budget-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="fas fa-chart-pie me-3"></i>Plans Budgétaires</h1>
                    <p class="mb-0 opacity-75 mt-2">Gérez vos plans budgétaires et suivez leur progression</p>
                </div>
                @if(can('responsable-suivi-evaluation|assistant-suivi-evaluation'))
                    <a href="{{ route('budget-plans.create') }}" class="btn-new-plan">
                        <i class="fas fa-plus-circle"></i>
                        Nouveau Plan
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="container">
        <div class="budget-table-container">
            @if($budgetPlans->count() > 0)
                <table class="table budget-table">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Type</th>
                            <th width="30%">Nom du Plan</th>
                            <th width="10%">Année</th>
                            <th width="15%">Taux (1€)</th>
                            <th width="20%" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($budgetPlans as $plan)
                            <tr>
                                <td>
                                    <span class="fw-bold text-muted">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <span class="type-badge">{{ strtoupper($plan->type) }}</span>
                                </td>
                                <td>
                                    <span class="plan-name">{{ $plan->name }}</span>
                                </td>
                                <td>
                                    <span class="year-badge">
                                        <i class="fas fa-calendar me-1"></i>{{ $plan->year }}
                                    </span>
                                </td>
                                <td>
                                    <span class="conversion-rate">
                                        {{ $plan->conversion_xof }} FCFA
                                    </span>
                                </td>
                                
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('budget-plans.show', $plan) }}" class="btn btn-action btn-view">
                                            <i class="fas fa-eye"></i>
                                            <span class="d-none d-md-inline">Voir</span>
                                        </a>
                                        @if(can('responsable-suivi-evaluation|assistant-suivi-evaluation'))
                                            <a href="{{ route('budget-plans.edit', $plan) }}" class="btn btn-action btn-edit">
                                                <i class="fas fa-edit"></i>
                                                <span class="d-none d-md-inline">Modifier</span>
                                            </a>
                                            <a href="{{ route('budget-plans.export', $plan) }}" class="btn btn-action btn-export">
                                                <i class="fas fa-file-excel"></i>
                                                <span class="d-none d-md-inline">Excel</span>
                                            </a>
                                            <form action="{{ route('budget-plans.destroy', $plan) }}" method="POST" class="delete-form" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-action btn-delete delete-btn">
                                                    <i class="fas fa-trash"></i>
                                                    <span class="d-none d-md-inline">Supprimer</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h3>Aucun plan budgétaire</h3>
                    <p>Commencez par créer votre premier plan budgétaire</p>
                    <a href="{{ route('budget-plans.create') }}" class="btn-new-plan mt-3">
                        <i class="fas fa-plus-circle"></i>
                        Créer un plan
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    
                    Swal.fire({
                        title: 'Êtes-vous sûr?',
                        text: "Cette action est irréversible! Tous les éléments liés seront supprimés.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Oui, supprimer!',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            @if(session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#16a34a",
                    stopOnFocus: true,
                }).showToast();
            @endif
        });
    </script>
@endsection