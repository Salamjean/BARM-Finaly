@extends('layouts.app')
@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.js') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css  ') }}" />
    @endpush
    @push('js-push')
        <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
        <script src="{{ asset('assets/js/app-ecommerce-product-add.js') }}"></script>
        <script>
            $(document).ready(function() {

                $("#formSubmit").submit(function(e) {
                    e.preventDefault();

                    var descr = $('.ql-editor').html();
                    $("input[name='description']").val(descr);

                    $("#formSubmit")[0].submit();

                });
            });
        </script>
    @endpush
    <div class="container">

        <div class="card mb-4">
            <h5 class="card-header">Edition d'une offre d'emploi</h5>

            <hr class="my-0">
            <div class="card-body">
                <form action="{{ route('job.update', $data->id) }}" method="POST" id="formSubmit">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="description" value="" />

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="title" class="form-label">Nom du poste<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="title" name="title"
                                value="{{ $data->title }}" placeholder="Développeur FullStack Web, Mobile H/F" required />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="job_type" class="form-label">Type de contrat <span
                                    class="text-danger">*</span></label>
                            <select id="job_type" name="job_type" class="select2 form-select" required>
                                <option value="" disabled>Selectionnez</option>
                                @foreach (JOBTYPE as $job)
                                    <option value="{{ $job }}" @if ($data->job_type == $job) selected @endif>
                                        {{ $job }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label" for="pay">Salaire (par an)</label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="pay" name="pay" class="form-control"
                                    value="{{ $data->pay }}" placeholder="1 500 000" />
                                <span class="input-group-text">{{ DEVICE }}</span>
                            </div>
                        </div>
                        <div class="mb-3 col-md-12">
                            <div>

                                <div class="descriptionn">

                                </div>

                                <label class="form-label">Description </label>
                                <div class="form-control p-0 pt-1">
                                    <div class="comment-toolbar border-0 border-bottom">
                                        <div class="d-flex justify-content-start">
                                            <span class="ql-formats me-0">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
                                                <button class="ql-list" value="ordered"></button>
                                                <button class="ql-list" value="bullet"></button>
                                                <button class="ql-link"></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="comment-editor border-0 pb-4" id="ecommerce-category-description">
                                        @php
                                            echo $data->description;
                                        @endphp
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="TagifySkills">Competence</label>
                            <input id="TagifySkills" class="form-control" name="skills" value="{{ $data->skills }}" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="modalEditEdutation">Niveau d'étude</label>
                            <select id="modalEditEdutation" name="education[]" class="select2 form-select" multiple>
                                <option value="" disabled>Selectionnez</option>
                                @foreach (EDUCATIONS as $education)

                                        {{ $education }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="number" class="form-label">Nombre deplace</label>
                            <input type="number" class="form-control" id="number" name="number"
                                placeholder="Nombre de poste" value="{{ $data->number }}" />
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label" for="modalEditGender">Genres</label>
                            <select id="modalEditGender" name="gender[]" class="select2 form-select" multiple>
                                <option value="" disabled>Selectionnez</option>
                                @foreach (GENDERS as $gender)
                                    <option value="{{ $gender }}" @if (isset($data->genders) && in_array($gender, json_decode($data->genders))) selected @endif>
                                        {{ $gender }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label" for="modalEditUserLanguage">Langue</label>
                            <select id="modalEditUserLanguage" name="language[]" class="select2 form-select" multiple>
                                <option value="" disabled>Selectionnez</option>
                                @foreach (LANGUAGES['fr'] as $language)
                                    <option value="{{ $language }}" @if (isset($data->languages) && in_array( $language, json_decode($data->languages))) selected @endif>
                                        {{ $language }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="TagifyBenefits">Les avantages du poste</label>
                            <input id="TagifyBenefits" class="form-control" name="benefits"
                                value="{{ $data->benefits }}" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label" for="phone_number">Numéro de téléphone<span
                                    class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">+225</span>
                                <input type="text" id="phone_number" name="phone_number" class="form-control"
                                    placeholder="0704 0511 52" value="{{ $data->phone_number }}" required />
                            </div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="email" class="form-label">Email<span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Votre email" value="{{ $data->email }}" required />
                        </div>

                        <div class="mb-3 col-md-3">
                            <label class="form-label" for="country">Ville<span class="text-danger">*</span></label>
                            <select id="country" name="location" class="select2 form-select" required>
                                <option value="" disabled selected>Selectionnez</option>
                                @foreach (CITIES as $city)
                                    <option value="{{ $city }}" @if ($data->location == $city) selected @endif>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="end_date" class="form-label">Date de cloture<span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ $data->end_date }}" required />
                        </div>

                    </div>
                    <div class="mt-2 d-flex justify-content-between">
                        <div>
                            <label class="switch">
                                <input type="checkbox" class="switch-input" name="status"
                                    @if ($data->status == 'enable') checked @endif />
                                <span class="switch-label mx-2">Statut</span>
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Editer</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>

    </div>
    <script>
        var x = document.querySelector(".ql-blank");
        x.innerHTML = "{{ $data->description }}";
    </script>
@endsection
