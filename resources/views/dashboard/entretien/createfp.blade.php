@extends('layouts.app')

@section('content')
<style>
    .select2-search__field{
        border: 1px solid #CED4DA !important;
        border-radius: 5px !important;
        padding: 15px 10px !important;
        width: 40vw !important;
    }
</style>
    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-plus-circle text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Entretiens</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center">
                <i class="bx bx-calendar-plus text-success fs-3 me-3"></i>
                <div>
                    <h5 class="mb-0 text-dark">Organisation d'un entretien</h5>
                    <small class="text-muted">
                        @if ($type == 'collectif')
                            Planification d'un entretien collectif
                        @else
                            Planification d'un entretien personnalisé
                        @endif
                    </small>
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
                                <h5 class="mb-0 text-dark">Informations de l'entretien</h5>
                                <small class="text-muted">
                                    @if ($type == 'collectif')
                                        Entretien collectif - Plusieurs candidats
                                    @else
                                        Entretien personnalisé - Un seul candidat
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <form class="row g-4" method="POST" action="{{ route('entretiens.storefp') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Date de l'entretien -->
                            <div class="col-12">
                                <label for="date" class="form-label fw-medium">
                                    <i class="bx bx-calendar text-primary me-1"></i>
                                    Date de tenue <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bx bx-calendar-event"></i>
                                    </span>
                                    <input type="date" 
                                           class="form-control form-control-lg @error('date') is-invalid @enderror" 
                                           id="date" 
                                           name="date" 
                                           value="{{ old('date') }}" 
                                           required />
                                    <input type="hidden" name="type" value="{{ $type }}" />
                                    <input type="hidden" name="parcours" value="fonction_public" />
                                </div>
                                @error('date')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-error-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Sélection des candidats -->
                            <div class="col-12">
                                @if ($type == 'collectif')
                                    <label class="form-label fw-medium">
                                        <i class="bx bx-group text-primary me-1"></i>
                                        Candidats participants <span class="text-danger"></span>
                                    </label>
                                    <select class="form-select select2 " 
                                            data-placeholder="Sélectionnez plusieurs candidats"
                                            id="candidats-select" 
                                            multiple 
                                            style="width: 20vh"
                                            name="candidatures[]"
                                            required>
                                        @foreach($candidats as $candidat)
                                            <option value="{{ $candidat->id }}">
                                                {{ $candidat->user->fullName() }} - {{ $candidat->user->mecano }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">
                                        <i class="bx bx-info-circle me-1"></i>
                                        Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs candidats
                                    </small>
                                @else
                                    <label class="form-label fw-medium">
                                        <i class="bx bx-user text-primary me-1"></i>
                                        Candidat à interviewer <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-select-lg select2" 
                                            data-placeholder="Sélectionnez un candidat"
                                            id="candidats-select" 
                                            name="candidatures[]"
                                            required>
                                        <option value="">Choisir un candidat</option>
                                        @foreach($candidats as $candidat)
                                            <option value="{{ $candidat->id }}">
                                                {{ $candidat->user->fullName() }} - {{ $candidat->user->mecano }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                                @error('candidatures')
                                    <div class="invalid-feedback d-block">
                                        <i class="bx bx-error-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Informations complémentaires -->
                            <div class="col-12">
                                <div class="bg-light p-3 rounded border">
                                    <h6 class="mb-2">
                                        <i class="bx bx-info-circle text-info me-1"></i>
                                        Informations sur l'entretien
                                    </h6>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <small class="text-muted">Type :</small>
                                            <p class="mb-1 fw-medium">
                                                @if ($type == 'collectif')
                                                    <i class="bx bx-group text-primary me-1"></i>
                                                    Entretien collectif
                                                @else
                                                    <i class="bx bx-user text-primary me-1"></i>
                                                    Entretien personnalisé
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted">Parcours :</small>
                                            <p class="mb-1 fw-medium">
                                                <i class="bx bx-briefcase text-primary me-1"></i>
                                                Fonction public
                                            </p>
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
                                    <a href="{{ route('entretiens.index', $type) }}" 
                                       class="btn btn-outline-danger btn-lg px-4">
                                        <i class="bx bx-x me-2"></i>
                                        Annuler
                                    </a>
                                    <button type="submit" 
                                            class="btn btn-primary btn-lg px-4">
                                        <i class="bx bx-save me-2"></i>
                                        Organiser l'entretien
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            $(document).ready(function() {
                // Initialisation de Select2 si disponible
                if ($.fn.select2) {
                    $('.select2').select2({
                        theme: 'bootstrap-5',
                        width: '100%'
                    });
                }

                // Script original pour la gestion des cohortes (si nécessaire)
                var cohortSelect = $('#cohortSelect');
                var candidateSelect = $('#candidateSelect');

                function populateCandidates(cohortId) {
                    $.ajax({
                        url: "/getCandidats",
                        data: { cohortId: cohortId },
                        success: function(data) {
                            candidateSelect.empty();

                            $.each(data, function(index, candidate) {
                                candidateSelect.append($('<option>').val(candidate.id).text(candidate.name));
                            });
                        }
                    });
                }

                if (cohortSelect.length) {
                    populateCandidates(cohortSelect.val());

                    cohortSelect.change(function() {
                        var cohortId = $(this).val();
                        populateCandidates(cohortId);
                    });
                }
            });
        </script>
    @endpush
@endsection