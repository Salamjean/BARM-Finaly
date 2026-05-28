
<div id="condition-depart">
    <form method="post" id="formmm" action="{{ route('adherent.update', [$step, $user->id]) }}">
        @csrf
        @method('PUT')
        <div class="accordion-body">
            <div class="mb-3">
                <label class="form-check-label">&bull; Conditions Administratives<span
                        class="text-danger">*</span></label>
                <div class="col-md-6 mt-1 mb-3">
                    <div class="form-group">

                        <input type="text" class="form-control @error('condition_admin') is-invalid @enderror"
                            id="condition_admin" placeholder="" name="condition_admin"
                            value="{{ old('condition_admin') ?? $submission->condition_admin }}" required />
                        <div class="wizard-form-error"></div>
                    </div>
                </div>
                <label for="condition_financiere" class="form-check-label">&bull; Conditions Financières<span
                        class="text-danger">
                        *</span></label><br>
                <i>(Cochez la ou les case(s) corespondant à votre situation en quittant l'institution)</i>
                <br>

                @foreach (FINANCIAL_CONDITIONS as $financial)
                    @if ($submission->condition_financiere)
                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="checkbox" name="condition_financiere[]"
                                id="{{ $financial['id'] }}" value="{{ $financial['value'] }}"
                                {{ in_array($financial['value'], json_decode($submission->condition_financiere)) ? 'checked' : '' }} />
                            <label class="form-check-label"
                                for="{{ $financial['id'] }}">{{ $financial['value'] }}</label>
                        </div>
                    @else
                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="checkbox" name="condition_financiere[]"
                                id="{{ $financial['id'] }}" value="{{ $financial['value'] }}" />
                            <label class="form-check-label"
                                for="{{ $financial['id'] }}">{{ $financial['value'] }}</label>
                        </div>
                    @endif
                @endforeach


            </div>
            <div class="col-md-12">
                <label class="form-check-label" for="collapsible-phone">&bull; Conditions disciplinaires :</label>
                {{-- {{ dd($submission->condition_disciplinaire) }} --}}
                @php
                    if ($submission->condition_disciplinaire) {

                        $first_element = json_decode($submission->condition_disciplinaire)[0];
                        $orther_element = [];

                        foreach (json_decode($submission->condition_disciplinaire) as $key => $element) {
                            if ($key != 0) {
                                $orther_element[$key - 1] = $element;
                            }
                        }
                    } else {
                        $first_element = null;
                        $orther_element = [];
                    }
                @endphp

                <div class="row me-2">
                    @if ($first_element)
                        <div class="col-md-8">
                            <label for="title_decoration" class="form-label">Intitulé de la décoration
                                1
                            </label>
                            <input type="text" class="form-control" id="title_decoration"
                                placeholder="Médaille d'honneur" name="condition_disciplinaire[0][title_decoration]"
                                value="{{ $first_element->title_decoration }}" />
                        </div>
                        <div class="col-md-3">
                            <label for="date_decoration" class="form-label">Date d'obtention 1</label>
                            <input type="date" class="form-control" id="date_decoration"
                                name="condition_disciplinaire[0][date_decoration]"
                                value="{{ $first_element->date_decoration }}" />
                        </div>
                    @else
                        <div class="col-md-8">
                            <label for="title_decoration" class="form-label">Intitulé de la décoration
                                1 </label>
                            <input type="text" class="form-control" id="title_decoration"
                                placeholder="Médaille d'honneur" name="condition_disciplinaire[0][title_decoration]" />
                        </div>
                        <div class="col-md-3">
                            <label for="date_decoration" class="form-label">Date d'obtention </label>
                            <input type="date" class="form-control" id="date_decoration"
                                name="condition_disciplinaire[0][date_decoration]" />
                        </div>
                    @endif
                    <div class="col-1" style="">
                        <button type="button"
                            class="btn btn-primary border-info text-white add__items__btn fs-4 mt-4"><i
                                class='bx bx-plus'></i></button>
                    </div>
                </div>

                <div id="items__enfant">
                    @foreach ($orther_element as $key => $element)
                        <div class="row me-2">
                            <div class="col-md-8">
                                <label for="title_decoration" class="form-label">Intitulé de la décoration
                                    {{ $key + 1 }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title_decoration"
                                    placeholder="Médaille d'honneur"
                                    name="condition_disciplinaire[{{ $key + 1 }}][title_decoration]"
                                    value="{{ $element->title_decoration }}" required />
                            </div>
                            <div class="col-md-3">
                                <label for="date_decoration" class="form-label">Date d'obtention {{ $key + 1 }}</label>
                                <input type="date" class="form-control" id="date_decoration"
                                    name="condition_disciplinaire[{{ $key + 1 }}][date_decoration]"
                                    value="{{ $element->date_decoration }}" />
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
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = [
                document.getElementById('pension_retraite'),
                document.getElementById('pension_reforme'),
                document.getElementById('solde_reforme'),
                document.getElementById('remboursement')
            ];

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        checkboxes.forEach((cb) => {
                            if (cb !== this) {
                                cb.checked = false;
                            }
                        });
                    }
                });
            });
        });
    </script>
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
            "use strict";

            var rowIndex =
                {{ $submission->condition_disciplinaire ? count(json_decode($submission->condition_disciplinaire)) : 1 }};

            // Add item handler
            $('.add__items__btn').click(function() {
                rowIndex++;
                addItems();
            });

            // Remove item handler
            $(document).on('click', '.remove__item__btn', function() {
                $(this).closest(".row").remove();
                rowIndex--;
            });


            // Add item function
            function addItems() {
                $('#items__enfant').append(`<div class="row me-2">
                    <div class="col-md-8">
                    <label for="title_decoration" class="form-label">Intitulé de la décoration ${rowIndex - 1} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title_decoration" placeholder="Médaille d'honneur" name="condition_disciplinaire[${rowIndex - 1}][title_decoration]" required />
                    </div>
                    <div class="col-md-3">
                        <label for="date_decoration" class="form-label">Date d'obtention ${rowIndex - 1} </label>
                        <input type="date" class="form-control" id="date_decoration" name="condition_disciplinaire[${rowIndex - 1}][date_decoration]" />
                    </div>
                    <div class="col-md-1 mt-4">
                        <button type="button" class="btn btn-danger remove__item__btn">
                            <i class="bx bx-trash" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>`);

            }

        });
    </script>
@endpush
