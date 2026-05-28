<div id="accident-maladie">
    <form method="post" id="formmm" action="{{ route('adherent.update', [$step, $user->id]) }}">
        @csrf
        @method('PUT')
        <div class="accordion-body">
            <div class="mb-3">
                <div class="">
                    <h6 class="mb-0">&bull; Accident ou maladie<span
                                    class="text-danger">*</span></h6>
                    <div class="col mt-2">
                        <div class="form-check form-check-inline">
                            <input name="accident_maladie" class="form-check-input" type="radio"
                                value="Blessé en opération" id="blesse_operation" {{ $submission->accident_maladie == 'Blessé en opération' ? 'checked ' : '' }} required />
                            <label class="form-check-label" for="blesse_operation">Blessé en opération</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="accident_maladie" class="form-check-input" type="radio"
                                value="Blessé en service" id="blesse_service" {{ $submission->accident_maladie == 'Blessé en service' ? 'checked ' : '' }} />
                            <label class="form-check-label" for="blesse_service">Blessé en service</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="accident_maladie" class="form-check-input" type="radio" value="Handicap"
                                id="handicap" {{ $submission->accident_maladie == 'Handicap' ? 'checked ' : '' }} />
                            <label class="form-check-label" for="handicap">Handicap</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="accident_maladie" class="form-check-input" type="radio"
                                value="Maladie professionnelle" id="maladie_prof" {{ $submission->accident_maladie == 'Maladie professionnelle' ? 'checked ' : '' }} />
                            <label class="form-check-label" for="maladie_prof">Maladie professionnelle</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="accident_maladie" class="form-check-input" type="radio" value="Aucun"
                                id="aucun" {{ $submission->accident_maladie == 'Aucun' ? 'checked ' : '' }} />
                            <label class="form-check-label" for="aucun">Aucun</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="collapsible-phone">Indication de l'accident ou maladie </label>
                    <textarea class="form-control" id="maladie_supp" placeholder="Préciser" name="maladie_supp" cols="3">{{ $submission->indication }}</textarea>
                </div>
            </div>
            <div class="content-header mb-3 mt-3">
                <h6 >&bull; Démarches déjà entreprises<span
                                    class="text-danger">*</span></h6>
                <div class="col">
                    <div class="form-check form-check-inline">
                        <input name="orientation" class="form-check-input" type="radio" value="oui" id="oui"
                            onchange="toggleDemarcheFields()" {{ $submission->demarche_nature  ? 'checked ' : '' }} required />
                        <label class="form-check-label" for="oui">Oui</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="orientation" class="form-check-input" type="radio" value="non" id="non"
                            onchange="toggleDemarcheFields()" {{ $submission->demarche_nature ? '' : 'checked' }} />
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
                            <input type="text" class="form-control @error('demarche_nature') is-invalid @enderror"
                                id="demarche_nature" placeholder="Préciser" name="demarche_nature"
                                value="{{ old('demarche_nature') ?? $submission->demarche_nature }}" />
                            @error('demarche_nature')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="collapsible-phone">Démarche de quelle administration ? <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('demarche_admin') is-invalid @enderror"
                                id="demarche_admin" placeholder="Préciser" name="demarche_admin"
                                value="{{ old('demarche_admin') ?? $submission->demarche_admin  }}" />
                            @error('demarche_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="collapsible-phone">Etat d'avancement des démarches ? <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('etat_avancement') is-invalid @enderror"
                                id="etat_avancement" placeholder="Préciser" name="etat_avancement"
                                value="{{ old('etat_avancement ') ?? $submission->etat_avancement }}" />
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
                    <label class="form-label" for="collapsible-phone">Indications ou commentaires </label>
                    <textarea class="form-control" id="indication" placeholder="Préciser" name="indication" cols="3">{{ $submission->indication }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-end mt-3">


            <button type="submit" class="btn btn-primary"> <span class="d-sm-inline-block d-none me-sm-1">Suivant</span> <i
                    class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>


        </div>
    </form>
</div>

<!-- Content wrapper -->
@push('js-push')
    <script>
        @if ($submission->demarche_nature)
            toggleDemarcheFields()
        @endif
        function toggleDemarcheFields() {
            var ouiRadio = document.getElementById("oui");
            var demarcheFields = document.getElementById("demarche_fields");

            if (ouiRadio.checked) {
                demarcheFields.style.display = "block";
                document.getElementById("indication").disabled = false;
                document.getElementById("demarche_nature").required = true;
                document.getElementById("demarche_admin").required = true;
                document.getElementById("etat_avancement").required = true;
            } else {
                demarcheFields.style.display = "none";
                // document.getElementById("indication").disabled = true; 
                document.getElementById("demarche_nature").required = false;
                document.getElementById("demarche_admin").required = false;
                document.getElementById("etat_avancement").required = false;
            }
        }
    </script>
@endpush
