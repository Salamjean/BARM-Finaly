@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-10 mx-auto">

                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Etablir le budget annuel/</span> Etablir le budget de l'année
                </h4>

                <div class="card">
                    <div class="card-header px-4 py-3 border-bottom">
                        <h5 class="mb-0">Etablir le budget de l'année</h5>
                    </div>
                    <div class="card-body p-4">
                        <form class="row g-3" method="POST" action="{{ route('annual-budget.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="http" value="post">

                            <div class="col-md-9 mb-10">
                                <label for="title" class="form-label">Titre: </label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" placeholder="Titre" name="title" value="{{ old('title') }}">
                                @error('title')
                                    <span class="invalid-feedback" budget="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-10">
                                <label for="date" class="form-label">Période: </label>
                                <input disabled class="form-control " value="{{ old('date') ?? date('Y') }}">

                            </div>
                            <div class="col-md-12 mb-10">
                                <label for="description" class="form-label">Consigne : </label>
                                <textarea name="description" id="description" rows="10" class="form-control"></textarea>
                                @error('description')
                                    <span class="invalid-feedback" budget="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                    <a href="{{ route('annual-budget.index') }}" type="reset"
                                        class="btn btn-danger px-4">Annuler</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
