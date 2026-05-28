@extends('layouts.app')

@section('content')
    <style>
        .search-loading {
            position: relative;
            overflow: hidden;
        }

        .search-loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .spinner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .table-container {
            position: relative;
            min-height: 200px;
        }

        .loading-row {
            animation: pulse 1.5s ease-in-out infinite alternate;
        }

        @keyframes pulse {
            0% {
                opacity: 0.6;
            }

            100% {
                opacity: 1;
            }
        }

        .skeleton-loader {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton 1.5s infinite;
            border-radius: 4px;
            height: 20px;
        }

        @keyframes skeleton {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }
    </style>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <i class="bx bx-search me-2 fs-4 text-primary"></i>
                <h4 class="card-title mb-0">Recherche d'adhérents</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-5">
                <!-- Recherche générale -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="search" class="form-label">Recherche générale</label>
                    <input type="text" class="form-control" id="search"
                        placeholder="Nom, prénom, numéro, diplôme, orientation, grade, condition administrative...">
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <label for="armee" class="form-label">Armée ou Arme</label>
                    <select class="form-control" id="armee" name="armee">
                        <option value="">-- Sélectionner armée ou arme --</option>

                        <option >Terre</option>
                        <option >Air</option>
                        <option >Force Spéciale</option>
                        <option >Autre</option>
                        <option >Marine Nationale</option>
                        <option >Gendarmerie Nationale</option>


                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <label for="grade" class="form-label">Grade</label>
                    <select class="form-control" id="grade" name="grade">
                        <option value="">-- Sélectionner un grade --</option>

                        <option>Soldat 2e classe</option>
                        <option>Soldat 1ère classe</option>
                        <option>Caporal</option>
                        <option>Caporal-Chef</option>
                        <option>Sergent</option>
                        <option>Sergent-Chef</option>
                        <option>Adjudant</option>
                        <option>Adjudant-Chef</option>
                        <option>Adjudant-Chef Major</option>

                        <option>MDL</option>
                        <option>MDL Chef</option>

                        <option>Matelot 1e classe</option>
                        <option>Quartier Maître 2e classe</option>
                        <option>Quartier Maître 1e classe</option>
                        <option>Second-Maître</option>
                        <option>Maître</option>
                        <option>Premier Maître</option>
                        <option>Maître-Principal</option>
                        <option>Maître-Principal Major</option>

                        <option>Enseigne de vaisseau de 1e Classe</option>
                        <option>Lieutenant</option>
                        <option>Lieutenant de Vaisseau</option>
                        <option>Capitaine</option>
                        <option>Capitaine de Corvette</option>
                        <option>Capitaine de Frégate</option>
                        <option>Capitaine de Vaisseau</option>
                        <option>Capitaine de Vaisseau Major</option>
                        <option>Commandant</option>
                        <option>Lieutenant-Colonel</option>
                        <option>Colonel</option>
                        <option>Colonel-Major</option>

                        <option>Contre-Amiral</option>
                        <option>Vice-Amiral</option>
                        <option>Vice-Amiral d’Escadre</option>
                        <option>Amiral</option>

                        <option>Général de Brigade</option>
                        <option>Général de Division</option>
                        <option>Général de Corps d’Armée</option>
                        <option>Général d’Armée</option>
                    </select>
                </div>


                <!-- Date début -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="date_start" class="form-label">Date début inscription</label>
                    <input type="date" class="form-control" id="date_start">
                </div>

                <!-- Date fin -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="date_end" class="form-label">Date fin inscription</label>
                    <input type="date" class="form-control" id="date_end">
                </div>

                <!-- Période d'entrée - Date début -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="date_entree_debut" class="form-label">Entrée - Date début</label>
                    <input type="date" class="form-control" id="date_entree_debut">
                </div>

                <!-- Période d'entrée - Date fin -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="date_entree_fin" class="form-label">Entrée - Date fin</label>
                    <input type="date" class="form-control" id="date_entree_fin">
                </div>

                <!-- Période de radiation - Date début -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="date_radiation_debut" class="form-label">Radiation - Date début</label>
                    <input type="date" class="form-control" id="date_radiation_debut">
                </div>

                <!-- Période de radiation - Date fin -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="date_radiation_fin" class="form-label">Radiation - Date fin</label>
                    <input type="date" class="form-control" id="date_radiation_fin">
                </div>

                <!-- Condition administrative -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="condition_admin" class="form-label">Condition administrative</label>
                    <select class="form-control" id="condition_admin">
                        <option value="">Toutes</option>
                        <option value="Départ volontaire">Départ volontaire</option>
                        <option value="Démission">Démission</option>
                        <option value="Limite d'age">Limite d'age</option>
                        <option value="Réforme">Réforme</option>
                    </select>
                </div>

                <!-- Condition financière -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="condition_financiere" class="form-label">Condition financière</label>
                    <select class="form-control" id="condition_financiere">
                        <option value="">Toutes</option>
                        @foreach (FINANCIAL_CONDITIONS as $fc)
                            <option value="{{ $fc['value'] }}">{{ $fc['value'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Bouton recherche -->
                <div class="col-12 col-sm-6 col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100 position-relative" id="btn-search">
                        <i class="bx bx-search me-1"></i>
                        <span class="search-text">Rechercher</span>
                        <span class="spinner-border spinner-border-sm d-none ms-2" id="search-spinner"></span>
                    </button>
                </div>

                <!-- Bouton export -->
                <div class="col-12 col-sm-6 col-md-3 d-flex align-items-end">
                    <button class="btn btn-warning w-100 d-none" id="openExportModal" data-bs-toggle="modal"
                        data-bs-target="#exportModal">
                        <i class="bx bx-export me-1"></i>
                        Exporter la recherche
                    </button>
                </div>
            </div>

            <div class="table-container">
                <div class="spinner-overlay" id="table-spinner">
                    <div class="text-center">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                        <p class="text-muted mb-0">Recherche en cours...</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table" id="result">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th class="text-white">Orientation</th>
                                <th class="text-white">Mecano</th>
                                <th class="text-white">Pièce</th>
                                <th class="text-white">Nom</th>
                                <th class="text-white">Prénoms</th>
                                <th class="text-white">Date de naissance</th>
                                <th class="text-white">Téléphone</th>
                                <th class="text-white">Date d'inscription</th>
                                <th class="text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    <i class="bx bx-search fs-1 opacity-50 mb-2 d-block"></i>
                                    Utilisez les filtres ci-dessus pour rechercher des adhérents
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>

    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-download me-2"></i>
                        Champs à exporter
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">Sélectionnez les champs que vous souhaitez inclure dans l'export :</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="orientation" checked>
                                <label class="form-check-label">Orientation</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="mecano" checked>
                                <label class="form-check-label">Mecano</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="cgrae_no" checked>
                                <label class="form-check-label">N° CGRAE</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="type_piece" checked>
                                <label class="form-check-label">Type de pièce</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="no_card" checked>
                                <label class="form-check-label">Numéro de pièce</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="grade" checked>
                                <label class="form-check-label">Grade</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="armee" checked>
                                <label class="form-check-label">Armée ou Arme</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="lastname" checked>
                                <label class="form-check-label">Nom</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="firstname" checked>
                                <label class="form-check-label">Prénom</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="birth_date" checked>
                                <label class="form-check-label">Date de naissance</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="phone_number" checked>
                                <label class="form-check-label">Téléphone</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="condition_admin" checked>
                                <label class="form-check-label">Condition administrative</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="date_inscription" checked>
                                <label class="form-check-label">Date d'inscription</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a href="#" id="exportLink" class="btn btn-primary" target="_blank">
                        <i class="bx bx-download me-1"></i>
                        Exporter
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js-push')
    <script>
        $(function() {
            let lastSearchParams = null;
            let searchTimeout = null;

            // Fonction pour créer des lignes de chargement skeleton
            function createSkeletonRows(count = 5) {
                let rows = '';
                for (let i = 0; i < count; i++) {
                    rows += `
                        <tr class="loading-row">
                            <td><div class="skeleton-loader"></div></td>
                            <td><div class="skeleton-loader"></div></td>
                            <td><div class="skeleton-loader"></div></td>
                            <td><div class="skeleton-loader"></div></td>
                            <td><div class="skeleton-loader"></div></td>
                            <td><div class="skeleton-loader"></div></td>
                            <td><div class="skeleton-loader"></div></td>
                            <td><div class="skeleton-loader"></div></td>
                            <td><div class="skeleton-loader"></div></td>
                        </tr>
                    `;
                }
                return rows;
            }

            // Fonction pour démarrer le chargement
            function startLoading() {
                $('#btn-search').prop('disabled', true).addClass('search-loading');
                $('#search-spinner').removeClass('d-none');
                $('.search-text').text('Recherche...');
                $('#table-spinner').show();
                $('#result tbody').html(createSkeletonRows());
            }

            // Fonction pour arrêter le chargement
            function stopLoading() {
                $('#btn-search').prop('disabled', false).removeClass('search-loading');
                $('#search-spinner').addClass('d-none');
                $('.search-text').text('Rechercher');
                $('#table-spinner').hide();
            }

            // Recherche automatique pendant la frappe (debounced)
            $('#search').on('input', function() {
                clearTimeout(searchTimeout);
                const query = $(this).val();

                if (query.length >= 3) {
                    searchTimeout = setTimeout(function() {
                        performSearch();
                    }, 800); // Attendre 800ms après la dernière frappe
                }
            });

            // Recherche automatique sur changement de dates et select
            $('#date_start, #grade, #armee, #date_end, #date_entree_debut, #date_entree_fin, #date_radiation_debut, #date_radiation_fin, #condition_admin, #condition_financiere')
                .on('change', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function() {
                        performSearch();
                    }, 500);
                });

            // Clic sur le bouton rechercher
            $('#btn-search').on('click', function() {
                clearTimeout(searchTimeout);
                performSearch();
            });

            // Fonction principale de recherche
            function performSearch() {
                let query = $('#search').val();
                let grade = $('#grade').val();
                let armee = $('#armee').val();
                let dateStart = $('#date_start').val();
                let dateEnd = $('#date_end').val();
                let dateEntreeDebut = $('#date_entree_debut').val();
                let dateEntreeFin = $('#date_entree_fin').val();
                let dateRadiationDebut = $('#date_radiation_debut').val();
                let dateRadiationFin = $('#date_radiation_fin').val();
                let conditionAdmin = $('#condition_admin').val();
                let conditionFinanciere = $('#condition_financiere').val();

                if (query.length < 3 && !grade && !armee && !dateStart && !dateEnd && !dateEntreeDebut && !
                    dateEntreeFin && !
                    dateRadiationDebut && !dateRadiationFin && !conditionAdmin && !conditionFinanciere) {
                    $('#result tbody').html(
                        `<tr>
                            <td colspan="9" class="text-center text-warning">
                                <i class="bx bx-info-circle me-2"></i>
                                Entrez au moins 3 caractères ou sélectionnez un filtre
                            </td>
                        </tr>`
                    );
                    $('#openExportModal').addClass('d-none');
                    return;
                }

                startLoading();

                $.ajax({
                    url: "{{ route('search.candidatures') }}",
                    method: 'GET',
                    data: {
                        search: query,
                        grade: grade,
                        armee: armee,
                        date_start: dateStart,
                        date_end: dateEnd,
                        date_entree_debut: dateEntreeDebut,
                        date_entree_fin: dateEntreeFin,
                        date_radiation_debut: dateRadiationDebut,
                        date_radiation_fin: dateRadiationFin,
                        condition_admin: conditionAdmin,
                        condition_financiere: conditionFinanciere
                    },
                    success: function(response) {
                        stopLoading();

                        if (response.length === 0) {
                            $('#result tbody').html(
                                `<tr>
                                    <td colspan="9" class="text-center text-muted">
                                        <i class="bx bx-search-alt-2 fs-1 opacity-50 mb-2 d-block"></i>
                                        <strong>Aucun résultat trouvé</strong><br>
                                        <small>Essayez de modifier vos critères de recherche</small>
                                    </td>
                                </tr>`
                            );
                            $('#openExportModal').addClass('d-none');
                            return;
                        }

                        let rows = '';
                        response.forEach(item => {
                            rows += `
                                <tr class="table-row-hover">
                                    <td><span class="badge bg-info">${item.orientation.toUpperCase()}</span></td>
                                    <td><strong>${item.mecano}</strong></td>
                                    <td>
                                        <div class="small">
                                            <div>${item.type_piece}</div>
                                            <div class="text-muted">${item.no_card}</div>
                                        </div>
                                    </td>
                                    <td><strong>${item.firstname.toUpperCase()}</strong></td>
                                    <td><strong>${item.lastname.toUpperCase()}</strong></td>
                                    <td class="text-muted small">${item.birth_date}</td>
                                    <td class="text-muted small">${item.phone_number}</td>
                                    <td class="text-muted small">${item.date_inscription}</td>
                                    <td>
                                        <a href="/adherent/show/${item.user_id}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Voir le profil">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    </td>
                                </tr>
                            `;
                        });

                        $('#result tbody').html(rows);
                        $('#openExportModal').removeClass('d-none');

                        // Animation d'apparition des lignes
                        $('#result tbody tr').hide().each(function(index) {
                            $(this).delay(index * 50).fadeIn(300);
                        });

                        lastSearchParams = {
                            search: query,
                            grade: grade,
                            armee: armee,
                            date_start: dateStart,
                            date_end: dateEnd,
                            date_entree_debut: dateEntreeDebut,
                            date_entree_fin: dateEntreeFin,
                            date_radiation_debut: dateRadiationDebut,
                            date_radiation_fin: dateRadiationFin,
                            condition_admin: conditionAdmin,
                            condition_financiere: conditionFinanciere
                        };
                    },
                    error: function() {
                        stopLoading();
                        $('#result tbody').html(
                            `<tr>
                                <td colspan="9" class="text-center text-danger">
                                    <i class="bx bx-error-circle fs-1 mb-2 d-block"></i>
                                    <strong>Erreur de recherche</strong><br>
                                    <small>Veuillez réessayer dans quelques instants</small>
                                </td>
                            </tr>`
                        );
                        $('#openExportModal').addClass('d-none');
                    }
                });
            }

            // Gestion de l'export
            $('#exportLink').on('click', function(e) {
                if (!lastSearchParams) {
                    e.preventDefault();
                    return;
                }

                let selectedFields = [];
                $('#exportModal .form-check-input:checked').each(function() {
                    selectedFields.push($(this).val());
                });

                if (selectedFields.length === 0) {
                    e.preventDefault();
                    alert('Veuillez sélectionner au moins un champ à exporter.');
                    return;
                }

                let params = new URLSearchParams(lastSearchParams);
                selectedFields.forEach(f => params.append('fields[]', f));

                let fullUrl = "{{ route('search.export') }}?" + params.toString();
                $(this).attr('href', fullUrl);
            });

            // Recherche au chargement de la page si des valeurs sont présentes
            if ($('#search').val().length >= 3 || $('#grade').val() || $('#armee').val() || $('#date_start')
            .val() || $('#date_end').val() || $(
                    '#date_entree_debut').val() || $('#date_entree_fin').val() || $('#date_radiation_debut')
                .val() || $('#date_radiation_fin').val() || $('#condition_admin').val() || $(
                    '#condition_financiere')
                .val()) {
                performSearch();
            }
        });
    </script>
@endpush
