<section class="wizard-section">
    <div class="row no-gutters">
        <div class="col-10" style="margin:auto; border-radius:0.5rem !important; background-color:#FFFFFF;">
            <div class="form-wizard">
                <form action="" method="post" role="form">
                    <div class="form-wizard-header">
                        <p>Fill all form field to go next step</p>
                        <ul class="list-unstyled form-wizard-steps clearfix">
                            <li class="active"><span>1</span></li>
                            <li><span>2</span></li>
                            <li><span>3</span></li>
                            <li><span>4</span></li>
                            <li><span>5</span></li>
                            <li><span>6</span></li>
                            <li><span>7</span></li>
                        </ul>
                    </div>
                    <fieldset class="wizard-fieldset show">
                        <h5>Etat Civil</h5>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="nom" class="form-label">Nom :</label>
                                    <input type="text" class="form-control" id="nom" value="{{$user->firstname}}" readonly>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="prenoms" class="form-label">Prénom(s) :</label>
                                    <input type="text" class="form-control" id="prenoms" value="{{$user->lastname}}" readonly>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="collapsible-phone">Mécano / N° Identifiant :</label>
                                    <input type="text" class="form-control @error('mecano') is-invalid @enderror" id="mecano" placeholder="0000034535"
                                        name="mecano" value="{{ $user->mecano }}" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="genre" class="form-label">Genre :</label>
                                    <input type="text" class="form-control" id="genre" value="{{$submission->gender}}" readonly>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="hbd" class="form-label">Né(e) le :</label>
                                    <input type="text" class="form-control" id="hbd" value="{{$submission->birth_date}}" readonly>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="piece" class="form-label">Type de pièce :</label>
                                    <input type="text" class="form-control" id="piece" value="{{$submission->type_piece}}" readonly>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="npiece" class="form-label">N° Pièce :</label>
                                    <input type="text" class="form-control" id="npiece" value="{{$submission->no_card}}" readonly>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="etic" class="form-label">Ethnie :</label>
                                    <input type="text" class="form-control" id="etic" value="{{$submission->ethnic}}" readonly>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="reli" class="form-label">Religion :</label>
                                    <input type="text" class="form-control" id="reli" value="{{$submission->religion}}" readonly>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <a href="javascript:;" class="form-wizard-next-btn requis float-right">Suivant</a>
                        </div>
                    </fieldset>
                    <fieldset class="wizard-fieldset">
                        <h5>Situation Matrimoniale</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" for="situation_matrimoniale">Situation Matrimoniale <span class="text-danger">*</span>
                                    :</label>
                                <select name="situation_matrimoniale" id="situation_matrimoniale"
                                    class="form-control @error('situation_matrimoniale') is-invalid @enderror">
                                    <option value="">Selectionner</option>
                                    <option value="marié(e)">Marié(e)</option>
                                    <option value="concubin(e)">Concubin(e)</option>
                                    <option value="celibataire">Célibataire</option>
                                    <option value="divorcé(e)">Divorcé(e)</option>
                                    <option value="veuf(ve)">Veuf(ve)</option>
                                </select>
                                <div class="wizard-form-error"></div>
                                @error('situation_matrimoniale')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-2">
                                <label class="form-label" for="partnerName" style="display: none;">Nom Conjoint(e) <span
                                        class="text-danger">*</span> :</label>
                                <input type="text" id="partnerName" name="partnerName"
                                    class="form-control @error('partnerName') is-invalid @enderror" placeholder="Nom complet"
                                    value="{{old('partnerName')}}" style="display: none" />
                                @error('partnerName')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label" for="partnerJob" style="display: none;">Profession Conjoint(e) <span
                                        class="text-danger">*</span> :</label>
                                <input type="text" id="partnerJob" name="partnerJob"
                                    class="form-control @error('partnerJob') is-invalid @enderror" placeholder="Caissière"
                                    value="{{old('partnerJob')}}" style="display: none" />
                                @error('partnerJob')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label" for="contactPartner" style="display: none;">Contact Conjoint(e) <span
                                        class="text-danger">*</span> :</label>
                                <input type="text" class="form-control @error('contactPartner') is-invalid @enderror" id="contactPartner"
                                    placeholder="0505051010" name="contactPartner" value="{{ old('contactPartner') }}" style="display: none" />
                                @error('contactPartner')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="partnerCard" style="display: none;">Pièce d'identité conjoint(e) <span
                                        class="text-danger">*</span> :</label>
                                <input type="file" class="form-control" name="partnerCard" id="partnerCard" style="display: none" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="marriageCertificate" style="display: none;">Acte de mariage <span
                                        class="text-danger">*</span> :</label>
                                <input type="file" class="form-control" name="marriageCertificate" id="marriageCertificate"
                                    style="display: none" />
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
                                        <button type="button" class="btn btn-outline-info add__items__btn fs-10"><span
                                                class="fa-solid fa-plus-circle">&nbsp;</span>
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
                                        <div class="form-group">
                                            <label class="form-label" for="collapsible-phone">Email :</label>
                                            <input type="email" name="email" id="email" class="form-control  @error('email') is-invalid @enderror"
                                            placeholder="john.doe@email.com" aria-label="john.doe" value="{{$user->email}}" />
                                            <div class="wizard-form-error"></div>
                                        </div>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label" for="collapsible-phone">Mobile :</label>
                                            <input type="text" class="form-control  @error('mobile') is-invalid @enderror" id="mobile"
                                            placeholder="0707252525" name="mobile" value="{{$submission->phone_number}}" disabled />
                                            <div class="wizard-form-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label" for="collapsible-phone">Lieu d'habitation <span class="text-danger">*</span>
                                            :</label>
                                            <input type="text" class="form-control  @error('residence') is-invalid @enderror" id="residence"
                                            placeholder="Cocody cité des arts" name="residence" />
                                            <div class="wizard-form-error"></div>
                                        </div>
                                        @error('residence')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label" for="collapsible-phone">Adresse postale :</label>
                                            <input type="text" class="form-control  @error('address') is-invalid @enderror" id="address"
                                            placeholder="01 BP 0251 Abidjan 01" name="address" value="{{old('address')}}" required />
                                            <div class="wizard-form-error"></div>
                                        </div>
                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix text-right">
                            <a href="javascript:;" class="form-wizard-previous-btn float-left">Précédent</a>
                            <a href="javascript:;" class="form-wizard-next-btn requis float-right">Suivant</a>
                        </div>
                    </fieldset>
                    <fieldset class="wizard-fieldset">
                        <h5>Situation Professionnelle</h5>
                        <div class="accordion-body">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">A. Origine</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-state">Armée ou Arme <span class="text-danger">*</span> :</label>
                                        <div class="input-group">
                                            <select name="armee" id="armee" class="form-control  @error('armee') is-invalid @enderror">
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
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-phone">Unité de rattachement <span class="text-danger">*</span>
                                        :</label>
                                        <input type="text" class="form-control  @error('unite_rattachement') is-invalid @enderror"
                                        id="unite_rattachement" placeholder="1ère LEGION MILITAIRE" name="unite_rattachement"
                                        value="{{ old('unite_rattachement') }}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                    @error('Unite_rattachement')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-state">Statut <span class="text-danger">*</span> :</label>
                                        <div class="input-group">
                                            <select name="statut_prof" id="statut_prof"
                                                class="form-control  @error('statut_prof') is-invalid @enderror">
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
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-phone">Dernier grade <span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control  @error('grade') is-invalid @enderror" id="grade"
                                        placeholder="Ex: ADJUDANT-CHEF" name="grade" value="{{ old('grade') }}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                    @error('grade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="date_entree">Date d'entrée en service <span class="text-danger">*</span> :</label>
                                        <input type="date" class="form-control " id="date_entree" name="date_entree"
                                        onchange="updateRadiationDateOptions(); calculateServiceDuration()" value="{{ old('date_entree') }}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                    @error('date_entree')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="date_radiation">Date de radiation <span class="text-danger">*</span> :</label>
                                        <input type="date" class="form-control " id="date_radiation" name="date_radiation"
                                        onchange="calculateServiceDuration()" value="{{ old('date_radiation') }}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                    @error('date_radiation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="duree_service">Durée de service :</label>
                                        <input type="text" class="form-control " id="duree_service" placeholder="" name="duree_service"
                                            value="{{ old('duree_service') }}" disabled />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="content-header mb-3">
                                <h6 class="mb-0">B. Emplois successifs</h6>
                            </div>
                            <div class="box-body">
                                <div class="d-flex justify-content mb-4">
                                    <div class="">
                                        <button type="button" class="btn btn-outline-info add__emp__btn fs-10"><span
                                                class="fa-solid fa-plus-circle">&nbsp;</span>
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
                                        <button type="button" class="btn btn-outline-info add__dom__btn fs-10"><span
                                                class="fa-solid fa-plus-circle">&nbsp;</span>
                                            Ajouter Diplôme
                                        </button>
                                    </div>
                                </div>
                                <div id="items__diplome"></div>
                            </div>
                        
                        </div>
                        <div class="form-group clearfix">
                            <a href="javascript:;" class="form-wizard-previous-btn float-left">Précédent</a>
                            <a href="javascript:;" class="form-wizard-next-btn requis float-right">Suivant</a>
                        </div>
                    </fieldset>
                    <fieldset class="wizard-fieldset">
                        <h5>Projet Professionnel</h5>
                        <div class="accordion-body">
                            <div class="form-group">
                                <label class="form-check-label">Orientation envisagée<span class="text-danger">*</span></label> <br>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input name="orientation" class="form-check-input" type="radio" value="fonction_publique"
                                            id="fonction_publique" />
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
                                <div class="wizard-form-error"></div>
                            </div>
                            
                            <div class="content-header mb-3">
                                <h6 class="mb-0">&bull; 1er Choix</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-phone">Domaine <span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control @error('domaine_1c') is-invalid @enderror" id="domaine_1c"
                                        placeholder="" name="domaine_1c" value="{{old('domaine_1c')}}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                    @error('domaine_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-phone">Spécialisation <span class="text-danger">*</span>
                                        :</label>
                                        <input type="text" class="form-control @error('specialisation_1c') is-invalid @enderror"
                                        id="specialisation_1c" placeholder="" name="specialisation_1c" value="{{old('specialisation_1c')}}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                    @error('specialisation_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-state">Région de retraite <span class="text-danger">*</span>
                                            :</label>
                                        <div class="input-group">
                                            <select class="form-control  @error('region_retraite_1c') is-invalid @enderror" aria-label="Default select example"
                                                name="region_retraite_1c">
                                                <option value="">Selectionner</option>
                                                @foreach (DISTRICTS as $district)
                                                <option value="{{ $district }}">{{ $district }}</option>
                                                @endforeach
                                            </select>
                                            @error('region_retraite_1c')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-state">Département de retraite <span class="text-danger">*</span>
                                            :</label>
                                        <div class="input-group">
                                            <select class="form-control  @error('department_1c') is-invalid @enderror" aria-label="Default select example"
                                                name="department_1c">
                                                <option value="">Selectionner</option>
                                                @foreach (CITIES as $city)
                                                <option value="{{ $city }}">{{ $city }}</option>
                                                @endforeach
                                            </select>
                                            @error('department_1c')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-state">Localité de retraite <span class="text-danger">*</span>
                                            :</label>
                                        <div class="input-group">
                                            <select class="form-control  @error('locality_1c') is-invalid @enderror" aria-label="Default select example"
                                                name="locality_1c">
                                                <option value="">Selectionner</option>
                                                @foreach (CITIES as $city)
                                                <option value="{{ $city }}">{{ $city }}</option>
                                                @endforeach
                                            </select>
                                            @error('department_1c')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-phone">Adresse géographique <span class="text-danger">*</span>
                                        :</label>
                                        <input type="text" class="form-control @error('adressGeo_1c') is-invalid @enderror" id="adressGeo_1c"
                                        placeholder="" name="adressGeo_1c" value="{{old('adressGeo_1c')}}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                    @error('adressGeo_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-phone">Formation sollicitée <span class="text-danger">*</span>
                                        :</label>
                                        <input type="text" class="form-control  @error('formation_1c') is-invalid @enderror" id="formation_1c"
                                        placeholder="" name="formation_1c" value="{{old('formation_1c')}}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                    @error('formation_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-phone">Autres solicitations :</label>
                                        <input type="text" class="form-control " id="autres_form_1c" placeholder="" name="autres_form_1c"
                                        value="{{old('autres_form_1c')}}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="content-header mb-3">
                                <h6 class="mb-0">&bull; 2e Choix</h6>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-phone">Domaine <span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control @error('domaine_2c') is-invalid @enderror" id="domaine_2c"
                                        placeholder="" name="domaine_2c" value="{{old('domaine_2c')}}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                    @error('domaine_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-phone">Spécialisation <span class="text-danger">*</span>
                                        :</label>
                                        <input type="text" class="form-control @error('specialisation_2c') is-invalid @enderror"
                                        id="specialisation_2c" placeholder="" name="specialisation_2c" value="{{old('specialisation_2c')}}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                    @error('specialisation_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                        
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-state">Région de retraite :</label>
                                        <div class="input-group">
                                            <select class="form-control @error('region_retraite_2c') is-invalid @enderror"
                                                aria-label="Default select example" name="region_retraite_2c">
                                                <option value="">Selectionner</option>
                                                @foreach (DISTRICTS as $district)
                                                <option value="{{ $district }}">{{ $district }}</option>
                                                @endforeach
                                            </select>
                                            @error('region_retraite_2c')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-state">Département de retraite :</label>
                                        <div class="input-group">
                                            <select class="form-control @error('department_2c') is-invalid @enderror" aria-label="Default select example"
                                                name="department_2c">
                                                <option value="">Selectionner</option>
                                                @foreach (CITIES as $city)
                                                <option value="{{ $city }}">{{ $city }}</option>
                                                @endforeach
                                            </select>
                                            @error('department_2c')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-state">Localité de retraite :</label>
                                        <div class="input-group">
                                            <select class="form-control  @error('locality_2c') is-invalid @enderror" aria-label="Default select example"
                                                name="locality_2c">
                                                <option value="">Selectionner</option>
                                                @foreach (CITIES as $city)
                                                <option value="{{ $city }}">{{ $city }}</option>
                                                @endforeach
                                            </select>
                                            @error('department_2c')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-phone">Adresse géographique <span class="text-danger">*</span>
                                            :</label>
                                        <input type="text" class="form-control  @error('adressGeo_2c') is-invalid @enderror" id="adressGeo_2c"
                                            placeholder="" name="adressGeo_2c" value="{{old('adressGeo_2c')}}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                    @error('adressGeo_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-phone">Formation sollicitée <span class="text-danger">*</span>
                                            :</label>
                                        <input type="text" class="form-control  @error('formation_2c') is-invalid @enderror" id="formation_2c"
                                            placeholder="" name="formation_2c" value="{{old('formation_2c')}}" />
                                        <div class="wizard-form-error"></div>
                                    </div>
                                    @error('formation_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="collapsible-phone">Autres solicitations :</label>
                                        <input type="text" class="form-control " id="autres_form_2c" placeholder="" name="autres_form_2c"
                                            value="{{old('autres_form_2c')}}" />
                                    <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <a href="javascript:;" class="form-wizard-previous-btn float-left">Précédent</a>
                            <a href="javascript:;" class="form-wizard-next-btn requis float-right">Suivant</a>
                            
                        </div>
                    </fieldset>
                    <fieldset class="wizard-fieldset">
                        <h5>Conditions de départ</h5>
                        <div class="accordion-body">
                            <div class="mb-3">
                                <label class="form-check-label">&bull; Conditions Administratives<span class="text-danger">*</span></label>
                                <div class="col mt-1">
                                    <div class="form-check form-check-inline">
                                        <div class="form-check form-check-inline mt-3">
                                            <input name="Condition_admin" class="form-check-input" type="radio" value="fin de contrat"
                                                id="fin_contrat" />
                                            <label class="form-check-label" for="fin_contrat">Fin de contrat</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input name="Condition_admin" class="form-check-input" type="radio" value="depart volontaire"
                                                id="depart_volontaire" />
                                            <label class="form-check-label" for="depart_volontaire">Départ Volontaire</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input name="Condition_admin" class="form-check-input" type="radio" value="démission"
                                                id="demission" />
                                            <label class="form-check-label" for="demission">Démission</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input name="Condition_admin" class="form-check-input" type="radio" value="limite d'age"
                                                id="limite_age" />
                                            <label class="form-check-label" for="limite_age">Limite d'Age</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input name="Condition_admin" class="form-check-input" type="radio" value="reforme" id="reforme" />
                                            <label class="form-check-label" for="reforme">Reforme</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input name="Condition_admin" class="form-check-input" type="radio" value="radiation" id="radiation"
                                                data-bs-toggle="modal" data-bs-target="#modalToggle" />
                                            <label class="form-check-label" for="radiation">Radiation</label>
                                        </div>
                                    </div>
                                    <br><br>
                                    @include('layouts.inc.modal')
                                </div>
                                <label for="condition_financiere" class="form-label">&bull; Conditions Financières<span class="text-danger">
                                        *</span></label><br>
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
                                <label class="form-label" for="collapsible-phone">&bull; Conditions disciplinaires <span
                                        class="text-danger">*</span> :</label>
                                <textarea class="form-control" id="condition_disciplinaire" placeholder="Précisez"
                                    name="condition_disciplinaire" rows="5" required></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <a href="javascript:;" class="form-wizard-previous-btn float-left">Précédent</a>
                            <a href="javascript:;" class="form-wizard-next-btn requis float-right">Suivant</a>
                        </div>
                    </fieldset>
                    <fieldset class="wizard-fieldset">
                        <h5>Accident/Maladie</h5>
                        <div class="accordion-body">
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">&bull; Accident ou maladie</label>
                                    <div class="col mt-2">
                                        <div class="form-check form-check-inline">
                                            <input name="accident_maladie" class="form-check-input" type="radio" value="Blessé en opération"
                                                id="blesse_operation" />
                                            <label class="form-check-label" for="blesse_operation">Blessé en opération</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input name="accident_maladie" class="form-check-input" type="radio" value="Blessé en service"
                                                id="blesse_service" />
                                            <label class="form-check-label" for="blesse_service">Blessé en service</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input name="accident_maladie" class="form-check-input" type="radio" value="Handicap"
                                                id="handicap" />
                                            <label class="form-check-label" for="handicap">Handicap</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input name="accident_maladie" class="form-check-input" type="radio" value="Maladie professionnelle"
                                                id="maladie_prof" />
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
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input name="orientation" class="form-check-input" type="radio" value="oui" id="oui"
                                            onchange="toggleDemarcheFields()" />
                                        <label class="form-check-label" for="oui">Oui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="orientation" class="form-check-input" type="radio" value="non" id="non"
                                            onchange="toggleDemarcheFields()" />
                                        <label class="form-check-label" for="non">Non</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div id="demarche_fields" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="collapsible-phone">Démarche de quelle nature ? <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('demarche_nature') is-invalid @enderror" id="demarche_nature"
                                                placeholder="Préciser" name="demarche_nature" value="{{old('demarche_nature')}}" />
                                            @error('demarche_nature')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="collapsible-phone">Démarche de quelle administration ? <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('demarche_admin') is-invalid @enderror" id="demarche_admin"
                                                placeholder="Préciser" name="demarche_admin" value="{{old('demarche_admin')}}" />
                                            @error('demarche_admin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="collapsible-phone">Etat d'avancement des démarches ? <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('etat_avancement') is-invalid @enderror" id="etat_avancement"
                                                placeholder="Préciser" name="etat_avancement" value="{{old('etat_avancement ')}}" />
                                            @error('etat_avancement ')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="content-header mb-3">
                                    <h6 class="mb-0">&bull; Indications ou commentaires supplémentaires</h6>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="collapsible-phone">Indications ou commentaires <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="indication" placeholder="Préciser" name="indication" rows="5"
                                        disabled></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <a href="javascript:;" class="form-wizard-previous-btn float-left">Précédent</a>
                            <a href="javascript:;" class="form-wizard-next-btn requis float-right">Suivant</a>
                        </div>
                    </fieldset>
                    <fieldset class="wizard-fieldset">
                        <h5>Pièces jointes</h5>
                        <div class="accordion-body">
                        
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Demande manuscrite <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="demande_manuscrite" id="demande_manuscrite" required />
                                    @error('demande_manuscrite')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Curriculum vitae (CV) <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="cv" id="cv" required />
                                    @error('cv')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Pièce d'identité (les 2 faces sur la même page)
                                        <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="id_card" id="id_card" required />
                                    @error('id_card')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Carte professionnelle <span
                                            class="text-danger">*</span></label>
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
                                    <label class="form-label" for="basic-default-upload-file">Fiche d'engagement <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="fiche_engagement" name="fiche_engagement" required />
                                    @error('fiche_engagement')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Fiche individuelle <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="fiche_individuelle" name="fiche_individuelle " required />
                                    @error('fiche_individuelle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Arrêté de radiation <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="fiche_engagement" name="arrete_radiation" required />
                                    @error('arrete_radiation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-default-upload-file">Certificat médical<span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="certificat" name="certificat" required />
                                    @error('certificat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        
                        </div>
                        <div class="form-group clearfix">
                            <a href="javascript:;" class="form-wizard-previous-btn float-left">Précédent</a>
                            <button type="submit" class="form-wizard-submit float-right">Envoyer</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</section>


<script>
    function toggleDemarcheFields() {
        var ouiRadio = document.getElementById("oui");
        var demarcheFields = document.getElementById("demarche_fields");

        if (ouiRadio.checked) {
            demarcheFields.style.display = "block";
        } else {
            demarcheFields.style.display = "none";
        }
    }
</script>


<script>
    function updateRadiationDateOptions() {
        var dateEntree = new Date(document.getElementById("date_entree").value);
        var dateRadiation = document.getElementById("date_radiation");

        dateRadiation.min = dateEntree.toISOString().split('T')[0];
    }

    function calculateServiceDuration() {
        var dateEntree = new Date(document.getElementById("date_entree").value);
        var dateRadiation = new Date(document.getElementById("date_radiation").value);
        var dureeService = document.getElementById("duree_service");

        var timeDiff = Math.abs(dateRadiation.getTime() - dateEntree.getTime());
        var years = Math.floor(timeDiff / (1000 * 3600 * 24 * 365));
        timeDiff -= years * (1000 * 3600 * 24 * 365);
        var months = Math.floor(timeDiff / (1000 * 3600 * 24 * 30));
        timeDiff -= months * (1000 * 3600 * 24 * 30);
        var days = Math.floor(timeDiff / (1000 * 3600 * 24));

        dureeService.value = years + " ans, " + months + " mois, " + days + " jours";
    }
</script>
