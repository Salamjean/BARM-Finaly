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
                <th style="width: 18%;">Candidat</th>
                <th style="width: 8%;">Mécano</th>
                <th style="width: 6%;">Genre</th>
                <th style="width: 16%;">Partenaire & Cohorte</th>
                <th style="width: 12%;">Plan d'Affaire</th>
                <th style="width: 12%;">Commission</th>
                <th style="width: 12%;">Compte Bancaire</th>
                <th style="width: 12%;">Financement</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $candidat)
                @php
                    $rawGender = strtolower(trim($candidat->gender ?? ($candidat->user->gender ?? '')));
                    $genreLabel = in_array($rawGender, ['feminin', 'féminin', 'femme', 'f']) ? 'Femme' : 'Homme';

                    $partnerTechName = !empty($candidat->partnerTechnical?->user?->username) 
                        ? $candidat->partnerTechnical->user->username 
                        : (!empty(trim($candidat->partnerTechnical?->user?->fullName() ?? '')) 
                            ? $candidat->partnerTechnical->user->fullName() 
                            : ($candidat->partnerTechnical->nom ?? 'Non affecté'));
                    
                    $partnerFinName = !empty($candidat->partnerFinancial?->user?->username) 
                        ? $candidat->partnerFinancial->user->username 
                        : (!empty(trim($candidat->partnerFinancial?->user?->fullName() ?? '')) 
                            ? $candidat->partnerFinancial->user->fullName() 
                            : ($candidat->partnerFinancial->nom ?? ''));

                    // Compte bancaire
                    $monitoredPayment = $candidat->selfEmploymentMonitoredPayment;
                    $isAccountOpen = $monitoredPayment && ($monitoredPayment->account_opening == 1 || $monitoredPayment->account_opening === true);

                    // Décaissements
                    $disbursements = $monitoredPayment ? $monitoredPayment->disbursements : collect();
                    $totalDecaisseCand = $disbursements->sum('amount_disbursement') ?? 0;
                    $hasDisbursement = $candidat->disbursement == '1' || $totalDecaisseCand > 0;

                    $commissionAccepted = $candidat->favorable_opinion || ($candidat->commissionCandidat != null);
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $candidat->user ? $candidat->user->fullName() : 'N/A' }}</strong><br>
                        <span style="color: #666; font-size: 8px;">{{ $candidat->phone_number ?? ($candidat->user->phone ?? '') }}</span>
                    </td>
                    <td style="text-align: center;">{{ $candidat->user->mecano ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $genreLabel }}</td>
                    <td>
                        <strong>{{ $partnerTechName }}</strong><br>
                        <span style="color: #666; font-size: 8px;">{{ $candidat->cohort ? $candidat->cohort->title : 'Sans cohorte' }}</span>
                    </td>
                    <td style="text-align: center;">
                        @if ($candidat->pa == '1' && $candidat->pa_decision == '1')
                            <span style="color: green; font-weight: bold;">Validé</span>
                        @elseif ($candidat->pa == '1' && $candidat->pa_decision == '2')
                            <span style="color: red; font-weight: bold;">Différé</span>
                        @elseif ($candidat->pa == '1')
                            <span style="color: #b45309; font-weight: bold;">En attente</span>
                        @else
                            <span style="color: #888;">Non initié</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if ($commissionAccepted)
                            <span style="color: green; font-weight: bold;">Avis favorable</span>
                        @elseif ($candidat->commission_step == '1')
                            <span style="color: #0284c7; font-weight: bold;">En cours</span>
                        @else
                            <span style="color: #888;">En attente</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if ($isAccountOpen)
                            <span style="color: green; font-weight: bold;">Ouvert</span>
                            @if ($partnerFinName)
                                <br><span style="color: #666; font-size: 8px;">{{ $partnerFinName }}</span>
                            @endif
                        @elseif ($commissionAccepted)
                            <span style="color: #b45309; font-weight: bold;">En cours</span>
                        @else
                            <span style="color: #888;">Non ouvert</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if ($hasDisbursement)
                            <strong style="color: green;">Décaissé</strong><br>
                            @if ($totalDecaisseCand > 0)
                                <span style="color: #001B63; font-weight: bold; font-size: 8px;">{{ number_format($totalDecaisseCand, 0, ',', ' ') }} F</span>
                            @endif
                        @elseif ($candidat->credit_committee || $candidat->creditCommittee)
                            <span style="color: #0284c7; font-weight: bold;">Comité validé</span>
                        @else
                            <span style="color: #888;">En attente</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 15px;">Aucun candidat trouvé pour cette sélection.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
