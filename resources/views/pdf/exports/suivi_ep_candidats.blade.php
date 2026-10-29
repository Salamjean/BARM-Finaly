@extends('pdf.exports.base')

@section('pdf_content')
    <style>
        body {
            margin: 40px;
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .header img {
            max-height: 60px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 12px;
            margin: 0;
            line-height: 1.3;
        }
        
        h1 {
            font-size: 14px;
            text-align: center;
            margin: 20px 0 25px 0;
            color: #000;
            text-transform: uppercase;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .data-table th {
            background: #001B63;
            color: #fff;
            padding: 6px;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid #ddd;
            text-align: center;
            text-transform: uppercase;
        }
        
        .data-table td {
            padding: 6px;
            font-size: 9px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        .data-table tr:nth-child(even) td {
            background-color: #f9f9f9;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8px;
            font-weight: bold;
            border-radius: 10px;
            text-transform: uppercase;
        }
        
        .badge-green {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-red {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .badge-yellow {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-blue {
            background-color: #cce5ff;
            color: #004085;
        }
    </style>

    @if (!empty($filtersText))
        <div style="margin-bottom: 12px; font-size: 10px; color: #555; background: #f1f5f9; padding: 6px 10px; border-radius: 4px; border-left: 3px solid #001B63;">
            <strong>Filtres appliqués :</strong> {{ $filtersText }}
        </div>
    @endif

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">#</th>
                <th style="width: 20%;">Candidat</th>
                <th style="width: 8%;">Mécano</th>
                <th style="width: 6%;">Genre</th>
                <th style="width: 14%;">Profilage (RDV)</th>
                <th style="width: 16%;">Prépa Insertion</th>
                <th style="width: 18%;">Mise en relation / Entreprise</th>
                <th style="width: 14%;">Situation</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $candidat)
                @php
                    $rdv1 = $candidat->candidatentretiens ? $candidat->candidatentretiens->where('presence', 1)->count() > 0 : false;
                    $rdv2 = $candidat->bilancompetences ? $candidat->bilancompetences->where('presence', 1)->count() > 0 : false;
                    $rdv3 = $candidat->profilage_decision == 1;

                    $cvlm = $candidat->cvlms ? $candidat->cvlms->count() : 0;
                    $prepa = $candidat->prepaentretiens ? $candidat->prepaentretiens->count() : 0;
                    $tre = $candidat->techrechercheemplois ? $candidat->techrechercheemplois->count() : 0;
                    $formations = $candidat->candidatformations ? $candidat->candidatformations->count() : 0;

                    $mads = $candidat->candidatentreprises ?? collect();
                    $lastMad = $mads->sortByDesc('created_at')->first();
                    $isAccepted = $mads->where('statut', 'accepted')->count() > 0 || $candidat->en_poste == '1';

                    $rawGender = strtolower(trim($candidat->gender ?? ($candidat->user->gender ?? '')));
                    $genreLabel = in_array($rawGender, ['feminin', 'féminin', 'femme', 'f']) ? 'Femme' : 'Homme';
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $candidat->user ? $candidat->user->fullName() : 'N/A' }}</strong><br>
                        <span style="color: #666; font-size: 8px;">{{ $candidat->phone_number ?? ($candidat->user->phone ?? '') }}</span>
                    </td>
                    <td>{{ $candidat->user->mecano ?? 'N/A' }}</td>
                    <td>{{ $genreLabel }}</td>
                    <td>
                        <div>RDV 1 (Entretien) : {!! $rdv1 ? '<span style="color:green;font-weight:bold;">Effectué</span>' : '<span style="color:#888;">En attente</span>' !!}</div>
                        <div>RDV 2 (Bilan) : {!! $rdv2 ? '<span style="color:green;font-weight:bold;">Validé</span>' : '<span style="color:#888;">En attente</span>' !!}</div>
                        <div>RDV 3 (Décision) : {!! $rdv3 ? '<span style="color:#001B63;font-weight:bold;">Validé</span>' : '<span style="color:#888;">En attente</span>' !!}</div>
                    </td>
                    <td>
                        <div>CV/LM : <strong>{{ $cvlm }}</strong> | Entretien : <strong>{{ $prepa }}</strong></div>
                        <div>TRE : <strong>{{ $tre }}</strong> | Formation : <strong>{{ $formations }}</strong></div>
                    </td>
                    <td>
                        @if ($lastMad)
                            <strong>{{ $lastMad->entreprise }}</strong><br>
                            @if ($lastMad->statut === 'accepted' || $isAccepted)
                                <span style="color: green; font-weight: bold;">Accepté</span>
                            @elseif ($lastMad->statut === 'rejected')
                                <span style="color: red; font-weight: bold;">Non retenu</span>
                            @else
                                <span style="color: #b45309; font-weight: bold;">En attente</span>
                            @endif
                            @if ($mads->count() > 1)
                                <span style="font-size: 8px; color: #666;">({{ $mads->count() }} envois)</span>
                            @endif
                        @else
                            <span style="color: #888;">Non envoyé</span>
                        @endif
                    </td>
                    <td>
                        @if ($candidat->en_poste == '1' || $isAccepted)
                            <strong style="color: green;">En Poste</strong>
                        @elseif ($lastMad)
                            <strong style="color: #b45309;">En Entreprise</strong>
                        @elseif ($formations > 0 || $cvlm > 0 || $prepa > 0 || $tre > 0)
                            <strong style="color: #0284c7;">En Prépa</strong>
                        @elseif ($candidat->profilage_decision == 1)
                            <strong style="color: #001B63;">Profilé</strong>
                        @else
                            <span style="color: #666;">En Profilage</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 15px;">Aucun candidat trouvé pour cette sélection.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
