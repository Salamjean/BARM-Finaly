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
                            <th>Date de tenue</th>
                            <th>Lieu de tenue</th>
                            <th>L'heure de tenue</th>
                            <th>Partenaires techiques</th>
                            <th>Partenaires financier</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($sessioncollectives as $sessioncollective)
                        <tr>
                            <td>{{ dateFr($sessioncollective->date) }}</td>
                            <td>{{ $sessioncollective->lieu }}</td>
                            <td>{{ $sessioncollective->heure }}</td>
                            <td>
                                @foreach ($sessioncollective->partenaires as $partenaire)
                                    @if ($sessioncollective->partenaires->find($partenaire->id)->pivot->type == 'partner_technique')
                                        <span class="badge bg-primary mb-2">{{ $partenaire->user->username }}</span>
                                        @if (!$loop->last)
                                        &nbsp;
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($sessioncollective->partenaires as $partenaire)
                                    @if ($sessioncollective->partenaires->find($partenaire->id)->pivot->type == 'partner_financial')
                                        <span class="badge bg-primary mb-2">{{ $partenaire->user->username }}</span>
                                        @if (!$loop->last)
                                        &nbsp;
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('listepartenershow', $sessioncollective->id) }}">
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
