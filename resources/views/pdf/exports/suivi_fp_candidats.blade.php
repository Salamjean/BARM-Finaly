@extends('pdf.exports.base')

@section('pdf_content')
    @if (!empty($filtersText))
        <div style="margin-bottom: 12px; font-size: 10px; color: #555; background: #f1f5f9; padding: 6px 10px; border-radius: 4px; border-left: 3px solid #001B63;">
            <strong>Filtres appliqués :</strong> {{ $filtersText }}
        </div>
    @endif

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">#</th>
                <th style="width: 22%;">Candidat</th>
                <th style="width: 9%;">Mécano</th>
                <th style="width: 6%;">Genre</th>
                <th style="width: 15%;">Profilage (RDV)</th>
                <th style="width: 24%;">Parcours Concours</th>
                <th style="width: 10%;">Dépôt Choix</th>
                <th style="width: 10%;">Résultat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $candidat)
                @php
                    $rdv1 = $candidat->candidatentretiens ? $candidat->candidatentretiens->where('presence', 1)->count() > 0 : false;
                    $rdv2 = $candidat->bilancompetences ? $candidat->bilancompetences->where('presence', 1)->count() > 0 : false;
                    $rdv3 = $candidat->profilage_decision == 1;

                    $suivi = $candidat->concourSuivi;
                    $prepaStatut = $suivi ? $suivi->prepa_statut : null;
                    $isDepose = $suivi && $suivi->choix_final_statut === 'depose';
                    $resultat = $suivi ? $suivi->resultat_statut : null;

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
                        <div>RDV 1 : {!! $rdv1 ? '<span style="color:green;font-weight:bold;">Effectué</span>' : '<span style="color:#888;">En attente</span>' !!}</div>
                        <div>RDV 2 : {!! $rdv2 ? '<span style="color:green;font-weight:bold;">Validé</span>' : '<span style="color:#888;">En attente</span>' !!}</div>
                        <div>RDV 3 : {!! $rdv3 ? '<span style="color:#001B63;font-weight:bold;">Validé</span>' : '<span style="color:#888;">En attente</span>' !!}</div>
                    </td>
                    <td>
                        @if ($suivi && $suivi->intitule_concours)
                            <strong>{{ $suivi->intitule_concours }}</strong>
                            @if ($suivi->type_concours)
                                <span style="font-size: 8px; color: #666;">({{ $suivi->type_concours }})</span>
                            @endif
                            <br>
                            <span style="font-size: 9px;">Prépa : 
                                @if ($prepaStatut === 'present')
                                    <span style="color:green; font-weight:bold;">Présent</span>
                                @elseif ($prepaStatut === 'absent')
                                    <span style="color:red; font-weight:bold;">Absent</span>
                                @elseif ($prepaStatut === 'abandon')
                                    <span style="color:#b45309; font-weight:bold;">Abandon</span>
                                @else
                                    <span style="color:#888;">Non inscrit</span>
                                @endif
                            </span>
                        @else
                            <span style="color: #888;">Aucun concours choisi</span>
                        @endif
                    </td>
                    <td>
                        @if ($isDepose)
                            <strong style="color: green;">Déposé</strong>
                        @else
                            <span style="color: #888;">Non déposé</span>
                        @endif
                    </td>
                    <td>
                        @if ($resultat === 'admis')
                            <strong style="color: green;">Admis</strong>
                        @elseif ($resultat === 'ajourne')
                            <strong style="color: red;">Ajourné</strong>
                        @else
                            <span style="color: #b45309;">En attente</span>
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
