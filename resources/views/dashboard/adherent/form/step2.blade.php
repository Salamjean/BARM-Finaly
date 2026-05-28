<div id="projet-professionnel">
    <form method="post" id="formmm" action="{{ route('adherent.update', [$step, $user->id]) }}">
        @csrf
        @method('PUT')
        <div class="accordion-body">
            <div class="content-header mb-3">
                <h6 class="mb-0">A. Origine</h6>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-state">Armée ou Arme <span
                                class="text-danger">*</span>
                            :</label>
                        <div class="input-group">
                            <input type="text" class="form-control  @error('armee') is-invalid @enderror"
                                id="armee" placeholder="1ère LEGION MILITAIRE" name="armee"
                                value="{{ old('armee') ?? $submission->armee }}" required />
                            @error('armee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="wizard-form-error"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-phone">Unité de rattachement <span
                                class="text-danger">*</span>
                            :</label>
                        <input type="text" class="form-control  @error('unite_rattachement') is-invalid @enderror"
                            id="unite_rattachement" placeholder="1ère LEGION MILITAIRE" name="unite_rattachement"
                            value="{{ old('unite_rattachement') ?? $submission->unite_rattachement }}" required />
                        <div class="wizard-form-error"></div>
                    </div>
                    @error('Unite_rattachement')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="collapsible-state">Statut <span class="text-danger">*</span>
                            :</label>
                        <div class="input-group">
                            <select name="statut_prof" id="statut_prof"
                                class="form-control  @error('statut_prof') is-invalid @enderror" required>
                                <option value="">Selectionner</option>
                                <option value="Carrière" {{ $submission->statut_prof == 'Carrière' ? 'selected' : '' }}>
                                    Carrière</option>
                                <option value="Sous contrat"
                                    {{ $submission->statut_prof == 'Sous contrat' ? 'selected' : '' }}>Sous-contrat
                                </option>
                                <option value="Retraité" {{ $submission->statut_prof == 'Retraité' ? 'selected' : '' }}>
                                    Retraité</option>
                                <option value="Engagé volontaire"
                                    {{ $submission->statut_prof == 'Engagé volontaire' ? 'selected' : '' }}>Engagé
                                    volontaire
                                </option>
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
                        <label class="form-label" for="collapsible-phone">Dernier grade <span
                                class="text-danger">*</span>
                            :</label>
                        <input type="text" class="form-control  @error('grade') is-invalid @enderror" id="grade"
                            placeholder="Ex: ADJUDANT-CHEF" name="grade"
                            value="{{ old('grade') ?? $submission->grade }}" required />
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
                        <label class="form-label" for="date_entree">Date d'entrée en service <span
                                class="text-danger">*</span> :</label>
                        <input type="date" class="form-control " id="date_entree" name="date_entree"
                            onchange="updateRadiationDateOptions(); calculateServiceDuration()"
                            value="{{ old('date_entree') ?? $submission->date_entree }}"
                            max="{{ $submission->date_radiation }}" required />
                        <div class="wizard-form-error"></div>
                    </div>
                    @error('date_entree')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="date_radiation">Date de radiation <span
                                class="text-danger">*</span>
                            :</label>
                        <input type="date" class="form-control " id="date_radiation" name="date_radiation"
                            onchange="calculateServiceDuration()"
                            value="{{ old('date_radiation') ?? $submission->date_radiation }}"
                            max="{{ date('Y-m-d') }}" required />
                        <div class="wizard-form-error"></div>
                    </div>
                    @error('date_radiation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="duree_service">Durée de service :</label>
                        <input type="text" class="form-control " id="duree_service" placeholder=""
                            name="duree_service" value="{{ old('duree_service') }}" disabled />
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
                <div id="items__emploi">
                    @foreach ($submission->jobs as $job)
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="periode" class="form-label">Periodes <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control flatpickr-input" id="flatpickr-range"
                                        placeholder="1984-1986 " name="periode[]"
                                        value="{{ old('periode') ?? $job->periode }}" required />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="organism" class="form-label">Unité <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control " id="organism"
                                        placeholder="1ère leGION MILITAIRE ABIDJAN" name="organism[]"
                                        value="{{ old('organism') ?? $job->organism }}" required />
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <label for="fonction" class="form-label">Fonctions <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fonction" placeholder="Fonction"
                                        name="fonction[]" value="{{ old('fonction') ?? $job->fonction }}" required />
                                </div>
                            </div>
                            <div class="col-md-1 mt-4">
                                <button type="button" class="btn btn-danger remove__item__btn">
                                    <i class="bx bx-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <br>
            <div class="content-header mb-3">
                <h6 class="mb-0">C. Domaine de spécialité </h6>
            </div>
            <div class="box-body">
                <div class="d-flex justify-content mb-2">
                    <div class=" mt-2">
                        <button type="button" class="btn btn-outline-info add__dom__btn__militaire fs-10"><span
                                class="fa-solid fa-plus-circle">&nbsp;</span>
                            Ajouter Diplôme militaire
                        </button>
                    </div>
                </div>
                <div id="items__diplome__militaire">
                    @foreach ($submission->diplomes as $diplome)
                        @if ($diplome->type == 'militaire')
                            <div class="row">
                                <div class="col-sm-7">
                                    <label for="diplome_militaire " class="form-label">Diplômes militaires <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input required type="text" class="form-control" id="diplome_militaire"
                                            placeholder="CS1 SPORT" name="diplome_militaire[]"
                                            value="{{ old('diplome_militaire') ?? $diplome->diplome }}" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="annees_dm" class="form-label">Années <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input required type="text" class="form-control" id="annees_dm"
                                            placeholder="1986" name="annees_dm[]"
                                            value="{{ old('annees_dm') ?? $diplome->annees }}" />
                                    </div>
                                </div>
                                <div class="col-md-1 mt-4">
                                    <button type="button" class="btn btn-danger remove__item__btn__militaire">
                                        <i class="bx bx-trash" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="box-body">
                <div class="d-flex justify-content mb-2">
                    <div class="mt-4">
                        <button type="button" class="btn btn-outline-info add__dom__btn__civil fs-10"><span
                                class="fa-solid fa-plus-circle">&nbsp;</span>
                            Ajouter Diplôme civil
                        </button>
                    </div>
                </div>
                <div id="items__diplome__civil">
                    @foreach ($submission->diplomes as $diplome)
                        @if ($diplome->type == 'civil')
                            <div class="row">

                                <div class="col-sm-7">
                                    <label for="diplome_civil" class="form-label">Diplôme civils <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input required type="text" class="form-control" id="diplome_civil"
                                            placeholder="BEPC" name="diplome_civil[]"
                                            value="{{ old('diplome_civil') ?? $diplome->diplome }}" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="annees_dc" class="form-label">Années <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input required type="text" class="form-control" id="annees_dc"
                                            placeholder="1986" name="annees_dc[]"
                                            value="{{ old('annees_dc') ?? $diplome->annees }}" />
                                    </div>
                                </div>
                                <div class="col-md-1 mt-4">
                                    <button type="button" class="btn btn-danger remove__item__btn__civil">
                                        <i class="bx bx-trash" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end mt-3">

                <a href="{{ url('/inscription/step3') }}">
                    <button type="submit" class="btn btn-primary"> <span
                            class="d-sm-inline-block d-none me-sm-1">Suivant</span> <i
                            class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
                </a>

            </div>
        </div>
    </form>
</div>

<!-- Content wrapper -->
@push('js-push')
    <script>
        @if ($submission->date_radiation && $submission->date_entree)
            calculateServiceDuration();
        @endif
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
    <script>
        $(document).ready(function() {
            "use strict";
        $('.add__emp__btn').click(function() {
            addItems();
        });

        $('#items__emploi').on('click', '.remove__item__btn', function() {
            $(this).closest(".row").remove();
        });

        function addItems() {
            $('#items__emploi').append(`<div class="row">
                <div class="col-sm-3">
                    <label for="periode" class="form-label">Periodes <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control flatpickr-input" id="flatpickr-range" placeholder="1984-1986 " name="periode[]" value="{{ old('periode') }}" required/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label for="organism" class="form-label">Unité <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control " id="organism" placeholder="1ère leGION MILITAIRE ABIDJAN" name="organism[]" value="{{ old('organism') }}" required/>
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="fonction" class="form-label">Fonctions <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="fonction" placeholder="Fonction" name="fonction[]" value="{{ old('fonction') }}" required/>
                    </div>
                </div>
                <div class="col-md-1 mt-4">
                    <button type="button" class="btn btn-danger remove__item__btn">
                        <i class="bx bx-trash" aria-hidden="true"></i>
                    </button>
                </div>
            </div>`);
        }

        $('.add__dom__btn__militaire').click(function() {
            addItemsMilitaire();
        });

        $('#items__diplome__militaire').on('click', '.remove__item__btn__militaire', function() {
            $(this).closest(".row").remove();
        });

        function addItemsMilitaire() {
            $('#items__diplome__militaire').append(`<div class="row">
                <div class="col-sm-7">
                    <label for="diplome_militaire " class="form-label">Diplômes militaires <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input required type="text" class="form-control" id="diplome_militaire" placeholder="CS1 SPORT" name="diplome_militaire[]" value="{{ old('diplome_militaire') }}"/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="annees_dm" class="form-label">Années <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input required type="text" class="form-control" id="annees_dm" placeholder="1986" name="annees_dm[]" value="{{ old('annees_dm') }}"/>
                    </div>
                </div>
                <div class="col-md-1 mt-4">
                    <button type="button" class="btn btn-danger remove__item__btn__militaire">
                        <i class="bx bx-trash" aria-hidden="true"></i>
                    </button>
                </div>
            </div>`);
        }

        $('.add__dom__btn__civil').click(function() {
            addItemsCivil();
        });

        $('#items__diplome__civil').on('click', '.remove__item__btn__civil', function() {
            $(this).closest(".row").remove();
        });

        function addItemsCivil() {
            $('#items__diplome__civil').append(`<div class="row">
                <div class="col-sm-7">
                    <label for="diplome_civil" class="form-label">Diplôme civils <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input required type="text" class="form-control" id="diplome_civil" placeholder="BEPC" name="diplome_civil[]" value="{{ old('diplome_civil') }}"/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="annees_dc" class="form-label">Années <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input required type="text" class="form-control" id="annees_dc" placeholder="1986" name="annees_dc[]" value="{{ old('annees_dc') }}"/>
                    </div>
                </div>
                <div class="col-md-1 mt-4">
                    <button type="button" class="btn btn-danger remove__item__btn__civil">
                        <i class="bx bx-trash" aria-hidden="true"></i>
                    </button>
                </div>
            </div>`);
        }

        });
    </script>

@endpush
