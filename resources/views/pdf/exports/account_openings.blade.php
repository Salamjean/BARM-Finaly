@extends('pdf.exports.base')

@section('pdf_content')
    <div style="margin-bottom: 15px; background: #f0f4f8; padding: 10px; border-radius: 4px;">
        <strong>Cohorte :</strong> {{ $cohort->reference ?? $cohort->title }} |
        <strong>Intitulé :</strong> {{ $cohort->title }}
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 30%;">Adhérent</th>
                <th style="width: 15%;">Mécano</th>
                <th style="width: 15%;">Téléphone</th>
                <th style="width: 20%;">Partenaire Financier</th>
                <th style="width: 15%;">Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $candidature)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $candidature->user ? $candidature->user->fullName() : 'N/A' }}</strong></td>
                    <td>{{ $candidature->user->mecano ?? 'N/A' }}</td>
                    <td>{{ $candidature->phone_number ?? 'N/A' }}</td>
                    <td>{{ $candidature->partnerFinancial ? $candidature->partnerFinancial->user->username : ($candidature->other_partner_financial ?? 'Non défini') }}</td>
                    <td>
                        @if($candidature->data_collect) Approuvé
                        @else En attente
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Aucun adhérent dans cette cohorte</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
