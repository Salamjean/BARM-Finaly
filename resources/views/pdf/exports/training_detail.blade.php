@extends('pdf.exports.base')

@section('pdf_content')
    <div style="margin-bottom: 15px; background: #f0f4f8; padding: 10px; border-radius: 4px;">
        <strong>Intitulé :</strong> {{ $training->title ?? 'Formation #' . $training->id }} |
        <strong>Partenaire :</strong> {{ $training->partner?->user?->username ?? 'N/A' }} |
        <strong>Cohorte :</strong> {{ $training->cohort?->title ?? 'N/A' }} |
        <strong>Période :</strong> {{ $training->beging_date ? date('d/m/Y', strtotime($training->beging_date)) : 'N/A' }} {{ $training->end_date ? 'au ' . date('d/m/Y', strtotime($training->end_date)) : '' }}
    </div>

    @if($training->description)
        <div style="margin-bottom: 15px; background: #fafafa; padding: 8px; border-left: 3px solid #001B63;">
            <strong>Description :</strong> {{ $training->description }}
        </div>
    @endif

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 40%;">Nom & Prénoms</th>
                <th style="width: 25%;">Mécano</th>
                <th style="width: 15%;">Téléphone</th>
                <th style="width: 15%;">Présence</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($training->participations as $index => $participation)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $participation->candidature?->user ? $participation->candidature->user->fullName() : 'N/A' }}</strong></td>
                    <td>{{ $participation->candidature?->user?->mecano ?? 'N/A' }}</td>
                    <td>{{ $participation->candidature?->phone_number ?? $participation->candidature?->user?->phone_number ?? 'N/A' }}</td>
                    <td>
                        @if($participation->participation) Présent
                        @else Absent
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Aucun participant inscrit à cette formation</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
