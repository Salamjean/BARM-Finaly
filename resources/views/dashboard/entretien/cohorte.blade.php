@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Entretiens/</span> {{ $title }}
                </h4>
            </nav>
        </div>

        <div class="ms-auto">

            @if(can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion'))
            <div class="btn-group">
                <a href="{{ route('entretiens.create') }}" type="button" class="btn btn-primary">Organiser un
                    entretien</a>
            </div>
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
                            <th>Date</th>
                            <th>Mecano / Matricule</th>
                            <th>Nom & Prénoms</th>
                            <th class="text-start">Numéro de téléphone</th>
                            <th>Présence</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entretiens as $entretien)

                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{ dateFr($entretien->date) }}</td>
                            <td>{{ $entretien->candidature->user->mecano }}</td>
                            <td>{{ $entretien->candidature->user->fullName() }}</td>
                            {{-- <td class="text-start">{{ $entretien->candidature->phone_number }}</td>
                            @if ($candidat->pivot->presence == '0')
                            <td class="text-danger">Abscent</td>
                            @else
                            <td class="text-success">Présent</td>
                            @endif --}}
                            <td style="text-align: center">
                                <a href="{{ route('adherent.show', $entretien->candidature->user->id) }}">
                                    <i class='bx bxs-show'></i>
                                </a>

                                <a href="#" data-bs-toggle="modal" data-bs-target="#rapportModal{{$entretien->id}}"
                                    class="badge bg-warning text-white">Rapport</a>
                                <div class="modal fade" id="rapportModal{{$entretien->id}}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                        <div class="modal-content p-3 p-md-5">
                                            <div class="modal-body">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                                <div class="text-center mb-4">
                                                    <h3>Compte rendu de la entretien</h3>
                                                    {{-- <p>Add new card to complete payment</p> --}}
                                                </div>
                                                <form action="{{ route('entretiens.cr') }}" method="POST"
                                                    class="row g-3" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Charger un fichier</label>
                                                        <input type="file" class="form-control" name="rapport">
                                                    </div>
                                                    <input type="text" name="entretien_id" value="{{$entretien->id}}"
                                                        hidden>
                                                    <div class="col-12 text-center mt-4">
                                                        <button type="submit"
                                                            class="btn btn-label-info me-sm-3 me-1">Enregistrer</button>
                                                        <button type="reset" class="btn btn-label-danger btn-reset"
                                                            data-bs-dismiss="modal" aria-label="Close">Retour</button>
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