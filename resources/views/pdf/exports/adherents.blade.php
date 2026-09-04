@extends('pdf.exports.base')

@section('pdf_content')
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 30%;">Nom & Prénoms</th>
                <th style="width: 15%;">Mécano</th>
                <th style="width: 15%;">Téléphone</th>
                <th style="width: 20%;">Cohorte</th>
                <th style="width: 15%;">Orientation</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $candidature)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $candidature->user ? $candidature->user->fullName() : 'N/A' }}</strong></td>
                    <td>{{ $candidature->user->mecano ?? 'N/A' }}</td>
                    <td>{{ $candidature->phone_number ?? 'N/A' }}</td>
                    <td>{{ $candidature->cohort ? ($candidature->cohort->title ?? $candidature->cohort->reference) : 'N/A' }}</td>
                    <td>{{ $candidature->orientation ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Aucun adhérent trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
