@extends('pdf.exports.base')

@section('pdf_content')
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Entreprise / Organisme</th>
                <th style="width: 30%;">Intitulé de la formation</th>
                <th style="width: 20%;">Lieu</th>
                <th style="width: 10%;">Date début</th>
                <th style="width: 10%;">Date fin</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $formation)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $formation->entreprise ?? $formation->partner?->user?->username ?? 'N/A' }}</td>
                    <td><strong>{{ $formation->intitule ?? $formation->title ?? $formation->name ?? ('Formation #' . $formation->id) }}</strong></td>
                    <td>{{ $formation->lieu ?? $formation->location ?? 'N/A' }}</td>
                    <td>{{ $formation->date_db ? \Carbon\Carbon::parse($formation->date_db)->format('d/m/Y') : ($formation->beging_date ? date('d/m/Y', strtotime($formation->beging_date)) : 'N/A') }}</td>
                    <td>{{ $formation->date_fin ? \Carbon\Carbon::parse($formation->date_fin)->format('d/m/Y') : ($formation->end_date ? date('d/m/Y', strtotime($formation->end_date)) : 'N/A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Aucune formation trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
