@extends('pdf.exports.base')

@section('pdf_content')
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Nom & Prénoms</th>
                <th style="width: 15%;">Statut PA</th>
                <th style="width: 25%;">Partenaire technique</th>
                <th style="width: 30%;">Motif / Observation</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $pa)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $pa->candidature->user->fullName() ?? 'N/A' }}</strong></td>
                    <td>
                        @if($pa->status == 'deferred') Différé
                        @elseif($pa->status == 'refused' || $pa->status == 'rejected') Refusé
                        @elseif($pa->status == 'resignation') Abandon
                        @else {{ $pa->status }}
                        @endif
                    </td>
                    <td>{{ $pa->candidature->partnerTechnical->user->username ?? 'N/A' }}</td>
                    <td>{{ $pa->sentence_reason ?? 'Aucun motif renseigné' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Aucun élément trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
