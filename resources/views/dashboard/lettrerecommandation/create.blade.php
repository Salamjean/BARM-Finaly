@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Curriculum vitae et Letttre de motivation/</span> {{ $title }}
            </h4>
            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">{{ $title }}</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('lettresrecommandations.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Candidat:</label>
                            <select class="form-select select2" data-placeholder="Choisir un ou plusieurs candidats"
                                id="small-bootstrap-class-multiple-field2" name="candidature_id">
                                <option value="" selected>Choisir un candidat</option>
                                @foreach($candidats as $candidature)
                                <option value="{{ $candidature->id }}">{{ $candidature->user->fullName() }} - {{
                                    $candidature->user->mecano }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="date" class="form-label">Date <span
                            class="text-danger">*</span> : </label>
                            <div class="input-group">
                                <input type="date"
                                    class="form-control @error('date') is-invalid @enderror" id="date"
                                    placeholder="Date" name="date_demande" value="{{ old('date') }}" />
                            </div>
                            @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{ route('lettresrecommandations.index') }}" type="reset"
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


