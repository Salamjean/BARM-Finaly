@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Cohorte/Formation/</span>Edition
                    </h4>
                </nav>
            </div>

        </div>
        <div class="card">
            <div class="card-body p-4">
                @if ($training->status != 'finished')
                    <form class="row g-3" method="POST" action="{{ route('cohort.training.update', $training->id) }}">
                        @csrf
                        @method('PUT')
                @endif
                <input type="hidden" name="update" value="update" />
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Intitulé<span class="text-danger">*</span> : </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            placeholder="Formation en agriculture" name="title"
                            value="{{ old('title') ?? $training->title }}"
                            {{ $training->status != 'finished' ? 'required' : 'readonly' }}>
                        @error('title')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="beging_date" class="form-label">Date de début<span class="text-danger">*</span> :
                        </label>
                        <input type="date" class="form-control @error('beging_date') is-invalid @enderror"
                            id="beging_date" name="beging_date" value="{{ old('beging_date') ?? $training->beging_date }}"
                             {{ $training->status != 'finished' ? 'required' : 'readonly' }}>
                        @error('beging_date')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    @if ($training->status != 'finished')
                        <div class="mb-3 col-md-12">
                            <label class="form-label" for="all">Concernées</label>
                            <div class="d-flex" style="gap: 20px;">
                                <div class="form-check">
                                    <input class="form-check-input" value="all" type="radio" name="participation"
                                        id="all">
                                    <label class="form-check-label" for="all">
                                        Tout les adhérents
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="selected" checked type="radio"
                                        name="participation" id="selected">
                                    <label class="form-check-label" for="selected">
                                        Selectionner des participants
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="mb-3 col-md-12" id="list" style="display: none;">
                        <label class="form-label" for="adherents_id">Participants</label>
                        <select id="adherents_id" name="adherents_id[]" class="select2 form-select bg-white"
                            {{ $training->status != 'finished' ? 'required' : 'disabled' }} multiple>
                            @foreach ($adherents as $adherent)
                                <option value="{{ $adherent->id }}"
                                    {{ in_array($adherent->id, $training->participations->pluck('candidature_id')->toArray()) ? 'selected' : '' }}
                                    class="text-capitalize">
                                    {{ $adherent->user->fullName() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- @if ($training->status == 'finished')
                    <div class="mb-3 col-md-12" id="list" style="">
                        <label class="form-label" for="add">Absents</label>
                        <select id="add" name="adherents_id[]" class="select2 form-select bg-white"
                            disabled multiple>
                            @foreach ($adherents as $adherent)
                                <option value="{{ $adherent->id }}"
                                    {{ in_array($adherent->id, $training->participations->pluck('candidature_id')->toArray()) ? 'selected' : '' }}
                                    class="text-capitalize">
                                    {{ $adherent->user->fullName() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif --}}
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description : </label>
                        <textarea name="description" rows="10" class="form-control @error('description') is-invalid @enderror"
                            id="Description" {{ $training->status != 'finished' ? '' : 'readonly' }}>{{ $training->description }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3 float-end" style="gap: 10px;">
                            @if ($training->status != 'finished')
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                            @endif
                            <button type="button" data-bs-toggle="modal" data-bs-target="#finished"
                                class="btn btn-success px-4">{{ $training->status == 'finished' ? 'Voir plus' : 'Finaliser' }}</button>
                        </div>
                    </div>
                </div>

                @if ($training->status != 'finished')
                    </form>
                @endif
                <div class="modal fade" id="finished" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="finishedLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="finishedLabel">Terminer la formation</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if ($training->status != 'finished')
                                    <form class="" method="POST"
                                        action="{{ route('cohort.training.update', $training->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                @endif
                                <div class="row mb-3 py-4">
                                    <input type="hidden" name="update" value="finished" />
                                    <div class="col-md-12">
                                        <label for="end_date" class="form-label">Date de fin de la formation<span
                                                class="text-danger">*</span> :
                                        </label>
                                        <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                            id="end_date" name="end_date"
                                            value="{{ old('end_date') ?? $training->end_date }}"
                                            min="{{ $training->beging_date }}"
                                            {{ $training->status != 'finished' ? 'required' : 'readonly' }}>
                                        @error('end_date')
                                            <span class="invalid-feedback" besoin="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    @if ($training->status != 'finished')
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label" for="adherents_absen_id">Adhérents absent à la
                                                formation
                                            </label>
                                            <select id="adherents_absen_id" name="adherents_id[]"
                                                class="select2 form-select bg-white" multiple>
                                                @foreach ($training->participations as $participation)
                                                    <option value="{{ $participation->candidature->id }}"
                                                        class="text-capitalize">
                                                        {{ $participation->candidature->user->fullName() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label" for="list">Liste de présence
                                                <span class="text-danger">*</span></label>
                                            <input type="file" accept=".pdf" class="form-control" id="file_presence"
                                                name="file_presence"
                                                {{ $training->status != 'finished' ? 'required' : 'readonly' }}>
                                            @error('file_presence')
                                                <span class="invalid-feedback" besoin="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                    @endif
                                    <div class="col-md-12 mt-3">
                                        <label for="observation" class="form-label">Observation : </label>
                                        <textarea name="observation" rows="10" class="form-control @error('observation') is-invalid @enderror"
                                            id="observation" {{ $training->status != 'finished' ? '' : 'readonly' }}>{{ old('observation') ?? $training->observation }}</textarea>
                                        @error('observation')
                                            <span class="invalid-feedback" besoin="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end" style="gap: 10px;">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Annuler</button>
                                    @if ($training->status != 'finished')
                                        <button type="submit" class="btn btn-primary">Valider</button>
                                    @endif
                                </div>
                                @if ($training->status != 'finished')
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js-push')
        <script>
            $(document).ready(function() {
                $('#list').css('display', 'block');

                $('input[type=radio]').click(function() {
                    if (this.value != 'all')
                        $('#list').css('display', 'block');
                    else
                        $('#list').css('display', 'none');
                });
            });
        </script>
    @endpush
@endsection
