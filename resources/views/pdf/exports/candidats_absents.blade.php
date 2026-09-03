@extends('pdf.exports.base')

@section('pdf_content')
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 30%;">Nom & Prénoms</th>
                <th style="width: 15%;">Mécano</th>
                <th style="width: 25%;">Cohorte</th>
                <th style="width: 25%;">Téléphone</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $candidat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $candidat->user ? $candidat->user->fullName() : 'N/A' }}</strong></td>
                    <td>{{ $candidat->user->mecano ?? 'N/A' }}</td>
                    <td>{{ $candidat->cohort->title ?? $candidat->cohort->reference ?? 'Non assignée' }}</td>
                    <td>{{ $candidat->phone_number ?? $candidat->user->phone_number ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Aucun candidat absent trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
