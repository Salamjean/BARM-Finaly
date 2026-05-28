@php

    $other_data = regions();

@endphp
<div id="projet-professionnel">
    <form method="post" id="formmm" action="{{ route('adherent.update', [$step, $user->id]) }}">
        @csrf
        @method('PUT')
        <div class="accordion-body">
            <div class="form-group">
                <label class="form-check-label">Orientation envisagée<span class="text-danger">*</span></label> <br>
                <div class="mt-2 mb-3">
                    <div class="form-check form-check-inline">
                        <input name="orientation" class="form-check-input" type="radio" value="fonction-publique"
                            id="fonction-publique"
                            {{ $submission->orientation == 'fonction-publique' ? 'checked ' : '' }} required />
                        <label class="form-check-label" for="fonction-publique">Fonction Publique</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="orientation" class="form-check-input" type="radio" value="entreprise-privee"
                            id="entreprise" {{ $submission->orientation == 'entreprise-privee' ? 'checked ' : '' }} />
                        <label class="form-check-label" for="entreprise">Entreprise privée</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="orientation" class="form-check-input" type="radio" value="auto-emploi"
                            id="auto-emploi" {{ $submission->orientation == 'auto-emploi' ? 'checked ' : '' }} />
                        <label class="form-check-label" for="auto-emploi">Auto-emploi</label>
                    </div>
                </div>
                <div class="wizard-form-error"></div>
            </div>



            <div class="content-header mb-3">
                <h6 class="mb-0">&bull; 1er Choix</h6>
            </div>
            <div class="row">

                <div class="choice-dependent col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Domaine
                            :</label>

                        <select id="domaine_1c" class="form-control select2 w-full @error('domaine_1c') is-invalid @enderror"
                            name="domaine_1c" required>
                            <option value="" selected disabled>Selectionner</option>
                            @foreach (domain_orientation() as $domain)
                                <option value="{{ $domain }}"
                                    {{ $submission->domaine_1c == $domain ? 'selected' : '' }}>
                                    {{ $domain }}</option>
                            @endforeach

                        </select>
                        <div class="wizard-form-error"></div>
                    </div>
                    @error('domaine_1c')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Spécialisation <span
                                class="text-danger">*</span>
                            :</label>
                        <input type="text" class="form-control @error('specialisation_1c') is-invalid @enderror"
                            id="specialisation_1c" placeholder="" name="specialisation_1c"
                            value="{{ old('specialisation_1c') ?? $submission->specialisation_1c }}" required />
                        <div class="wizard-form-error"></div>
                    </div>
                    @error('specialisation_1c')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-state">Région du projet <span
                                class="text-danger">*</span>
                            :</label>
                        <div class="">
                            <select
                                class="form-control select2 w-full @error('region_retraite_1c') is-invalid @enderror"
                                name="region_retraite_1c" required>
                                <option value="" selected disabled>Selectionner</option>
                                <option {{ $submission->region_retraite_1c == "National" ? 'selected' : '' }} value="National">National</option>
                                <option {{ $submission->region_retraite_1c == "International" ? 'selected' : '' }} value="International">International</option>
                                @foreach ($other_data['regions'] as $key => $district)
                                    <option value="{{ ucfirst($district) }}"
                                        {{ $submission->region_retraite_1c == ucfirst($district) ? 'selected' : '' }}>
                                        {{ ucfirst($district) }}</option>
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
                        <label class="form-label" for="collapsible-state">Département du projet <span
                                class="text-danger">*</span>
                            :</label>
                        <div class="">
                            <select class="form-control select2 @error('department_1c') is-invalid @enderror"
                                name="department_1c" required>
                                <option value="" selected disabled>Selectionner</option>
                                <option {{ $submission->department_1c == "National" ? 'selected' : '' }} value="National">National</option>
                                <option {{ $submission->department_1c == "International" ? 'selected' : '' }} value="International">International</option>
                                @foreach ($other_data['departments'] as $city)
                                    <option value="{{ ucfirst($city) }}"
                                        {{ $submission->department_1c == ucfirst($city) ? 'selected' : '' }}>
                                        {{ ucfirst($city) }}</option>
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
                        <label class="form-label" for="collapsible-state">Commune/Ville du projet <span
                                class="text-danger">*</span>
                            :</label>
                        <div class="">
                            <select class="form-control select2 @error('locality_1c') is-invalid @enderror"
                                aria-label="Default select example" name="locality_1c" required>
                                <option value="" selected disabled>Selectionner</option>
                                <option {{ $submission->locality_1c == "National" ? 'selected' : '' }} value="National">National</option>
                                <option {{ $submission->locality_1c == "International" ? 'selected' : '' }} value="International">International</option>
                                @foreach ($other_data['villages'] as $city)
                                    <option value="{{ ucfirst($city) }}"
                                        {{ $submission->locality_1c == ucfirst($city) ? 'selected' : '' }}>
                                        {{ ucfirst($city) }}
                                    </option>
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
                        <label class="form-label" for="collapsible-phone">Quartier / village <span
                                class="text-danger">*</span>
                            :</label>
                        <input type="text" class="form-control @error('adress_geo_1c') is-invalid @enderror"
                            id="adress_geo_1c" placeholder="" name="adress_geo_1c"
                            value="{{ old('adress_geo_1c') ?? $submission->adress_geo_1c }}" />
                        <div class="wizard-form-error"></div>
                    </div>
                    @error('adress_geo_1c')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Formation sollicitée
                            :</label>
                        <input type="text" class="form-control  @error('formation_1c') is-invalid @enderror"
                            id="formation_1c" placeholder="" name="formation_1c"
                            value="{{ old('formation_1c') ?? $submission->formation_1c }}" />
                        <div class="wizard-form-error"></div>
                    </div>
                    @error('formation_1c')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Autres solicitations :</label>
                        <input type="text" class="form-control " id="autres_form_1c" placeholder=""
                            name="autres_form_1c"
                            value="{{ old('autres_form_1c') ?? $submission->autres_form_1c }}" />
                        <div class="wizard-form-error"></div>
                    </div>
                </div>
            </div>

            <br>

            <div class="content-header mb-3">
                <h6 class="mb-0">&bull; 2e Choix</h6>
            </div>

            <div class="row">
                <div class="col-md-3 choice-dependent">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Domaine
                            :</label>
                        <select class="form-control select2 w-full @error('domaine_2c') is-invalid @enderror"
                            name="domaine_2c">
                            <option value="" selected disabled>Selectionner</option>
                            @foreach (domain_orientation() as $domain)
                                <option value="{{ $domain }}"
                                    {{ $submission->domaine_2c == $domain ? 'selected' : '' }}>
                                    {{ $domain }}</option>
                            @endforeach

                        </select>
                        <div class="wizard-form-error"></div>
                    </div>
                    @error('domaine_2c')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Spécialisation
                            :</label>
                        <input type="text" class="form-control @error('specialisation_2c') is-invalid @enderror"
                            id="specialisation_2c" placeholder="" name="specialisation_2c"
                            value="{{ old('specialisation_2c') ?? $submission->specialisation_2c }}" />
                        <div class="wizard-form-error"></div>
                    </div>
                    @error('specialisation_2c')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-state">Région du projet :</label>
                        <div class="">
                            <select class="form-control select2 @error('region_retraite_2c') is-invalid @enderror"
                                aria-label="Default select example" name="region_retraite_2c">
                                <option value="" selected disabled>Selectionner</option>
                                <option {{ $submission->region_retraite_1c == "National" ? 'selected' : '' }} value="National">National</option>
                                <option {{ $submission->region_retraite_1c == "International" ? 'selected' : '' }} value="International">International</option>
                                @foreach ($other_data['regions'] as $key => $district)
                                    <option value="{{ ucfirst($district) }}"
                                        {{ $submission->region_retraite_1c == ucfirst($district) ? 'selected' : '' }}>
                                        {{ ucfirst($district) }}</option>
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
                        <label class="form-label" for="collapsible-state">Département du projet :</label>
                        <div class="">
                            <select class="form-control select2 @error('department_2c') is-invalid @enderror"
                                aria-label="Default select example" name="department_2c">
                                <option value="" selected disabled>Selectionner</option>
                                <option {{ $submission->region_retraite_1c == "National" ? 'selected' : '' }} value="National">National</option>
                                <option {{ $submission->region_retraite_1c == "International" ? 'selected' : '' }} value="International">International</option>
                                @foreach ($other_data['departments'] as $city)
                                    <option value="{{ ucfirst($city) }}"
                                        {{ $submission->department_1c == ucfirst($city) ? 'selected' : '' }}>
                                        {{ ucfirst($city) }}</option>
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
                        <label class="form-label" for="collapsible-state">Commune/Ville du projet :</label>
                        <div class="">
                            <select class="form-control select2 @error('locality_2c') is-invalid @enderror"
                                aria-label="Default select example" name="locality_2c">
                                <option value="" selected disabled>Selectionner</option>
                                <option {{ $submission->region_retraite_1c == "National" ? 'selected' : '' }} value="National">National</option>
                                <option {{ $submission->region_retraite_1c == "International" ? 'selected' : '' }} value="International">International</option>
                                @foreach ($other_data['villages'] as $city)
                                    <option value="{{ ucfirst($city) }}"
                                        {{ $submission->locality_1c == ucfirst($city) ? 'selected' : '' }}>
                                        {{ ucfirst($city) }}
                                    </option>
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
                        <label class="form-label" for="collapsible-phone">Quartier / village :</label>
                        <input type="text" class="form-control  @error('adress_geo_2c') is-invalid @enderror"
                            id="adress_geo_2c" placeholder="" name="adress_geo_2c"
                            value="{{ old('adress_geo_2c') ?? $submission->adress_geo_2c }}" />
                        <div class="wizard-form-error"></div>
                    </div>
                    @error('adress_geo_2c')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Formation sollicitée:</label>
                        <input type="text" class="form-control  @error('formation_2c') is-invalid @enderror"
                            id="formation_2c" placeholder="" name="formation_2c"
                            value="{{ old('formation_2c') ?? $submission->formation_2c }}" />
                        <div class="wizard-form-error"></div>
                    </div>
                    @error('formation_2c')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Autres solicitations :</label>
                        <input type="text" class="form-control " id="autres_form_2c" placeholder=""
                            name="autres_form_2c"
                            value="{{ old('autres_form_2c') ?? $submission->autres_form_2c }}" />
                        <div class="wizard-form-error"></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-12 d-flex justify-content-end mt-3">

            <button type="submit" class="btn btn-primary"> <span
                    class="d-sm-inline-block d-none me-sm-1">Suivant</span> <i
                    class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
        </div>
    </form>
</div>

@push('js-push')
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
        $(document).ready(function() {
            function toggleDomainFields() {
                let selectedOrientation = $("input[name='orientation']:checked").val();
                if (selectedOrientation === "auto-emploi") {
                    $(".choice-dependent").show();
                    $("#domaine_1c").attr("required", true);
                } else {
                    $(".choice-dependent").hide();
                    $("#domaine_1c").removeAttr("required");
                }
            }

            toggleDomainFields();

            $("input[name='orientation']").change(function() {
                toggleDomainFields();
            });
        });
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
    <script>
        $(document).ready(function() {
            "use strict";
            $('.add__emp__btn').click(function() {
                addItems();
            });

            function addItems() {
                $('#items__emploi').append(`<div class="row">
                    <div class="col-sm-3">
            <label for="periode" class="form-label">Periodes <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" class="form-control flatpickr-input" id="flatpickr-range" placeholder="1984-1986 " name="periode" value="{{ old('periode') }}"/>
            </div>
          </div>
          <div class="col-sm-6">
            <label for="organism" class="form-label">Unité <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" class="form-control " id="organism" placeholder="1ère leGION MILITAIRE ABIDJAN" name="organism" value="{{ old('organism') }}"/>
            </div>
          </div>
          <div class="col-sm-2">
            <label for="fonction" class="form-label">Fonctions <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" class="form-control" id="fonction" placeholder="Fonction" name="fonction" value="{{ old('fonction') }}"/>
            </div>
          </div>
          <div class="col-md-1 mt-4">
                <button type="button" class="btn btn-danger remove__item__btn">
                    <i class="bx bx-trash" aria-hidden="true"></i>
                </button>
            </div>
            </div>`);


                $(`.remove__item__btn`).click(function() {
                    $(this).closest(".row").remove();
                });
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            "use strict";
            $('.add__dom__btn').click(function() {
                addItems();
            });

            function addItems() {
                $('#items__diplome').append(`<div class="row">
                            <div class="col-sm-3">
                            <label for="diplome_militaire " class="form-label">Diplômes militaires  <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="diplome_militaire" placeholder="CS1 SPORT" name="diplome_militaire" value="{{ old('diplome_militaire') }}"/>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label for="annees_dm" class="form-label">Années <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="annees_dm" placeholder="1986" name="annees_dm" value="{{ old('annees_dm') }}"/>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="diplome_civil" class="form-label">Diplôme civils <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="diplome_civil" placeholder="BEPC" name="diplome_civil" value="{{ old('diplome_civil') }}"/>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label for="annees_dc" class="form-label">Années <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="annees_dc" placeholder="1986" name="annees_dc" value="{{ old('annees_dc') }}"/>
                            </div>
                        </div>
                        <div class="col-md-1 mt-4">
                                <button type="button" class="btn btn-danger remove__item__btn">
                                    <i class="bx bx-trash" aria-hidden="true"></i>
                                </button>
                        </div>
                    </div>`);


                $(`.remove__item__btn`).click(function() {
                    $(this).closest(".row").remove();
                });
            }

        });
    </script>
@endpush
