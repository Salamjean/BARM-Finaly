@extends('layouts.app')

@section('content')
<div class="container pt-2">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Sessions collectives d'informations/</span> {{ $title }}
    </h4>
    <div class="card">
        <div class="card-body mt-4">
            <h5 class="card-header">{{ $title }}</h5>
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Date d'ajout</th>
                            <th>Nom & Prénoms</th>
                            <th>Numéro de téléphone</th>
                            <th>Date de naissance</th>
                            <th>Orientation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($candidatures as $candidat)
                        <tr>
                            <td>{{ dateFr($candidat->created_at) }}</td>
                            <td>{{ $candidat->user->fullName() }}</td>
                            <td>{{ $candidat->phone_number }}</td>
                            <td>{{ dateFr($candidat->birth_date) }}</td>
                            <td>{{ $candidat->orientation }}</td>
                            <td>
                                <a href="{{ route('adherent.show', $candidat->user->id) }}">
                                    <i class='bx bxs-show'></i>
                                </a>

                                <a style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#addNewCCModal{{$candidat->id}}">
                                    <span class="badge bg-info mb-2">Donner RDV</span>
                                </a>

                                <!-- Add New Credit Card Modal -->
                                <div class="modal fade" id="addNewCCModal{{$candidat->id}}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                        <div class="modal-content p-3 p-md-5">
                                            <div class="modal-body">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                <div class="text-center mb-4">
                                                    <h3>Donner un rendez-vous au candidat</h3>
                                                </div>
                                                <form action="{{route('rdvpartners.store')}}" method="POST" class="row g-3">
                                                    @csrf
                                                    <div class="col-12 col-md-12">
                                                        <label class="form-label" for="modalAddCardName1">Lieu</label>
                                                        <input type="text" id="modalAddCardName1" name="lieu" class="form-control" />
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label class="form-label" for="modalAddCardName">Date</label>
                                                        <input type="date" id="modalAddCardName" name="date" class="form-control" />
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label class="form-label" for="modalAddCardExpiryDate">Heure</label>
                                                        <input type="time" id="modalAddCardExpiryDate" name="heure"
                                                            class="form-control expiry-date-mask" />
                                                    </div>
                                                    <input type="text" name="user_id" value="{{ Auth::user()->id }}" hidden>
                                                    <input type="text" name="candidature_id" value="{{$candidat->id}}" hidden>
                                                    <div class="col-12 text-center mt-4">
                                                        <button type="submit" class="btn btn-label-info me-sm-3 me-1">Envoyer</button>
                                                        <button type="reset" class="btn btn-label-danger btn-reset" data-bs-dismiss="modal"
                                                            aria-label="Close">Retour</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
