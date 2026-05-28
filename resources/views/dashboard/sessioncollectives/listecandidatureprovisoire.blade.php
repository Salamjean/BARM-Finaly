@extends('layouts.app')

@section('content')
<div class="container pt-2">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Sessions collectives d'informations/</span> {{ $title }}
    </h4>
    <div class="card">
        <h5 class="card-header">{{ $title }}</h5>
        <div class="card-body mt-4">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>Date d'ajout</th>
                            <th>Nom & Prénoms</th>
                            <th>Numéro de téléphone</th>
                            <th>Date de naissance</th>
                            <th>Orientation</th>
                            <th>Partenaires Techniques</th>
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
                                @if ($candidat->choiceFinal()->exists())
                                    <span class="badge bg-primary mb-2">{{ $candidat->choiceFinal->partner->user->username }}</span>
                                @else
                                    @foreach ($candidat->partenaires as $partenaire)
                                        @php
                                        $status = $candidat->partenaires->find($partenaire->id)->pivot->status;
                                        @endphp
                                        @if ($status == 'accepted')
                                        <span class="badge bg-primary mb-2">{{ $partenaire->user->username }}</span>
                                        @if (!$loop->last)
                                        &nbsp;
                                        @endif
                                        @endif
                                    @endforeach
                                @endif
                            <td>
                                    <a href="{{ route('adherent.show', $candidat->user->id) }}">
                                        <i class='bx bxs-show'></i>
                                    </a>
                                    <a style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#addNewCCModal{{$candidat->id}}"><span class="badge bg-info">Voir le rapport des sessions individuelles</span></a>
                                    
                                    <!-- Add New Credit Card Modal -->
                                    <div class="modal fade" id="addNewCCModal{{$candidat->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                            <div class="modal-content p-3 p-md-5">
                                                <div class="modal-body">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    <div class="text-center mb-4">
                                                        <h3>Terminer rendez-vous avec le candidat</h3>
                                                        {{-- <p>Add new card to complete payment</p> --}}
                                                    </div>
                                                    <form action="#" method="POST" class="row g-3">
                                                        @csrf
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Présence :</label>
                                                            <select class="form-select select2" data-placeholder="Le candidat à t'il été present au RDV"
                                                                id="small-bootstrap-class-multiple-field1" name="presence">
                                                                <option value="1">OUI, candidat effectivement présent</option>
                                                                <option value="0">NON, candidat abscent</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label" for="exampleFormControlTextarea1">Rapport de la séance</label>
                                                            <textarea class="form-control" name="rapport" id="exampleFormControlTextarea1" cols="30"
                                                                rows="5"></textarea>
                                                        </div>
                                                        <div class="col-12 text-center mt-4">
                                                            <button type="reset" class="btn btn-label-danger btn-reset" data-bs-dismiss="modal"
                                                                aria-label="Close">Retour</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if (!$candidat->choiceFinal()->exists())
                                        <a href="{{ route('adherent.choice.final', $candidat->user->id) }}"><span class="badge bg-info">Retenir un projet
                                                final</span></a>
                                    @else
                                        {{-- <a href="{{ route('adherent.choice.final', $candidat->user->id) }}"><span class="badge bg-warning">Modifier le projet
                                                final</span></a> --}}
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
