@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Choix du parrtenaire BARM/</span> Etat Civil
            </h4>
            <div class="card">
                {{-- <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Créer une session</h5>
                </div> --}}
                <div class="card-body p-4">
                    <form class="row g-3" method="POST"
                        action="{{route('updatecandidatpartner', $candidature->id)}}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 mb-3">
                            <label for="date" class="form-label">Candidat</label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bx-date'></i></span>
                                <input type="text"
                                    class="form-control @error('date') is-invalid @enderror border-start-0" id="date"
                                    placeholder="text" name="date" value="{{$candidature->user->fullName()}}"
                                    readonly />
                            </div>
                            @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Partenaire(s) :</label>
                            <select class="form-select select2" data-placeholder="Choisir un ou plusieurs partenaires"
                                id="small-bootstrap-class-multiple-field" multiple name="partenaire_id">
                                @foreach($partenaires as $partenaire)
                                <option value="{{ $partenaire->id }}" {{ in_array($partenaire->id,
                                    $candidature->partenaires->pluck('id')->toArray()) ? 'selected' : '' }}>{{
                                    $partenaire->user->fullName() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Modifier</button>
                                <a href="{{ route('candidaturepresent') }}" type="reset"
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
