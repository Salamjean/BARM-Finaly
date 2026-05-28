<div id="situation-matrimoniale">
    <form method="post" id="formmm" action="{{ route('adherent.update', [$step, $user->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <label class="form-label" for="situation_matrimoniale">Situation Matrimoniale <span
                        class="text-danger">*</span>
                    :</label>
                <select name="situation_matrimoniale" id="situation_matrimoniale"
                    class="form-control @error('situation_matrimoniale') is-invalid @enderror" required>
                    <option value="">Selectionner</option>
                    <option value="marié(e)" {{ $submission->situation_matrimoniale == 'marié(e)' ? 'selected' : '' }}>
                        Marié(e)</option>
                    <option
                        value="concubin(e)"
                        {{ $submission->situation_matrimoniale == 'concubin(e)' ? 'selected' : '' }}
                    >
                        Concubin(e)
                    </option>
                    <option
                        value="celibataire"
                        {{ $submission->situation_matrimoniale == 'celibataire' ? 'selected' : '' }}
                    >
                        Célibataire
                    </option>
                    <option value="divorcé(e)"
                        {{ $submission->situation_matrimoniale == 'divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                    <option value="veuf(ve)" {{ $submission->situation_matrimoniale == 'veuf(ve)' ? 'selected' : '' }}>
                        Veuf(ve)</option>
                </select>
                <div class="wizard-form-error"></div>
                @error('situation_matrimoniale')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label" for="partner_name" style="display: none;">Nom Conjoint(e) <span
                        class="text-danger">*</span> :</label>
                <input type="text" id="partner_name" name="partner_fullname"
                    class="form-control @error('partner_fullname') is-invalid @enderror" placeholder="Nom complet"
                    value="{{ old('partner_fullname') ?? $submission->partner_fullname }}" style="display: none" />
                @error('partner_fullname')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label" for="partner_job" style="display: none;">Profession Conjoint(e)  :</label>
                <input type="text" id="partner_job" name="partner_job"
                    class="form-control @error('partner_job') is-invalid @enderror" placeholder="Caissière"
                    value="{{ old('partner_job') ?? $submission->partner_job }}" style="display: none" />
                @error('partner_job')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label" for="partner_phone_number" style="display: none;">Contact Conjoint(e) <span
                        class="text-danger">*</span> :</label>
                <input type="text" class="form-control @error('partner_phone_number') is-invalid @enderror"
                    id="partner_phone_number" placeholder="0505051010" name="partner_phone_number"
                    value="{{ old('partner_phone_number') ?? $submission->partner_phone_number }}"
                    style="display: none" />
                @error('partner_phone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label" for="partner_phone_number2" style="display: none;">Contact 2 Conjoint(e)  :</label>
                <input type="text" class="form-control @error('partner_phone_number2') is-invalid @enderror"
                    id="partner_phone_number2" placeholder="0505051010" name="partner_phone_number2"
                    value="{{ old('partner_phone_number2') ?? $submission->partner_phone_number2 }}"
                    style="display: none" />
                @error('partner_phone_number2')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label" for="partner_card" style="display: none;">Pièce d'identité conjoint(e) : </label>

                @if ($submission->partner_card)
                    <a href="{{ asset($submission->partner_card) }}" download><i class="fa-solid fa-down-long"></i></a>
                @endif
                <input type="file" class="form-control" name="partner_card" id="partner_card"
                    value="{{ old('partner_card') }}" style="display: none" accept=".pdf" />
                @error('partner_card')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label" for="marriage_certificate" style="display: none;">Acte de mariage  :</label>
                @if ($submission->marriage_certificate)
                    <a href="{{ asset($submission->marriage_certificate) }}" download><i
                            class="fa-solid fa-down-long"></i></a>
                @endif
                <input type="file" class="form-control" name="marriage_certificate" id="marriage_certificate"
                    style="display: none" accept=".pdf" />
                @error('marriage_certificate')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <br>
        <div class="row g-3 mb-3">
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
                <div id="items__enfant">
                    @foreach ($submission->childs as $child)
                        <div class="row">
                            <div class="col-md-6">
                                <label for="child_name" class="form-label">Nom & Prénom(s) de l'enfant <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="child_name"
                                    placeholder="Nom Complet de l'enfant" name="child_name[]"
                                    value="{{ $child->fullname }}" required />

                            </div>
                            <div class="col-md-3">
                                <label for="child_birthdate" class="form-label">Date de Naissance <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="child_birthdate"
                                    name="child_birthdate[]" value="{{ $child->birth_date }}" />

                            </div>
                            <div class="col-md-3">
                                <label for="child_niveau" class="form-label">Niveau d'étude <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="child_niveau"
                                    placeholder="niveau ou Formation" name="child_niveau[]"
                                    value="{{ $child->level }}" required />

                            </div>
                            <div class="col-md-5 py-2">
                                <label class="form-label" for="basic-default-upload-file">Document Justificatif <span
                                        class="text-danger">*</span></label>
                                @if ($child->file)
                                    <a href="{{ asset($child->file) }}" download><i
                                            class="fa-solid fa-down-long"></i></a>
                                @endif
                                <input type="file" class="form-control" id="child_file"
                                    accept=".pdf" name="child_file[]"
                                    required />

                            </div>
                            <div class="col-md-2 mt-4">
                                <button type="button" class="btn btn-danger remove__item__btn">
                                    <i class="bx bx-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <br>
                <b>&bull;
                    Coordonnées
                </b>
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="collapsible-phone">Mobile :</label>
                            <input type="text" class="form-control  @error('phone_number') is-invalid @enderror"
                                id="phone_number" placeholder="0707252525" name="phone_number"
                                value="{{ old('phone_number') ?? $submission->phone_number }}" disabled />
                            <div class="wizard-form-error"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="collapsible-phone">Lieu d'habitation <span
                                    class="text-danger">*</span>
                                :</label>
                            <input type="text" class="form-control  @error('residence') is-invalid @enderror"
                                id="residence" placeholder="Cocody cité des arts" name="residence"
                                value="{{ old('residence') ?? $submission->residence }}" required />
                            <div class="wizard-form-error"></div>
                        </div>
                        @error('residence')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="collapsible-phone">Adresse postale :</label>
                            <input type="text" class="form-control  @error('address') is-invalid @enderror"
                                id="address" placeholder="01 BP 0251 Abidjan 01" name="address"
                                value="{{ old('address') ?? $submission->address }}" />
                            <div class="wizard-form-error"></div>
                        </div>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-end mt-3">


            <button type="submit" class="btn btn-primary"> <span class="d-sm-inline-block d-none me-sm-1">Suivant</span> <i
                    class="bx bx-chevron-right bx-sm me-sm-n2"></i>
            </button>

        </div>
    </form>
</div>

@push('js-push')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var situationMatrimoniale = document.getElementById('situation_matrimoniale');

            var partnerName = document.getElementById('partner_name');
            var partnerNameLabel = document.querySelector('label[for="partner_name"]');
            var partnerJob = document.getElementById('partner_job');
            var partnerJobLabel = document.querySelector('label[for="partner_job"]');
            var contactPartner = document.getElementById('partner_phone_number');
            var contactPartner2 = document.getElementById('partner_phone_number2');
            var contactPartnerLabel = document.querySelector('label[for="partner_phone_number"]');
            var contactPartnerLabel2 = document.querySelector('label[for="partner_phone_number2"]');
            var marriageCertificate = document.getElementById('marriage_certificate');
            var marriageCertificateLabel = document.querySelector('label[for="marriage_certificate"]');
            var partnerId = document.getElementById('partner_card');
            var partnerIdLabel = document.querySelector('label[for="partner_card"]');

            @if ($submission->situation_matrimoniale == 'marié(e)')
                partnerName.style.display = 'block';
                partnerNameLabel.style.display = 'block';
                partnerJob.style.display = 'block';
                partnerJobLabel.style.display = 'block';
                contactPartner.style.display = 'block';
                contactPartner2.style.display = 'block';
                contactPartnerLabel.style.display = 'block';
                contactPartnerLabel2.style.display = 'block';
                marriageCertificate.style.display = 'block';
                marriageCertificateLabel.style.display = 'block';
                partnerId.style.display = 'block';
                partnerIdLabel.style.display = 'block';
            @elseif ($submission->situation_matrimoniale == 'concubin(e)')
                partnerName.style.display = 'block';
                partnerNameLabel.style.display = 'block';
                partnerJob.style.display = 'block';
                partnerJobLabel.style.display = 'block';
                contactPartner.style.display = 'block';
                contactPartner2.style.display = 'block';
                contactPartnerLabel.style.display = 'block';
                contactPartnerLabel2.style.display = 'block';
                partnerId.style.display = 'block';
                partnerIdLabel.style.display = 'block';
            @endif

            situationMatrimoniale.addEventListener('change', function() {

                partnerName.style.display = 'none';
                partnerNameLabel.style.display = 'none';
                partnerJob.style.display = 'none';
                partnerJobLabel.style.display = 'none';
                contactPartner.style.display = 'none';
                contactPartner2.style.display = 'none';
                contactPartnerLabel.style.display = 'none';
                contactPartnerLabel2.style.display = 'none';
                marriageCertificate.style.display = 'none';
                marriageCertificateLabel.style.display = 'none';
                partnerId.style.display = 'none';
                partnerIdLabel.style.display = 'none';

                switch (this.value) {
                    case 'marié(e)':

                        partnerName.style.display = 'block';
                        partnerNameLabel.style.display = 'block';
                        partnerJob.style.display = 'block';
                        partnerJobLabel.style.display = 'block';
                        contactPartner.style.display = 'block';
                        contactPartner2.style.display = 'block';
                        contactPartnerLabel.style.display = 'block';
                        contactPartnerLabel2.style.display = 'block';
                        marriageCertificate.style.display = 'block';
                        marriageCertificateLabel.style.display = 'block';
                        partnerId.style.display = 'block';
                        partnerIdLabel.style.display = 'block';
                        break;
                    case 'concubin(e)':

                        partnerName.style.display = 'block';
                        partnerNameLabel.style.display = 'block';
                        partnerJob.style.display = 'block';
                        partnerJobLabel.style.display = 'block';
                        contactPartner.style.display = 'block';
                        contactPartner2.style.display = 'block';
                        contactPartnerLabel.style.display = 'block';
                        contactPartnerLabel2.style.display = 'block';
                        partnerId.style.display = 'block';
                        partnerIdLabel.style.display = 'block';
                        break;
                    default:
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            "use strict";
            $('.add__items__btn').click(function() {
                addItems();
            });

            function addItems() {
                $('#items__enfant').append(`<div class="row">
                    <div class="col-md-4">
                    <label for="child_name" class="form-label">Nom & Prénom(s) de l'enfant <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="child_name" placeholder="Nom Complet de l'enfant" name="child_name[]" required />

                    </div>
                    <div class="col-md-3">
                        <label for="child_birthdate" class="form-label">Date de Naissance </label>
                        <input type="date" class="form-control" id="child_birthdate" name="child_birthdate[]"  />

                    </div>
                    <div class="col-md-2">
                        <label for="child_niveau" class="form-label">Niveau d'étude </label>
                        <input type="text" class="form-control" id="child_niveau" placeholder="niveau ou Formation" name="child_niveau[]"  />

                    </div>
                    <div class="col-md-3">
                        <label for="child_job" class="form-label">Emploi </label>
                        <input type="text" class="form-control" id="child_job" placeholder="niveau ou Formation" name="child_job[]"  />

                    </div>
                    <div class="col-md-5">
                            <label class="form-label" for="basic-default-upload-file">Document Justificatif </label>
                            <input type="file" class="form-control" id="child_file" accept=".pdf" name="child_file[]"  />

                    </div>
                    <div class="col-md-2 mt-4">
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
