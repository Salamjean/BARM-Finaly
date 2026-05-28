@extends('layouts.app')

@section('content')
    <div class="container pt-2">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Candidatures/</span> {{ $title }}
        </h4>

        <div class="card">
            <h3 class="card-header mt-2">{{ $title }}</h3>

            <div class="card-body mt-4">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                @if ($title != 'Liste')
                                    <th>Date de soumission</th>
                                @else
                                    <th>Date de validation</th>
                                @endif
                                <th>Adhérents</th>
                                <th>Orientation</th>
                                <th class="text-center">Statut</th>

                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($candidatures as $candidature)
                                <tr>
                                    @if ($title != 'Liste')
                                        <td>{{ dateFr($candidature->choiceFinal->created_at, 'complet') }}</td>
                                    @else
                                        <td>{{ dateFr($candidature->choiceFinal->updated_at, 'complet') }}</td>
                                    @endif
                                    <td>{{ $candidature->user->fullName() }}</td>
                                    <td>{{ statusCandidature($candidature->orientation, 'orientation') }}</td>
                                    <td class="text-center">
                                        <span @php echo statusCandidature($candidature->status, 'css'); @endphp>
                                            {{ statusCandidature($candidature->status) }}
                                        </span>
                                    </td>


                                    <td class="d-flex justify-content-center gap-2">


                                        <a class="btn btn-outline-success fw-bold"
                                            href="{{ route('adherent.candidature.validation.show', $candidature->choiceFinal->id) }}">

                                            @if ($candidature->status == 'pending')
                                                Faire un choix
                                                @else
                                                Voir les infos
                                            @endif

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
