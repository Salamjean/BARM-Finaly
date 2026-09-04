@extends('pdf.exports.base')

@section('pdf_content')
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Nom & Prénom</th>
                <th style="width: 15%;">Mécano</th>
                <th style="width: 20%;">Axe d'insertion</th>
                <th style="width: 15%;">Téléphone</th>
                <th style="width: 10%;">Statut</th>
                <th style="width: 10%;">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $item->fullname }}</strong></td>
                    <td>{{ $item->mecano }}</td>
                    <td>
                        @if($item->axe_auto_emploi) Auto emploi
                        @elseif($item->axe_entreprise_privee) Entreprise privée
                        @elseif($item->axe_fonction_publique) Fonction publique
                        @else N/A
                        @endif
                    </td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        @if($item->status == 'approved') Approuvée
                        @elseif($item->status == 'rejected') Rejetée
                        @else En attente
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Aucune pré-inscription trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
