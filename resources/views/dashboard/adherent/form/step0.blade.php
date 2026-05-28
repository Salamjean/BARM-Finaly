<!-- Content wrapper -->

<div id="etat-civil">
    <form method="post" id="formmm" action="{{ route('adherent.update', [$step ?? 0, $user->id ?? 0]) }}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            @if (!isset($submission))
                <div class="col-md-12">
                    <div class="content-header">
                        <h6 class="mb-1">&bull; Recherche de rétraité</h6>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Mécano :<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('mecano') is-invalid @enderror" id="mecano"
                            required placeholder="0000036535" name="mecano"
                            value="{{ $user->mecano ?? old('mecano') }}" />
                        @error('mecano')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2 d-flex justify-content-end">
                    <label class="form-label" for="collapsible-phone"> .</label>
                    <button type="button" class="mt-4 btn btn-primary" id="search-button">
                        Recherche
                    </button>

                </div>
            @endif

            <div class="col-md-12 mt-4">
                <div class="content-header">
                    <h6 class="mb-1">&bull; Information sur le retraité</h6>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="nom" class="form-label">Photo d'dentité :</label>
                    <input type="file" accept=".jpg, .jpeg, .png" id="file-upload" class="form-control"
                        value="{{ old('image') }}" name="image"
                        {{-- {{ isset($submission) && $submission->image ? '' : 'required' }} --}}
                        >
                    @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                @if (isset($submission) && $submission->image)
                    <img src="{{ asset($submission->image) }}" alt="photo" width="100px" height="100px"
                        id="file-preview">
                @else
                    <img src="#" alt="photo" width="100px" height="100px" id="file-preview">
                @endif
            </div>
            @if (isset($submission))
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Mécano:<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('mecano') is-invalid @enderror" id="mecano"
                            disabled placeholder="0000036535" name="mecano"
                            value="{{ $user->mecano ?? old('mecano') }}" />
                        @error('mecano')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Matricule :</label>
                        <input type="text" class="form-control @error('matricule') is-invalid @enderror" id="matricule"
                            disabled placeholder="0000036535" name="matricule"
                            value="{{ $user->matricule ?? old('matricule') }}" />
                        @error('matricule')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                @else
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Matricule :</label>
                        <input type="text" class="form-control @error('matricule') is-invalid @enderror" id="matricule"
                            disabled placeholder="*********" name="matricule"
                            value="{{ $user->matricule ?? old('matricule') }}" />
                        @error('matricule')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            @endif
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nom" class="form-label">Nom :<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="first_name" placeholder="Toure" id="nom"
                        value="{{ $user->firstname ?? old('first_name') }}" required>
                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="prenoms" class="form-label">Prénom(s) :<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="last_name" id="prenoms"
                        placeholder="Emmanuel Dicap" value="{{ $user->lastname ?? old('last_name') }}" required>
                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label" for="cgrae_no">N° CGRAE :</label>
                    <input type="text" class="form-control @error('cgrae_no') is-invalid @enderror" id="cgrae_no"
                        placeholder="0000036535" name="cgrae_no"
                        value="{{ $submission->cgrae_no ?? old('cgrae_no') }}" minlength="11" maxlength="14" />
                    @error('cgrae_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="gender" class="form-label">Genre<span class="text-danger">*</span></label>
                    <select id="gender" class="form-select @error('gender') is-invalid @enderror"
                        aria-label="Default select example" name="gender" required>
                        <option value="" disabled
                            {{ ($submission->gender ?? old('gender')) == '' ? 'selected' : '' }}>Sélectionner</option>
                        @foreach (GENDERS as $gender)
                            <option value="{{ $gender }}"
                                {{ ($submission->gender ?? old('gender')) == $gender ? 'selected' : '' }}>
                                {{ $gender }}</option>
                        @endforeach
                    </select>
                    @error('gender')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="hbd" class="form-label">Né(e) le :<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="birth_date" id="hbd"
                        value="{{ $submission->birth_date ?? old('birth_date') }}"
                        max="{{ Carbon\Carbon::now()->subYears(20)->format('Y-m-d') }}" required>
                    <div class="wizard-form-error"></div>
                </div>
                @error('birth_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="phone_number" class="form-label">Contact<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span
                            class="input-group-text @error('phone_number') border border-danger @enderror">+225</span>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                            id="phone_number" name="phone_number" placeholder="05 00 00 00 00"
                            value="{{ $submission->phone_number ?? old('phone_number') }}" required
                            pattern="[0-9]{10}" maxlength="10" minlength="10" />
                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="phone_number2" class="form-label">Contact 2</label>
                    <div class="input-group input-group-merge">
                        <span
                            class="input-group-text @error('phone_number2') border border-danger @enderror">+225</span>
                        <input type="text" class="form-control @error('phone_number2') is-invalid @enderror"
                            id="phone_number2" name="phone_number2" placeholder="05 00 00 00 00"
                            value="{{ $submission->phone_number2 ?? old('phone_number2') }}" pattern="[0-9]{10}"
                            maxlength="10" minlength="10" />
                        @error('phone_number2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="phone_number3" class="form-label">Contact 3</label>
                    <div class="input-group input-group-merge">
                        <span
                            class="input-group-text @error('phone_number3') border border-danger @enderror">+225</span>
                        <input type="text" class="form-control @error('phone_number3') is-invalid @enderror"
                            id="phone_number3" name="phone_number3" placeholder="05 00 00 00 00"
                            value="{{ $submission->phone_number3 ?? old('phone_number3') }}" pattern="[0-9]{10}"
                            maxlength="10" minlength="10" />
                        @error('phone_number3')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <label for="type_piece" class="form-label">Type de pièce<span class="text-danger">*</span></label>
                <select class="form-select @error('type_piece') is-invalid @enderror"
                    aria-label="Sélectionner un type de pièce" name="type_piece" required>
                    <option value="" disabled
                        {{ ($submission->type_piece ?? old('type_piece')) == '' ? 'selected' : '' }}>Sélectionner
                    </option>
                    @foreach (TYPEPIECES as $type_piece)
                        <option value="{{ $type_piece }}"
                            {{ ($submission->type_piece ?? old('type_piece')) == $type_piece ? 'selected' : '' }}>
                            {{ $type_piece }}
                        </option>
                    @endforeach
                </select>
                @error('type_piece')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="npiece" class="form-label">N° Pièce :<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('no_card') is-invalid @enderror"
                        placeholder="CI0102050610" name="no_card" id="npiece"
                        value="{{ $submission->no_card ?? old('no_card') }}" required>
                    @error('no_card')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">

                    <label for="ethnic" class="form-label">Ethnie<span class="text-danger">*</span></label>
                    <select class="form-select @error('ethnic') is-invalid @enderror"
                        aria-label="Default select example" name="ethnic" >
                        <option value="" disabled
                            {{ ($submission->ethnic ?? old('ethnic')) == '' ? 'selected' : '' }}>Selectionner</option>
                        @foreach (ETHNICS as $ethnic)
                            <option value="{{ $ethnic }}"
                                {{ ($submission->ethnic ?? old('ethnic')) == $ethnic ? 'selected' : '' }}>
                                {{ $ethnic }}</option>
                        @endforeach
                    </select>
                    @error('ethnic')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="religion" class="form-label">Réligion<span class="text-danger">*</span></label>
                    <select class="form-select @error('religion') is-invalid @enderror"
                        aria-label="Default select example" name="religion" >
                        <option value="" disabled
                            {{ ($submission->religion ?? old('religion')) == '' ? 'selected' : '' }}>Selectionner
                        </option>
                        @foreach (RELIGIONS as $religion)
                            <option value="{{ $religion }}"
                                {{ ($submission->religion ?? old('religion')) == $religion ? 'selected' : '' }}>
                                {{ $religion }}</option>
                        @endforeach
                    </select>
                    @error('religion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="lahminet0@gmail.com" name="email" id="email"
                        value="{{ $user->email ?? old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-md-12 mt-4">
                <div class="content-header">
                    <h6 class="mb-1">&bull; Information sur la personne à contacter en cas d&apos;urgence</h6>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="sos_person_fullname" class="form-label">Nom complet</label>
                    <div class="input-group input-group-merge">
                        <input type="text" class="form-control @error('sos_person_fullname') is-invalid @enderror"
                            id="sos_person_fullname" name="sos_person_fullname" placeholder="Kone Brice"
                            value="{{ $submission->sos_person_fullname ?? old('sos_person_fullname') }}"  />
                        @error('sos_person_fullname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="form-group">
                    <label for="sos_person_phone_number" class="form-label">Contact</label>
                    <div class="input-group input-group-merge">
                        <span
                            class="input-group-text @error('sos_person_phone_number') border border-danger @enderror">+225</span>
                        <input type="text" class="form-control @error('sos_person_phone_number') is-invalid @enderror"
                            id="sos_person_phone_number" name="sos_person_phone_number" placeholder="05 00 00 00 00"
                            value="{{ $submission->sos_person_phone_number ?? old('sos_person_phone_number') }}" pattern="[0-9]{10}"
                            maxlength="10" minlength="10" />
                        @error('sos_person_phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="form-group">
                    <label for="sos_person_phone_number2" class="form-label">Contact 2</label>
                    <div class="input-group input-group-merge">
                        <span
                            class="input-group-text @error('sos_person_phone_number2') border border-danger @enderror">+225</span>
                        <input type="text" class="form-control @error('sos_person_phone_number2') is-invalid @enderror"
                            id="sos_person_phone_number2" name="sos_person_phone_number2" placeholder="05 00 00 00 00"
                            value="{{ $submission->sos_person_phone_number2 ?? old('sos_person_phone_number2') }}" pattern="[0-9]{10}"
                            maxlength="10" minlength="10" />
                        @error('sos_person_phone_number2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end mt-20">

                <button type="submit" class="btn btn-primary"> <span
                        class="d-sm-inline-block d-none me-sm-1">Suivant</span> <i
                        class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>

            </div>
        </div>
    </form>
</div>

<!-- Content wrapper -->

@push('js-push')
    <script>
        const input = document.getElementById('file-upload');
        const previewPhoto = () => {
            const file = input.files;
            if (file) {
                const fileReader = new FileReader();
                const preview = document.getElementById('file-preview');
                fileReader.onload = event => {
                    preview.setAttribute('src', event.target.result);
                }
                fileReader.readAsDataURL(file[0]);
            }
        }
        input.addEventListener('change', previewPhoto);
    </script>
    @if (!isset($submission))
        <script>
            document.getElementById('search-button').addEventListener('click', function() {
                const mecano = document.getElementById('mecano').value;
                if (mecano) {
                    fetch(`{{ route('retiredSearch') }}?search=${mecano}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                const retired = data.data;
                                document.getElementById('matricule').value = retired.matricule;
                                document.getElementById('nom').value = retired.firstname;
                                document.getElementById('prenoms').value = retired.lastname;
                                document.getElementById('hbd').value = retired.birth_date;
                                document.getElementById('gender').value = retired.gender === 'M' ? 'Masculin' : 'Feminin';
                            } else {
                                document.getElementById('matricule').value = '';
                                document.getElementById('nom').value = '';
                                document.getElementById('prenoms').value = '';
                                document.getElementById('hbd').value = '';
                                document.getElementById('gender').value = '';

                            }
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'bottom-right',
                                iconColor: 'white',
                                color: 'white',
                                background: data.status == 'error' ? '#C11515B6' : data.status ==
                                    'success' ? '#00AA47B6' : '#817909',
                                customClass: {
                                    popup: 'colored-toast',
                                },
                                showConfirmButton: false,
                                timer: 10000,
                                timerProgressBar: true,

                            })
                            Toast.fire({
                                text: data.message,
                                icon: data.status,
                            });
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'bottom-right',
                        iconColor: 'white',
                        color: 'white',
                        background: '#C11515B6',
                        customClass: {
                            popup: 'colored-toast',
                        },
                        showConfirmButton: false,
                        timer: 10000,
                        timerProgressBar: true,

                    })
                    Toast.fire({
                        text: 'Veuillez entrer un numéro de mécano.',
                        icon: 'error',
                    });
                }
            });
        </script>
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function() {

        });
    </script>
    <script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') ?? '' }}"></script>
    <script src="{{ asset('assets/js/main.js') ?? '' }}"></script>
    <script src="{{ asset('assets/js/forms-file-upload.js') ?? '' }}"></script>
@endpush
