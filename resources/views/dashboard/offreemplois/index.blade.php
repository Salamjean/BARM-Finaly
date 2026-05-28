@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Offres d'emplois/</span> {{ $title }}
                </h4>
            </nav>
        </div>

        <div class="ms-auto">


            <div class="btn-group">
                <a href="{{ route('offreemplois.create') }}" type="button" class="btn btn-primary">Enregistrer une
                    offre</a>
            </div>


        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Intitulé</th>
                            <th>Localisation</th>
                            <th>Date d'échéance</th>
                            <th>Auteur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offreemplois as $offreemploi)

                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{ $offreemploi->libelle }}</td>
                            <td>{{ $offreemploi->localisation }}</td>
                            <td>{{ dateFr($offreemploi->datefin, 'letter') }}</td>
                            <td>{{ $offreemploi->author->fullName() }}</td>
                            <td style="text-align: center">
                                <a class="badge bg-primary text-white"
                                    href="{{route('offreemplois.show',$offreemploi->id)}}">
                                    voir
                                </a>
                                <a class="badge bg-warning text-white"
                                    href="{{route('offreemplois.edit',$offreemploi->id)}}">
                                    Modifier
                                </a>
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
