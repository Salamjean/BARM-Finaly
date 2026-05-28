@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">

            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Demande de consommable/</span> Modifier la demande
            </h4>

            <div class="card">
                {{-- <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Faire une demande de consommable</h5>
                </div> --}}

                @if(!can('responsable-gestionnaire-des-ressources-humaines|chef-barm'))
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('besoins.update', $besoin->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12 mb-10">
                            <label for="libelle" class="form-label">Titre de la demande : </label>
                            <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle"
                                placeholder="Nom de besoin" name="libelle" value="{{ $besoin->libelle }}">
                            @error('libelle')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        {{-- <div class="col-md-3 mb-10">
                            <label for="date" class="form-label">Période de la demande : </label>
                            <input type="text" class="form-control @error('date') is-invalid @enderror" id="date"
                                placeholder="Nom de besoin" name="date" value="{{ $besoin->date }}">
                            @error('date')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> --}}
                        {{-- <div class="col-md-4 mb-10">
                            <label for="service" class="form-label">Service : </label>
                            <input type="text" class="form-control @error('service') is-invalid @enderror" id="service"
                                placeholder="Nom de besoin" name="service" value="{{$besoin->service}}" readonly>
                            @error('service')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> --}}
                        <input type="text" class="form-control  is-invalid " placeholder="Nom de besoin" name="user_id"
                            value="{{$besoin->user_id}}" hidden>

                        @foreach ($besoin->besoinitems as $key=>$besoinitem)
                        <div class="col-10">
                            <div class="mb-3">
                                <label class="form-label">Consommable</label>
                                <select class="form-select select2" data-placeholder="Choisir un consommable" name="besoinitems[{{ $key }}][consommable_id]">
                                    <option value="{{$besoinitem->consommable->id}}">{{$besoinitem->consommable->designation}}</option>
                                    @foreach($consommables as $consommable)
                                    <option value="{{ $consommable->id }}">{{ $consommable->designation }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Designation requis</div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <label class="form-label">Quantité demandé</label>
                                <input class="form-control quantite" type="number"
                                    name="besoinitems[{{ $key }}][qte_demande]" value="{{$besoinitem->qte_demande}}" 
                                    required />
                                <div class="invalid-feedback">Quantité requis</div>
                            </div>
                        </div>
                        @endforeach

                        <div id="items__enfant"></div>

                        <div class="d-flex justify-content mb-4">
                            <button type="button" class="btn btn-primary border-info text-white add__items__btn fs-4"><i
                                    class='bx bx-plus'></i></button>
                        </div>

                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Modifier</button>
                                <a href="{{ route('besoins.index') }}" type="reset"
                                    class="btn btn-danger px-4">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
                @endif

                @if(can('responsable-gestionnaire-des-ressources-humaines|chef-barm'))
                <div class="card-body p-4">
                    <form id="validationForm" class="row g-3" method="POST"
                        action="{{ route('validatebesoin', $besoin->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 mb-10">
                            <label for="libelle" class="form-label">Titre de la demande : </label>
                            <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle"
                                placeholder="Nom de besoin" name="libelle" value="{{ $besoin->libelle }}">
                            @error('libelle')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <input type="text" class="form-control  is-invalid " placeholder="Nom de besoin" name="user_id"
                            value="{{$besoin->user_id}}" hidden>

                        @foreach ($besoin->besoinitems as $key=>$besoinitem)
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Consommable</label>
                                <input class="form-control" placeholder="Consommable" type="text" name="besoinitems[{{ $key }}][consommable_id]"
                                    value="{{$besoinitem->consommable->id}}" hidden required readonly />
                                <input class="form-control" placeholder="Consommable" type="text" value="{{$besoinitem->consommable->designation}}"
                                    required readonly />
                                <div class="invalid-feedback">Designation requis</div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <label class="form-label">Quantité demandé</label>
                                <input class="form-control quantite" type="number"
                                    name="besoinitems[{{ $key }}][qte_demande]" value="{{$besoinitem->qte_demande}}"
                                    required readonly />
                                <div class="invalid-feedback">Quantité requis</div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <label class="form-label">Quantité envoyé</label>
                                <input class="form-control quantite" type="number"
                                    name="besoinitems[{{ $key }}][qte_recue]" value="{{$besoinitem->qte_recue == null ? '0' : $besoinitem->qte_recue}}"
                                    {{$besoin->status == 'pending' ? '' : 'readonly'}}
                                required />
                                <div class="invalid-feedback">Quantité requis</div>
                            </div>
                        </div>
                        @if ($besoin->status == 'pending')
                            @if (can('responsable-gestionnaire-des-ressources-humaines'))
                                <div class="col-2" style="margin-top:2.5rem">
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-success btn-toggle" onclick="toggleDisponibilite(this)">Disponible</button>
                                        <input type="hidden" value="1" name="besoinitems[{{ $key }}][disponible]">
                                    </div>
                                </div>
                            @endif
                        @endif
                        
                        @endforeach

                        {{-- <div class="col-md-12 mb-10">
                            <label for="commentaire" class="form-label">Commentaire : </label>
                            <textarea class="form-control @error('commentaire') is-invalid @enderror" name="commentaire" id="commentaire" rows="5">{{ $besoin->commentaire }}</textarea>
                            @error('commentaire')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> --}}

                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                
                                    @if (can('responsable-gestionnaire-des-ressources-humaines'))
                                        @if ($besoin->rh_id == null)
                                            <button type="button" id="validerBtn" class="btn btn-primary px-4">Valider</button>
                                            <form id="refusedForm" action="{{route('refusebesoin', $besoin->id)}}" method="POST">
                                                @csrf
                                                {{-- <input type="text" id="commentaire_hidden" name="commentaire" value="{{ $besoin->commentaire }}" hidden> --}}
                                                <a style="cursor: pointer" class="btn btn-danger text-white px-4 refused_besoin"
                                                    data-route="{{route('refusebesoin', $besoin->id)}}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="Refuser">Refuser</a>
                                            </form>
                                        @endif
                                    @elseif (can('chef-barm'))
                                        @if ($besoin->chef_barm_id == null)
                                            <button type="button" id="validerBtn" class="btn btn-primary px-4">Valider</button>
                                            <form id="refusedForm" action="{{route('refusebesoin', $besoin->id)}}" method="POST">
                                                @csrf
                                                {{-- <input type="text" id="commentaire_hidden" name="commentaire" value="{{ $besoin->commentaire }}" hidden> --}}
                                                <a style="cursor: pointer" class="btn btn-danger text-white px-4 refused_besoin"
                                                    data-route="{{route('refusebesoin', $besoin->id)}}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="Refuser">Refuser</a>
                                            </form>
                                        @endif
                                    @endif
                                    
                                
                                <a href="{{ route('besoins.index') }}" type="reset"
                                    class="btn btn-warning px-4">Retour</a>
                            </div>
                        </div>
                    </form>
                </div>
                @endif

            </div>
        </div>
    </div>

</div>

@endsection

@push('js-push')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    function toggleDisponibilite(button) {
        var input = button.nextElementSibling;

        if (button.textContent.trim() === "Disponible") {
            button.textContent = "Indisponible";
            button.classList.remove("btn-success");
            button.classList.add("btn-danger");
            input.value = "0";
        } else {
            button.textContent = "Disponible";
            button.classList.remove("btn-danger");
            button.classList.add("btn-success");
            input.value = "1";
        }
    }
</script>

<script>
    (function ($) {
        "use strict";
        $('#commentaire').on('input', function () {
            $('#commentaire_hidden').val($(this).val());
        });
    })(jQuery);
</script>

<script>
    (function ($) {
        "use strict";
        $('#validerBtn').on('click', function () {
            var routevalidate = $('#validationForm').attr('action');
            var formData = new FormData($('#validationForm')[0]);
            Swal.fire({
                title: "Valider cete demande",
                text: "Voulez-vous valider cette demande?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Valider!",
                cancelButtonText: "Non, retour"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: routevalidate,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            window.location.href = "{{ route('besoins.index') }}";
                        },
                        error: function (xhr, status, error) {

                        }
                    });
                }
            });
        });
    })(jQuery);
</script>

<script>
    (function ($) {
            "use strict";
            $('.refused_besoin').on('click', function () {
                var routerefuse = $(this).data('route');
                var form = $('#refusedForm').serialize();
                console.log($('#refusedForm').serialize());
                Swal.fire({
                    title: "Réfuser la demande",
                    text: "Voulez-vous refuser cette demande?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Réfuser!",
                    cancelButtonText: "Non, retour"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Envoyer le formulaire via AJAX
                        $.ajax({
                            url: routerefuse,
                            type: 'POST',
                            data: $('#refusedForm').serialize(),
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                window.location.href = "{{ route('besoins.index') }}";
                            },
                            error: function (xhr, status, error) {
                                // Gérer les erreurs ici
                            }
                        });
                    }
                });
            });
        })(jQuery);
</script>

<script>
    $(document).ready(function () {
            "use strict";
            // Add item handler
            $('.add__items__btn').click(function () {
                addItems();
            });


            // Add item function
            var rowIndex = {{$key}}+1;

            function addItems() {
                $('#items__enfant').append(`<div class="row">
                    <div class="col-9">
                        <div class="mb-3">
                            <label class="form-label">Designation</label>
                            <select class="form-select select2" data-placeholder="Choisir un consommable"
                                name="besoinitems[${rowIndex}][consommable_id]">
                                @foreach($consommables as $consommable)
                                <option value="{{ $consommable->id }}">{{ $consommable->designation }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Description requis</div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="mb-3">
                            <label class="form-label">Quantité demandé</label>
                            <input class="form-control quantite" type="number" name="besoinitems[${rowIndex}][qte_demande]" value="1" required />
                            <div class="invalid-feedback">Quantité requis</div>
                        </div>
                    </div>
                    <div class="col-1" style="margin-top:1.5rem">
                        <button type="button" class="btn btn-danger border-danger text-white remove__item__btn fs-4">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>`);

                rowIndex++;

                // Remove item handler
                $(document).on('click', '.remove__item__btn', function () {
                    $(this).closest(".row").remove();
                });
            }

        });
</script>
@endpush