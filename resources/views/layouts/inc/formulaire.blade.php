<form action="{{ route('inscription.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Inscription/</span> Enregistrement d'un candidat</h4>
    <div class="row my-4">
        <div class="col">
            <div class="accordion" id="collapsibleSection">
        <!-- Etat civil -->
        <div class="card accordion-item">
                <h2 class="accordion-header" id="headingEtatcivil">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEtatcivil" aria-expanded="true" aria-controls="collapseEtatcivil">
                        <h5>1. Etat Civil</h5>
                    </button>
                </h2>
                <div id="collapseEtatcivil" class="accordion-collapse collapse show" aria-labelledby="headingEtatcivil" data-bs-parent="#etatCivilSection">
                    <div class="accordion-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-end fw-bold" for="collapsible-fullname">Nom :</label>
                            <div class="col-sm-9">
                                <span class="form-control" style="border:none"> {{$user->lastname}}</span>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-end fw-bold" for="collapsible-fullname">Prénom(s) :</label>
                            <div class="col-sm-9">
                                <span class="form-control" style="border:none"> {{$user->firstname}}</span>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-end fw-bold" for="collapsible-fullname">Genre :</label>
                            <div class="col-sm-9">
                                <span class="form-control" style="border:none"> {{$submission->gender}}</span>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-end fw-bold" for="collapsible-fullname">Né(e) le :</label>
                            <div class="col-sm-9">
                                <span class="form-control" style="border:none"> {{$submission->birth_date}}</span>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-end fw-bold" for="collapsible-fullname">Type de pièce :</label>
                            <div class="col-sm-9">
                                <span class="form-control" style="border:none"> {{$submission->type_piece}}</span>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-end fw-bold" for="collapsible-fullname">N° Pièce :</label>
                            <div class="col-sm-9">
                                <span class="form-control" style="border:none"> {{$submission->no_card}}</span>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-end fw-bold" for="collapsible-fullname">Ethnie :</label>
                            <div class="col-sm-9">
                                <span class="form-control" style="border:none"> {{$submission->ethnic}}</span>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-end fw-bold" for="collapsible-fullname">Religion :</label>
                            <div class="col-sm-9">
                                <span class="form-control" style="border:none"> {{$submission->religion}}</span>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <!-- Situation Matrimoniale -->
            <div class="card accordion-item">
                <h2 class="accordion-header" id="Option_situation_matri">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_sm" aria-expanded="false" aria-controls="collapse_sm">
                    <h5>2. Situation Matrimoniale</h5>
                    </button>
                </h2>
                <div id="collapse_sm" class="accordion-collapse collapse" aria-labelledby="Option_situation_matri" data-bs-parent="#collapsibleSection">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label" for="situation_matrimoniale">Situation Matrimoniale <span class="text-danger">*</span> :</label>
                                <select name="situation_matrimoniale" id="situation_matrimoniale" class="form-control @error('situation_matrimoniale') is-invalid @enderror">
                                    <option value="">Selectionner</option>
                                    <option value="marié(e)">Marié(e)</option>
                                    <option value="concubin(e)">Concubin(e)</option>
                                    <option value="celibataire">Célibataire</option>
                                    <option value="divorcé(e)">Divorcé(e)</option>
                                    <option value="veuf(ve)">Veuf(ve)</option>
                                </select>
                                @error('situation_matrimoniale')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-2">
                                <label class="form-label" for="partnerName" style="display: none;">Nom Conjoint(e) <span class="text-danger">*</span> :</label>
                                <input type="text" id="partnerName" name="partnerName" class="form-control @error('partnerName') is-invalid @enderror" placeholder="Nom complet" value="{{old('partnerName')}}" style="display: none"/>
                                @error('partnerName')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label" for="partnerJob" style="display: none;">Profession Conjoint(e) <span class="text-danger">*</span> :</label>
                                <input type="text" id="partnerJob" name="partnerJob" class="form-control @error('partnerJob') is-invalid @enderror" placeholder="Caissière" value="{{old('partnerJob')}}" style="display: none"/>
                                @error('partnerJob')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label" for="contactPartner" style="display: none;">Contact Conjoint(e) <span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control @error('contactPartner') is-invalid @enderror" id="contactPartner" placeholder="0505051010" name="contactPartner" value="{{ old('contactPartner') }}" style="display: none"/>
                                @error('contactPartner')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="partnerCard" style="display: none;">Pièce d'identité conjoint(e) <span class="text-danger">*</span> :</label>
                                <input type="file" class="form-control" name="partnerCard" id="partnerCard" style="display: none"/>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="marriageCertificate" style="display: none;">Acte de mariage <span class="text-danger">*</span> :</label>
                                <input type="file" class="form-control" name="marriageCertificate" id="marriageCertificate" style="display: none"/>
                            </div>
                        </div>                    
                            <br>
                            <div class="row g-3">
                            <b>&bull; 
                            Informations sur les enfants
                            </b>
                            <div class="box-body">
                            <div class="d-flex justify-content mb-4">
                                <div class="">
                                    <button type="button" class="btn btn-outline-info add__items__btn fs-10"><span class="fa-solid fa-plus-circle">&nbsp;</span>
                                        Ajouter enfant
                                    </button>
                                </div>
                            </div>
                            <div id="items__enfant"></div>
                            <br>
                            <b>&bull; 
                                Coordonnées
                            </b>
                            <div class="row">
                                <div class="col-md-3">
                                        <label class="form-label" for="collapsible-phone">Email :</label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="john.doe@email.com" aria-label="john.doe" value="{{old('email')}}"/>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                </div>
                                <div class="col-md-3">
                                        <label class="form-label" for="collapsible-phone">mobile :</label>
                                        <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" placeholder="0707252525" name="mobile" value="{{$submission->phone_number}}" disabled/>
                                </div>
                                <div class="col-md-3">
                                        <label class="form-label" for="collapsible-phone">Lieu d'habitation <span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control @error('residence') is-invalid @enderror" id="residence" placeholder="Cocody cité des arts" name="residence"/>
                                        @error('residence')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                </div>
                                <div class="col-md-3">
                                        <label class="form-label" for="collapsible-phone">Adresse postale :</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="01 BP 0251 Abidjan 01" name="address" value="{{old('address')}}"/>
                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <!-- Situation professionnelle -->
            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingSituationProf">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_sprof" aria-expanded="false" aria-controls="collapse_sprof">
                    <h5>3. Situation Professionnelle</h5>
                    </button>
                </h2>
                <div id="collapse_sprof" class="accordion-collapse collapse" aria-labelledby="headingSituationProf" data-bs-parent="#collapsibleSection">
                    <div class="accordion-body">
                        <div class="content-header mb-3">
                            <h6 class="mb-0">A. Origine</h6>
                        </div>
                        <div class="row">
                                <div class="col-md-3">
                                        <label class="form-label" for="collapsible-state">Armée ou Arme <span class="text-danger">*</span> :</label>
                                            <div class="input-group"> 
                                                <select name="armee" id="armee" class="form-control @error('armee') is-invalid @enderror">
                                                <option value="">Selectionner</option>
                                                <option value="Terre">Terre</option>
                                                <option value="Air">Air</option>
                                                <option value="Marine">Marine</option>
                                                <option value="Gendarmerie">Gendarmerie</option>
                                                <option value="Forces spéciale">Forces spéciale</option>
                                                </select>
                                                @error('armee')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                </div>
                                <div class="col-md-3">
                                        <label class="form-label" for="collapsible-phone">Unité de rattachement <span class="text-danger">*</span> :</label>
                                            <input type="text" class="form-control @error('unite_rattachement') is-invalid @enderror" id="unite_rattachement" placeholder="1ère LEGION MILITAIRE" name="unite_rattachement" value="{{ old('unite_rattachement') }}"/>
                                            @error('Unite_rattachement')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="collapsible-state">Statut <span class="text-danger">*</span> :</label>
                                        <div class="input-group"> 
                                            <select name="statut_prof" id="statut_prof" class="form-control @error('statut_prof') is-invalid @enderror">
                                                <option value="">Selectionner</option>
                                                <option value="carriere">Carrière</option>
                                                <option value="sous_contrat">Sous-contrat</option>
                                                <option value="retraite">Retraité</option>
                                                <option value="engage_volontaire">Engagé volontaire</option>
                                            </select>
                                            @error('statut_prof')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="collapsible-phone">Dernier grade <span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control @error('grade') is-invalid @enderror" id="grade" placeholder="Ex: ADJUDANT-CHEF" name="grade" value="{{ old('grade') }}"/>
                                        @error('grade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <label class="form-label" for="collapsible-phone">Mécano / N° Identifiant :</label>
                                    <input type="text" class="form-control @error('mecano') is-invalid @enderror" id="mecano" placeholder="0000034535" name="mecano" value="{{ $user->mecano }}" style="color:red; font-style: bold;" disabled/>
                            </div>
                            <div class="col-md-2">
                                    <label class="form-label" for="collapsible-phone">Date d'entrée en service <span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control @error('date_entree') is-invalid @enderror" id="date_entree" placeholder="Préciser" name="date_entree" value="{{ old('date_entree') }}"/>
                                        @error('date_entree')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                            </div>
                            <div class="col-md-2">
                                    <label class="form-label" for="collapsible-phone">Date de radiation <span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control @error('date_radiation') is-invalid @enderror" id="date_radiation" placeholder="Préciser" name="date_radiation" value="{{ old('date_radiation') }}"/>
                                        @error('date_radiation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label" for="collapsible-phone">Duree de service :</label>
                                    <input type="text" class="form-control @error('duree_service') is-invalid @enderror" id="duree_service" placeholder="" name="duree_service" value="{{ old('duree_service') }}" disabled/>
                            </div>
                        </div>
                        <br>
                                <div class="content-header mb-3">
                                    <h6 class="mb-0">B. Emplois successifs</h6>
                                </div>
                                <div class="box-body">
                                    <div class="d-flex justify-content mb-4">
                                        <div class="">
                                            <button type="button" class="btn btn-outline-info add__emp__btn fs-10"><span class="fa-solid fa-plus-circle">&nbsp;</span>
                                                Ajouter Emploi
                                            </button>
                                        </div>
                                    </div>
                                    <div id="items__emploi"></div>
                                </div>
                                <br>
                                <div class="content-header mb-3">
                                    <h6 class="mb-0">C. Domaine de spécialité </h6>
                                </div>
                                <div class="box-body">
                                <div class="d-flex justify-content mb-4">
                                    <div class="">
                                        <button type="button" class="btn btn-outline-info add__dom__btn fs-10"><span class="fa-solid fa-plus-circle">&nbsp;</span>
                                            Ajouter Diplôme
                                        </button>
                                    </div>
                                </div>
                                <div id="items__diplome"></div>
                            </div>
                        
                    </div>
                </div>
            </div>
            <!-- Projet -->
            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingProjet">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProjet" aria-expanded="false" aria-controls="collapseProjet">
                    <h5>4. Projet Professionnel</h5>
                </button>
                </h2>
                <div id="collapseProjet" class="accordion-collapse collapse" aria-labelledby="headingProjet" data-bs-parent="#collapsibleSection">
                    <div class="accordion-body">
                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">Orientation envisagée<span class="text-danger">*</span></label>
                            <div class="col mt-2">
                            <div class="form-check form-check-inline">
                                <input name="orientation" class="form-check-input" type="radio" value="fonction_publique" id="fonction_publique"/>
                                <label class="form-check-label" for="fonction_publique">Fonction Publque</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="orientation" class="form-check-input" type="radio" value="entreprise" id="entreprise" />
                                <label class="form-check-label" for="entreprise">Entreprise</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="orientation" class="form-check-input" type="radio" value="auto-emploi" id="auto-emploi" />
                                <label class="form-check-label" for="auto-emploi">Auto-emploi</label>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-header mb-3">
                        <h6 class="mb-0">&bull; 1er Choix</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" for="collapsible-phone">Domaine <span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control @error('domaine_1c') is-invalid @enderror" id="domaine_1c" placeholder="" name="domaine_1c" value="{{old('domaine_1c')}}"/>
                                @error('domaine_1c')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="collapsible-phone">Spécialisation <span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control @error('specialisation_1c') is-invalid @enderror" id="specialisation_1c" placeholder="" name="specialisation_1c" value="{{old('specialisation_1c')}}"/>
                                @error('specialisation_1c')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="collapsible-state">Région de retraite <span class="text-danger">*</span> :</label>
                                <select class="form-select @error('region_retraite_1c') is-invalid @enderror" aria-label="Default select example" name="region_retraite_1c">
                                    <option value="">Selectionner</option>
                                    @foreach (DISTRICTS as $district)
                                        <option value="{{ $district }}">{{ $district }}</option>
                                    @endforeach
                                </select>
                                @error('region_retraite_1c')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="collapsible-state">Département de retraite <span class="text-danger">*</span> :</label>
                                <select class="form-select @error('department_1c') is-invalid @enderror" aria-label="Default select example" name="department_1c">
                                    <option value="">Selectionner</option>
                                    @foreach (CITIES as $city)
                                        <option value="{{ $city }}">{{ $city }}</option>
                                    @endforeach
                                </select>
                                @error('department_1c')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">
                                <label class="form-label" for="collapsible-state">Localité de retraite <span class="text-danger">*</span> :</label>
                                    <select class="form-select @error('locality_1c') is-invalid @enderror" aria-label="Default select example" name="locality_1c" >
                                        <option value="">Selectionner</option>
                                        @foreach (CITIES as $city)
                                            <option value="{{ $city }}">{{ $city }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="col-md-3">
                                    <label class="form-label" for="collapsible-phone">Adresse géographique <span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control @error('adressGeo_1c') is-invalid @enderror" id="adressGeo_1c" placeholder="" name="adressGeo_1c" value="{{old('adressGeo_1c')}}"/>
                                        @error('adressGeo_1c')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                            </div>
                            <div class="col-md-3">
                                    <label class="form-label" for="collapsible-phone">Formation sollicitée  <span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control @error('formation_1c') is-invalid @enderror" id="formation_1c" placeholder="" name="formation_1c" value="{{old('formation_1c')}}"/>
                                        @error('formation_1c')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                            </div>
                            <div class="col-md-3">
                                    <label class="form-label" for="collapsible-phone">Autres solicitations :</label>
                                        <input type="text" class="form-control" id="autres_form_1c" placeholder="" name="autres_form_1c" value="{{old('autres_form_1c')}}"/>
                            </div>
                    </div>
                    <br>
                    <div class="content-header mb-3">
                        <h6 class="mb-0">&bull; 2e Choix</h6>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" for="collapsible-phone">Domaine <span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control @error('domaine_2c') is-invalid @enderror" id="domaine_2c" placeholder="" name="domaine_2c" value="{{old('domaine_2c')}}"/>
                                @error('domaine_2c')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="collapsible-phone">Spécialisation <span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control @error('specialisation_2c') is-invalid @enderror" id="specialisation_2c" placeholder="" name="specialisation_2c" value="{{old('specialisation_2c')}}"/>
                                @error('specialisation_2c')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                       
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="collapsible-state">Région de retraite :</label>
                                <select class="form-select @error('region_retraite_2c') is-invalid @enderror" aria-label="Default select example" name="region_retraite_2c">
                                    <option value="">Selectionner</option>
                                    @foreach (DISTRICTS as $district)
                                        <option value="{{ $district }}">{{ $district }}</option>
                                    @endforeach
                                </select>
                                @error('region_retraite_2c')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="collapsible-state">Département de retraite :</label>
                                <select class="form-select @error('department_2c') is-invalid @enderror" aria-label="Default select example" name="department_2c">
                                    <option value="">Selectionner</option>
                                    @foreach (CITIES as $city)
                                        <option value="{{ $city }}">{{ $city }}</option>
                                    @endforeach
                                </select>
                                @error('department_2c')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">
                                <label class="form-label" for="collapsible-state">Localité de retraite :</label>
                                    <select class="form-select @error('locality_2c') is-invalid @enderror" aria-label="Default select example" name="locality_2c" >
                                        <option value="">Selectionner</option>
                                        @foreach (CITIES as $city)
                                            <option value="{{ $city }}">{{ $city }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="col-md-3">
                                    <label class="form-label" for="collapsible-phone">Adresse géographique <span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control @error('adressGeo_2c') is-invalid @enderror" id="adressGeo_2c" placeholder="" name="adressGeo_2c" value="{{old('adressGeo_2c')}}"/>
                                        @error('adressGeo_2c')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                            </div>
                            <div class="col-md-3">
                                    <label class="form-label" for="collapsible-phone">Formation sollicitée  <span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control @error('formation_2c') is-invalid @enderror" id="formation_2c" placeholder="" name="formation_2c" value="{{old('formation_2c')}}"/>
                                        @error('formation_2c')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                            </div>
                            <div class="col-md-3">
                                    <label class="form-label" for="collapsible-phone">Autres solicitations :</label>
                                        <input type="text" class="form-control" id="autres_form_2c" placeholder="" name="autres_form_2c" value="{{old('autres_form_2c')}}"/>
                            </div>
                    </div>
                    </div>
                </div>
            </div>
            <!-- Conditions -->
            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingCondition">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCondition" aria-expanded="false" aria-controls="collapseCondition">
                    <h5>5. Conditions de départ</h5>
                    </button>
                </h2>
                <div id="collapseCondition" class="accordion-collapse collapse" aria-labelledby="headingCondition" data-bs-parent="#collapsibleSection">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <label class="form-check-label">&bull; Conditions Administratives<span class="text-danger">*</span></label>
                            <div class="col mt-1">
                                <div class="form-check form-check-inline">
                                    <div class="form-check form-check-inline mt-3">
                                        <input name="Condition_admin" class="form-check-input" type="radio" value="fin de contrat" id="fin_contrat"/>
                                        <label class="form-check-label" for="fin_contrat">Fin de contrat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="Condition_admin" class="form-check-input" type="radio" value="depart volontaire" id="depart_volontaire" />
                                        <label class="form-check-label" for="depart_volontaire">Départ Volontaire</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="Condition_admin" class="form-check-input" type="radio" value="démission" id="demission" />
                                        <label class="form-check-label" for="demission">Démission</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="Condition_admin" class="form-check-input" type="radio" value="limite d'age" id="limite_age" />
                                        <label class="form-check-label" for="limite_age">Limite d'Age</label>
                                    </div>                                
                                    <div class="form-check form-check-inline">
                                        <input name="Condition_admin" class="form-check-input" type="radio" value="reforme" id="reforme" />
                                        <label class="form-check-label" for="reforme">Reforme</label>
                                    </div>                                
                                    <div class="form-check form-check-inline">
                                        <input name="Condition_admin" class="form-check-input" type="radio" value="radiation" id="radiation" data-bs-toggle="modal" data-bs-target="#modalToggle"  />
                                        <label class="form-check-label" for="radiation">Radiation</label>
                                    </div>
                                </div>
                                <br><br>
                                @include('layouts.inc.modal')
                            </div>
                            <label for="condition_financiere" class="form-label">&bull; Conditions Financières<span class="text-danger"> *</span></label><br>
                            <i>(Cochez la ou les case(s) corespondant à votre situation en quittant l'institution)</i>
                            <br>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="pecule" value="Pécule" />
                                <label class="form-check-label" for="pecule">Pécule</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="perm" value="PERM" />
                                <label class="form-check-label" for="perm">Plan épagne retraite mutualiste (PERM)</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="pension_retraite" value="Pension retraite" />
                                <label class="form-check-label" for="pension_retraite">Pension retraite</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="pension_reforme" value="Pension de réforme" />
                                <label class="form-check-label" for="pension_reforme">Pension de réforme</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="solde_reforme" value="Solde de réforme" />
                                <label class="form-check-label" for="solde_reforme">Solde de réforme</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="remboussement" value="Remboussement retenue" />
                                <label class="form-check-label" for="remboussement">Remboussement retenue</label>
                            </div>                              
                            <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="checkbox" id="epargne" value="Epargne personnelle" />
                            <label class="form-check-label" for="epargne">Epargne personnelle</label>
                        </div>
                            <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="checkbox" id="assurance" value="Assurance-retaite personnelle" />
                            <label class="form-check-label" for="assurance">Assurance-retaite personnelle</label>
                        </div>
                        </div>
                        <div class="col-md-12">
                                <label class="form-label" for="collapsible-phone">&bull; Conditions disciplinaires <span class="text-danger">*</span> :</label>
                                <textarea class="form-control" id="condition_disciplinaire" placeholder="Précisez" name="condition_disciplinaire" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Acident ou maladie -->
            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingAcident">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAcident" aria-expanded="false" aria-controls="collapseAcident">
                    <h5>6. Accident/Maladie</h5>
                </button>
                </h2>
                <div id="collapseAcident" class="accordion-collapse collapse" aria-labelledby="headingAcident" data-bs-parent="#collapsibleSection">
                    <div class="accordion-body">
                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">&bull; Accident ou maladie</label>
                            <div class="col mt-2">
                                <div class="form-check form-check-inline">
                                    <input name="accident_maladie" class="form-check-input" type="radio" value="Blessé en opération" id="blesse_operation" />
                                    <label class="form-check-label" for="blesse_operation">Blessé en opération</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="accident_maladie" class="form-check-input" type="radio" value="Blessé en service" id="blesse_service" />
                                    <label class="form-check-label" for="blesse_service">Blessé en service</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="accident_maladie" class="form-check-input" type="radio" value="Handicap" id="handicap" />
                                    <label class="form-check-label" for="handicap">Handicap</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="accident_maladie" class="form-check-input" type="radio" value="Maladie professionnelle" id="maladie_prof" />
                                    <label class="form-check-label" for="maladie_prof">Maladie professionnelle</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="accident_maladie" class="form-check-input" type="radio" value="Aucun" id="aucun" />
                                    <label class="form-check-label" for="maladie_prof">Aucun</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-header mb-3">
                        <h6 class="mb-0">&bull; Démarches déjà entreprises</h6>
                    </div>
                    <div class="row g-3">
                            <div class="col-md-4">
                                    <label class="form-label" for="collapsible-phone">Démarche de quelle nature ? <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('demarche_nature') is-invalid @enderror" id="demarche_nature" placeholder="Préciser" name="demarche_nature" value="{{old('demarche_nature')}}" disabled/>
                                        @error('demarche_nature')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                            </div>
                            <div class="col-md-4">
                                    <label class="form-label" for="collapsible-phone">Démarche de quelle administration ? <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('demarche_admin') is-invalid @enderror" id="demarche_admin" placeholder="Préciser" name="demarche_admin" value="{{old('demarche_admin')}}" disabled/>
                                        @error('demarche_admin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                            </div>
                            <div class="col-md-4">
                                    <label class="form-label" for="collapsible-phone">Etat d'avancement des démarches ? <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('etat_avancement') is-invalid @enderror" id="etat_avancement" placeholder="Préciser" name="etat_avancement" value="{{old('etat_avancement ')}}" disabled/>
                                        @error('etat_avancement ')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                            </div>
                            <br>
                            <div class="content-header mb-3">
                                <h6 class="mb-0">&bull; Indications ou commentaires supplémentaires</h6>
                            </div>
                            <div class="col-md-12">
                                    <label class="form-label" for="collapsible-phone">Indications ou commentaires <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="indication" placeholder="Préciser" name="indication" rows="5" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         <!-- Pièces jointes -->
            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingPaymentMethod">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePaymentMethod" aria-expanded="false" aria-controls="collapsePaymentMethod">
                        <h5>7. Pièces jointes</h5> 
                    </button>
                </h2>
                <div id="collapsePaymentMethod" class="accordion-collapse collapse" aria-labelledby="headingPaymentMethod" data-bs-parent="#collapsibleSection">
                        <div class="accordion-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Demande manuscrite <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="demande_manuscrite" id="demande_manuscrite" required />
                                    @error('demande_manuscrite')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Curriculum vitae (CV) <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="cv" id="cv" required />
                                    @error('cv')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>                            
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Pièce d'identité (les 2 faces sur la même page) <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="id_card" id="id_card" required />
                                    @error('id_card')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>                            
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Carte professionnelle <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="carte_pro" name="carte_pro" required />
                                    @error('carte_pro')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Fiche d'engagement <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="fiche_engagement" name="fiche_engagement" required />
                                    @error('fiche_engagement')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Fiche individuelle <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="fiche_individuelle" name="fiche_individuelle " required />
                                    @error('fiche_individuelle')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Arrêté de radiation <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="fiche_engagement" name="arrete_radiation" required />
                                    @error('arrete_radiation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Certificat médical<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="certificat" name="certificat" required />
                                    @error('certificat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                </div>
            </div>
            <br>
            <div class="mt-1 text-end">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Valider</button>
                <button type="reset" class="btn btn-label-secondary">Annuler</button>
            </div>
            </div>
        </div>
    </div>
</form>