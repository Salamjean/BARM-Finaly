@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css" rel="stylesheet" />
    @endpush
    
    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-user-pin text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Administration</div>
                            <h4 class="mb-0 text-primary">Gestion des Retraités</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec boutons d'action -->
        @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
            <div class="bg-white p-4 rounded-3 shadow-none mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-group text-success fs-3 me-3"></i>
                        <div>
                            <h5 class="mb-0 text-dark">Base de données des retraités</h5>
                            <small class="text-muted">Gestion complète des dossiers</small>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button data-bs-toggle="modal" data-bs-target="#addModal" class="addBtn btn btn-success d-flex align-items-center">
                            <i class="bx bx-plus me-2"></i>
                            Ajout de retraité
                        </button>
                        <a href="{{ route('excel.upload.adherent_list') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="bx bx-upload me-2"></i>
                            Importer une liste
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Alertes et indicateurs -->
        <div id="error-alert" class="alert alert-danger d-none mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bx bx-error-circle fs-4 me-3"></i>
                <div>
                    <strong>Erreur!</strong> <span id="error-message"></span>
                </div>
            </div>
        </div>

        <div id="loading-indicator" class="bg-white p-5 rounded-3 shadow-sm text-center">
            <div class="spinner-border text-primary mb-3" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p class="mb-0 text-muted">Chargement des données...</p>
        </div>

        <!-- Tableau principal -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table table-hover" id="datatable--barm">
                        <thead>
                            <tr class="table-primary">
                                <th class="border-0">
                                    <i class="bx bx-calendar text-primary me-1"></i>
                                    ANNÉE
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-award text-primary me-1"></i>
                                    GRADE
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-id-card text-primary me-1"></i>
                                    MECANO
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-hash text-primary me-1"></i>
                                    MATRICULE
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    NOM
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    PRÉNOMS
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-cake text-primary me-1"></i>
                                    DATE DE NAISSANCE
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-male-female text-primary me-1"></i>
                                    GENRE
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-building text-primary me-1"></i>
                                    UNITÉ
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-shield text-primary me-1"></i>
                                    ARMÉE
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-calendar-check text-primary me-1"></i>
                                    DATE DE RETRAITE
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-bookmark text-primary me-1"></i>
                                    TYPE DE RETRAITE
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-check-circle text-primary me-1"></i>
                                    STATUT
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-file-doc text-primary me-1"></i>
                                    AUTORISATION
                                </th>
                                @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                                    <th class="border-0 text-center">
                                        <i class="bx bx-cog text-primary me-1"></i>
                                        ACTIONS
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

  <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajout de retaité</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('retired.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="mecano" class="form-label">Mecano<span class="text-danger">*</span>
                                    :
                                </label>
                                <input type="text" class="form-control @error('mecano') is-invalid @enderror"
                                    id="mecano" name="mecano" value="{{ old('mecano') }}" required>
                                @error('mecano')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="matricule" class="form-label">Matricule
                                    :
                                </label>
                                <input type="text" class="form-control @error('matricule') is-invalid @enderror"
                                    id="matricule" name="matricule" value="{{ old('matricule') }}">
                                @error('matricule')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="army">Armée ou Arme<span class="text-danger">*</span></label>
                                <select name="army" id="army"
                                    class="form-control select2 @error('army') is-invalid @enderror" required>
                                    <option selected disabled>Selectionner</option>
                                    <option value="Terre">Terre</option>
                                    <option value="Air">Air</option>
                                    <option value="Force Spéciale">Force Spéciale</option>
                                    <option value="Autre">Autre</option>
                                    <option value="Marine Nationale">Marine Nationale</option>
                                    <option value="Gendarmerie Nationale">Gendarmerie Nationale</option>
                                </select>
                                @error('army')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="grade">Grade<span class="text-danger">*</span></label>
                                <select id="grade" name="grade" class="select2" required>
                                    <option value="">Sélectionnez un grade</option>
                                </select>
                                @error('grade')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="firstname" class="form-label">Nom <span class="text-danger">*</span>
                                    :
                                </label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                    id="firstname" name="firstname" value="{{ old('firstname') }}" required>
                                @error('firstname')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastname" class="form-label">Prénoms <span class="text-danger">*</span>
                                    :
                                </label>
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                    id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                                @error('lastname')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Date de naissance<span
                                        class="text-danger">*</span>
                                    :
                                </label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                    id="birth_date" max="{{ Carbon\Carbon::now()->subYears(20)->format('Y-m-d') }}"
                                    name="birth_date" value="{{ old('birth_date') }}" min="1" required>
                                @error('birth_date')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Genre<span class="text-danger">*</span>
                                    :
                                </label>
                                <select name="gender" class=" form-select" id="gender" required>
                                    <option selected disabled>Selectionner</option>
                                    <option value="F">Feminin</option>
                                    <option value="M">Masculin</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="retired_type">TYPE DE RETRAITE <span
                                            class="text-danger">*</span>
                                        :</label>
                                    <div class="input-group">
                                        <select name="retired_type" id="retired_type"
                                            class="form-control  @error('retired_type') is-invalid @enderror" required>
                                            <option value="" selected disabled>Selectionner</option>
                                            @foreach (DEPARTURE_CONDITIONS as $condition)
                                                <option value="{{ $condition }}">{{ $condition }}</option>
                                            @endforeach
                                        </select>
                                        @error('retired_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="unit" class="form-label">Unité <span class="text-danger">*</span>:
                                </label>
                                <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                    id="unit" name="unit" value="{{ old('unit') }}" required>
                                @error('unit')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="retired_date" class="form-label">Date de rétraite<span
                                        class="text-danger">*</span>
                                    :
                                </label>
                                <input type="date" class="form-control @error('retired_date') is-invalid @enderror"
                                    id="retired_date" {{-- min="{{ Carbon\Carbon::now()->subYears(2)->format('Y-m-d') }}" --}} max="{{ date('Y-m-d') }}"
                                    name="retired_date" value="{{ old('retired_date') }}" min="1" required>
                                @error('retired_date')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edition de retraité</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="mecano" class="form-label">Mecano<span
                                        class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('mecano') is-invalid @enderror"
                                    id="mecano" name="mecano" value="{{ old('mecano') }}" required>
                                @error('mecano')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="matricule" class="form-label">Matricule:</label>
                                <input type="text" class="form-control @error('matricule') is-invalid @enderror"
                                    id="matricule" name="matricule" value="{{ old('matricule') }}">
                                @error('matricule')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="army-edit">Armée ou Arme<span class="text-danger">*</span></label>
                                <select name="army" id="army-edit"
                                    class="form-control select2 @error('army') is-invalid @enderror" required>
                                    <option selected disabled>Selectionner</option>
                                    <option value="Terre">Terre</option>
                                    <option value="Air">Air</option>
                                    <option value="Force Spéciale">Force Spéciale</option>
                                    <option value="Autre">Autre</option>
                                    <option value="Marine Nationale">Marine Nationale</option>
                                    <option value="Gendarmerie Nationale">Gendarmerie Nationale</option>
                                </select>
                                @error('army')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="grade-edit">Grade<span class="text-danger">*</span></label>
                                <select id="grade-edit" name="grade" class="select2" required>
                                    <option value="">Sélectionnez un grade</option>
                                </select>
                                @error('grade')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="firstname" class="form-label">Nom <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                    id="firstname" name="firstname" value="{{ old('firstname') }}" required>
                                @error('firstname')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastname" class="form-label">Prénoms <span
                                        class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                    id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                                @error('lastname')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Date de naissance<span
                                        class="text-danger">*</span>:</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                    id="birth_date" max="{{ Carbon\Carbon::now()->subYears(20)->format('Y-m-d') }}"
                                    name="birth_date" value="{{ old('birth_date') }}" min="1" required>
                                @error('birth_date')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Genre<span class="text-danger">*</span>:</label>
                                <select name="gender" class=" form-select" id="gender" required>
                                    <option selected disabled>Selectionner</option>
                                    <option value="F">Feminin</option>
                                    <option value="M">Masculin</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="retired_type">TYPE DE RETRAITE <span
                                            class="text-danger">*</span>:</label>
                                    <div class="input-group">
                                        <select name="retired_type" id="retired_type"
                                            class="form-control  @error('retired_type') is-invalid @enderror" required>
                                            <option value="" selected disabled>Selectionner</option>
                                            @foreach (DEPARTURE_CONDITIONS as $condition)
                                                <option value="{{ $condition }}">{{ $condition }}</option>
                                            @endforeach
                                        </select>
                                        @error('retired_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="unit" class="form-label">Unité <span
                                        class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                    id="unit" name="unit" value="{{ old('unit') }}" required>
                                @error('unit')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="retired_date" class="form-label">Date de retraite<span
                                        class="text-danger">*</span>:</label>
                                <input type="date" class="form-control @error('retired_date') is-invalid @enderror"
                                    id="retired_date" max="{{ date('Y-m-d') }}" name="retired_date"
                                    value="{{ old('retired_date') }}" min="1" required>
                                @error('retired_date')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="editAuthModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajout de document justificatif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="mecano" class="form-label">Mecano <span class="text-danger">*</span>
                                    :
                                </label>
                                <input type="text" class="form-control @error('mecano') is-invalid @enderror"
                                    id="mecano" name="mecano" value="{{ old('mecano') }}">
                                @error('mecano')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="firstname" class="form-label">Nom <span class="text-danger">*</span>
                                    :
                                </label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                    id="firstname" name="firstname" value="{{ old('firstname') }}" disabled>
                                @error('firstname')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastname" class="form-label">Prénoms <span class="text-danger">*</span>
                                    :
                                </label>
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                    id="lastname" name="lastname" value="{{ old('lastname') }}" disabled>
                                @error('lastname')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="file_authorization" class="form-label">Document d&apos;autorisation <span
                                        class="text-danger">*</span>:
                                </label>
                                <input type="file" accept=".pdf"
                                    class="form-control @error('file_authorization') is-invalid @enderror"
                                    id="file_authorization" name="file_authorization"
                                    value="{{ old('file_authorization') }}" required>
                                @error('file_authorization')
                                    <span class="invalid-feedback" besoin="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            $(document).ready(function() {

                function showError(message) {
                    $('#error-message').text(message);
                    $('#error-alert').removeClass('d-none');
                    $('#loading-indicator').addClass('d-none');
                }

                function hideLoading() {
                    $('#loading-indicator').addClass('d-none');
                }

                const grades = {
                    'Terre': [
                        'Soldat 2e classe', 'Soldat 1ère classe', 'Caporal', 'Caporal-Chef',
                        'Sergent', 'Sergent-Chef', 'Adjudant', 'Adjudant-Chef',
                        'Adjudant-Chef Major', 'Lieutenant', 'Capitaine', 'Commandant',
                        'Lieutenant-Colonel', 'Colonel', 'Colonel-Major', 'Général de Brigade',
                        'Général de Division', 'Général de Corps d\'Armée', 'Général d\'Armée'
                    ],
                    'Air': [
                        'Soldat 2e classe', 'Soldat 1ère classe', 'Caporal', 'Caporal-Chef',
                        'Sergent', 'Sergent-Chef', 'Adjudant', 'Adjudant-Chef',
                        'Adjudant-Chef Major', 'Lieutenant', 'Capitaine', 'Commandant',
                        'Lieutenant-Colonel', 'Colonel', 'Colonel-Major', 'Général de Brigade',
                        'Général de Division', 'Général de Corps d\'Armée', 'Général d\'Armée'
                    ],
                    'Force Spéciale': [
                        'Soldat 2e classe', 'Soldat 1ère classe', 'Caporal', 'Caporal-Chef',
                        'Sergent', 'Sergent-Chef', 'Adjudant', 'Adjudant-Chef',
                        'Adjudant-Chef Major', 'Lieutenant', 'Capitaine', 'Commandant',
                        'Lieutenant-Colonel', 'Colonel', 'Colonel-Major', 'Général de Brigade',
                        'Général de Division', 'Général de Corps d\'Armée', 'Général d\'Armée'
                    ],
                    'Autre': [
                        'Soldat 2e classe', 'Soldat 1ère classe', 'Caporal', 'Caporal-Chef',
                        'Sergent', 'Sergent-Chef', 'Adjudant', 'Adjudant-Chef',
                        'Adjudant-Chef Major', 'Lieutenant', 'Capitaine', 'Commandant',
                        'Lieutenant-Colonel', 'Colonel', 'Colonel-Major', 'Général de Brigade',
                        'Général de Division', 'Général de Corps d\'Armée', 'Général d\'Armée'
                    ],
                    'Marine Nationale': [
                        'Matelot 1e classe', 'Quartier Maître 2e classe', 'Quartier Maître 1e classe',
                        'Second-Maître', 'Maître', 'Premier Maître', 'Maître-Principal',
                        'Maître-Principal Major', 'Enseigne de vaisseau de 1e Classe',
                        'Lieutenant de Vaisseau', 'Capitaine de Corvette', 'Capitaine de Fregate',
                        'Capitaine de Vaisseau', 'Capitaine de Vaisseau Major', 'Contre-Amiral',
                        'Vice-Amiral', 'Vice-Amiral d\'Escadre', 'Amiral'
                    ],
                    'Gendarmerie Nationale': [
                        'MDL', 'MDL Chef', 'Adjudant', 'Adjudant-Chef', 'Adjudant-Chef Major',
                        'Lieutenant', 'Capitaine', 'Commandant', 'Lieutenant-Colonel', 'Colonel',
                        'Colonel-Major', 'Général de brigade', 'Général de division',
                        'Général de corps d\'armée', 'Général d\'Armée'
                    ]
                };

                

                const datatableUrl = '{{ route('retired.datatables') }}';

                $.ajax({
                    url: datatableUrl,
                    type: 'GET',
                    data: {
                        test: true
                    },
                    timeout: 20000, // 10 secondes timeout
                    beforeSend: function() {
                        console.log('Test de connectivité à l\'endpoint...');
                    }
                }).done(function(response) {
                    initializeDataTable();
                }).fail(function(xhr, status, error) {
                    console.error('✗ Endpoint inaccessible:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        error: error,
                        responseText: xhr.responseText
                    });
                    showError('Impossible de se connecter au serveur. Vérifiez votre connexion et la route.');
                });

                function initializeDataTable() {
                    if ($.fn.DataTable.isDataTable('#datatable--barm')) {
                        $('#datatable--barm').DataTable().destroy();
                    }

                    const table = $('#datatable--barm').DataTable({
                        processing: true,
                        serverSide: true,
                        ordering: false,
                        responsive: true,
                        ajax: {
                            url: datatableUrl,
                            type: 'GET',
                            timeout: 30000, // 30 secondes timeout
                            data: function(d) {
                                console.log('Données envoyées:', d);
                                return d;
                            },
                            error: function(xhr, error, thrown) {
                                console.error('=== ERREUR AJAX DATATABLES ===');
                                console.error('Status:', xhr.status);
                                console.error('Status Text:', xhr.statusText);
                                console.error('Error:', error);
                                console.error('Thrown:', thrown);
                                console.error('Response Text:', xhr.responseText);

                                let errorMsg = 'Erreur lors du chargement des données';

                                if (xhr.status === 0) {
                                    errorMsg = 'Problème de connexion réseau';
                                } else if (xhr.status === 404) {
                                    errorMsg = 'Route non trouvée (404)';
                                } else if (xhr.status === 500) {
                                    errorMsg = 'Erreur serveur interne (500)';
                                } else if (xhr.status === 403) {
                                    errorMsg = 'Accès refusé (403)';
                                } else if (error === 'timeout') {
                                    errorMsg = 'Délai d\'attente dépassé';
                                }

                                showError(errorMsg + ' (Code: ' + xhr.status + ')');
                            },
                            beforeSend: function(xhr) {
                                console.log('Requête AJAX en cours...');
                                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr(
                                    'content'));
                            }
                        },
                        columns: [{
                                data: 'year',
                                name: 'year'
                            },
                            {
                                data: 'grade',
                                name: 'grade'
                            },
                            {
                                data: 'mecano',
                                name: 'mecano'
                            },
                            {
                                data: 'matricule',
                                name: 'matricule'
                            },
                            {
                                data: 'firstname',
                                name: 'firstname'
                            },
                            {
                                data: 'lastname',
                                name: 'lastname'
                            },
                            {
                                data: 'birth_date',
                                name: 'birth_date'
                            },
                            {
                                data: 'gender',
                                name: 'gender'
                            },
                            {
                                data: 'unit',
                                name: 'unit'
                            },
                            {
                                data: 'army',
                                name: 'army'
                            },
                            {
                                data: 'retired_date',
                                name: 'retired_date'
                            },
                            {
                                data: 'retired_type',
                                name: 'retired_type'
                            },
                            {
                                data: 'status',
                                name: 'used'
                            },
                            {
                                data: 'authorization',
                                name: 'authorization',
                                orderable: false,
                                searchable: false
                            },
                            @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                                {
                                    data: 'actions',
                                    name: 'actions',
                                    orderable: false,
                                    searchable: false
                                }
                            @endif
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        pageLength: 25,
                        lengthMenu: [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "Tous"]
                        ],
                        language: {
                            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json',
                            processing: "Traitement en cours...",
                            loadingRecords: "Chargement en cours...",
                        },
                        dom: 'Bfrtip',
                        initComplete: function(settings, json) {
                            hideLoading();
                        },
                        drawCallback: function(settings) {
                            hideLoading();
                        },
                        preDrawCallback: function(settings) {
                            console.log('Début du dessin DataTables');
                        }
                    });

                    $('#datatable--barm').on('click', '.editBtn', function(e) {
                        e.preventDefault();

                        const modal = $('#editModal');
                        const retired = $(this).data('retired');
                        const action = $(this).data('action');

                        if (!retired || !action) {
                            console.error('Données manquantes pour l\'édition');
                            return;
                        }

                        console.log('Retired data:', retired);

                        modal.find('form').attr('action', action);
                        modal.find('input[name="mecano"]').val(retired.mecano || '');
                        modal.find('input[name="matricule"]').val(retired.matricule || '');
                        modal.find('input[name="firstname"]').val(retired.firstname || '');
                        modal.find('input[name="lastname"]').val(retired.lastname || '');
                        modal.find('input[name="birth_date"]').val(retired.birth_date || '');
                        modal.find('input[name="retired_date"]').val(retired.retired_date || '');
                        modal.find('input[name="unit"]').val(retired.unit || '');
                        modal.find('select[name="gender"]').val(retired.gender || '');
                        modal.find('select[name="retired_type"]').val(retired.retired_type || '');

                        if (typeof grades !== 'undefined' && retired.army) {
                            modal.find('#army-edit').val(retired.army).trigger('change');

                            const gradeOptions = grades[retired.army] || [];
                            const gradeSelect = modal.find('#grade-edit');
                            gradeSelect.empty().append('<option value="">Sélectionnez un grade</option>');

                            gradeOptions.forEach(function(grade) {
                                gradeSelect.append(`<option value="${grade}">${grade}</option>`);
                            });

                            gradeSelect.val(retired.grade || '');
                        }

                        modal.modal('show');
                    });

                    $('#datatable--barm').on('click', '.editAuthBtn', function(e) {
                        e.preventDefault();
                        console.log('Bouton autorisation cliqué');

                        const modal = $('#editAuthModal');
                        const retired = $(this).data('retired');
                        const action = $(this).data('action');

                        if (!retired || !action) {
                            console.error('Données manquantes pour l\'autorisation');
                            return;
                        }

                        modal.find('form').attr('action', action);
                        modal.find('input[name="mecano"]').val(retired.mecano || '');
                        modal.find('input[name="firstname"]').val(retired.firstname || '');
                        modal.find('input[name="lastname"]').val(retired.lastname || '');
                        modal.modal('show');
                    });
                }

                $('.addBtn').on('click', function() {
                    $('#addModal').modal('show');
                });

                
                $('#army-edit').on('change', function() {
                    let selectedArmy = $(this).val();
                    let gradeOptions = grades[selectedArmy] || [];

                    $('#grade-edit').empty().append('<option value="">Sélectionnez un grade</option>');
                    gradeOptions.forEach(function(grade) {
                        $('#grade-edit').append(`<option value="${grade}">${grade}</option>`);
                    });
                });


                $('.editAuthBtn').on('click', function() {
                    var modal = $('#editAuthModal');
                    var retired = $(this).data('retired');
                    modal.find('form').attr('action', $(this).data('action'));
                    modal.find('input[name=mecano]').val(retired.mecano);
                    modal.find('input[name=firstname]').val(retired.firstname);
                    modal.find('input[name=lastname]').val(retired.lastname);
                    modal.modal('show');
                });

                $('#army').on('change', function() {
                    let selectedType = $(this).val();
                    let gradeOptions = grades[selectedType] || [];

                    $('#grade').empty().append('<option value="">Sélectionnez un grade</option>');
                    gradeOptions.forEach(function(grade) {
                        $('#grade').append(`<option value="${grade}">${grade}</option>`);
                    });

                    $('#grade').trigger('change');
                });
            });
        </script>
    @endpush
@endsection