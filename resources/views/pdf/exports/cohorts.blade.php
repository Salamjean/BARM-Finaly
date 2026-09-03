@extends('pdf.exports.base')

@section('pdf_content')
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 35%;">Titre de la cohorte</th>
                <th style="width: 25%;">Référence</th>
                <th style="width: 15%;">Nombre d'adhérents</th>
                <th style="width: 20%;">Date de création</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $cohort)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $cohort->title ?? $cohort->name ?? 'Cohorte ' . $cohort->id }}</strong></td>
                    <td>{{ $cohort->reference ?? 'N/A' }}</td>
                    <td>{{ $cohort->adhrents_count ?? $cohort->adhrents->count() }}</td>
                    <td>{{ $cohort->created_at ? $cohort->created_at->format('d/m/Y') : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Aucun élément trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
