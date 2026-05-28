@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">CANDIDATURE ></span> Demande de prêt
            </h4>
            <div class="card">
                <div class="card-body p-4">
                    <form id="formationForm" class="row g-3" method="POST" action="{{ route('formation.store') }}" enctype="multipart/form-data">
                        @csrf
                        {{--<div class="col-md-4 mb-3 form-group">
                            <label for="mecano" class="form-label">Mecano / Matricule : </label>
                                <input type="text" class="form-control @error('mecano') is-invalid @enderror" id="mecano" placeholder="Mecano" name="mecano" value="{{ old('mecano') }}"/>
                            @error('mecano')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>--}}
                        <div class="col-md-4 mb-3 form-group">
                            <label for="nom" class="form-label">Nom du demandeur: </label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" placeholder="Nom du demandeur" name="nom" value="{{ old('nom') }}"/>
                            @error('nom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3 form-group">
                            <label for="prenom" class="form-label">Prenom du demandeur : </label>
                                <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" placeholder="Prenom" name="prenom" value="{{ old('prenom') }}"/>
                            @error('prenom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3 form-group">
                            <label for="num_compte" class="form-label">N° de compte ou RIB : </label>
                                <input type="texte" class="form-control @error('num_compte') is-invalid @enderror" id="num_compte" placeholder="N° de compte ou RIB" name="fiche_autorisation" value="{{ old('fiche_autorisation') }}"/>
                            @error('num_compte')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3 form-group">
                            <label for="num_carte" class="form-label">N° carte d'identite: </label>
                                <input type="text" class="form-control @error('num_carte') is-invalid @enderror" id="num_carte" placeholder="ex: CI0120455365" name="num_carte" value="{{ old('num_carte') }}"/>
                            @error('num_carte')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="telephone" class="form-label">Téléphone :</label>
                                <input type="text"  class="form-control @error('telephone') is-invalid @enderror" id="telephone" placeholder="Telephone" name="telephone" value="{{ old('telephone') }}"></textarea>
                            @error('telephone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="email" class="form-label">Email :</label>
                                <input type="email"  class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email" value="{{ old('email') }}"></textarea>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="adresse" class="form-label">Adresse :</label>
                                <input type="adresse"  class="form-control @error('adresse') is-invalid @enderror" id="adresse" placeholder="Adresse" name="adresse" value="{{ old('adresse') }}"></textarea>
                            @error('adresse')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3 form-group">
                            <label for="duree" class="form-label">Durée du prêt : </label>
                                <input type="text" class="form-control @error('duree') is-invalid @enderror" id="duree" placeholder="Duree du prêt" name="duree" value="{{ old('duree') }}"/>
                            @error('duree')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3 form-group">
                            <label for="montant" class="form-label">Montant du prêt : </label>
                                <input type="number" class="form-control @error('montant') is-invalid @enderror" id="montant" placeholder="Montant" name="montant" value="{{ old('montant') }}"/>
                            @error('montant')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                       <div class="col-md-4 mb-3 form-group">
                            <label for="delais" class="form-label">Delais de remboussement : </label>
                                <input type="date" class="form-control @error('delais') is-invalid @enderror" id="delais" placeholder="Delais de remboussement" name="delais" value="{{ old('delais') }}"/>
                            @error('delais')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        {{--  <div class="col-md-4 mb-3 form-group">
                            <label class="form-label">Mode de financement:</label>
                            <select class="form-select select2" data-placeholder="Choisir le mode de financement" name="mode_financement">
                                <option value="" selected disabled>---- Selectionner ----</option>
                                <option value="C2D-CSP-BARM">C2D-CSP-BARM</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3 form-group">
                            <label class="form-label">Personnel(s) Concerné(s) :</label>
                            <select class="form-select select2" data-placeholder="Choisir un ou plusieurs personnel(s)" id="small-bootstrap-class-multiple-field" multiple name="personnels[]">
                                @foreach($personnels as $personnel)
                                <option value="{{ $personnel->id }}">{{ $personnel->user->firstname }} {{ $personnel->user->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="objectif" class="form-label">Objectif attendu :</label>
                                <textarea type="text" rows="5" class="form-control @error('objectif') is-invalid @enderror" id="objectif" placeholder="Objectif attendu" name="objectif" value="{{ old('objectif') }}"></textarea>
                            @error('objectif')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="strategie" class="form-label">Stratégie d'Organisation :</label>
                                <textarea type="text" rows="5" class="form-control @error('strategie') is-invalid @enderror" id="strategie" placeholder="strategie attendu" name="strategie" value="{{ old('strategie') }}"></textarea>
                            @error('strategie')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>--}} 
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{ route('formation.index') }}" type="reset" class="btn btn-danger px-4">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>


<!-- <script type="text/javascript">
    $(document).ready(function (){
        $('#formationForm').validate({
            rules: {
                typologie: {
                    required : true,
                }, 
                nom: {
                    required : true,
                }, 
                duree: {
                    required : true,
                }, 
                cout: {
                    required : true,
                }, 
                lieu: {
                    required : true,
                }, 

                date_previsionnelle: {
                    required : true,
                },  
                mode_financement: {
                    required : true,
                }, 
                strategie: {
                    required : true,
                },
                fonction_occupee: {
                    required : true,
                }, 
                objectif: {
                    required : true,
                }, 
            },
            messages :{
                typologie: {
                    required : 'Typologie de la formation est obligatoire',
                },  
                nom: {
                    required : 'Nom de la formation est obligatoire',
                },
                duree: {
                    required : 'Durée de la formation est obligatoire',
                },
                cout: {
                    required : 'Coût de la formation est obligatoire',
                },
               
                lieu: {
                    required : 'Lieu de la formation est obligatoire',
                },
                date_previsionnelle: {
                    required : 'Date prévsisionnelle est obligatoire',
                },
                mode_financement: {
                    required : 'Mode de financement est obligatoire',
                }, 
                strategie: {
                    required : 'Stratégie d\'organisation est obligatoire',
                }, 
                fonction_occupee: {
                    required : 'Fonction Occupée est obligatoire',
                }, 
                objectif: {
                    required : 'Objectif de la formation est obligatoire',
                },  

            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('text-danger');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script> -->
@endsection