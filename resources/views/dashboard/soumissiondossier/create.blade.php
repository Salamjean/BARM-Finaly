@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush
    
    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-file-plus text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Soumissions de dossiers</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center">
                <i class="bx bx-plus-circle text-info fs-3 me-3"></i>
                <div>
                    <h5 class="mb-0 text-dark">Nouveau dépôt de dossier</h5>
                    <small class="text-muted">Création d'une soumission de dossier pour {{ $candidat->user->fullName() }}</small>
                </div>
            </div>
        </div>

        <!-- Formulaire organisé en sections -->
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <form class="row g-4" method="POST" action="{{ route('soumissiondossiers.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Section Candidat -->
                    <div class="col-12">
                        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="bx bx-user me-2"></i>
                                Informations du candidat
                            </h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Adhérent :</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" value="{{ $candidat->user->fullName() }}" disabled />
                                        <input type="hidden" name="candidature_id" value="{{ $candidat->id }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Premier Choix -->
                    <div class="col-12">
                        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                            <h6 class="text-warning mb-3">
                                <i class="bx bx-star me-2"></i>
                                Premier Choix de Concours
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Intitulé du concours :</label>
                                    <select class="form-select" name="intitule_concours1" onchange="toggleIntituleChoix1()" id="intitulechoix1">
                                        <option value="">-- Choisir un intitulé --</option>
                                        @foreach ($intituleconcours as $intituleconcour1)
                                            <option value="{{ $intituleconcour1->libelle }}">{{ $intituleconcour1->libelle }}</option>
                                        @endforeach
                                        <option value="otherintitulechoix1">✏️ Saisir un autre intitulé</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="otherintitulechoix1-div" style="display: none;">
                                    <label class="form-label">Intitulé personnalisé :</label>
                                    <input type="text" name="other_intitule_concours1" class="form-control" placeholder="Saisir l'intitulé du concours">
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Type du concours :</label>
                                    <select class="form-select" name="type_concours1" onchange="toggleTypeChoix1()" id="typechoix1">
                                        <option value="">-- Choisir un type --</option>
                                        @foreach ($typeconcours as $typeconcour1)
                                            <option value="{{ $typeconcour1->libelle }}">{{ $typeconcour1->libelle }}</option>
                                        @endforeach
                                        <option value="othertypechoix1">✏️ Saisir un autre type</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="othertypechoix1-div" style="display: none;">
                                    <label class="form-label">Type personnalisé :</label>
                                    <input type="text" name="other_type_concours1" class="form-control" placeholder="Saisir le type de concours">
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Date de dépôt de dossier :</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                        <input type="date" class="form-control @error('date1') is-invalid @enderror" 
                                               name="date1" value="{{ old('date1') }}" />
                                    </div>
                                    @error('date1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Deuxième Choix -->
                    <div class="col-12">
                        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                            <h6 class="text-secondary mb-3">
                                <i class="bx bx-star me-2"></i>
                                Deuxième Choix de Concours
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Intitulé du concours :</label>
                                    <select class="form-select" name="intitule_concours2" onchange="toggleIntituleChoix2()" id="intitulechoix2">
                                        <option value="">-- Choisir un intitulé --</option>
                                        @foreach ($intituleconcours as $intituleconcour2)
                                            <option value="{{ $intituleconcour2->libelle }}">{{ $intituleconcour2->libelle }}</option>
                                        @endforeach
                                        <option value="otherintitulechoix2">✏️ Saisir un autre intitulé</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="otherintitulechoix2-div" style="display: none;">
                                    <label class="form-label">Intitulé personnalisé :</label>
                                    <input type="text" name="other_intitule_concours2" class="form-control" placeholder="Saisir l'intitulé du concours">
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Type du concours :</label>
                                    <select class="form-select" name="type_concours2" onchange="toggleTypeChoix2()" id="typechoix2">
                                        <option value="">-- Choisir un type --</option>
                                        @foreach ($typeconcours as $typeconcour2)
                                            <option value="{{ $typeconcour2->libelle }}">{{ $typeconcour2->libelle }}</option>
                                        @endforeach
                                        <option value="othertypechoix2">✏️ Saisir un autre type</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="othertypechoix2-div" style="display: none;">
                                    <label class="form-label">Type personnalisé :</label>
                                    <input type="text" name="other_type_concours2" class="form-control" placeholder="Saisir le type de concours">
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Date de dépôt de dossier :</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                        <input type="date" class="form-control @error('date2') is-invalid @enderror" 
                                               name="date2" value="{{ old('date2') }}" />
                                    </div>
                                    @error('date2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="col-12">
                        <div class="bg-white rounded-3 shadow-sm p-4">
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('soumissiondossiers.index', $candidat->id) }}" class="btn btn-outline-secondary px-4">
                                    <i class="bx bx-x me-1"></i>
                                    Annuler
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bx bx-check me-1"></i>
                                    Enregistrer le dossier
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            function toggleIntituleChoix1() {
                var select = document.getElementById('intitulechoix1');
                var other = document.getElementById('otherintitulechoix1-div');
                if (select.value === 'otherintitulechoix1') {
                    other.style.display = 'block';
                    other.querySelector('input').setAttribute('required', 'required');
                } else {
                    other.style.display = 'none';
                    other.querySelector('input').removeAttribute('required');
                }
            }

            function toggleIntituleChoix2() {
                var select = document.getElementById('intitulechoix2');
                var other = document.getElementById('otherintitulechoix2-div');
                if (select.value === 'otherintitulechoix2') {
                    other.style.display = 'block';
                    other.querySelector('input').setAttribute('required', 'required');
                } else {
                    other.style.display = 'none';
                    other.querySelector('input').removeAttribute('required');
                }
            }

            function toggleTypeChoix1() {
                var select = document.getElementById('typechoix1');
                var other = document.getElementById('othertypechoix1-div');
                if (select.value === 'othertypechoix1') {
                    other.style.display = 'block';
                    other.querySelector('input').setAttribute('required', 'required');
                } else {
                    other.style.display = 'none';
                    other.querySelector('input').removeAttribute('required');
                }
            }

            function toggleTypeChoix2() {
                var select = document.getElementById('typechoix2');
                var other = document.getElementById('othertypechoix2-div');
                if (select.value === 'othertypechoix2') {
                    other.style.display = 'block';
                    other.querySelector('input').setAttribute('required', 'required');
                } else {
                    other.style.display = 'none';
                    other.querySelector('input').removeAttribute('required');
                }
            }

            $(document).ready(function() {
                var cohortSelect = $('#cohortSelect');
                var candidateSelect = $('#candidateSelect');

                function populateCandidates(cohortId) {
                    $.ajax({
                        url: "/getCandidats",
                        data: {
                            cohortId: cohortId
                        },
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