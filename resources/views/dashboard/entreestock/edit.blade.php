@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">

            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Gestion de stock/</span> Entree de stock
            </h4>

            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Voir l'entrée en stock</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('entreestock.update',$entreestock->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Consommable :</label>
                            <select class="form-select select2" data-placeholder="Choisir un consommable"
                                name="consommable_id">
                                <option value="{{ $entreestock->consommable->id }}" selected>{{ $entreestock->consommable->designation }}</option>
                                @foreach($consommables as $consommable)
                                <option value="{{ $consommable->id }}">{{ $consommable->designation }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-10">
                            <label for="qte_entree" class="form-label">Quantité entrée : </label>
                            <input type="number" class="form-control @error('qte_entree') is-invalid @enderror"
                                id="qte_entree" placeholder="Quantité entrée" name="qte_entree"
                                value="{{ $entreestock->qte_entree }}">
                            @error('qte_entree')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-10">
                            <label for="date_entree" class="form-label">Date d'entrée : </label>
                            <input type="date" class="form-control @error('date_entree') is-invalid @enderror"
                                id="date_entree" placeholder="Nom de besoin" name="date_entree"
                                value="{{ dateFr($entreestock->date_entree) }}">
                            @error('date_entree')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-10">
                            <label for="fournisseur" class="form-label">Fournisseur : </label>
                            <input type="text" class="form-control @error('fournisseur') is-invalid @enderror"
                                id="fournisseur" placeholder="Nom du fournisseur" name="fournisseur" value="{{ $entreestock->fournisseur }}">
                            @error('fournisseur')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-10">
                            <label for="temoin1" class="form-label">Temoin1 : </label>
                            <input type="text" class="form-control @error('temoin1') is-invalid @enderror" id="temoin1"
                                placeholder="Nom du premier temoin" name="temoin1" value="{{ $entreestock->temoin1 }}">
                            @error('temoin1')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-10">
                            <label for="temoin2" class="form-label">Temoin2 : </label>
                            <input type="text" class="form-control @error('temoin2') is-invalid @enderror" id="temoin2"
                                placeholder="Nom du deusième temoin" name="temoin2" value="{{ $entreestock->temoin2 }}">
                            @error('temoin2')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-10">
                            <label for="temoin3" class="form-label">Temoin3 : </label>
                            <input type="text" class="form-control @error('temoin3') is-invalid @enderror" id="temoin3"
                                placeholder="Nom du troisième temoin" name="temoin3" value="{{ $entreestock->temoin3 }}">
                            @error('temoin3')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <input type="text" class="form-control  is-invalid " placeholder="Nom de besoin"
                            name="crator_id" value="{{Auth::user()->id}}" hidden>


                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Modifier</button>
                                <a href="{{ route('entreestock.index') }}" type="reset"
                                    class="btn btn-danger px-4">Retour</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection