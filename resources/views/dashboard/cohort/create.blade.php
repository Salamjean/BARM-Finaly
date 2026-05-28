@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-plus-circle text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Cohorte</div>
                            <h4 class="mb-0 text-primary">Ajouter une cohorte</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center">
                <i class="bx bx-bookmark-plus text-success fs-3 me-3"></i>
                <div>
                    <h5 class="mb-0 text-dark">Création d'une nouvelle cohorte</h5>
                    <small class="text-muted">Renseignez les informations de la cohorte</small>
                </div>
            </div>
        </div>

        <!-- Formulaire dans une carte moderne -->
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="bg-white rounded-3 shadow-sm">
                    <div class="border-bottom p-4">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-edit text-info fs-4 me-3"></i>
                            <div>
                                <h5 class="mb-0 text-dark">Informations de la cohorte</h5>
                                <small class="text-muted">Tous les champs marqués d'un * sont obligatoires</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <form class="row g-4" method="POST" action="{{ route('cohort.store') }}">
                            @csrf
                            
                            <div class="col-md-6">
                                <label for="title" class="form-label fw-medium">
                                    Libellé <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('title') is-invalid @enderror"
                                       id="title" 
                                       placeholder="Ex: Cohorte Juillet 2024" 
                                       name="title"
                                       value="{{ old('title') }}" 
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
                                       value="{{ old('number_adherent') }}" 
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
                                          placeholder="Description détaillée de la cohorte (optionnel)">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-error-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
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
                                        <i class="bx bx-check me-2"></i>
                                        Enregistrer
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