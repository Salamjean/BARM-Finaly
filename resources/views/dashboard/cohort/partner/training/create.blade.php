@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Cohorte/Formation/</span>Création
                    </h4>
                </nav>
            </div>

        </div>
        <div class="card">
            <div class="card-body p-4">
                <form class="row g-3" method="POST" action="{{ route('cohort.training.store', $cohort->id) }}">
                    @csrf
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Intitulé<span class="text-danger">*</span> : </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            placeholder="Formation en agriculture" name="title" value="{{ old('title') }}" required>
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
                            id="beging_date" name="beging_date" value="{{ old('beging_date') }}"  required>
                        @error('beging_date')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label" for="all">Concernées</label>
                        <div class="d-flex" style="gap: 20px;">
                            <div class="form-check">
                                <input class="form-check-input" value="all" type="radio" name="participation"
                                    id="all" checked>
                                <label class="form-check-label" for="all">
                                    Tout les adhérents
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" value="selected" type="radio" name="participation"
                                    id="selected">
                                <label class="form-check-label" for="selected">
                                    Selectionner des participants
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-12" id="list" style="display: none;">
                        <label class="form-label" for="adherents_id">Participants</label>
                        <select id="adherents_id" name="adherents_id[]" class="select2 form-select" multiple>
                            <option value="" disabled>Selectionnez</option>
                            @foreach ($adherents as $adherent)
                                <option value="{{ $adherent->id }}" class="text-capitalize">
                                    {{ $adherent->user->fullName() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description : </label>
                        <textarea name="description" rows="10" class="form-control @error('description') is-invalid @enderror"
                            id="Description"></textarea>
                        @error('description')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                            <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js-push')
        <script>
            $(document).ready(function() {

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
