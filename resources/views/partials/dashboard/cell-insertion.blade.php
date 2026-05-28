<div class="container pt-3">
    <!-- Indicateur de chargement -->
    <div id="loadingIndicator" class="text-center d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>

    <!-- Onglets pour organiser les graphiques par orientation -->

    <ul class="nav nav-tabs mb-4" id="orientationTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                type="button">
                Vue générale
            </button>
        </li>
        @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="auto-emploi-tab" data-bs-toggle="tab" data-bs-target="#auto-emploi"
                    type="button">
                    Auto-emploi
                </button>
            </li>
        @endif
        
        @if (can('chef-cellule-formation-et-insertion|conseiller-entreprise-prive'))
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="entreprise-tab" data-bs-toggle="tab" data-bs-target="#entreprise"
                    type="button">
                    Entreprise privée
                </button>
            </li>
        @endif
        @if (can('chef-cellule-formation-et-insertion|conseiller-fonction-public'))
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="fonction-tab" data-bs-toggle="tab" data-bs-target="#fonction"
                    type="button">
                    Fonction publique
                </button>
            </li>
        @endif
    </ul>

    <div class="tab-content" id="orientationTabContent">
        <!-- Vue générale -->
        <div class="tab-pane fade show active" id="general" role="tabpanel">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Répartition par condition administrative</h5>
                            <div style="height: 300px;">
                                <canvas id="adherentsByCondition"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Répartition par orientation</h5>
                            <div style="height: 300px;">
                                <canvas id="adherentsByOrientation"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Répartition par condition financière</h5>
                            <div style="height: 300px;">
                                <canvas id="adherentsByConditionFinanciere"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auto-emploi -->
        @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
            <div class="tab-pane fade" id="auto-emploi" role="tabpanel">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Décisions de commission</h5>
                                <div style="height: 300px;">
                                    <canvas id="adherentsByCommission"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Répartition par partenaire technique</h5>
                                <div style="height: 300px;">
                                    <canvas id="adherentsByPartner"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Répartition par types d'arme</h5>
                                <div style="height: 300px;">
                                    <canvas id="armeeAutoEmploi"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Répartition par grades</h5>
                                <div style="height: 300px;">
                                    <canvas id="gradeAutoEmploi"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">Nombre de bénéficiaires financés par partenaire</h5>
                                    <span class="badge bg-primary fs-5">{{ array_sum($disbursements_count_by_partner ?? []) }}</span>
                                </div>
                                <div style="height: 300px;">
                                    <canvas id="disbursementsCountByPartner"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">Montant total des décaissements éffectués par partenaire</h5>
                                    <span class="badge bg-success fs-5">{{ amount(array_sum($disbursements_amount_by_partner ?? [])) }} FCFA</span>
                                </div>
                                <div style="height: 300px;">
                                    <canvas id="disbursementsAmountByPartner"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (can('chef-cellule-formation-et-insertion|conseiller-entreprise-prive'))
            <div class="tab-pane fade" id="entreprise" role="tabpanel">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Répartition par types d'arme</h5>
                                <div style="height: 300px;">
                                    <canvas id="armeeEntreprise"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Répartition par grades</h5>
                                <div style="height: 300px;">
                                    <canvas id="gradeEntreprise"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Fonction publique -->
        @if (can('chef-cellule-formation-et-insertion|conseiller-fonction-public'))
            <div class="tab-pane fade" id="fonction" role="tabpanel">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Répartition par types d'arme</h5>
                                <div style="height: 300px;">
                                    <canvas id="armeeFonction"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Répartition par grades</h5>
                                <div style="height: 300px;">
                                    <canvas id="gradeFonction"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('js-push')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script>
        // Configuration globale pour Chart.js
        Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
        Chart.defaults.plugins.legend.labels.usePointStyle = true;

        // Palette de couleurs moderne
        const colors = {
            primary: ['#6366f1', '#ec4899', '#f59e0b', '#8b5cf6', '#10b981', '#3b82f6'],
            secondary: ['#c084fc', '#fcd34d', '#f9a8d4', '#86efac', '#93c5fd', '#e9d5ff'],
            gradients: []
        };

        // Fonction pour créer des graphiques avec animation
        function createChart(elementId, type, data, options = {}) {
            const ctx = document.getElementById(elementId);
            if (!ctx) return;

            const defaultOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: type === 'pie' || type === 'doughnut' ? 'right' : 'top',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                }
            };

            // Fusionner les options
            const finalOptions = {
                ...defaultOptions,
                ...options
            };

            return new Chart(ctx.getContext('2d'), {
                type: type,
                data: data,
                options: finalOptions
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Graphique des conditions
            const adherentsByCondition = @json($adherents_by_condition);
            createChart('adherentsByCondition', 'bar', {
                labels: Object.keys(adherentsByCondition),
                datasets: [{
                    label: 'Nombre d\'adhérents',
                    data: Object.values(adherentsByCondition),
                    backgroundColor: colors.primary,
                    borderWidth: 0,
                    borderRadius: 8
                }]
            }, {
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribution par condition administrative',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            });

            // Graphique des orientations
            const adherentsByOrientation = @json($adherents_by_orientation);
            createChart('adherentsByOrientation', 'doughnut', {
                labels: Object.keys(adherentsByOrientation).map(label => {
                    return label.split('-').map(word =>
                        word.charAt(0).toUpperCase() + word.slice(1)
                    ).join(' ');
                }),
                datasets: [{
                    data: Object.values(adherentsByOrientation),
                    backgroundColor: colors.primary.slice(0, 3),
                    borderWidth: 0
                }]
            }, {
                plugins: {
                    title: {
                        display: true,
                        text: 'Répartition par orientation professionnelle',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                }
            });

            // Graphique des conditions financières
            const adherentsByConditionFinanciere = @json($adherents_by_condition_financiere ?? []);
            createChart('adherentsByConditionFinanciere', 'bar', {
                labels: Object.keys(adherentsByConditionFinanciere),
                datasets: [{
                    label: 'Nombre d\'adhérents',
                    data: Object.values(adherentsByConditionFinanciere),
                    backgroundColor: colors.primary,
                    borderWidth: 0,
                    borderRadius: 8
                }]
            }, {
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribution par condition financière',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            });

            @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                // Graphique des commissions
                const adherentsByCommission = @json($adherents_by_commissions_auto_emploi);
                const commissionLabels = {
                    'accepted': 'Accepté',
                    'refused': 'Refusé',
                    'deferred': 'Différé',
                    'resignation': 'Démission'
                };
                createChart('adherentsByCommission', 'pie', {
                    labels: Object.keys(adherentsByCommission).map(key => commissionLabels[key] || key),
                    datasets: [{
                        data: Object.values(adherentsByCommission),
                        backgroundColor: colors.primary.slice(0, 4),
                        borderWidth: 0
                    }]
                });

                // Graphique des partenaires
                const partnersCount = @json($adherents_by_partners_technicial_count);
                createChart('adherentsByPartner', 'bar', {
                    labels: Object.keys(partnersCount),
                    datasets: [{
                        label: 'Nombre de candidatures',
                        data: Object.values(partnersCount),
                        backgroundColor: colors.primary[0],
                        borderWidth: 0,
                        borderRadius: 8
                    }]
                }, {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                });

                // Graphiques Auto-emploi
                const armeeAutoEmploi = @json($adherents_by_type_armes_auto_emploi);
                createChart('armeeAutoEmploi', 'polarArea', {
                    labels: Object.keys(armeeAutoEmploi),
                    datasets: [{
                        data: Object.values(armeeAutoEmploi),
                        backgroundColor: colors.secondary,
                        borderWidth: 0
                    }]
                });

                const gradeAutoEmploi = @json($adherents_by_grades_auto_emploi);
                createChart('gradeAutoEmploi', 'bar', {
                    labels: Object.keys(gradeAutoEmploi),
                    datasets: [{
                        label: 'Effectifs',
                        data: Object.values(gradeAutoEmploi),
                        backgroundColor: colors.primary[1],
                        borderWidth: 0,
                        borderRadius: 8
                    }]
                }, {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                });

                // Graphique: Nombre de décaissements terminés par partenaire technique
                const disbursementsCount = @json($disbursements_count_by_partner ?? []);
                createChart('disbursementsCountByPartner', 'bar', {
                    labels: Object.keys(disbursementsCount),
                    datasets: [{
                        label: 'Nombre de décaissements terminés',
                        data: Object.values(disbursementsCount),
                        backgroundColor: Object.keys(disbursementsCount).map((_, index) => {
                            const hue = (index * 360) / Object.keys(disbursementsCount).length;
                            return `hsla(${hue}, 80%, 50%, 0.5)`;
                        }),
                        borderColor: Object.keys(disbursementsCount).map((_, index) => {
                            const hue = (index * 360) / Object.keys(disbursementsCount).length;
                            return `hsla(${hue}, 80%, 40%, 1)`;
                        }),
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                }, {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                });

                // Graphique: Montant total des décaissements terminés par partenaire technique
                const disbursementsAmount = @json($disbursements_amount_by_partner ?? []);
                createChart('disbursementsAmountByPartner', 'bar', {
                    labels: Object.keys(disbursementsAmount),
                    datasets: [{
                        label: 'Montant total (FCFA)',
                        data: Object.values(disbursementsAmount),
                        backgroundColor: Object.keys(disbursementsAmount).map((_, index) => {
                            const hue = 120 + (index * 240) / Object.keys(disbursementsAmount).length;
                            return `hsla(${hue}, 70%, 50%, 0.6)`;
                        }),
                        borderColor: Object.keys(disbursementsAmount).map((_, index) => {
                            const hue = 120 + (index * 240) / Object.keys(disbursementsAmount).length;
                            return `hsla(${hue}, 70%, 35%, 1)`;
                        }),
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                }, {
                    indexAxis: 'y',
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.x !== null) {
                                        label += new Intl.NumberFormat('fr-FR', {
                                            style: 'currency',
                                            currency: 'XOF',
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 0
                                        }).format(context.parsed.x);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('fr-FR', {
                                        style: 'currency',
                                        currency: 'XOF',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    }).format(value);
                                }
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                });
            @endif

            @if (can('chef-cellule-formation-et-insertion|conseiller-entreprise-prive'))

                const armeeEntreprise = @json($adherents_by_type_armes_entreprise_privee);
                createChart('armeeEntreprise', 'polarArea', {
                    labels: Object.keys(armeeEntreprise),
                    datasets: [{
                        data: Object.values(armeeEntreprise),
                        backgroundColor: colors.secondary,
                        borderWidth: 0
                    }]
                });

                const gradeEntreprise = @json($adherents_by_grades_entreprise_privee);
                createChart('gradeEntreprise', 'bar', {
                    labels: Object.keys(gradeEntreprise),
                    datasets: [{
                        label: 'Effectifs',
                        data: Object.values(gradeEntreprise),
                        backgroundColor: colors.primary[2],
                        borderWidth: 0,
                        borderRadius: 8
                    }]
                }, {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                },
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    }
                });
            @endif

            @if (can('chef-cellule-formation-et-insertion|conseiller-fonction-public'))
                // Graphiques Fonction publique
                const armeeFonction = @json($adherents_by_type_armes_fonction_publique);
                createChart('armeeFonction', 'polarArea', {
                    labels: Object.keys(armeeFonction),
                    datasets: [{
                        data: Object.values(armeeFonction),
                        backgroundColor: colors.secondary,
                        borderWidth: 0
                    }]
                });

                const gradeFonction = @json($adherents_by_grades_fonction_publique);
                createChart('gradeFonction', 'bar', {
                    labels: Object.keys(gradeFonction),
                    datasets: [{
                        label: 'Effectifs',
                        data: Object.values(gradeFonction),
                        backgroundColor: colors.primary[2],
                        borderWidth: 0,
                        borderRadius: 8
                    }]
                }, {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                },
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    }
                });

                
            @endif
        });
    </script>
@endpush
