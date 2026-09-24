@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="d-none d-sm-flex align-items-center mb-4">
        <div class="border-start border-primary border-3 ps-3">
            <nav aria-label="breadcrumb">
                <div class="d-flex align-items-center">
                    <i class="bx bx-award text-primary fs-4 me-3"></i>
                    <div>
                        <div class="text-muted small">Concours & Fonction Publique / Étape 1</div>
                        <h4 class="mb-0 text-primary">{{ $title }}</h4>
                    </div>
                </div>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('concours.choix') }}" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="bx bx-arrow-back me-1"></i> Retour à la liste
            </a>
        </div>
    </div>

    <!-- Messages Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3" role="alert">
            <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3" role="alert">
            <i class="bx bx-error-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <!-- Carte Candidat -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar bg-label-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; font-size: 1.25rem; font-weight: bold;">
                            {{ strtoupper(substr($candidat->user->name ?? 'C', 0, 1) . substr($candidat->user->first_name ?? '', 0, 1)) }}
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold text-dark">{{ $candidat->user ? $candidat->user->fullName() : 'Candidat #' . $candidat->id }}</h5>
                            <div class="d-flex flex-wrap align-items-center gap-2 small text-muted">
                                <span class="badge bg-secondary">{{ $candidat->user->matricule ?? ($candidat->user->mecano ?? 'Sans matricule') }}</span>
                                <span><i class="bx bx-phone me-1"></i>{{ $candidat->phone_number }}</span>
                                <span class="badge bg-label-info">{{ $candidat->cohort->title ?? 'Cohorte N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire Choix du Concours -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white p-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bx bx-list-check text-primary fs-4"></i>
                        <span>Formulaire de Choix du Concours</span>
                    </h5>
                </div>
                <form action="{{ route('concours.choix.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="candidature_id" value="{{ $candidat->id }}">

                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Date du Choix <span class="text-danger">*</span></label>
                            <input type="date" name="date_choix" class="form-control form-control-lg" value="{{ $suivi->date_choix ? \Carbon\Carbon::parse($suivi->date_choix)->format('Y-m-d') : date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Intitulé du Concours <span class="text-danger">*</span></label>
                            <select name="intitule_concours" id="choix_intitule" class="form-select form-select-lg" required onchange="toggleOtherIntitule(this.value)">
                                <option value="">-- Choisir l'intitulé du concours --</option>
                                @php
                                    $currentIntitule = $suivi->intitule_concours ?? '';
                                    $intituleFound = false;
                                @endphp
                                @foreach($intitules as $it)
                                    @php
                                        $selected = ($currentIntitule === $it->libelle);
                                        if ($selected) $intituleFound = true;
                                    @endphp
                                    <option value="{{ $it->libelle }}" {{ $selected ? 'selected' : '' }}>{{ $it->libelle }}</option>
                                @endforeach
                                <option value="__other__" {{ ($currentIntitule && !$intituleFound) ? 'selected' : '' }}>+ Autre intitulé (ajouter)...</option>
                            </select>
                            <div id="wrapper_other_intitule" class="mt-2 {{ ($currentIntitule && !$intituleFound) ? '' : 'd-none' }}">
                                <input type="text" name="other_intitule" id="other_intitule_input" class="form-control" placeholder="Saisir le nouvel intitulé..." value="{{ (!$intituleFound) ? $currentIntitule : '' }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Type de Concours</label>
                            @php
                                $currentType = $suivi->type_concours ?? 'Concours Direct';
                            @endphp
                            <select name="type_concours" id="choix_type" class="form-select form-select-lg" onchange="toggleOtherType(this.value)">
                                <option value="Concours Direct" {{ $currentType === 'Concours Direct' ? 'selected' : '' }}>Concours Direct</option>
                                <option value="Concours Professionnel" {{ $currentType === 'Concours Professionnel' ? 'selected' : '' }}>Concours Professionnel</option>
                                @php $typeFound = in_array($currentType, ['Concours Direct', 'Concours Professionnel']); @endphp
                                @foreach($types as $tp)
                                    @if(!in_array($tp->libelle, ['Concours Direct', 'Concours Professionnel']))
                                        @php
                                            $sel = ($currentType === $tp->libelle);
                                            if ($sel) $typeFound = true;
                                        @endphp
                                        <option value="{{ $tp->libelle }}" {{ $sel ? 'selected' : '' }}>{{ $tp->libelle }}</option>
                                    @endif
                                @endforeach
                                <option value="__other__" {{ (!$typeFound && $currentType) ? 'selected' : '' }}>+ Autre type...</option>
                            </select>
                            <div id="wrapper_other_type" class="mt-2 {{ (!$typeFound && $currentType) ? '' : 'd-none' }}">
                                <input type="text" name="other_type" id="other_type_input" class="form-control" placeholder="Saisir le nouveau type..." value="{{ !$typeFound ? $currentType : '' }}">
                            </div>
                        </div>

                        <div class="alert alert-info border-0 rounded-3 small mb-0">
                            <i class="bx bx-info-circle me-1"></i>
                            Une fois enregistré, le candidat sera mis à jour et disponible dans le sous-onglet <strong>Prépa Concours</strong>.
                        </div>
                    </div>

                    <div class="card-footer bg-light border-top p-4 d-flex justify-content-between align-items-center">
                        <a href="{{ route('concours.choix') }}" class="btn btn-light-secondary rounded-pill px-4">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bx bx-save me-1"></i> Enregistrer le choix
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js-push')
<script>
    function toggleOtherIntitule(val) {
        const wrapper = document.getElementById('wrapper_other_intitule');
        const input = document.getElementById('other_intitule_input');
        if (val === '__other__') {
            wrapper.classList.remove('d-none');
            input.setAttribute('required', 'required');
            input.focus();
        } else {
            wrapper.classList.add('d-none');
            input.removeAttribute('required');
        }
    }

    function toggleOtherType(val) {
        const wrapper = document.getElementById('wrapper_other_type');
        const input = document.getElementById('other_type_input');
        if (val === '__other__') {
            wrapper.classList.remove('d-none');
            input.setAttribute('required', 'required');
            input.focus();
        } else {
            wrapper.classList.add('d-none');
            input.removeAttribute('required');
        }
    }
</script>
@endpush
@endsection
