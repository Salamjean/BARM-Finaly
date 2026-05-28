@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Proifages/</span> {{ $title }}
                </h4>
            </nav>
        </div>

        <div class="ms-auto">
            @if(can('chef-cellule-formation-et-insertion|responsable-preparation-a-la-reconversion|conseiller-preparation-a-la-reconversion|conseiller-en-reconversion'))
            
                @if (!$profilages->isEmpty())
                    @foreach ($profilages as $profil)
                        @if ($loop->last && $profil->end === 1)
                            <div class="btn-group">
                                <a href="{{ route('profilage.create_profilage',$cohort->id) }}" type="button" class="btn btn-primary">Organiser un
                                    profilage</a>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="btn-group">
                        <a href="{{ route('profilage.create_profilage',$cohort->id) }}" type="button" class="btn btn-primary">Organiser un
                            profilage</a>
                    </div>
                @endif

            @endif
        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Partenaires Techniques</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profilages as $profilage)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{ $profilage->partenaire->user->username }}</td>
                            <td>{{ $profilage->start_date }}</td>
                            <td>{{ $profilage->end_date }}</td>
                            <td style="text-align: center">
                                <a href="{{ route('profilage.candidat_profilage', $profilage->id) }}"
                                    class="badge bg-primary text-white">Voir</a>
                                @if ($profilage->end == '0' && can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                                    <a href="#" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#addNewCCModal{{$profilage->id}}" class="badge bg-warning text-white">Terminer le profilage</a>
                                    <!-- Add New Credit Card Modal -->
                                    <div class="modal fade" id="addNewCCModal{{$profilage->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                            <div class="modal-content p-3 p-md-5">
                                                <div class="modal-body">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    <div class="text-center mb-4">
                                                        <h3>Terminer le profilage</h3>
                                                        {{-- <p>Add new card to complete payment</p> --}}
                                                    </div>
                                                    <form action="{{ route('profilage.end_profilage') }}" method="POST" class="row g-3">
                                                        @csrf
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Date de fin :</label>
                                                            <input type="date" class="form-select" name="end_date">
                                                        </div>
                                                        <input type="text" name="end" value="1" hidden>
                                                        <input type="text" name="profilage_id" value="{{$profilage->id}}" hidden>
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