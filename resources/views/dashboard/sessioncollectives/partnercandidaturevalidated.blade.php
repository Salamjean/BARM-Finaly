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
                            <td>{{ $candidat->orientation }}</td>
                            <td>
                                {{-- <span class="badge bg-primary mb-2">{{ $candidat->partner_technical->user->username
                                    }}</span> --}}
                            </td>
                            <td>
                                {{-- <a class="btn btn-outline-success fw-bold"
                                    href="{{ route('adherent.candidature.validation.show', $candidat->choiceFinal->id) }}">
                                    Voir les infos
                                </a> --}}
                                {{-- <div>
                                    <a href="{{ route('ouverture_compte', $candidat->id) }}" target="_blank"><i
                                            class="fa-solid fa-down-long"></i></a>
                                </div> --}}
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