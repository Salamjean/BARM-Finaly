@extends('layouts.app')
@section('content')
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #065f43 0%, #1e452a 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #2d482e;
            margin: 0;
            padding: 20px 0;
        }

        .container-fuild {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .page-breadcrumb {
            margin-bottom: 2rem;
        }

        .breadcrumb-wrapper {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 20px 30px;
            color: white;
            font-weight: 500;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .main-card {
            background: rgba(255, 255, 255, 0.95);

            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.5) inset;
            padding: 0;
            overflow: hidden;
            position: relative;
        }

        .main-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #c9ea66, #4ba255, #93fbb6, #57f5e3);
            background-size: 300% 100%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .card-body {
            padding: 40px;
        }

        .profile-section {
            padding: 0;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            gap: 40px;
        }

        .avatar-container {
            position: relative;
        }

        .avatarr {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid rgba(255, 255, 255, 0.9);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.5) inset;
            transition: all 0.3s ease;
            position: relative;
        }

        .avatarr::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            background: linear-gradient(45deg, #83ea66, #4ba261);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .avatarr:hover::after {
            opacity: 1;
        }

        .status-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .status-online {
            background: linear-gradient(45deg, #48bb78, #38a169);
        }

        .profile-info h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0 0 10px 0;
            background: linear-gradient(135deg, #7eea66, #4ba268);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .profile-subtitle {
            font-size: 1.25rem;
            color: #718096;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .profile-subtitle2 {
            font-size: 1rem;
            color: #718096;
            margin-bottom: 20px;
            font-weight: 400;
            font-style: italic;
        }

        .edit-button {
            background: linear-gradient(135deg, #66ea80, #4ba26f);
            border: none;
            border-radius: 50px;
            padding: 12px 24px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .edit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 234, 166, 0.6);
            color: white;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #66ea7a, #4ba25c);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #4a5568;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-value {
            color: #2d3748;
            font-weight: 500;
            text-align: right;
            max-width: 60%;
        }

        .stats-container {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 25px;
            padding: 30px;
            margin: 40px 0;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .stat-card {
            text-align: center;
            padding: 25px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2.1rem;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #89ea66, #4ba27f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            color: #718096;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .section-header {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, #6aea66, #4ba267);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1.25rem;
            font-weight: 600;
            margin: 40px 0 30px 0;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .status-finished {
            background: #38a169;
            color: white !important;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .status-pending {
            background: #dd6b20;
            color: white !important;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .action-button {
            background: linear-gradient(135deg, #48bb78, #38a169);
            border: none;
            border-radius: 15px;
            padding: 12px 24px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
            color: white;
        }

        .icon {
            width: 20px;
            height: 20px;
            opacity: 0.7;
        }

        @media (max-width: 768px) {
            .container-fuild {
                padding: 0 15px;
            }

            .card-body {
                padding: 25px;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 25px;
            }

            .profile-info h1 {
                font-size: 2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-number {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .avatarr {
                width: 140px;
                height: 140px;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .info-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .info-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .info-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .info-card:nth-child(4) {
            animation-delay: 0.3s;
        }
    </style>

    <div class="container-fuild">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3 w-100">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 text-muted fw-light mb-4">
                        <span class="text-muted fw-light">
                            Suivi-Evaluation / Décaissement / Cohorte /
                            {{ $adherent->cohort->reference }} / Adhérent /
                        </span>
                        {{ $adherent->user->fullName() }}
                    </h4>
                </nav>
            </div>
        </div>

        <div class="mb-10">
            <div class="card shadow-none main-card">
                <div class="card-body">
                    <section class="profile-section">
                        <div class="profile-header">
                            <div class="avatar-container">
                                <img src="{{ asset($adherent->image) }}" alt="Profile" class="avatarr">
                            </div>

                            <div class="profile-info flex-grow-1">
                                <h1>{{ $adherent->user->fullName() }}</h1>
                                <p class="profile-subtitle">{{ $adherent->paAccepted->title }}</p>
                                <p class="profile-subtitle2">{{ $adherent->paAccepted->location }}</p>
                                <p class="profile-subtitle2">
                                    <p><span class="text-danger me-1">Pensionnaire :</span>
                                    {{ $adherent->creditCommittee->pension == 1 ? 'Oui' : 'Non' }}</p>
                                    <p><span class="text-danger me-1">Pension domeciliée au FIDRA
                                        :</span>
                                    {{ $adherent->creditCommittee->pension_partner_financial == 1 ? 'Oui' : 'Non' }}</p>
                                </p>

                                @if (!$adherent->selfEmploymentMonitoredPayment->loan_set_up_date)
                                    @if (can('partner-financial'))
                                        <a href="#" class="edit-button disbursement-loan-link"
                                            title="Renseigné date de mise en place du prêt"
                                            data-action="{{ route('monitored-evaluation.disbursement.update.loan', $adherent->selfEmploymentMonitoredPayment->id) }}"
                                            data-loan-disbursement-title="Date de mise à disposition du prêt">
                                            Définir date de prêt
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="info-grid">
                            <div class="info-card">
                                <h3 style="margin-bottom: 20px; color: #4a5568; font-weight: 700;">Informations personnelles
                                </h3>

                                <div class="info-item">
                                    <span class="info-label">Mecano</span>
                                    <span class="info-value">{{ $adherent->user->mecano }}</span>
                                </div>

                                <div class="info-item">
                                    <span class="info-label"> Date de naissance</span>
                                    <span class="info-value">{{ dateFr($adherent->birth_date) }}</span>
                                </div>

                                <div class="info-item">
                                    <span class="info-label"> Pièce d'identité</span>
                                    <span class="info-value">{{ $adherent->type_piece }} / {{ $adherent->no_card }}</span>
                                </div>

                                <div class="info-item">
                                    <span class="info-label"> Adresse</span>
                                    <span class="info-value">{{ $adherent->address }}</span>
                                </div>

                                @if ($adherent->user->email)
                                    <div class="info-item">
                                        <span class="info-label"> E-mail</span>
                                        <span class="info-value">{{ $adherent->user->email }}</span>
                                    </div>
                                @endif

                                <div class="info-item">
                                    <span class="info-label"> Téléphone</span>
                                    <span class="info-value">
                                        (+225) {{ $adherent->phone_number }}
                                        {{ $adherent->phone_number2 ? ', ' . $adherent->phone_number2 : '' }}
                                        {{ $adherent->phone_number3 ? ', ' . $adherent->phone_number3 : '' }}
                                    </span>
                                </div>
                            </div>

                            <div class="info-card">
                                <h3 style="margin-bottom: 20px; color: #4a5568; font-weight: 700;">Informations business
                                </h3>

                                @if (!can('partner-technical'))
                                    <div class="info-item">
                                        <span class="info-label"> Partenaire technique</span>
                                        <span class="info-value">{{ $adherent->partnerTechnical->user->username }}</span>
                                    </div>
                                @endif

                                <div class="info-item">
                                    <span class="info-label"> Partenaire financier</span>
                                    <span class="info-value">{{ $adherent->partnerFinancial->user->username }}</span>
                                </div>

                                <div class="info-item">
                                    <span class="info-label"> Agence</span>
                                    <span class="info-value">{{ $adherent->creditCommittee->agency }}</span>
                                </div>

                                <div class="info-item">
                                    <span class="info-label"> Date de comité</span>
                                    <span
                                        class="info-value">{{ dateFr($adherent->creditCommittee->pvCommittee->date) }}</span>
                                </div>

                                <div class="info-item">
                                    <span class="info-label"> Montant demandé</span>
                                    <span class="info-value">{{ amount($adherent->paAccepted->amount) . DEVICE }}</span>
                                </div>

                                <div class="info-item">
                                    <span class="info-label"> Crédit accordé</span>
                                    <span
                                        class="info-value">{{ amount($adherent->creditCommittee->amount_agreed) . DEVICE }}</span>
                                </div>

                                @if ($adherent->selfEmploymentMonitoredPayment->loan_set_up_date)
                                    <div class="info-item">
                                        <span class="info-label"> Mise en place du prêt</span>
                                        <span
                                            class="info-value">{{ dateFr($adherent->selfEmploymentMonitoredPayment->loan_set_up_date) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if (!$pre_disbursement)
                            <div class="stats-container">
                                <div class="stats-grid">
                                    <div class="stat-card">
                                        <div class="stat-number text-warning">
                                            {{ $adherent->commissionCandidat->commission->number }}
                                        </div>
                                        <div class="stat-label">{{ dateFr($adherent->commissionCandidat->commission->date) }}</div>
                                        <div class="stat-label">Date de la commission d'approbation</div>
                                    </div>
                                    <div class="stat-card">
                                        <div class="stat-number">
                                            {{ count($adherent->selfEmploymentMonitoredPayment->disbursements->where('status', 'finished')) }}
                                        </div>
                                        <div class="stat-label">Nombre de décaissements</div>
                                    </div>

                                    <div class="stat-card">
                                        <div class="stat-number">{{ amount($amount_disbursed) }}</div>
                                        <div class="stat-label">Montant décaissé {{ DEVICE }}</div>
                                    </div>

                                    <div class="stat-card">
                                        <div class="stat-number">{{ amount($left_pay) }}</div>
                                        <div class="stat-label">Reste à décaisser {{ DEVICE }}</div>
                                    </div>

                                    <div class="stat-card d-flex flex-column justify-content-center">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class=" pb-4">
                                                <span
                                                    class="status-{{ $left_pay === 0 ? 'finished' : 'pending' }} text-white">{{ $left_pay === 0 ? 'Terminé' : 'En cours' }}</span>
                                            </div>
                                            <div class="stat-label">Statut de la procédure</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </section>

                    <div class="section-header">
                        Décaissement
                    </div>

                    @if ($pre_disbursement)
                        @include('dashboard.monitored_evaluation.disbursement.adherent.one')
                    @else
                        @include('dashboard.monitored_evaluation.disbursement.adherent.two')
                    @endif

                    @if ($adherent->selfEmploymentMonitoredPayment->disbursements->whereIn('status', ['pending', 'in_progress', 'finished'])->count() > 0)
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <div class="d-flex align-items-center gap-5">
                                <div class="section-header" style="margin: 0;">
                                    Échéances
                                </div>
                                <div>
                                    Mois différés : <span
                                        class="text-danger">{{ $adherent->creditCommittee->deferred_months }}</span>
                                </div>
                                <div>
                                    Durée du prêt : <span
                                        class="text-danger">{{ $adherent->creditCommittee->loan_duration }} mois</span>
                                </div>
                            </div>
                            @if (can('partner-financial'))
                                <button type="button" class="action-button" data-bs-toggle="modal"
                                    data-bs-target="#addDisbursementDeadlineModal">
                                    Ajouter une date
                                </button>
                            @endif
                        </div>
                        @include('dashboard.monitored_evaluation.disbursement.adherent.deadline')
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal pour définir la date de mise en place du prêt --}}
    @if (can('partner-financial'))
        <div class="modal fade" id="disbursementLoanModal" tabindex="-1" aria-labelledby="disbursementLoanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="disbursementLoanModalLabel">Date de mise en place du prêt</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="disbursementLoanForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="date_loan" class="form-label">Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date_loan" name="date"
                                    max="{{ date('Y-m-d') }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('js-push')
        <script>
            $(document).ready(function() {
                @if (can('partner-financial'))
                    $('a.disbursement-loan-link').on('click', function(e) {
                        e.preventDefault();
                        const actionUrl = $(this).data('action');
                        const disbursementTitle = $(this).data('loan-disbursement-title');

                        $('#disbursementLoanModalLabel').text(disbursementTitle);
                        $('#disbursementLoanForm').data('action-url', actionUrl);

                        $('#disbursementLoanModal').modal('show');
                    });

                    $('#disbursementLoanForm').on('submit', function(e) {
                        e.preventDefault();
                        loading();

                        const formData = new FormData(this);
                        const actionUrl = $(this).data('action-url');

                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            }
                        });

                        $.ajax({
                            url: actionUrl,
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                endLoading();
                                if (response.action) {
                                    ToastSuccess.fire({
                                        icon: 'success',
                                        title: response.message,
                                    });
                                    $('#disbursementLoanModal').modal('hide');
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    ToastError.fire({
                                        icon: 'error',
                                        title: response.message,
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                endLoading();
                                alert('Une erreur est survenue, veuillez réessayer.');
                            }
                        });
                    });
                @endif
            });
        </script>
    @endpush
@endsection
