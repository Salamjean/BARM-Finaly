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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($rdvpartners as $rdvpartner)
                        
                        <tr>
                            <td>{{ dateFr($rdvpartner->created_at) }}</td>
                            <td>{{ $rdvpartner->candidature->user->fullName() }}</td>
                            <td>{{ $rdvpartner->candidature->phone_number }}</td>
                            <td>{{ dateFr($rdvpartner->candidature->birth_date) }}</td>
                            <td>
                                <a href="{{ route('adherent.show', $rdvpartner->candidature->user->id) }}">
                                    <i class='bx bxs-show'></i>
                                </a>

                                @if ($rdvpartner->presence!=1)
                                    <a style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#addNewCCModal{{$rdvpartner->id}}">
                                        <span class="badge bg-info mb-2">Terminer le RVD</span>
                                    </a>
                                    
                                    <!-- Add New Credit Card Modal -->
                                    <div class="modal fade" id="addNewCCModal{{$rdvpartner->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                            <div class="modal-content p-3 p-md-5">
                                                <div class="modal-body">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    <div class="text-center mb-4">
                                                        <h3>Terminer rendez-vous avec le candidat</h3>
                                                        {{-- <p>Add new card to complete payment</p> --}}
                                                    </div>
                                                    <form action="{{route('rdvpartners.update', $rdvpartner->id)}}" method="POST" class="row g-3">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Présence :</label>
                                                            <select class="form-select select2" data-placeholder="Le candidat à t'il été present au RDV"
                                                                id="small-bootstrap-class-multiple-field1" name="presence">
                                                                <option value="1">OUI, candidat effectivement présent</option>
                                                                <option value="0">NON, candidat abscent</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <small class="text-light fw-medium d-block">Valider cette candidature?</small>
                                                            <div class="form-check form-check-inline mt-3">
                                                                <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" />
                                                                <label class="form-check-label" for="inlineRadio1">OUI</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0" />
                                                                <label class="form-check-label" for="inlineRadio2">NON</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label" for="exampleFormControlTextarea1">Rapport de la séance</label>
                                                            <textarea class="form-control" name="rapport" id="exampleFormControlTextarea1" cols="30"
                                                                rows="5"></textarea>
                                                        </div>
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
                                @endif
                                

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
 