<div id="pieces-jointes">
    <form method="post" id="formmm" action="{{ route('adherent.update', [$step, $user->id]) }}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="accordion-body">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="fiche_inscription">Fiche d'inscription <span
                            class="text-danger">*</span></label>
                    @if ($submission->fiche_inscription)
                        <a href="{{ asset($submission->fiche_inscription) }}" download><i
                                class="fa-solid fa-down-long"></i></a>
                    @endif
                    <input type="file" class="form-control" name="fiche_inscription" id="fiche_inscription"
                        {{ $submission->fiche_inscription ? '' : 'required' }} accept=".pdf" />
                    @error('fiche_inscription')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="demande_manuscrite">Demande manuscrite <span
                            class="text-danger">*</span></label>
                    @if ($submission->demande_manuscrite)
                        <a href="{{ asset($submission->demande_manuscrite) }}" download><i
                                class="fa-solid fa-down-long"></i></a>
                    @endif
                    <input type="file" class="form-control" name="demande_manuscrite" id="demande_manuscrite"
                        {{ $submission->demande_manuscrite ? '' : 'required' }} accept=".pdf" />
                    @error('demande_manuscrite')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="cv">Curriculum vitae (CV)
                            
                    </label>

                    @if ($submission->cv)
                        <a href="{{ asset($submission->cv) }}" download><i class="fa-solid fa-down-long"></i></a>
                    @endif
                    <input type="file" class="form-control" name="cv" id="cv" accept=".pdf" />
                    @error('cv')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="id_card">Pièce d'identité (les 2 faces sur la même
                        page)
                        <span class="text-danger">*</span></label>
                    @if ($submission->id_card)
                        <a href="{{ asset($submission->id_card) }}" download><i class="fa-solid fa-down-long"></i></a>
                    @endif
                    <input type="file" class="form-control" name="id_card" id="id_card" accept=".pdf"
                        {{ $submission->id_card ? '' : 'required' }} />
                    @error('id_card')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="carte_pro">Carte professionnelle </label>
                    @if ($submission->carte_pro)
                        <a href="{{ asset($submission->carte_pro) }}" download><i
                                class="fa-solid fa-down-long"></i></a>
                    @endif
                    <input type="file" class="form-control" id="carte_pro" name="carte_pro"
                        {{ $submission->carte_pro ? '' : '' }} accept=".pdf" />
                    @error('carte_pro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="fiche_engagement">Fiche d'engagement <span
                            class="text-danger">*</span></label>
                    @if ($submission->fiche_engagement)
                        <a href="{{ asset($submission->fiche_engagement) }}" download><i
                                class="fa-solid fa-down-long"></i></a>
                    @endif
                    <input type="file" class="form-control" id="fiche_engagement" name="fiche_engagement"
                        {{ $submission->fiche_engagement ? '' : 'required' }} accept=".pdf" />
                    @error('fiche_engagement')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="fiche_individuelle">Fiche individuelle</label>
                    @if ($submission->fiche_individuelle)
                        <a href="{{ asset($submission->fiche_individuelle) }}" download><i
                                class="fa-solid fa-down-long"></i></a>
                    @endif
                    <input type="file" class="form-control" id="fiche_individuelle" name="fiche_individuelle"
                        {{ $submission->fiche_individuelle ? '' : '' }} accept=".pdf" />
                    @error('fiche_individuelle')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="arrete_radiation">Arrêté de radiation <span
                            class="text-danger">*</span></label>
                    @if ($submission->arrete_radiation)
                        <a href="{{ asset($submission->arrete_radiation) }}" download><i
                                class="fa-solid fa-down-long"></i></a>
                    @endif
                    <input type="file" class="form-control" id="arrete_radiation" name="arrete_radiation"
                        {{ $submission->arrete_radiation ? '' : 'required' }} accept=".pdf" />
                    @error('arrete_radiation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="certificat">Certificat médical</label>
                    @if ($submission->certificat)
                        <a href="{{ asset($submission->certificat) }}" download><i
                                class="fa-solid fa-down-long"></i></a>
                    @endif
                    <input type="file" class="form-control" id="certificat" name="certificat" accept=".pdf" />
                    @error('certificat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                 <div class="col-md-6 mb-3">
                    <label class="form-label" for="date_inscription">Date d&apos;incription au BARM<span
                            class="text-danger">*</span></label>
                    
                    <input type="date" class="form-control" id="date_inscription" name="date_inscription" required value="{{ old('date_inscription ') ?? $submission->date_inscription }}" />
                    @error('date_inscription')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

        </div>

        <div class="col-12 d-flex justify-content-end mt-3">


            <button type="submit" class="btn btn-primary"> <span class="d-sm-inline-block d-none me-sm-1">Terminer
                    l'inscription</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>


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
@endpush
