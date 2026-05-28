@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-edit text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Cohorte</div>
                            <h4 class="mb-0 text-primary">Édition de cohorte</h4>
                            <small class="text-muted">{{ $cohort->title }}</small>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-bookmark-alt text-warning fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Modification de la cohorte</h5>
                        <small class="text-muted">Modifiez les informations de {{ $cohort->title }}</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $cohort->reference }}
                        </div>
                        <small class="text-muted d-block">Référence</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $cohort->adhrents->count() ?? 0 }}
                        </div>
                        <small class="text-muted d-block">Adhérents</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire dans une carte moderne -->
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="bg-white rounded-3 shadow-sm">
                    <div class="border-bottom p-4">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-form text-info fs-4 me-3"></i>
                            <div>
                                <h5 class="mb-0 text-dark">Informations de la cohorte</h5>
                                <small class="text-muted">Tous les champs marqués d'un * sont obligatoires</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <form class="row g-4" method="POST" action="{{ route('cohort.update', $cohort->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="col-md-6">
                                <label for="title" class="form-label fw-medium">
                                    Libellé <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('title') is-invalid @enderror"
                                       id="title" 
                                       placeholder="Ex: Cohorte Juillet 2024" 
                                       name="title"
                                       value="{{ old('title', $cohort->title) }}" 
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-error-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="number_adherent" class="form-label fw-medium">
                                    Nombre de participants <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control form-control-lg @error('number_adherent') is-invalid @enderror"
                                       id="number_adherent" 
                                       min="1" 
                                       placeholder="Ex: 25"
                                       name="number_adherent"
                                       value="{{ old('number_adherent', $cohort->number_adherent) }}" 
                                       required>
                                @error('number_adherent')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-error-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="form-label fw-medium">
                                    Description
                                </label>
                                <textarea name="description" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          id="description"
                                          rows="4"
                                          placeholder="Description détaillée de la cohorte (optionnel)">{{ old('description', $cohort->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-error-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Informations supplémentaires -->
                            <div class="col-12">
                                <div class="bg-light rounded-3 p-3">
                                    <h6 class="text-muted mb-2">
                                        <i class="bx bx-info-circle me-1"></i>
                                        Informations de création
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">Créée le : {{ $cohort->created_at->format('d/m/Y à H:i') }}</small>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted">Dernière modification : {{ $cohort->updated_at->format('d/m/Y à H:i') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Séparateur -->
                            <div class="col-12">
                                <hr class="my-4">
                            </div>

                            <!-- Boutons d'action -->
                            <div class="col-12">
                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="{{ route('cohort.index') }}" 
                                       class="btn btn-outline-danger btn-lg px-4">
                                        <i class="bx bx-x me-2"></i>
                                        Annuler
                                    </a>
                                    <button type="submit" 
                                            class="btn btn-primary btn-lg px-4">
                                        <i class="bx bx-save me-2"></i>
                                        Enregistrer les modifications
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection