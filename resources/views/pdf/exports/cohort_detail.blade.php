@extends('pdf.exports.base')

@section('pdf_content')
    <div style="margin-bottom: 15px; background: #f0f4f8; padding: 10px; border-radius: 4px;">
        <strong>Cohorte :</strong> {{ $cohort->title ?? $cohort->reference ?? 'Cohorte ' . $cohort->id }} |
        <strong>Date création :</strong> {{ $cohort->created_at ? $cohort->created_at->format('d/m/Y') : 'N/A' }} |
        <strong>Total membres :</strong> {{ $cohort->adhrents->count() }}
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 30%;">Nom & Prénoms</th>
                <th style="width: 15%;">Mécano</th>
                <th style="width: 25%;">Téléphone</th>
                <th style="width: 25%;">Orientation</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cohort->adhrents as $index => $candidat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $candidat->user ? $candidat->user->fullName() : 'N/A' }}</strong></td>
                    <td>{{ $candidat->user->mecano ?? 'N/A' }}</td>
                    <td>{{ $candidat->phone_number ?? $candidat->user->phone_number ?? 'N/A' }}</td>
                    <td>{{ $candidat->orientation ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Aucun membre dans cette cohorte</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
