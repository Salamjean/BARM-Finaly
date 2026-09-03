@extends('pdf.exports.base')

@section('pdf_content')
    <div style="margin-bottom: 15px; background: #f0f4f8; padding: 10px; border-radius: 4px;">
        <strong>Formation :</strong> {{ $formation->title ?? $formation->name ?? 'Formation ' . $formation->id }} |
        <strong>Lieu :</strong> {{ $formation->location ?? $formation->center ?? 'N/A' }} |
        <strong>Période :</strong> {{ $formation->date_debut ? date('d/m/Y', strtotime($formation->date_debut)) : 'N/A' }} au {{ $formation->date_fin ? date('d/m/Y', strtotime($formation->date_fin)) : 'N/A' }}
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 35%;">Nom & Prénoms</th>
                <th style="width: 20%;">Mécano</th>
                <th style="width: 20%;">Téléphone</th>
                <th style="width: 20%;">Présence</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($formation->candidatures as $index => $candidat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $candidat->user ? $candidat->user->fullName() : 'N/A' }}</strong></td>
                    <td>{{ $candidat->user->mecano ?? 'N/A' }}</td>
                    <td>{{ $candidat->phone_number ?? $candidat->user->phone_number ?? 'N/A' }}</td>
                    <td>
                        @if(isset($candidat->pivot->presence) && $candidat->pivot->presence == '1') Présent
                        @elseif(isset($candidat->pivot->presence) && $candidat->pivot->presence == '0') Absent
                        @else En attente
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
