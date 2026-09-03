@extends('pdf.exports.base')

@section('pdf_content')
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 30%;">Intitulé de la session</th>
                <th style="width: 25%;">Lieu</th>
                <th style="width: 20%;">Date de tenue</th>
                <th style="width: 20%;">Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $session)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $session->title ?? $session->name ?? 'Session ' . $session->id }}</strong></td>
                    <td>{{ $session->location ?? $session->lieu ?? 'N/A' }}</td>
                    <td>{{ $session->session_date ? date('d/m/Y', strtotime($session->session_date)) : 'N/A' }}</td>
                    <td>{{ $session->status ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Aucune session collective trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
