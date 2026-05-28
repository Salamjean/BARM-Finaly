@extends('layouts.app')
@section('content')
    @php
        $other_data = regions();

    @endphp
    <div class="container mx-5 flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Utilisateur </span> / <a
                href="{{ route('adherent.show', $user->id) }}">Profil</a> / Edition
        </h4>
        <form action="{{ route('adherent.update.profile', $user->id) }}" method="POST" enctype="multipart/form-data"
            style="gap:10px;">
            @csrf
            @method('PUT')

            <div class="card mb-4">
                <h5 class="card-header pb-0 text-uppercase">Informations personnelles</h5>

                <div class="card-body p-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file-upload" class="form-label fw-bold">Photo d'identité :</label>
                                <input type="file" accept=".jpg, .jpeg, .png" id="file-upload"
                                    class="form-control @error('image') is-invalid @enderror" name="image">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-bold">Aperçu actuel :</label><br>

                            @if ($user->candidate->image)
                                <img src="{{ asset($user->candidate->image) }}" alt="Photo d'identité" width="100px"
                                    height="100px" id="file-preview"
                                    style="object-fit: cover; border: 1px solid #ccc; border-radius: 8px;">
                            @else
                                <img src="#" alt="Aperçu" width="100px" height="100px" id="file-preview"
                                    style="display: none; object-fit: cover; border: 1px solid #ccc; border-radius: 8px;">
                            @endif
                        </div>
                        <!-- Nom -->
                        <div class="col-md-6">
                            <label for="firstname" class="form-label fw-bold">Nom</label>
                            <input type="text" name="firstname" id="firstname"
                                class="form-control @error('firstname') is-invalid @enderror"
                                value="{{ old('firstname', $user->firstname) }}" required />
                            @error('firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Prénom(s) -->
                        <div class="col-md-6">
                            <label for="lastname" class="form-label fw-bold">Prénom(s)</label>
                            <input type="text" name="lastname" id="lastname"
                                class="form-control @error('lastname') is-invalid @enderror"
                                value="{{ old('lastname', $user->lastname) }}" required />
                            @error('lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">E-mail</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date de naissance -->
                        <div class="col-md-6">
                            <label for="birth_date" class="form-label fw-bold">Date de naissance</label>
                            <input type="date" name="birth_date" id="birth_date"
                                class="form-control @error('birth_date') is-invalid @enderror"
                                value="{{ old('birth_date', $user->candidate->birth_date) }}" required />
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Genre -->
                        <div class="col-md-6">
                            <label for="gender" class="form-label fw-bold">Genre</label>
                            <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror"
                                required>
                                <option value="" disabled
                                    {{ old('gender', $user->candidate->gender) ? '' : 'selected' }}>
                                    Sélectionner
                                </option>
                                @foreach (GENDERS as $gender)
                                    <option value="{{ $gender }}"
                                        {{ old('gender', $user->candidate->gender) == $gender ? 'selected' : '' }}>
                                        {{ $gender }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Religion -->
                        <div class="col-md-6">
                            <label for="religion" class="form-label fw-bold">Religion</label>
                            <select name="religion" id="religion"
                                class="form-select @error('religion') is-invalid @enderror">
                                <option value="" disabled
                                    {{ old('religion', $user->candidate->religion) ? '' : 'selected' }}>
                                    Sélectionner
                                </option>
                                @foreach (RELIGIONS as $religion)
                                    <option value="{{ $religion }}"
                                        {{ old('religion', $user->candidate->religion) == $religion ? 'selected' : '' }}>
                                        {{ $religion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('religion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ethnie -->
                        <div class="col-md-6">
                            <label for="ethnic" class="form-label fw-bold">Ethnie</label>
                            <select name="ethnic" id="ethnic" class="form-select @error('ethnic') is-invalid @enderror">
                                <option value="" disabled
                                    {{ old('ethnic', $user->candidate->ethnic) ? '' : 'selected' }}>
                                    Sélectionner
                                </option>
                                @foreach (ETHNICS as $ethnic)
                                    <option value="{{ $ethnic }}"
                                        {{ old('ethnic', $user->candidate->ethnic) == $ethnic ? 'selected' : '' }}>
                                        {{ $ethnic }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ethnic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Numéros de téléphone -->
                        <div class="col-md-6">
                            <label for="phone_number" class="form-label fw-bold">Numéro de téléphone 1</label>
                            <input type="text" name="phone_number" id="phone_number"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                value="{{ old('phone_number', $user->candidate->phone_number) }}" required />
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number2" class="form-label fw-bold">Numéro de téléphone 2</label>
                            <input type="text" name="phone_number2" id="phone_number2"
                                class="form-control @error('phone_number2') is-invalid @enderror"
                                value="{{ old('phone_number2', $user->candidate->phone_number2) }}" />
                            @error('phone_number2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number3" class="form-label fw-bold">Numéro de téléphone 3</label>
                            <input type="text" name="phone_number3" id="phone_number3"
                                class="form-control @error('phone_number3') is-invalid @enderror"
                                value="{{ old('phone_number3', $user->candidate->phone_number3) }}" />
                            @error('phone_number3')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- CGRAE -->
                        <div class="col-md-3">
                            <label for="cgrae_no" class="form-label fw-bold">N° CGRAE</label>
                            <input type="text" name="cgrae_no" id="cgrae_no"
                                class="form-control @error('cgrae_no') is-invalid @enderror"
                                value="{{ old('cgrae_no', $user->candidate->cgrae_no) }}" />
                            @error('cgrae_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div class="col-md-3">
                            <label for="date_inscription" class="form-label fw-bold">Date d'inscription</label>
                            <input type="date" name="date_inscription" id="date_inscription"
                                class="form-control @error('date_inscription') is-invalid @enderror"
                                value="{{ old('date_inscription', $user->candidate->date_inscription) }}" required />
                            @error('date_inscription')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Résidence -->
                        <div class="col-md-6">
                            <label for="residence" class="form-label fw-bold">Résidence</label>
                            <input type="text" name="residence" id="residence"
                                class="form-control @error('residence') is-invalid @enderror"
                                value="{{ old('residence', $user->candidate->residence) }}" required />
                            @error('residence')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-0 text-uppercase">Informations sur la candidature</h5>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Type de pièce -->
                        <div class="col-md-6">
                            <label for="type_piece" class="form-label fw-bold">Type de pièce</label>
                            <select class="form-select @error('type_piece') is-invalid @enderror" id="type_piece"
                                name="type_piece" required>
                                <option value="" disabled
                                    {{ old('type_piece', $user->candidate->type_piece) ? '' : 'selected' }}>
                                    Sélectionner
                                </option>
                                @foreach (TYPEPIECES as $type_piece)
                                    <option value="{{ $type_piece }}"
                                        {{ old('type_piece', $user->candidate->type_piece) == $type_piece ? 'selected' : '' }}>
                                        {{ $type_piece }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_piece')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Numéro de pièce -->
                        <div class="col-md-6">
                            <label for="no_card" class="form-label fw-bold">N° de pièce</label>
                            <input type="text" name="no_card" id="no_card"
                                class="form-control @error('no_card') is-invalid @enderror"
                                value="{{ old('no_card', $user->candidate->no_card) }}" />
                            @error('no_card')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-0 text-uppercase">Contacts d'urgence</h5>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Nom complet du Contact -->
                        <div class="col-md-6">
                            <label for="sos_person_fullname" class="form-label fw-bold">Nom complet</label>
                            <input type="text" name="sos_person_fullname" id="sos_person_fullname"
                                class="form-control @error('sos_person_fullname') is-invalid @enderror"
                                value="{{ old('sos_person_fullname', $user->candidate->sos_person_fullname) }}" />
                            @error('sos_person_fullname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact principal -->
                        <div class="col-md-6">
                            <label for="sos_person_phone_number" class="form-label fw-bold">Contact principal</label>
                            <input type="text" name="sos_person_phone_number" id="sos_person_phone_number"
                                class="form-control @error('sos_person_phone_number') is-invalid @enderror"
                                value="{{ old('sos_person_phone_number', $user->candidate->sos_person_phone_number) }}" />
                            @error('sos_person_phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact secondaire -->
                        <div class="col-md-6">
                            <label for="sos_person_phone_number2" class="form-label fw-bold">Contact secondaire</label>
                            <input type="text" name="sos_person_phone_number2" id="sos_person_phone_number2"
                                class="form-control @error('sos_person_phone_number2') is-invalid @enderror"
                                value="{{ old('sos_person_phone_number2', $user->candidate->sos_person_phone_number2) }}" />
                            @error('sos_person_phone_number2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-0 text-uppercase">Situation matrimoniale</h5>
                <div class="card-body p-4">
                    <!-- Situation matrimoniale -->
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label" for="situation_matrimoniale">Situation Matrimoniale <span
                                    class="text-danger">*</span> :</label>
                            <select name="situation_matrimoniale" id="situation_matrimoniale"
                                class="form-control @error('situation_matrimoniale') is-invalid @enderror" required>
                                <option value="">Sélectionner</option>
                                <option value="marié(e)"
                                    {{ $user->candidate->situation_matrimoniale == 'marié(e)' ? 'selected' : '' }}>
                                    Marié(e)
                                </option>
                                <option value="concubin(e)"
                                    {{ $user->candidate->situation_matrimoniale == 'concubin(e)' ? 'selected' : '' }}>
                                    Concubin(e)
                                </option>
                                <option value="celibataire"
                                    {{ $user->candidate->situation_matrimoniale == 'celibataire' ? 'selected' : '' }}>
                                    Célibataire
                                </option>
                                <option value="divorcé(e)"
                                    {{ $user->candidate->situation_matrimoniale == 'divorcé(e)' ? 'selected' : '' }}>
                                    Divorcé(e)
                                </option>
                                <option value="veuf(ve)"
                                    {{ $user->candidate->situation_matrimoniale == 'veuf(ve)' ? 'selected' : '' }}>
                                    Veuf(ve)
                                </option>
                            </select>
                            <div class="wizard-form-error"></div>
                            @error('situation_matrimoniale')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Champs conditionnels pour les mariés -->
                    <div class="row mt-3" id="married-fields" style="display: none;">
                        <!-- Nom du conjoint -->
                        <div class="col-md-6">
                            <label class="form-label" for="partner_name">Nom Conjoint(e) <span
                                    class="text-danger">*</span> :</label>
                            <input type="text" id="partner_name" name="partner_fullname"
                                class="form-control @error('partner_fullname') is-invalid @enderror"
                                placeholder="Nom complet"
                                value="{{ old('partner_fullname') ?? $user->candidate->partner_fullname }}" />
                            @error('partner_fullname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Profession du conjoint -->
                        <div class="col-md-3">
                            <label class="form-label" for="partner_job">Profession Conjoint(e) :</label>
                            <input type="text" id="partner_job" name="partner_job"
                                class="form-control @error('partner_job') is-invalid @enderror" placeholder="Profession"
                                value="{{ old('partner_job') ?? $user->candidate->partner_job }}" />
                            @error('partner_job')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact conjoint -->
                        <div class="col-md-3">
                            <label class="form-label" for="partner_phone_number">Contact Conjoint(e) <span
                                    class="text-danger">*</span> :</label>
                            <input type="text"
                                class="form-control @error('partner_phone_number') is-invalid @enderror"
                                id="partner_phone_number" placeholder="0505051010" name="partner_phone_number"
                                value="{{ old('partner_phone_number') ?? $user->candidate->partner_phone_number }}" />
                            @error('partner_phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact 2 conjoint -->
                        <div class="col-md-3 mt-3">
                            <label class="form-label" for="partner_phone_number2">Contact 2 Conjoint(e) :</label>
                            <input type="text"
                                class="form-control @error('partner_phone_number2') is-invalid @enderror"
                                id="partner_phone_number2" placeholder="0505051010" name="partner_phone_number2"
                                value="{{ old('partner_phone_number2') ?? $user->candidate->partner_phone_number2 }}" />
                            @error('partner_phone_number2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pièce d'identité conjoint -->
                        <div class="col-md-4 mt-3">
                            <label class="form-label" for="partner_card">Pièce d'identité conjoint(e) : </label>
                            @if ($user->candidate->partner_card)
                                <a href="{{ asset($user->candidate->partner_card) }}" download><i
                                        class="fa-solid fa-down-long"></i></a>
                            @endif
                            <input type="file" class="form-control" name="partner_card" id="partner_card"
                                value="{{ old('partner_card') }}" accept=".pdf" />
                            @error('partner_card')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Acte de mariage -->
                        <div class="col-md-4 mt-3">
                            <label class="form-label" for="marriage_certificate">Acte de mariage :</label>
                            @if ($user->candidate->marriage_certificate)
                                <a href="{{ asset($user->candidate->marriage_certificate) }}" download><i
                                        class="fa-solid fa-down-long"></i></a>
                            @endif
                            <input type="file" class="form-control" name="marriage_certificate"
                                id="marriage_certificate" accept=".pdf" />
                            @error('marriage_certificate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-0 text-uppercase">Informations sur les enfants</h5>
                <div class="card-body p-4">
                    <!-- Bouton pour ajouter un enfant -->
                    <div class="mb-4">
                        <button type="button" class="btn btn-outline-info add__items__btn">
                            <i class="fa-solid fa-plus-circle"></i> Ajouter un enfant
                        </button>
                    </div>

                    <div id="items__enfant">
                        @foreach ($user->candidate->childs as $index => $child)
                            <div class="row g-3 child-item">
                                <!-- Nom & Prénom(s) de l'enfant -->
                                <div class="col-md-6">
                                    <label for="child_name_{{ $index }}" class="form-label fw-bold">Nom &
                                        Prénom(s)
                                        de l'enfant <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('child_name.' . $index) is-invalid @enderror"
                                        id="child_name_{{ $index }}" name="child_name[]"
                                        value="{{ old('child_name.' . $index, $child->fullname) }}" required />
                                    @error('child_name.' . $index)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Date de naissance -->
                                <div class="col-md-3">
                                    <label for="child_birthdate_{{ $index }}" class="form-label fw-bold">Date de
                                        Naissance </label>
                                    <input type="date"
                                        class="form-control @error('child_birthdate.' . $index) is-invalid @enderror"
                                        id="child_birthdate_{{ $index }}" name="child_birthdate[]"
                                        value="{{ old('child_birthdate.' . $index, $child->birth_date) }}" />
                                    @error('child_birthdate.' . $index)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Niveau d'étude -->
                                <div class="col-md-3">
                                    <label for="child_niveau_{{ $index }}" class="form-label fw-bold">Niveau
                                        d'étude</label>
                                    <input type="text"
                                        class="form-control @error('child_niveau.' . $index) is-invalid @enderror"
                                        id="child_niveau_{{ $index }}" name="child_niveau[]"
                                        value="{{ old('child_niveau.' . $index, $child->level) }}" />
                                    @error('child_niveau.' . $index)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Document justificatif -->
                                <div class="col-md-5">
                                    <label for="child_file_{{ $index }}" class="form-label fw-bold">Document
                                        Justificatif </label>
                                    @if ($child->file)
                                        <a href="{{ asset($child->file) }}" download class="d-block mb-2"><i
                                                class="fa-solid fa-download"></i> Télécharger le document existant</a>
                                    @endif
                                    <input type="file"
                                        class="form-control @error('child_file.' . $index) is-invalid @enderror"
                                        id="child_file_{{ $index }}" name="child_file[]" accept=".pdf" />
                                    @error('child_file.' . $index)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Bouton de suppression -->
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove__item__btn">
                                        <i class="bx bx-trash"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-0 text-uppercase">Coordonnées</h5>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Mobile -->
                        <div class="col-md-4">
                            <label for="phone_number" class="form-label fw-bold">Mobile</label>
                            <input type="text" name="phone_number" id="phone_number"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                value="{{ old('phone_number', $user->candidate->phone_number) }}"
                                placeholder="0707252525" required />
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lieu d'habitation -->
                        <div class="col-md-4">
                            <label for="residence" class="form-label fw-bold">Lieu d'habitation <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="residence" id="residence"
                                class="form-control @error('residence') is-invalid @enderror"
                                value="{{ old('residence', $user->candidate->residence) }}"
                                placeholder="Cocody cité des arts" required />
                            @error('residence')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Adresse postale -->
                        <div class="col-md-4">
                            <label for="address" class="form-label fw-bold">Adresse postale</label>
                            <input type="text" name="address" id="address"
                                class="form-control @error('address') is-invalid @enderror"
                                value="{{ old('address', $user->candidate->address) }}"
                                placeholder="01 BP 0251 Abidjan 01" />
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-0 text-uppercase">Origine</h5>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Armée ou Arme -->
                        <div class="col-md-3">
                            <label for="armee" class="form-label fw-bold">Armée ou Arme <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="armee" id="armee"
                                class="form-control @error('armee') is-invalid @enderror"
                                value="{{ old('armee', $user->candidate->armee) }}" placeholder="1ère LEGION MILITAIRE"
                                required />
                            @error('armee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Unité de rattachement -->
                        <div class="col-md-3">
                            <label for="unite_rattachement" class="form-label fw-bold">Unité de rattachement <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="unite_rattachement" id="unite_rattachement"
                                class="form-control @error('unite_rattachement') is-invalid @enderror"
                                value="{{ old('unite_rattachement', $user->candidate->unite_rattachement) }}"
                                placeholder="1ère LEGION MILITAIRE" required />
                            @error('unite_rattachement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="col-md-3">
                            <label for="statut_prof" class="form-label fw-bold">Statut <span
                                    class="text-danger">*</span></label>
                            <select name="statut_prof" id="statut_prof"
                                class="form-control @error('statut_prof') is-invalid @enderror" required>
                                <option value="" selected disabled>Selectionner</option>
                                <option value="Carrière"
                                    {{ old('statut_prof', $user->candidate->statut_prof) == 'Carrière' ? 'selected' : '' }}>
                                    Carrière</option>
                                <option value="Sous contrat"
                                    {{ old('statut_prof', $user->candidate->statut_prof) == 'Sous contrat' ? 'selected' : '' }}>
                                    Sous-contrat</option>
                                <option value="Retraité"
                                    {{ old('statut_prof', $user->candidate->statut_prof) == 'Retraité' ? 'selected' : '' }}>
                                    Retraité</option>
                                <option value="Engagé volontaire"
                                    {{ old('statut_prof', $user->candidate->statut_prof) == 'Engagé volontaire' ? 'selected' : '' }}>
                                    Engagé volontaire</option>
                            </select>
                            @error('statut_prof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dernier grade -->
                        <div class="col-md-3">
                            <label for="grade" class="form-label fw-bold">Dernier grade <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="grade" id="grade"
                                class="form-control @error('grade') is-invalid @enderror"
                                value="{{ old('grade', $user->candidate->grade) }}" placeholder="Ex: ADJUDANT-CHEF"
                                required />
                            @error('grade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <!-- Date d'entrée en service -->
                        <div class="col-md-4">
                            <label for="date_entree" class="form-label fw-bold">Date d'entrée en service <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="date_entree" id="date_entree"
                                class="form-control @error('date_entree') is-invalid @enderror"
                                value="{{ old('date_entree', $user->candidate->date_entree) }}"
                                max="{{ $user->candidate->date_radiation }}" required />
                            @error('date_entree')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date de radiation -->
                        <div class="col-md-4">
                            <label for="date_radiation" class="form-label fw-bold">Date de radiation <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="date_radiation" id="date_radiation"
                                class="form-control @error('date_radiation') is-invalid @enderror"
                                value="{{ old('date_radiation', $user->candidate->date_radiation) }}"
                                max="{{ date('Y-m-d') }}" required />
                            @error('date_radiation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Durée de service -->
                        <div class="col-md-4">
                            <label for="duree_service" class="form-label fw-bold">Durée de service</label>
                            <input type="text" name="duree_service" id="duree_service" class="form-control"
                                value="{{ old('duree_service') }}" placeholder="Calcul automatique" disabled />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-0 text-uppercase">Emplois successifs</h5>
                <div class="card-body p-4">
                    <!-- Bouton pour ajouter un emploi -->
                    <div class="mb-4">
                        <button type="button" class="btn btn-outline-info add__emp__btn">
                            <i class="fa-solid fa-plus-circle"></i> Ajouter un emploi
                        </button>
                    </div>

                    <!-- Liste des emplois -->
                    <div id="items__emploi">
                        @foreach ($user->candidate->jobs as $index => $job)
                            <div class="row g-3 job-item">
                                <!-- Périodes -->
                                <div class="col-md-3">
                                    <label for="periode_{{ $index }}" class="form-label fw-bold">Périodes <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('periode.' . $index) is-invalid @enderror"
                                        id="periode_{{ $index }}" name="periode[]"
                                        value="{{ old('periode.' . $index, $job->periode) }}" placeholder="1984-1986"
                                        required />
                                    @error('periode.' . $index)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Unité -->
                                <div class="col-md-5">
                                    <label for="organism_{{ $index }}" class="form-label fw-bold">Unité <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('organism.' . $index) is-invalid @enderror"
                                        id="organism_{{ $index }}" name="organism[]"
                                        value="{{ old('organism.' . $index, $job->organism) }}"
                                        placeholder="1ère LEGION MILITAIRE ABIDJAN" required />
                                    @error('organism.' . $index)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Fonction -->
                                <div class="col-md-2">
                                    <label for="fonction_{{ $index }}" class="form-label fw-bold">Fonction <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('fonction.' . $index) is-invalid @enderror"
                                        id="fonction_{{ $index }}" name="fonction[]"
                                        value="{{ old('fonction.' . $index, $job->fonction) }}" placeholder="Fonction"
                                        required />
                                    @error('fonction.' . $index)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Bouton de suppression -->
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove__item__btn">
                                        <i class="bx bx-trash"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-0 text-uppercase">Conditions de départ</h5>
                <div class="card-body p-4">
                    <div class="row g-3">
                        {{-- Condition Administrative --}}
                        <div class="col-md-12">
                            <label class="form-label fw-bold">&bull; Condition Administrative <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="condition_admin" id="condition_admin"
                                class="form-control @error('condition_admin') is-invalid @enderror"
                                value="{{ old('condition_admin', $user->candidate->condition_admin) }}" required>
                            @error('condition_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Conditions Financières --}}
                        <div class="col-md-12">
                            <label class="form-label fw-bold mt-3">&bull; Conditions Financières <span
                                    class="text-danger">*</span></label>
                            <i>(Cochez la ou les case(s) correspondant à votre situation en quittant l'institution)</i><br>

                            @php
                                $selectedFinancials = $user->candidate->condition_financiere
                                    ? json_decode($user->candidate->condition_financiere, true)
                                    : [];
                            @endphp

                            @foreach (FINANCIAL_CONDITIONS as $financial)
                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" type="checkbox" name="condition_financiere[]"
                                        id="{{ $financial['id'] }}" value="{{ $financial['value'] }}"
                                        {{ in_array($financial['value'], $selectedFinancials) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="{{ $financial['id'] }}">{{ $financial['value'] }}</label>
                                </div>
                            @endforeach
                        </div>

                        {{-- Conditions Disciplinaires --}}
                        <div class="col-md-12 mt-4">
                            <label class="form-label fw-bold">&bull; Conditions disciplinaires :</label>

                            @php
                                $disciplinaryConditions = $user->candidate->condition_disciplinaire
                                    ? json_decode($user->candidate->condition_disciplinaire)
                                    : [];
                            @endphp

                            <div id="disciplinary-container">
                                @foreach ($disciplinaryConditions as $index => $discipline)
                                    <div class="row g-2 mb-2">
                                        <div class="col-md-8">
                                            <input type="text"
                                                name="condition_disciplinaire[{{ $index }}][title_decoration]"
                                                class="form-control" placeholder="Intitulé de la décoration"
                                                value="{{ $discipline->title_decoration }}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date"
                                                name="condition_disciplinaire[{{ $index }}][date_decoration]"
                                                class="form-control" value="{{ $discipline->date_decoration }}">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-center">
                                            <button type="button" class="btn btn-danger btn-sm remove-disciplinary">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-primary btn-sm mt-2" id="add-disciplinary">
                                <i class="bx bx-plus"></i> Ajouter une décoration
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-0 text-uppercase">Accident ou maladie</h5>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Accident ou maladie -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">&bull; Accident ou maladie <span
                                    class="text-danger">*</span></label>
                            <div class="mt-2">
                                @php
                                    $accidentOptions = [
                                        'Blessé en opération',
                                        'Blessé en service',
                                        'Handicap',
                                        'Maladie professionnelle',
                                        'Aucun',
                                    ];
                                @endphp
                                @foreach ($accidentOptions as $option)
                                    <div class="form-check form-check-inline">
                                        <input name="accident_maladie" class="form-check-input" type="radio"
                                            value="{{ $option }}" id="accident_{{ $loop->index }}"
                                            {{ old('accident_maladie', $user->candidate->accident_maladie) == $option ? 'checked' : '' }}
                                            required />
                                        <label class="form-check-label"
                                            for="accident_{{ $loop->index }}">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('accident_maladie')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Indication de l'accident ou maladie -->
                        <div class="col-md-12 mt-3">
                            <label class="form-label fw-bold" for="maladie_supp">Indication de l'accident ou
                                maladie</label>
                            <textarea class="form-control @error('maladie_supp') is-invalid @enderror" id="maladie_supp" placeholder="Préciser"
                                name="maladie_supp" rows="3">{{ old('maladie_supp', $user->candidate->maladie_supp) }}</textarea>
                            @error('maladie_supp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Démarches déjà entreprises -->
                        <div class="col-md-12 mt-4">
                            <label class="form-label fw-bold">&bull; Démarches déjà entreprises <span
                                    class="text-danger">*</span></label>
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input name="demarche_entreprise" class="form-check-input" type="radio"
                                        value="oui" id="demarche_oui"
                                        {{ old('demarche_entreprise', $user->candidate->demarche_nature ? 'oui' : 'non') == 'oui' ? 'checked' : '' }}
                                        required />
                                    <label class="form-check-label" for="demarche_oui">Oui</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="demarche_entreprise" class="form-check-input" type="radio"
                                        value="non" id="demarche_non"
                                        {{ old('demarche_entreprise', $user->candidate->demarche_nature ? 'oui' : 'non') == 'non' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="demarche_non">Non</label>
                                </div>
                            </div>
                        </div>

                        <!-- Champs conditionnels pour les démarches -->
                        <div class="row g-3 mt-2" id="demarche_fields"
                            style="display: {{ old('demarche_entreprise', $user->candidate->demarche_nature ? 'oui' : 'non') == 'oui' ? 'block' : 'none' }};">
                            <div class="col-md-4">
                                <label class="form-label fw-bold" for="demarche_nature">Démarche de quelle nature ? <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('demarche_nature') is-invalid @enderror"
                                    id="demarche_nature" placeholder="Préciser" name="demarche_nature"
                                    value="{{ old('demarche_nature', $user->candidate->demarche_nature) }}" />
                                @error('demarche_nature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold" for="demarche_admin">Démarche de quelle administration ?
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('demarche_admin') is-invalid @enderror"
                                    id="demarche_admin" placeholder="Préciser" name="demarche_admin"
                                    value="{{ old('demarche_admin', $user->candidate->demarche_admin) }}" />
                                @error('demarche_admin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold" for="etat_avancement">Etat d'avancement des démarches ?
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('etat_avancement') is-invalid @enderror"
                                    id="etat_avancement" placeholder="Préciser" name="etat_avancement"
                                    value="{{ old('etat_avancement', $user->candidate->etat_avancement) }}" />
                                @error('etat_avancement')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Indications ou commentaires supplémentaires -->
                        <div class="col-md-12 mt-3">
                            <label class="form-label fw-bold" for="indication">Indications ou commentaires
                                supplémentaires</label>
                            <textarea class="form-control @error('indication') is-invalid @enderror" id="indication" placeholder="Préciser"
                                name="indication" rows="3">{{ old('indication', $user->candidate->indication) }}</textarea>
                            @error('indication')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-0 text-uppercase">Domaines de spécialité</h5>
                <div class="card-body p-4">
                    <!-- Bouton pour ajouter un diplôme militaire -->
                    <div class="mb-4">
                        <button type="button" class="btn btn-outline-info add__dom__btn__militaire">
                            <i class="fa-solid fa-plus-circle"></i> Ajouter un diplôme militaire
                        </button>
                    </div>
                    <!-- Liste des diplômes militaires -->
                    <div id="items__diplome__militaire">
                        @foreach ($user->candidate->diplomes as $index => $diplome)
                            @if ($diplome->type == 'militaire')
                                <div class="row g-3 diploma-item">
                                    <!-- Diplôme militaire -->
                                    <div class="col-md-7">
                                        <label for="diplome_militaire_{{ $index }}"
                                            class="form-label fw-bold">Diplôme militaire <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('diplome_militaire.' . $index) is-invalid @enderror"
                                            id="diplome_militaire_{{ $index }}" name="diplome_militaire[]"
                                            value="{{ old('diplome_militaire.' . $index, $diplome->diplome) }}"
                                            required />
                                        @error('diplome_militaire.' . $index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Année -->
                                    <div class="col-md-3">
                                        <label for="annees_militaire_{{ $index }}"
                                            class="form-label fw-bold">Année
                                            <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('annees_militaire.' . $index) is-invalid @enderror"
                                            id="annees_militaire_{{ $index }}" name="annees_militaire[]"
                                            value="{{ old('annees_militaire.' . $index, $diplome->annees) }}" required />
                                        @error('annees_militaire.' . $index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Bouton de suppression -->
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger remove__item__btn__militaire">
                                            <i class="bx bx-trash"></i> Supprimer
                                        </button>
                                    </div>
                                </div>
                                <hr>
                            @endif
                        @endforeach
                    </div>

                    <!-- Bouton pour ajouter un diplôme civil -->
                    <div class="mb-4 mt-5">
                        <button type="button" class="btn btn-outline-info add__dom__btn__civil">
                            <i class="fa-solid fa-plus-circle"></i> Ajouter un diplôme civil
                        </button>
                    </div>
                    <!-- Liste des diplômes civils -->
                    <div id="items__diplome__civil">
                        @foreach ($user->candidate->diplomes as $index => $diplome)
                            @if ($diplome->type == 'civil')
                                <div class="row g-3 diploma-item">
                                    <!-- Diplôme civil -->
                                    <div class="col-md-7">
                                        <label for="diplome_civil_{{ $index }}"
                                            class="form-label fw-bold">Diplôme
                                            civil <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('diplome_civil.' . $index) is-invalid @enderror"
                                            id="diplome_civil_{{ $index }}" name="diplome_civil[]"
                                            value="{{ old('diplome_civil.' . $index, $diplome->diplome) }}" required />
                                        @error('diplome_civil.' . $index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Année -->
                                    <div class="col-md-3">
                                        <label for="annees_civil_{{ $index }}" class="form-label fw-bold">Année
                                            <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('annees_civil.' . $index) is-invalid @enderror"
                                            id="annees_civil_{{ $index }}" name="annees_civil[]"
                                            value="{{ old('annees_civil.' . $index, $diplome->annees) }}" required />
                                        @error('annees_civil.' . $index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Bouton de suppression -->
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger remove__item__btn__civil">
                                            <i class="bx bx-trash"></i> Supprimer
                                        </button>
                                    </div>
                                </div>
                                <hr>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            @if (!$user->candidate->choiceFinal)
                <div class="card mb-4">
                    <h5 class="card-header pb-0 text-uppercase">Orientation</h5>
                    <div class="card-body p-4">

                        <!-- Orientation Envisagée -->
                        <div class="form-group">
                            <label class="form-check-label fw-bold">Orientation envisagée <span
                                    class="text-danger">*</span></label>
                            <div class="mt-2 mb-3">
                                @php
                                    $orientations = [
                                        'fonction-publique' => 'Fonction Publique',
                                        'entreprise-privee' => 'Entreprise privée',
                                        'auto-emploi' => 'Auto-emploi',
                                    ];
                                @endphp
                                @foreach ($orientations as $value => $label)
                                    <div class="form-check form-check-inline">
                                        <input name="orientation" class="form-check-input" type="radio"
                                            value="{{ $value }}" id="{{ $value }}"
                                            {{ old('orientation', $user->candidate->orientation) == $value ? 'checked' : '' }}
                                            required />
                                        <label class="form-check-label"
                                            for="{{ $value }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('orientation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 1er Choix -->
                        <div class="content-header mb-3">
                            <h6 class="mb-0 text-uppercase">1er Choix</h6>
                        </div>
                        <div class="row g-3">
                            <div class="choice-dependent col-md-3">
                                <label for="domaine_1c" class="form-label fw-bold">Domaine</label>
                                <select class="form-control select2 w-full @error('domaine_1c') is-invalid @enderror"
                                    name="domaine_1c" id="domaine_1c"
                                    {{ old('orientation', $user->candidate->orientation) == 'auto-emploi' ? 'required' : '' }}>
                                    <option value="" selected disabled>Selectionner</option>
                                    @foreach (domain_orientation() as $domain)
                                        <option value="{{ $domain }}"
                                            {{ old('domaine_1c', $user->candidate->domaine_1c) == $domain ? 'selected' : '' }}>
                                            {{ $domain }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('domaine_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="specialisation_1c" class="form-label fw-bold">Spécialisation <span
                                        class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control @error('specialisation_1c') is-invalid @enderror"
                                    id="specialisation_1c" name="specialisation_1c"
                                    value="{{ old('specialisation_1c', $user->candidate->specialisation_1c) }}"
                                    required />
                                @error('specialisation_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="region_retraite_1c" class="form-label fw-bold">Région du projet <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('region_retraite_1c') is-invalid @enderror"
                                    name="region_retraite_1c" required>

                                    <option value="" disabled selected>Sélectionner</option>
                                    <option value="National"
                                        {{ old('region_retraite_1c', $user->candidate->region_retraite_1c) == 'National' ? 'selected' : '' }}>
                                        National</option>
                                    <option value="International"
                                        {{ old('region_retraite_1c', $user->candidate->region_retraite_1c) == 'International' ? 'selected' : '' }}>
                                        International</option>
                                    @foreach ($other_data['regions'] as $region)
                                        <option value="{{ ucfirst($region) }}"
                                            {{ old('region_retraite_1c', $user->candidate->region_retraite_1c) == ucfirst($region) ? 'selected' : '' }}>
                                            {{ ucfirst($region) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('region_retraite_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="department_1c" class="form-label fw-bold">Département du projet <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('department_1c') is-invalid @enderror"
                                    name="department_1c" required>

                                    <option value="" disabled selected>Sélectionner</option>
                                    <option value="National"
                                        {{ old('department_1c', $user->candidate->department_1c) == 'National' ? 'selected' : '' }}>
                                        National</option>
                                    <option value="International"
                                        {{ old('department_1c', $user->candidate->department_1c) == 'International' ? 'selected' : '' }}>
                                        International</option>
                                    @foreach ($other_data['departments'] as $department)
                                        <option value="{{ ucfirst($department) }}"
                                            {{ old('department_1c', $user->candidate->department_1c) == ucfirst($department) ? 'selected' : '' }}>
                                            {{ ucfirst($department) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3 g-3">
                            <div class="col-md-3">
                                <label for="locality_1c" class="form-label fw-bold">Commune/Ville du projet <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('locality_1c') is-invalid @enderror" name="locality_1c"
                                    required>
                                    <option value="" disabled selected>Sélectionner</option>
                                    <option value="National"
                                        {{ old('locality_1c', $user->candidate->locality_1c) == 'National' ? 'selected' : '' }}>
                                        National</option>
                                    <option value="International"
                                        {{ old('locality_1c', $user->candidate->locality_1c) == 'International' ? 'selected' : '' }}>
                                        International</option>
                                    @foreach ($other_data['villages'] as $village)
                                        <option value="{{ ucfirst($village) }}"
                                            {{ old('locality_1c', $user->candidate->locality_1c) == ucfirst($village) ? 'selected' : '' }}>
                                            {{ ucfirst($village) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('locality_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="adress_geo_1c" class="form-label fw-bold">Quartier / Village</label>
                                <input type="text" class="form-control @error('adress_geo_1c') is-invalid @enderror"
                                    id="adress_geo_1c" name="adress_geo_1c"
                                    value="{{ old('adress_geo_1c', $user->candidate->adress_geo_1c) }}" />
                                @error('adress_geo_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="formation_1c" class="form-label fw-bold">Formation sollicitée</label>
                                <input type="text" class="form-control @error('formation_1c') is-invalid @enderror"
                                    id="formation_1c" name="formation_1c"
                                    value="{{ old('formation_1c', $user->candidate->formation_1c) }}" />
                                @error('formation_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="autres_form_1c" class="form-label fw-bold">Autres sollicitations</label>
                                <input type="text" class="form-control @error('autres_form_1c') is-invalid @enderror"
                                    id="autres_form_1c" name="autres_form_1c"
                                    value="{{ old('autres_form_1c', $user->candidate->autres_form_1c) }}" />
                                @error('autres_form_1c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="content-header mb-3 mt-4">
                            <h6 class="mb-0 text-uppercase">2e Choix</h6>
                        </div>
                        <div class="row g-3">
                            <div class="choice-dependent col-md-3">
                                <label for="domaine_2c" class="form-label fw-bold">Domaine</label>
                                <select class="form-control select2 w-full @error('domaine_2c') is-invalid @enderror"
                                    name="domaine_2c" id="domaine_2c">
                                    <option value="" selected disabled>Selectionner</option>
                                    @foreach (domain_orientation() as $domain)
                                        <option value="{{ $domain }}"
                                            {{ old('domaine_2c', $user->candidate->domaine_2c) == $domain ? 'selected' : '' }}>
                                            {{ $domain }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('domaine_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="specialisation_2c" class="form-label fw-bold">Spécialisation </label>
                                <input type="text"
                                    class="form-control @error('specialisation_2c') is-invalid @enderror"
                                    id="specialisation_2c" name="specialisation_2c"
                                    value="{{ old('specialisation_2c', $user->candidate->specialisation_2c) }}" />
                                @error('specialisation_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="region_retraite_2c" class="form-label fw-bold">Région du projet </label>
                                <select class="form-select @error('region_retraite_2c') is-invalid @enderror"
                                    name="region_retraite_2c">
                                    <option value="" disabled selected>Sélectionner</option>
                                    <option value="National"
                                        {{ old('region_retraite_2c', $user->candidate->region_retraite_2c) == 'National' ? 'selected' : '' }}>
                                        National</option>
                                    <option value="International"
                                        {{ old('region_retraite_2c', $user->candidate->region_retraite_2c) == 'International' ? 'selected' : '' }}>
                                        International</option>
                                    @foreach ($other_data['regions'] as $region)
                                        <option value="{{ ucfirst($region) }}"
                                            {{ old('region_retraite_2c', $user->candidate->region_retraite_2c) == ucfirst($region) ? 'selected' : '' }}>
                                            {{ ucfirst($region) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('region_retraite_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="department_2c" class="form-label fw-bold">Département du projet </label>
                                <select class="form-select @error('department_2c') is-invalid @enderror"
                                    name="department_2c">
                                    <option value="" disabled selected>Sélectionner</option>
                                    <option value="National"
                                        {{ old('department_2c', $user->candidate->department_2c) == 'National' ? 'selected' : '' }}>
                                        National</option>
                                    <option value="International"
                                        {{ old('department_2c', $user->candidate->department_2c) == 'International' ? 'selected' : '' }}>
                                        International</option>
                                    @foreach ($other_data['departments'] as $department)
                                        <option value="{{ ucfirst($department) }}"
                                            {{ old('department_2c', $user->candidate->department_2c) == ucfirst($department) ? 'selected' : '' }}>
                                            {{ ucfirst($department) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3 g-3">
                            <div class="col-md-3">
                                <label for="locality_2c" class="form-label fw-bold">Commune/Ville du projet </label>
                                <select class="form-select @error('locality_2c') is-invalid @enderror"
                                    name="locality_2c">
                                    <option value="" disabled selected>Sélectionner</option>
                                    <option value="National"
                                        {{ old('locality_2c', $user->candidate->locality_2c) == 'National' ? 'selected' : '' }}>
                                        National</option>
                                    <option value="International"
                                        {{ old('locality_2c', $user->candidate->locality_2c) == 'International' ? 'selected' : '' }}>
                                        International</option>
                                    @foreach ($other_data['villages'] as $village)
                                        <option value="{{ ucfirst($village) }}"
                                            {{ old('locality_2c', $user->candidate->locality_2c) == ucfirst($village) ? 'selected' : '' }}>
                                            {{ ucfirst($village) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('locality_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="adress_geo_2c" class="form-label fw-bold">Quartier / Village</label>
                                <input type="text" class="form-control @error('adress_geo_2c') is-invalid @enderror"
                                    id="adress_geo_2c" name="adress_geo_2c"
                                    value="{{ old('adress_geo_2c', $user->candidate->adress_geo_2c) }}" />
                                @error('adress_geo_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="formation_2c" class="form-label fw-bold">Formation sollicitée</label>
                                <input type="text" class="form-control @error('formation_2c') is-invalid @enderror"
                                    id="formation_2c" name="formation_2c"
                                    value="{{ old('formation_2c', $user->candidate->formation_2c) }}" />
                                @error('formation_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="autres_form_2c" class="form-label fw-bold">Autres sollicitations</label>
                                <input type="text" class="form-control @error('autres_form_2c') is-invalid @enderror"
                                    id="autres_form_2c" name="autres_form_2c"
                                    value="{{ old('autres_form_2c', $user->candidate->autres_form_2c) }}" />
                                @error('autres_form_2c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                </div>
            @endif

            <div class="card mb-4">
                <h5 class="card-header pb-0 text-uppercase">Documents joints</h5>
                <div class="card-body p-4">
                    <div class="row">
                        @php
                            $documents = [
                                'fiche_inscription' => "Fiche d'inscription",
                                'demande_manuscrite' => 'Demande manuscrite',
                                'cv' => 'Curriculum vitae (CV)',
                                'id_card' => "Pièce d'identité (les 2 faces sur la même page)",
                                'carte_pro' => 'Carte professionnelle',
                                'fiche_engagement' => "Fiche d'engagement",
                                'fiche_individuelle' => 'Fiche individuelle',
                                'arrete_radiation' => 'Arrêté de radiation',
                                'certificat' => 'Certificat médical',
                            ];
                        @endphp

                        @foreach ($documents as $key => $label)
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="{{ $key }}">
                                    {{ $label }}
                                    @if (in_array($key, ['fiche_inscription', 'demande_manuscrite', 'id_card', 'arrete_radiation', 'fiche_engagement']))
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                @if ($user->candidate->$key)
                                    <a href="{{ asset($user->candidate->$key) }}" download><i
                                            class="fa-solid fa-down-long"></i></a>
                                @endif
                                <input type="file" class="form-control @error($key) is-invalid @enderror"
                                    id="{{ $key }}" name="{{ $key }}"
                                    {{ $user->candidate->$key ? '' : (in_array($key, ['fiche_inscription', 'demande_manuscrite', 'id_card', 'arrete_radiation', 'fiche_engagement']) ? 'required' : '') }}
                                    accept=".pdf" />
                                @error($key)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <!-- Bouton de soumission -->
            <div class="col-md-12 mt-4 text-center">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>

        </form>
    </div>
    @push('js-push')
        <script>
            document.getElementById('file-upload').addEventListener('change', function(event) {
                const preview = document.getElementById('file-preview');
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };

                    reader.readAsDataURL(file);
                }
            });
        </script>

        <script>
            $(document).ready(function() {

                function setAutoEmploiFields() {
                    let val = $("input[name='orientation']:checked").val();

                    let champsRequired = [
                        "#domaine_1c"
                    ];

                    if (val === "auto-emploi") {
                        $('.choice-dependent').show();
                        champsRequired.forEach(id => {
                            $(id).attr('required', true);
                        });
                    } else {
                        $('.choice-dependent').hide();
                        champsRequired.forEach(id => {
                            $(id).removeAttr('required');
                        });
                    }
                }

                setAutoEmploiFields();
                $("input[name='orientation']").change(function() {
                    setAutoEmploiFields();
                });

            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Compteur pour les index des enfants
                let childIndex = {{ $user->candidate->childs->count() }};

                // Écouteur pour le bouton "Ajouter un enfant"
                document.querySelector('.add__items__btn').addEventListener('click', function() {
                    addChildItem();
                });

                // Fonction pour ajouter un nouveau champ enfant
                function addChildItem() {
                    const container = document.getElementById('items__enfant');
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'g-3', 'child-item');

                    newRow.innerHTML = `
                <div class="col-md-6">
                    <label for="child_name_${childIndex}" class="form-label fw-bold">Nom & Prénom(s) de l'enfant <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="child_name_${childIndex}" 
                        name="child_name[]" 
                        required 
                    />
                </div>

                <div class="col-md-3">
                    <label for="child_birthdate_${childIndex}" class="form-label fw-bold">Date de Naissance </label>
                    <input 
                        type="date" 
                        class="form-control" 
                        id="child_birthdate_${childIndex}" 
                        name="child_birthdate[]" 
                    />
                </div>

                <div class="col-md-3">
                    <label for="child_niveau_${childIndex}" class="form-label fw-bold">Niveau d'étude </label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="child_niveau_${childIndex}" 
                        name="child_niveau[]" 
                    />
                </div>

                <div class="col-md-5">
                    <label for="child_file_${childIndex}" class="form-label fw-bold">Document Justificatif </label>
                    <input 
                        type="file" 
                        class="form-control" 
                        id="child_file_${childIndex}" 
                        name="child_file[]" 
                        accept=".pdf" 
                    />
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove__item__btn">
                        <i class="bx bx-trash"></i> Supprimer
                    </button>
                </div>
            `;

                    container.appendChild(newRow);
                    childIndex++;

                    // Ajouter l'événement de suppression au nouveau bouton
                    newRow.querySelector('.remove__item__btn').addEventListener('click', function() {
                        newRow.remove();
                    });
                }

                // Écouteurs pour les boutons de suppression existants
                document.querySelectorAll('.remove__item__btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        button.closest('.child-item').remove();
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dateEntreeInput = document.getElementById('date_entree');
                const dateRadiationInput = document.getElementById('date_radiation');
                const dureeServiceInput = document.getElementById('duree_service');

                // Fonction pour mettre à jour la date minimale de radiation
                function updateRadiationDateOptions() {
                    if (dateEntreeInput.value) {
                        const dateEntree = new Date(dateEntreeInput.value);
                        dateRadiationInput.min = dateEntree.toISOString().split('T')[0];
                    }
                }

                // Fonction pour calculer la durée de service
                function calculateServiceDuration() {
                    if (dateEntreeInput.value && dateRadiationInput.value) {
                        const dateEntree = new Date(dateEntreeInput.value);
                        const dateRadiation = new Date(dateRadiationInput.value);

                        if (dateRadiation >= dateEntree) {
                            const diffTime = dateRadiation.getTime() - dateEntree.getTime();
                            const years = Math.floor(diffTime / (1000 * 60 * 60 * 24 * 365));
                            const months = Math.floor((diffTime % (1000 * 60 * 60 * 24 * 365)) / (1000 * 60 * 60 * 24 *
                                30));
                            const days = Math.floor((diffTime % (1000 * 60 * 60 * 24 * 30)) / (1000 * 60 * 60 * 24));

                            dureeServiceInput.value = `${years} ans, ${months} mois, ${days} jours`;
                        } else {
                            dureeServiceInput.value = "Durée invalide";
                        }
                    }
                }

                // Ajout des écouteurs d'événements
                dateEntreeInput.addEventListener('change', function() {
                    updateRadiationDateOptions();
                    calculateServiceDuration();
                });

                dateRadiationInput.addEventListener('change', calculateServiceDuration);

                // Initialisation au chargement si les dates existent déjà
                if (dateEntreeInput.value && dateRadiationInput.value) {
                    updateRadiationDateOptions();
                    calculateServiceDuration();
                }
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let jobIndex = {{ $user->candidate->jobs->count() }};

                // Fonction pour ajouter un nouvel emploi
                function addJobItem() {
                    const container = document.getElementById('items__emploi');
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'g-3', 'job-item');

                    newRow.innerHTML = `
                <!-- Périodes -->
                <div class="col-md-3">
                    <label for="periode_${jobIndex}" class="form-label fw-bold">Périodes <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="periode_${jobIndex}" 
                        name="periode[]" 
                        placeholder="1984-1986" 
                        required
                    />
                </div>

                <!-- Unité -->
                <div class="col-md-5">
                    <label for="organism_${jobIndex}" class="form-label fw-bold">Unité <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="organism_${jobIndex}" 
                        name="organism[]" 
                        placeholder="1ère LEGION MILITAIRE ABIDJAN" 
                        required
                    />
                </div>

                <!-- Fonction -->
                <div class="col-md-2">
                    <label for="fonction_${jobIndex}" class="form-label fw-bold">Fonction <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="fonction_${jobIndex}" 
                        name="fonction[]" 
                        placeholder="Fonction" 
                        required
                    />
                </div>

                <!-- Bouton de suppression -->
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove__item__btn">
                        <i class="bx bx-trash"></i> Supprimer
                    </button>
                </div>
            `;

                    container.appendChild(newRow);

                    // Ajout de l'événement de suppression
                    newRow.querySelector('.remove__item__btn').addEventListener('click', function() {
                        newRow.remove();
                    });

                    jobIndex++;
                }

                // Ajout de l'événement au bouton "Ajouter un emploi"
                document.querySelector('.add__emp__btn').addEventListener('click', addJobItem);

                // Ajout des événements de suppression pour les emplois existants
                document.querySelectorAll('.remove__item__btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        button.closest('.job-item').remove();
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let militaireIndex = {{ $user->candidate->diplomes->where('type', 'militaire')->count() }};
                let civilIndex = {{ $user->candidate->diplomes->where('type', 'civil')->count() }};

                // Ajouter un diplôme militaire
                document.querySelector('.add__dom__btn__militaire').addEventListener('click', function() {
                    addDiplomaItem('militaire', militaireIndex++);
                });

                // Ajouter un diplôme civil
                document.querySelector('.add__dom__btn__civil').addEventListener('click', function() {
                    addDiplomaItem('civil', civilIndex++);
                });

                // Ajouter dynamiquement un diplôme
                function addDiplomaItem(type, index) {
                    const containerId = type === 'militaire' ? 'items__diplome__militaire' : 'items__diplome__civil';
                    const container = document.getElementById(containerId);

                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'g-3', 'diploma-item');

                    newRow.innerHTML = `
                <!-- Diplôme -->
                <div class="col-md-7">
                    <label for="diplome_${type}_${index}" class="form-label fw-bold">Diplôme ${type} <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="diplome_${type}_${index}" 
                        name="diplome_${type}[]" 
                        placeholder="Ex: CS1 SPORT" 
                        required
                    />
                </div>
                <!-- Année -->
                <div class="col-md-3">
                    <label for="annees_${type}_${index}" class="form-label fw-bold">Année <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="annees_${type}_${index}" 
                        name="annees_${type}[]" 
                        placeholder="Ex: 1986" 
                        required
                    />
                </div>
                <!-- Bouton de suppression -->
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove__item__btn__${type}">
                        <i class="bx bx-trash"></i> Supprimer
                    </button>
                </div>
            `;

                    container.appendChild(newRow);

                    // Ajouter un événement de suppression
                    newRow.querySelector(`.remove__item__btn__${type}`).addEventListener('click', function() {
                        newRow.remove();
                    });
                }

                // Gestion des suppressions existantes
                document.querySelectorAll('.remove__item__btn__militaire, .remove__item__btn__civil').forEach(function(
                    button) {
                    button.addEventListener('click', function() {
                        button.closest('.diploma-item').remove();
                    });
                });
            });
        </script>

        <script>
            document.getElementById('situation_matrimoniale').addEventListener('change', function() {
                const marriedFields = document.getElementById('married-fields');
                if (this.value === 'marié(e)') {
                    marriedFields.style.display = 'flex';
                } else {
                    marriedFields.style.display = 'none';
                }
            });

            // Initialize visibility based on current value
            document.getElementById('situation_matrimoniale').dispatchEvent(new Event('change'));
        </script>

        <script>
            $(document).ready(function() {
                let disciplinaryIndex = {{ count($disciplinaryConditions) }};

                $('#add-disciplinary').click(function() {
                    $('#disciplinary-container').append(`
            <div class="row g-2 mb-2">
                <div class="col-md-8">
                    <input type="text" name="condition_disciplinaire[${disciplinaryIndex}][title_decoration]" class="form-control" placeholder="Intitulé de la décoration">
                </div>
                <div class="col-md-3">
                    <input type="date" name="condition_disciplinaire[${disciplinaryIndex}][date_decoration]" class="form-control">
                </div>
                <div class="col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-disciplinary">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>
        `);
                    disciplinaryIndex++;
                });

                $(document).on('click', '.remove-disciplinary', function() {
                    $(this).closest('.row').remove();
                });

                // Gestion du comportement financier unique
                const financialCheckboxes = [
                    '#pension_retraite',
                    '#pension_reforme',
                    '#solde_reforme',
                    '#remboursement'
                ];
                financialCheckboxes.forEach(selector => {
                    $(document).on('change', selector, function() {
                        if (this.checked) {
                            financialCheckboxes.forEach(otherSelector => {
                                if (otherSelector !== `#${this.id}`) {
                                    $(otherSelector).prop('checked', false);
                                }
                            });
                        }
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function toggleDemarcheFields() {
                    var ouiRadio = document.getElementById("demarche_oui");
                    var demarcheFields = document.getElementById("demarche_fields");
                    var demarcheNature = document.getElementById("demarche_nature");
                    var demarcheAdmin = document.getElementById("demarche_admin");
                    var etatAvancement = document.getElementById("etat_avancement");

                    if (ouiRadio.checked) {
                        demarcheFields.style.display = "block";
                        demarcheNature.required = true;
                        demarcheAdmin.required = true;
                        etatAvancement.required = true;
                    } else {
                        demarcheFields.style.display = "none";
                        demarcheNature.required = false;
                        demarcheAdmin.required = false;
                        etatAvancement.required = false;
                    }
                }

                // Écouteur pour les boutons radio de démarche
                document.querySelectorAll('input[name="demarche_entreprise"]').forEach(function(radio) {
                    radio.addEventListener('change', toggleDemarcheFields);
                });

                // Initialisation au chargement
                toggleDemarcheFields();
            });
        </script>
    @endpush
@endsection
