@extends('pdf.exports.base')

@section('pdf_content')
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 35%;">Intitulé de la formation</th>
                <th style="width: 25%;">Lieu / Centre</th>
                <th style="width: 20%;">Date début</th>
                <th style="width: 15%;">Date fin</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $formation)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $formation->title ?? $formation->name ?? 'Formation ' . $formation->id }}</strong></td>
                    <td>{{ $formation->location ?? $formation->center ?? 'N/A' }}</td>
                    <td>{{ $formation->date_debut ? date('d/m/Y', strtotime($formation->date_debut)) : 'N/A' }}</td>
                    <td>{{ $formation->date_fin ? date('d/m/Y', strtotime($formation->date_fin)) : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Aucune formation trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
