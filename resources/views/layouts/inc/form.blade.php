<!-- Validation Wizard -->
<div class="col-12 mb-4">
  <h4 class="py-3 breadcrumb-wrapper mb-4">
    <span class="text-muted fw-light">Enregistrement/</span> Candidatures
  </h4>
  <div id="wizard-validation" class="bs-stepper mt-2">
    <div class="bs-stepper-header">
      <!-- Step 1 -->
      <div class="step" data-target="#etat_civil">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">1</span>
          <span class="bs-stepper-label">Etat Civil</span>
        </button>
      </div>
      <!-- Step 2 -->
      <div class="line"></div>
      <div class="step" data-target="#marital_situation">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">2</span>
          <span class="bs-stepper-label">Situation matrimoniale</span>
        </button>
      </div>
      <!-- Step 3 -->
      <div class="line"></div>
      <div class="step" data-target="#address">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">3</span>
          <span class="bs-stepper-label">Coordonnées</span>
        </button>
      </div>
      <!-- Step 4 -->
      <div class="line"></div>
      <div class="step" data-target="#professional">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">4</span>
          <span class="bs-stepper-label">Situation professionnelle</span>
        </button>
      </div>
      <!-- Step 5 -->
      <div class="line"></div>
      <div class="step" data-target="#project">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">5</span>
          <span class="bs-stepper-label">Projet</span>
        </button>
      </div>
      <!-- Step 6 -->
      <div class="line"></div>
      <div class="step" data-target="#condition">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">6</span>
          <span class="bs-stepper-label">Conditions de départ</span>
        </button>
      </div>
      <!-- Step 7 -->
      <div class="line"></div>
      <div class="step" data-target="#accident">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">7</span>
          <span class="bs-stepper-label">Accident ou maladie</span>
        </button>
      </div>
    </div>
    <div class="bs-stepper-content">
      <form id="wizard-validation-form" onSubmit="return false" action="{{ route('inscription.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Etat civil -->
        <div id="etat_civil" class="content">
          <div class="content-header mb-3">
            <h6 class="mb-0">Etat Civil</h6>
            <small>Etape 01</small>
          </div>
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label" for="last_name">Nom <span class="text-danger">*</span></label>
              <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Nom de famille" value="{{$user->lastname}}" disabled/>
              @error('last_name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-6">
              <label class="form-label" for="first_name">Prénom(s) <span class="text-danger">*</span></label>
              <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="Prénoms" value="{{$user->firstname}}" disabled/>
              @error('first_name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-6">
              <label for="gender" class="form-label">Genre <span class="text-danger">*</span></label>
              <input type="text" name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" placeholder="Prénoms" value="{{$submission->gender ?? null}}" disabled/>
            </div>
            <div class="col-sm-6">
              <label for="birth_date" class="form-label">Date de naissance <span class="text-danger">*</span></label>
              <div class="input-group">
                  <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" placeholder="Date de naissance" name="birth_date" value="{{$submission->birth_date}}" disabled/>
                  @error('birth_date')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="col-sm-6">
              <label for="type_piece" class="form-label">Type de pièce <span class="text-danger">*</span></label>
              <input type="text" name="type_piece" id="type_piece" class="form-control @error('first_name') is-invalid @enderror" value="{{$submission->type_piece}}" disabled/>
            </div>
            <div class="col-sm-6">
              <label for="no_card" class="form-label">N° de la pièce <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('no_card') is-invalid @enderror" id="no_card" name="no_card" value="{{$submission->no_card}}" disabled>
            </div>
            <div class="col-sm-6">
              <label for="ethnic" class="form-label">Ethnie <span class="text-danger">*</span></label>
              <input type="text" name="ethnic" id="ethnic" class="form-control @error('ethnic') is-invalid @enderror" value="{{$submission->ethnic}}" disabled/>
            </div>
            <div class="col-sm-6">
              <label for="religion" class="form-label">Réligion <span class="text-danger">*</span></label>
              <input type="text" name="religion" id="religion" class="form-control @error('religion') is-invalid @enderror" value="{{$submission->religion}}" disabled/>

            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-label-secondary btn-prev" disabled> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                <span class="d-sm-inline-block d-none">Précédent</span>
              </button>
              <button class="btn btn-primary btn-next"> <span class="d-sm-inline-block d-none me-sm-1">Suivant</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
            </div>
          </div>
        </div>
        <!-- Situation matrimoniale -->
        <div id="marital_situation" class="content">
          <div class="content-header mb-3">
            <h6 class="mb-0">Situation Matrimoniale</h6>
            <small>Etape 2</small>
          </div>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="situation_matrimoniale" class="form-label">Statut <span class="text-danger">*</span></label>
              <div class="input-group">
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
            <div class="col-sm-6">
              <label class="form-label" for="partnerName">Nom du conjoint <span class="text-danger">*</span></label>
              <input type="text" id="partnerName" name="partnerName" class="form-control @error('partnerName') is-invalid @enderror" placeholder="Doe John" value="{{old('partnerName')}}" />
              @error('partnerName')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-6">
              <label for="partnerJob" class="form-label">Profession du conjoint <span class="text-danger">*</span></label>
              <select class="form-select @error('partnerJob') is-invalid @enderror" aria-label="Default select example" name="partnerJob" >
                  <option value="">Selectionner</option>
                  @foreach (JOBS as $job)
                      <option value="{{ $job }}">{{ $job }}</option>
                  @endforeach
              </select>
              @error('partnerJob')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-6">
              <label for="contactPartner" class="form-label">Contact du conjoint <span class="text-danger">*</span></label>
              <div class="input-group">
                  <input type="text" class="form-control @error('contactPartner') is-invalid @enderror" id="contactPartner" placeholder="0505051010" name="contactPartner" value="{{ old('contactPartner') }}"/>
              </div>
              @error('contactPartner')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <br>
            <div class="content-header mb-3">
              <h6 class="mb-0">Les informations concernant les enfants</h6>
            </div>
                <div class="box-body">
                  <div class="d-flex justify-content mb-4">
                      <div class="">
                          <button type="button" class="btn btn-outline-info add__items__btn fs-10"><span class="fa-solid fa-plus-circle">&nbsp;</span>
                              Ajouter enfant
                          </button>
                      </div>
                  </div>
                  <div id="items__enfant"></div>
              </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                <span class="d-sm-inline-block d-none">Précédent</span>
              </button>
              <button class="btn btn-primary btn-next"> <span class="d-sm-inline-block d-none me-sm-1">Suivant</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
            </div>
          </div>
        </div>
        <!-- Coordonnées -->
        <div id="address" class="content">
          <div class="content-header mb-3">
            <h6 class="mb-0">Coordonnées</h6>
            <small>Etape 3</small>
          </div>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="telephone" class="form-label">Fixe</label>
              <div class="input-group">
                  <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone" placeholder="2725252525" name="telephone"/>
              </div>
              @error('telephone')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-6">
              <label for="mobile" class="form-label">Téléphone Mobile</label>
              <div class="input-group">
                  <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" placeholder="0707252525" name="mobile" value="{{$submission->phone_number}}" disabled/>
              </div>
              @error('mobile')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-6">
              <label class="form-label" for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="john.doe@email.com" aria-label="john.doe" value="{{old('email')}}"/>
            </div>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="col-sm-6">
              <label for="address" class="form-label">adresse postale</label>
              <div class="input-group">
                  <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="01 BP 0251 Abidjan 01" name="address" value="{{old('address')}}"/>
              </div>
              @error('address')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                <span class="d-sm-inline-block d-none">Précédent</span>
              </button>
              {{-- <button class="btn btn-success btn-next btn-submit">Suivant</button> --}}
              <button class="btn btn-primary btn-next"> <span class="d-sm-inline-block d-none me-sm-1">Suivant</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
            </div>
          </div>
        </div>
        <!-- Situation professionnelle -->
        <div id="professional" class="content">
                <h6 class="mb-0">Situation Professionnelle</h6>
                <small>Etape 4</small>
              <br>
              <br>
              <div class="content-header mb-3">
                <h6 class="mb-0">1. Origine</h6>
              </div>
            <div class="row g-3">
                <div class="col-sm-2">
                  <label for="armee" class="form-label">Armée<span class="text-danger">*</span></label>
                  <div class="input-group"> 
                      <select name="armee" id="armee" class="form-control @error('armee') is-invalid @enderror">
                        <option value="">Selectionner</option>
                        <option value="terre">Terre</option>
                        <option value="air">Air</option>
                        <option value="Marine">Marine</option>
                        <option value="gendarmerie">Gendarmerie</option>
                        <option value="force_speciales">Force speciales</option>
                        <option value="autre">Autres</option>
                      </select>
                      @error('armee')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
                </div>
                <div class="col-sm-4">
                  <label for="unite_rattachement" class="form-label">Unité de rattachement <span class="text-danger">*</span></label>
                  <div class="input-group"> 
                      <input type="text" class="form-control @error('unite_rattachement') is-invalid @enderror" id="unite_rattachement" placeholder="Ex: 1ère REGION MILITAIRE" name="unite_rattachement" value="{{ old('unite_rattachement') }}"/>
                  </div>
                  @error('unite_rattachement')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-sm-2">
                  <label for="statut_prof" class="form-label">Statut <span class="text-danger">*</span></label>
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
                <div class="col-sm-4">
                  <label for="grade" class="form-label">Dernier grade <span class="text-danger">*</span></label>
                  <div class="input-group">
                      <input type="text" class="form-control @error('grade') is-invalid @enderror" id="grade" placeholder="Ex: ADJUDANT-CHEF" name="grade" value="{{ old('grade') }}"/>
                  </div>
                  @error('grade')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-sm-2">
                  <label for="mecano" class="form-label">Numéros indentifiants <span class="text-danger">*</span></label>
                  <div class="input-group">
                      <input type="text" class="form-control @error('mecano') is-invalid @enderror" id="mecano" placeholder="0000034535" name="mecano" value="{{ $user->mecano }}" disabled/>
                  </div>
                  @error('mecano')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-sm-3">
                  <label for="duree_service" class="form-label">Durée du service <span class="text-danger">*</span></label>
                  <div class="input-group"> 
                      <input type="text" class="form-control @error('duree_service') is-invalid @enderror" id="duree_service" placeholder="" name="duree_service" value="{{ old('duree_service') }}"/>
                  </div>
                  @error('duree_service')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
            </div>
              <br>
              <div class="content-header mb-3">
                <h6 class="mb-0">2. Emplois successifs</h6>
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
                <h6 class="mb-0">3. Domaine de spécialité </h6>
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
            <br>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                <span class="d-sm-inline-block d-none">Précédent</span>
              </button>
              {{-- <button class="btn btn-success btn-next btn-submit">Suivant</button> --}}
              <button class="btn btn-primary btn-next"> <span class="d-sm-inline-block d-none me-sm-1">Suivant</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
            </div>
        </div>
        <!-- Projet -->
        <div id="project" class="content">
          <div class="content-header mb-3">
            <h6 class="mb-0">Projet Professionnel</h6>
            <small>Etape 5</small>
          </div>
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-check-label">Orientation envisagée<span class="text-danger">*</span></label>
              <div class="col mt-2">
                <div class="form-check form-check-inline">
                  <input name="orientation" class="form-check-input" type="radio" value="fonction_publique" id="fonction_publique" checked="" />
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
            <div class="content-header mb-1">
              <h6 class="mb-0">&bull; 1er Choix</h6>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <label for="domaine_1c" class="form-label">Domaine <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control @error('domaine_1c') is-invalid @enderror" id="domaine_1c" placeholder="" name="domaine_1c" value="{{old('domaine_1c')}}"/>
                </div>
                @error('domaine_1c')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-sm-3">
                <label for="specialisation_1c" class="form-label">Spécialisation <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control @error('specialisation_1c') is-invalid @enderror" id="specialisation_1c" placeholder="" name="specialisation_1c" value="{{old('specialisation_1c')}}"/>
                </div>
                @error('specialisation_1c')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-sm-3">
                <label for="region_retraite_1c" class="form-label">Région de retraite <span class="text-danger">*</span></label>
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
              <div class="col-sm-3">
                <label for="department_1c" class="form-label">Département de retrait <span class="text-danger">*</span></label>
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
            <div class="row">
              <div class="col-sm-3">
                <label for="locality_1c" class="form-label">Localité de retrait <span class="text-danger">*</span></label>
              <select class="form-select @error('locality_1c') is-invalid @enderror" aria-label="Default select example" name="locality_1c" >
                  <option value="">Selectionner</option>
                  @foreach (CITIES as $city)
                      <option value="{{ $city }}">{{ $city }}</option>
                  @endforeach
              </select>
              @error('locality_1c')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              </div>
              <div class="col-sm-3">
                <label for="adressGeo_1c" class="form-label">Adresse geographique <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control @error('adressGeo_1c') is-invalid @enderror" id="adressGeo_1c" placeholder="" name="adressGeo_1c" value="{{old('adressGeo_1c')}}"/>
                </div>
                @error('adressGeo_1c')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-sm-3">
                <label for="formation_1c" class="form-label">Formation sollicitée <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control @error('formation_1c') is-invalid @enderror" id="formation_1c" placeholder="" name="formation_1c" value="{{old('formation_1c')}}"/>
                </div>
                @error('formation_1c')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-sm-3">
                <label for="autres_form_1c" class="form-label">Autres sollicitations</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="autres_form_1c" placeholder="" name="autres_form_1c" value="{{old('autres_form_1c')}}"/>
                </div>
                @error('autres_form_1c')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <br>
            <div class="content-header mb-1">
              <h6 class="mb-0">&bull; 2e Choix</h6>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <label for="domaine_2c" class="form-label">Domaine <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control @error('domaine_2c') is-invalid @enderror" id="domaine_2c" placeholder="" name="domaine_2c" value="{{old('domaine_2c')}}"/>
                </div>
                @error('domaine_2c')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-sm-3">
                <label for="specialisation_2c" class="form-label">Spécialisation <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control @error('specialisation_2c') is-invalid @enderror" id="specialisation_2c" placeholder="" name="specialisation_2c" value="{{old('specialisation_2c')}}"/>
                </div>
                @error('specialisation_2c')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-sm-3">
                <label for="region_retraite_2c" class="form-label">Région de retraite <span class="text-danger">*</span></label>
                <select class="form-select @error('region_retraite_2c') is-invalid @enderror" aria-label="Default select example" name="region_retraite_2c" value="{{old('region_retraite_2c')}}">
                  <option value="">Selectionner</option>
                  @foreach (DISTRICTS as $district)
                      <option value="{{ $district }}">{{ $district }}</option>
                  @endforeach
              </select>
              @error('region_retraite_2c')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              </div>
              <div class="col-sm-3">
                <label for="department_2c" class="form-label">Département de retrait <span class="text-danger">*</span></label>
              <select class="form-select @error('department_2c') is-invalid @enderror" aria-label="Default select example" name="department_2c" value="{{old('department_2c')}}" >
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
            <div class="row">
              <div class="col-sm-3">
                <label for="locality_2c" class="form-label">Localité de retrait <span class="text-danger">*</span></label>
              <select class="form-select @error('locality_2c') is-invalid @enderror" aria-label="Default select example" name="locality_2c" value="{{old('locality_2c')}}">
                  <option value="">Selectionner</option>
                  @foreach (CITIES as $city)
                      <option value="{{ $city }}">{{ $city }}</option>
                  @endforeach
              </select>
              @error('locality_2c')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              </div>
              <div class="col-sm-3">
                <label for="adressGeo_2c" class="form-label">Adresse geographique <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control" id="adressGeo_2c" placeholder="" name="adressGeo_2c" value="{{old('adressGeo_2c')}}"/>
                </div>
                @error('adressGeo_2c')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-sm-3">
                <label for="formation_2c" class="form-label">Formation sollicitée <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control" id="formation_2c" placeholder="" name="formation_2c" value="{{old('formation_2c')}}"/>
                </div>
                @error('formation_2c')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-sm-3">
                <label for="autres_form_2c" class="form-label">Autres sollicitations</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="autres_form_2c" placeholder="" name="autres_form_2c" value="{{old('autres_form_2c')}}"/>
                </div>
                @error('autres_form_2c')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div><br><br><br><br> 
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                <span class="d-sm-inline-block d-none">Précédent</span>
              </button>
              <button class="btn btn-primary btn-next"> <span class="d-sm-inline-block d-none me-sm-1">Suivant</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
            </div>
          </div>
        </div>
        <!-- Conditions -->
        <div id="condition" class="content">
          <div class="content-header mb-3">
            <h6 class="mb-0">Conditions de départ</h6>
            <small>Etape 6</small>
          </div>
          <div class="row g-3">
            <div class="col-sm-12">
              <label for="condition_administrative" class="form-label">&bull; CONDITIONS ADMINISTRATIVES<span class="text-danger"> *</span></label><br>
                  <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="checkbox" id="fin_contrat"
                          value="Fin de contrat" />
                      <label class="form-check-label" for="fin_contrat">Fin de contrat</label>
                  </div>
                  <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="checkbox" id="depart_volontaire"
                          value="Départ volontaire" />
                      <label class="form-check-label" for="depart_volontaire">Départ Volontaire</label>
                  </div>
                  <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="checkbox" id="demission" value="Démission" />
                      <label class="form-check-label" for="demission">Démission</label>
                  </div>
                  <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="checkbox" id="limite_age"
                          value="Limite d'age" />
                      <label class="form-check-label" for="limite_age">Limite d'Age</label>
                  </div>
                  <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="checkbox" id="reforme" value="Réforme" />
                      <label class="form-check-label" for="reforme">Réforme</label>
                  </div><br><br>
                  <label for="condition_financiere" class="form-label">&bull; CONDITIONS FINANCIERES<span class="text-danger"> *</span></label><br>
                  <i>(Cochez la ou les case(s) corespondant à votre situation en quittant l'institution)</i>
                  <br>
                  <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="checkbox" id="pecule"
                          value="Pécule" />
                      <label class="form-check-label" for="pecule">Pécule</label>
                  </div>
                  <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="checkbox" id="perm"
                          value="PERM" />
                      <label class="form-check-label" for="perm">Plan épagne retraite mutualiste (PERM)</label>
                  </div><br>
                  <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="checkbox" id="pension_retraite" value="Pension retraite" />
                      <label class="form-check-label" for="pension_retraite">Pension retraite</label>
                  </div>
                  <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="checkbox" id="pension_reforme"
                          value="Pension de réforme" />
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
                <br>                                
                  <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="checkbox" id="epargne" value="Epargne personnelle" />
                    <label class="form-check-label" for="epargne">Epargne personnelle</label>
                </div>
                  <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="checkbox" id="assurance" value="Assurance-retaite personnelle" />
                    <label class="form-check-label" for="assurance">Assurance-retaite personnelle</label>
                </div>
                <br><br>
                <div class="row">
                  <div class="col-sm-12">
                    <label for="condition_disciplinaire" class="form-label">&bull; CONDITIONS DISCIPLINAIRES    </label><i>(Décoration obtenue)</i>
                    <div class="input-group">
                        <textarea class="form-control" id="condition_disciplinaire" placeholder="Précisez" name="condition_disciplinaire" rows="5"></textarea>
                    </div>
                    </div>                          
                </div> 
            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                <span class="d-sm-inline-block d-none">Précédent</span>
              </button>
              <button class="btn btn-primary btn-next"> <span class="d-sm-inline-block d-none me-sm-1">Suivant</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
            </div>
          </div>
        </div>
        <!-- Accident ou maladie -->
        <div id="accident" class="content">
          <div class="content-header mb-3">
            <h6 class="mb-0">Accidents/Maladies</h6>
            <small>Etape 7</small>
          </div>
          <div class="row g-3">
            <div class="col-sm-6">
              <div class="content-header mb-1">
                <h6 class="mb-0">&bull; Accident ou maladie</h6>
              </div>
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
            <div class="content-header mb-1">
              <h6 class="mb-0">&bull; Démarches déjà entreprises</h6>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <label for="demarche_nature" class="form-label">Démarche de quelle nature ? <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control @error('demarche_nature') is-invalid @enderror" id="demarche_nature" placeholder="" name="demarche_nature" value="{{old('demarche_nature')}}"/>
                </div>
                @error('demarche_nature')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-sm-4">
                <label for="demarche_admin" class="form-label">Démarche de quelle administration ? <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control @error('demarche_admin') is-invalid @enderror" id="demarche_admin" placeholder="" name="demarche_admin" value="{{old('demarche_admin')}}"/>
                </div>
                @error('demarche_admin')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-sm-4">
                <label for="etat_avancement" class="form-label">Etat d'avancement des démarches ? <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control @error('etat_avancement') is-invalid @enderror" id="etat_avancement" placeholder="" name="etat_avancement" value="{{old('etat_avancement')}}"/>
                </div>
                @error('etat_avancement')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <br>
            <div class="content-header mb-1">
              <h6 class="mb-0">&bull; Indications ou commentaires supplémentaires</h6>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <label for="indication" class="form-label">Indications ou commentaires <span class="text-danger">*</span></label>
                <div class="input-group">
                   <textarea class="form-control @error('indication') is-invalid @enderror" id="indication" placeholder="Préciser" name="indication" rows="5" value="{{old('indication')}}"></textarea>
                </div>
                @error('indication')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
               </div>                          
            </div>
            <br><br>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                <span class="d-sm-inline-block d-none">Précédent</span>
              </button>
              <button class="btn btn-success btn-next btn-submit">Soumettre</button>
              {{-- <button class="btn btn-primary btn-next"> <span class="d-sm-inline-block d-none me-sm-1">Suivant</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button> --}}
            </div> 
          </div>
        </div>        
      </form>
    </div>
  </div>
</div>