@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Personnels/</span> Déclaration de décès
        </h4>
        <div class="card">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

                <div class="ms-auto p-4">
                    <div class="btn-group">
                        <a href="{{ route('personnel.index') }}" class="btn btn-primary">Liste du personnel </a>
                    </div>
                </div>
            </div>
            <h5 class="card-header pt-0">Déclaration de décès</h5>
            <div class="card-body">
                <form id="formSubmit" action="{{ route('personnel.death') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="personal" class="form-label">Selectionner le collaborateur</label>
                                <select name="personal_id" class="form-select select2" id="personal">
                                    <option value="" selected disabled>Selectionner</option>
                                    @foreach ($personals as $personal)
                                        <option value="{{ $personal->id }}" {{ old('personal_id') == $personal->id ? 'selected' : '' }}>{{ $personal->user->fullName() }}</option>
                                    @endforeach
                                </select>
                            @error('personal_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="death_date" class="form-label">Date</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="death_date" name="death_date" max="{{ date('Y-m-d') }}"
                                    value="{{ old('death_date') }}" required />
                            </div>
                            @error('death_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="no_act" class="form-label">N°Acte de décès</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="no_act" name="death_no_act"
                                    value="{{ old('death_no_act') }}" required />
                            </div>
                            @error('no_act')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label">Lieu de décès</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="city" name="death_city"
                                    value="{{ old('death_city') }}" required />
                            </div>
                            @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="justify" class="form-label">
                                Cause de décès
                            </label>
                            <div class="input-group">
                                <textarea name="death_justification" id="" class="form-control" rows="10">{{ old('death_justification') }}</textarea>
                            </div>
                            @error('justify')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{ route('personnel.index') }}" class="btn btn-danger px-4">Annuler</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js-push')
        <script>
            $(document).ready(function() {
                $("#formSubmit").submit(function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: '(Confirmation) \n Le personnel décédé sera supprimé dans vos données?',
                        icon: 'warning',
                        iconColor: '#E68200',
                        showCancelButton: true,
                        confirmButtonColor: '#6900AF',
                        cancelButtonColor: '#363636',
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let timerInterval
                            Swal.fire({
                                title: 'Veuillez patienter!',
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                },
                                willClose: () => {
                                    $("#formSubmit")[0].submit();
                                    clearInterval(timerInterval)
                                }
                            })
                        }
                    })
                });
            });
        </script>
    @endpush
@endsection
