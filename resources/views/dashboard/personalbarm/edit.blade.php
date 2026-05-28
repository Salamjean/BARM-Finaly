@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Personnels/</span> Modifier le personnel
                </h4>
                <div class="card">
                    <div class="card-header px-4 py-3 border-bottom">
                        <h5 class="mb-0">Modifier le personnel</h5>
                    </div>
                    <div class="card-body p-4">
                        <form class="row g-3" method="POST" action="{{ route('personnel.update', $personal->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 mb-3">
                                <label for="username" class="form-label">Nom d'utilisateur : </label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bx-at'></i></span>
                                    <input type="text"
                                        class="form-control @error('username') is-invalid @enderror border-start-0"
                                        id="username" placeholder="Nom d'personnel" name="username"
                                        value="{{ old('username') ?? $personal->username }}" disabled />
                                </div>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label for="firstname" class="form-label">Prénom(s)</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <input type="text" class="form-control border-start-0" id="firstname"
                                        placeholder="Prénom(s)" name="firstname"
                                        value="{{ old('firstname') ?? $personal->firstname }}" />
                                </div>
                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="lastname" class="form-label">Nom </label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <input type="text" class="form-control border-start-0" id="lastname"
                                        placeholder="Nom" name="lastname"
                                        value="{{ old('lastname') ?? $personal->lastname }}" />
                                </div>
                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">N° téléphone</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-phone'></i></span>
                                    <input type="text" class="form-control border-start-0" id="phone"
                                        placeholder="N° de telephone" name="phone"
                                        value="{{ old('phone') ?? $personal->phone }}" />
                                </div>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-envelope'></i></span>
                                    <input type="text" class="form-control border-start-0" id="email"
                                        placeholder="Adresse mail" name="email"
                                        value="{{ old('email') ?? $personal->email }}" />
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="type_piece" class="form-label">Type de pièce</label>
                                <select class="form-select @error('type_piece') is-invalid @enderror"
                                    aria-label="Sélectionner un type de pièce" name="type_piece" required>
                                    <option value="" disabled {{ old('type_piece') == '' ? 'selected' : '' }}>
                                        Sélectionner</option>
                                    <option value="cni"
                                        {{ old('type_piece') ?? $personal->type_piece == 'cni' ? 'selected' : '' }}>CNI
                                    </option>
                                    <option value="passeport"
                                        {{ old('type_piece') ?? $personal->type_piece == 'passeport' ? 'selected' : '' }}>
                                        PASSEPORT</option>
                                    <option value="cmu"
                                        {{ old('type_piece') ?? $personal->type_piece == 'cmu' ? 'selected' : '' }}>CMU
                                    </option>
                                </select>
                                @error('type_piece')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="no_card" class="form-label">N° de la carte</label>
                                <input type="text" class="form-control @error('no_card') is-invalid @enderror"
                                    id="no_card" name="no_card" placeholder="CI 0000000000"
                                    value="{{ old('no_card') ?? $personal->no_card }}">
                                @error('no_card')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-md-3 mb-3">
                                <label for="birth_date" class="form-label">Date de naissance</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                    id="birth_date" name="birth_date"
                                    value="{{ old('birth_date') ?? $personal->birth_date }}" disabled>
                                @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="gender" class="form-label">Genre</label>
                                <select class="form-select @error('gender') is-invalid @enderror"
                                    aria-label="Default select example" name="gender" required>
                                    <option value="" disabled {{ old('gender') == '' ? 'selected' : '' }}>
                                        Sélectionner</option>
                                    <option value="Masculin"
                                        {{ old('gender') ?? $personal->gender == 'Masculin' ? 'selected' : '' }}>Masculin
                                    </option>
                                    <option value="Feminin"
                                        {{ old('gender') ?? $personal->gender == 'Feminin' ? 'selected' : '' }}>Feminin
                                    </option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Mot de passe </label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-lock-open'></i></span>
                                    <input type="text" class="form-control border-start-0" id="password"
                                        placeholder="Mot de passe" name="password" value="{{ old('password') }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label">Confirmé mot de passe</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-lock'></i></span>
                                    <input type="text" class="form-control border-start-0" id="confirm_password"
                                        placeholder="Confirmé mot de passe" name="confirm_password" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="lieu_service" class="form-label">SERvice</label>
                                <select class="form-select select2" data-placeholder="Choisir le service d'affectation"
                                    id="roles" name="roles">
                                    <option selected disabled>Selectionner</option>
                                    @foreach (POSTBYCELLBARM as $role)
                                        @if ($role['name'] != 'CHEF BARM')
                                            <option value="{{ $role['name'] }}"
                                                {{ $personal->cell === $role['name'] ? 'selected' : '' }}>
                                                {{ $role['name'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-8 ">
                                <label class="form-label">POSTES :</label>
                                <select class="form-select select2" data-placeholder="Permissions" id="permissions"
                                    multiple name="permissions[]">

                                </select>
                            </div>

                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <button type="submit" class="btn btn-primary px-4">Modifier</button>
                                    <a href="{{ route('personnel.index') }}" type="reset"
                                        class="btn btn-danger px-4">Annuler</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            const typeUserRoles = {!! json_encode(POSTBYCELLBARM) !!};

            let selectedPermissions = [];

            function dataPermission(){
                let selectedRoleName = "{{ $personal->cell }}";
                let permissions = {!! json_encode($personal->posts) !!};
                console.log(JSON.stringify(permissions));

                typeUserRoles.forEach(role => {
                    if (role.name === selectedRoleName) {
                        selectedPermissions = role.permissions;
                    }
                });

                var perms = $("#permissions");
                perms.empty();
                perms.append($('<option>', {
                    value: '',
                    text: 'Selectionnez',
                }));

                selectedPermissions.forEach(function(permission) {
                    perms.append($('<option>', {
                        value: permission,
                        text: permission,
                        selected : permissions.includes(permission) ? true : false
                    }));
                });
            }

            @if ($personal->cell)
                dataPermission();
            @endif

            $('#roles').on("change", function() {
                let selectedRoleName = this.value;
                selectedPermissions = [];

                typeUserRoles.forEach(role => {
                    if (role.name === selectedRoleName) {
                        selectedPermissions = role.permissions;
                    }
                });

                var perms = $("#permissions");
                perms.empty();
                perms.append($('<option>', {
                    value: '',
                    text: 'Selectionnez',
                }));

                selectedPermissions.forEach(function(permission) {
                    perms.append($('<option>', {
                        value: permission,
                        text: permission,
                    }));
                });

            });
        </script>
    @endpush
@endsection
