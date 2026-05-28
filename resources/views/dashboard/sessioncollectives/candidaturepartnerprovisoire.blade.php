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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($candidatures as $candidat)
                        <tr>
                            <td>{{ dateFr($candidat->created_at) }}</td>
                            <td>{{ $candidat->candidature->user->fullName() }}</td>
                            <td>{{ $candidat->candidature->phone_number }}</td>
                            <td>{{ dateFr($candidat->candidature->birth_date) }}</td>
                            <td>{{ $candidat->candidature->orientation }}</td>
                            <td>
                                <a href="{{ route('adherent.show', $candidat->candidature->user->id) }}">
                                    <i class='bx bxs-show'></i>
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
