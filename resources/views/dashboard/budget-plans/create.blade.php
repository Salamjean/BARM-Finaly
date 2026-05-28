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

            body {
                background-color: #f9fafb;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
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

            .form-container {
                max-width: 800px;
                margin: 0 auto;
            }

            .form-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                overflow: hidden;
                margin-bottom: 2rem;
            }

            .form-section {
                padding: 2rem;
                border-bottom: 1px solid #e5e7eb;
            }

            .form-section:last-child {
                border-bottom: none;
            }

            .section-title {
                font-weight: 700;
                color: #111827;
                margin-bottom: 1.5rem;
                font-size: 1.125rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .section-title i {
                color: var(--primary-color);
                font-size: 1.25rem;
            }

            .form-label {
                font-weight: 600;
                color: #374151;
                margin-bottom: 0.5rem;
                font-size: 0.875rem;
                text-transform: uppercase;
                letter-spacing: 0.025em;
            }

            .form-control,
            .form-select {
                border-radius: 8px;
                border: 2px solid #e5e7eb;
                transition: all 0.2s ease;
                padding: 0.75rem 1rem;
                font-size: 1rem;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
                outline: none;
            }

            textarea.form-control {
                resize: vertical;
                min-height: 120px;
            }

            .type-selection {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }

            .type-option {
                position: relative;
                cursor: pointer;
            }

            .type-option input[type="radio"] {
                position: absolute;
                opacity: 0;
            }

            .type-label {
                display: block;
                padding: 1rem;
                border: 2px solid #e5e7eb;
                border-radius: 8px;
                text-align: center;
                transition: all 0.2s ease;
                background: white;
            }

            .type-label:hover {
                border-color: var(--primary-color);
                background: #f0f9ff;
            }

            .type-option input[type="radio"]:checked+.type-label {
                border-color: var(--primary-color);
                background: var(--primary-color);
                color: white;
                font-weight: 600;
            }

            .year-input-container {
                position: relative;
            }

            .year-suggestion {
                position: absolute;
                right: 1rem;
                top: 50%;
                transform: translateY(-50%);
                font-size: 0.875rem;
                color: #6b7280;
                cursor: pointer;
                transition: color 0.2s ease;
            }

            .year-suggestion:hover {
                color: var(--primary-color);
            }

            .form-actions {
                padding: 2rem;
                background: #f9fafb;
                display: flex;
                gap: 1rem;
                justify-content: flex-end;
            }

            .btn-submit {
                background: var(--primary-color);
                color: white;
                border: none;
                padding: 0.75rem 2rem;
                border-radius: 8px;
                font-weight: 600;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .btn-submit:hover {
                background: #1d4ed8;
                transform: translateY(-2px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }

            .btn-cancel {
                background: white;
                color: #374151;
                border: 2px solid #e5e7eb;
                padding: 0.75rem 2rem;
                border-radius: 8px;
                font-weight: 600;
                transition: all 0.3s ease;
                text-decoration: none;
            }

            .btn-cancel:hover {
                border-color: #d1d5db;
                background: #f3f4f6;
            }

            .form-text {
                font-size: 0.875rem;
                color: #6b7280;
                margin-top: 0.5rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .form-text i {
                font-size: 1rem;
            }

            @media (max-width: 768px) {
                .budget-header {
                    padding: 2rem 1rem;
                }

                .budget-header h1 {
                    font-size: 1.75rem;
                }

                .form-section {
                    padding: 1.5rem;
                }

                .form-actions {
                    flex-direction: column-reverse;
                }

                .btn-submit,
                .btn-cancel {
                    width: 100%;
                    justify-content: center;
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

            .form-card {
                animation: fadeInUp 0.4s ease forwards;
            }

            .form-section {
                animation: fadeInUp 0.5s ease forwards;
                opacity: 0;
            }

            .form-section:nth-child(1) {
                animation-delay: 0.1s;
            }

            .form-section:nth-child(2) {
                animation-delay: 0.2s;
            }

            .form-section:nth-child(3) {
                animation-delay: 0.3s;
            }
        </style>
    @endpush

    @push('js-push')
    @endpush

    <div class="budget-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="fas fa-plus-circle me-3"></i>Créer un Plan Budgétaire</h1>
                    <p class="mb-0 opacity-75 mt-2">Définissez les paramètres de votre nouveau plan budgétaire</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <form action="{{ route('budget-plans.store') }}" method="POST" id="createBudgetForm">
                @csrf
                <div class="form-card">
                    <!-- Informations Générales -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Informations Générales
                        </h3>

                        <div class="mb-4">
                            <label class="form-label">Type de Plan</label>
                            <div class="type-selection">
                                <div class="type-option">
                                    <input type="radio" name="type" id="type_c2d" value="c2d" required checked>
                                    <label for="type_c2d" class="type-label">
                                        <i class="fas fa-file-contract mb-2 d-block fs-4"></i>
                                        C2D
                                    </label>
                                </div>
                                <div class="type-option">
                                    <input type="radio" name="type" id="type_memdef" value="memdef" required>
                                    <label for="type_memdef" class="type-label">
                                        <i class="fas fa-shield-alt mb-2 d-block fs-4"></i>
                                        MEMDEF
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label">Nom du Plan</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Ex: Plan Budgétaire 2024" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="year" class="form-label">Année</label>
                                <div class="year-input-container">
                                    <input type="number" name="year" id="year" class="form-control" min="2020"
                                        max="2030" value="{{ date('Y') }}" required>
                                    <span class="year-suggestion"
                                        onclick="document.getElementById('year').value = {{ date('Y') + 1 }}">
                                        Année suivante →
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="conversion_xof" class="form-label">Taux de Conversion (1€)</label>
                                <input type="text" name="conversion_xof" id="conversion_xof" class="form-control"
                                    placeholder="Ex: 655.957" required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i>
                                    Montant en XOF pour 1 Euro
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-align-left"></i>
                            Description
                        </h3>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description du Plan (Optionnel)</label>
                            <textarea name="description" id="description" class="form-control"
                                placeholder="Décrivez les objectifs et le contexte de ce plan budgétaire..."></textarea>
                            <div class="form-text">
                                <i class="fas fa-lightbulb"></i>
                                Une bonne description aide à mieux comprendre l'objectif du plan
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions">
                        <a href="{{ route('budget-plans.index') }}" class="btn-cancel">
                            <i class="fas fa-arrow-left me-2"></i>Annuler
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-check me-2"></i>Créer le Plan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('createBudgetForm');

            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('.btn-submit');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Création en cours...';
                submitBtn.disabled = true;
            });

            const conversionInput = document.getElementById('conversion_xof');
            conversionInput.addEventListener('blur', function() {
                const value = parseFloat(this.value);
                if (!isNaN(value)) {
                    this.value = value.toFixed(3);
                }
            });

            const yearInput = document.getElementById('year');
            yearInput.addEventListener('input', function() {
                const year = parseInt(this.value);
                const currentYear = new Date().getFullYear();

                if (year < currentYear - 5) {
                    this.setCustomValidity('L\'année ne peut pas être antérieure à ' + (currentYear - 5));
                } else if (year > currentYear + 10) {
                    this.setCustomValidity('L\'année ne peut pas être supérieure à ' + (currentYear + 10));
                } else {
                    this.setCustomValidity('');
                }
            });
        });
    </script>
@endsection
