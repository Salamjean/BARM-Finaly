@extends('pdf.exports.base')

@section('pdf_content')
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Nom & Prénoms</th>
                <th style="width: 15%;">Mécano</th>
                <th style="width: 15%;">Téléphone</th>
                <th style="width: 20%;">Cohorte</th>
                <th style="width: 20%;">Session Collective</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $candidat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $candidat->user ? $candidat->user->fullName() : 'N/A' }}</strong></td>
                    <td>{{ $candidat->user->mecano ?? 'N/A' }}</td>
                    <td>{{ $candidat->phone_number ?? 'N/A' }}</td>
                    <td>{{ $candidat->cohort ? ($candidat->cohort->title ?? $candidat->cohort->reference) : 'N/A' }}</td>
                    <td>{{ $candidat->sessionCollective ? ($candidat->sessionCollective->lieu . ' - ' . $candidat->sessionCollective->date) : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Aucun candidat présent trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
