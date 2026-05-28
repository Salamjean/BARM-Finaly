@if (can('partner-technical'))
    <div class="container-fluid py-4">

        <!-- Première ligne - 2 graphiques -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-6 col-md-12 mb-3">
                <div class="card shadow-none h-100">

                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="conditionsChart" style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 mb-3">
                <div class="card shadow-none h-100">

                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="conditionsTrainingChart" style="max-height: 400px;"></canvas>
                    </div>

                </div>
            </div>
        </div>

        <!-- Deuxième ligne - 3 graphiques -->
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card shadow-none h-100">

                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="conditionsPaChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card shadow-none h-100">

                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="paDecisionChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card shadow-none h-100">

                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="conditionsFinancialChart" style="max-height: 300px;"></canvas>
                    </div>

                </div>
            </div>

            
        </div>
    </div>

    @push('js-push')
        <script src="{{ asset('assets/js/chart.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // Graphique des conditions administratives générales
                const conditions = @json($conditions);
                new Chart(document.getElementById('conditionsChart').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: Object.keys(conditions),
                        datasets: [{
                            label: 'Nombre de candidatures',
                            data: Object.values(conditions),
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Répartition des adhérents profilés par condition de départ'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Graphique des conditions avec formation
                const conditionsTraining = @json($conditions_training);
                new Chart(document.getElementById('conditionsTrainingChart').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: Object.keys(conditionsTraining),
                        datasets: [{
                            label: 'Candidatures avec formation',
                            data: Object.values(conditionsTraining),
                            backgroundColor: [
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)'
                            ],
                            borderColor: [
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Répartition des adhérents formés par condition de départ'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Graphique des conditions PA
                const conditionsPa = @json($conditions_pa);
                new Chart(document.getElementById('conditionsPaChart').getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(conditionsPa),
                        datasets: [{
                            label: 'Candidatures PA',
                            data: Object.values(conditionsPa),
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Répartition des plans d’affaires élaborés par condition de départ'
                            }
                        }
                    }
                });

                // Graphique des conditions financières
                const conditionsFinancial = @json($conditions_financial);
                new Chart(document.getElementById('conditionsFinancialChart').getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: Object.keys(conditionsFinancial).map(key => {
                            try {
                                const parsed = JSON.parse(key);
                                return Array.isArray(parsed) ? parsed.join(', ') : key;
                            } catch {
                                return key;
                            }
                        }),
                        datasets: [{
                            label: 'Conditions financières',
                            data: Object.values(conditionsFinancial),
                            backgroundColor: [
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(75, 192, 192, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 206, 86, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Répartition des adhérents financés par condition financières'
                            }
                        }
                    }
                });

                // Graphique des décisions PA
                const paDecision = @json($pa_decision);
                new Chart(document.getElementById('paDecisionChart').getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(paDecision).map(status => {
                            const statusLabels = {
                                'refused': 'Refusé',
                                'accepted': 'Accepté',
                                'in_progress': 'En cours',
                                'deferred': 'Différé',
                                'resignation': 'Démission'
                            };
                            return statusLabels[status] || status;
                        }),
                        datasets: [{
                            label: 'Décisions PA',
                            data: Object.values(paDecision),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Répartition des adhérents par décision de commission par partenaire'
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@elseif (can('partner-financial'))
    <div class="container-fluid py-4">
        
        <!-- Première ligne - 2 graphiques -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-6 col-md-12 mb-3">
                <div class="card shadow-none h-100">
                    
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="candidaturesPaChart" style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 mb-3">
                <div class="card shadow-none h-100">
                    
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="candidaturesAccountChart" style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deuxième ligne - 3 graphiques -->
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card shadow-none h-100">
                    
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="candidaturesCreditChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card shadow-none h-100">
                    
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="candidaturesDisbursementChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card shadow-none h-100">
                    
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="candidaturesPostChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function generateColors(count) {
                const colors = [];
                const borderColors = [];
                for (let i = 0; i < count; i++) {
                    const hue = (i * 360) / count;
                    colors.push(`hsla(${hue}, 80%, 40%, 0.6)`);
                    borderColors.push(`hsla(${hue}, 70%, 50%, 0)`);
                }
                return {
                    colors,
                    borderColors
                };
            }

            // Fonction pour créer un graphique avec gestion d'erreur
            function createChart(canvasId, data, chartConfig) {
                const canvas = document.getElementById(canvasId);
                if (!canvas) {
                    console.error('Canvas non trouvé:', canvasId);
                    return;
                }

                try {
                    // Vérifier si les données existent et ne sont pas vides
                    if (!data || typeof data !== 'object' || Object.keys(data).length === 0) {
                        const ctx = canvas.getContext('2d');
                        ctx.font = '16px Arial';
                        ctx.fillStyle = '#6c757d';
                        ctx.textAlign = 'center';
                        ctx.fillText('Aucune donnée disponible', canvas.width / 2, canvas.height / 2);
                        return;
                    }

                    const labels = Object.keys(data);
                    const values = Object.values(data);
                    const colors = generateColors(labels.length);

                    const chartData = {
                        labels: labels,
                        datasets: [{
                            label: chartConfig.label,
                            data: values,
                            backgroundColor: colors.colors,
                            borderColor: colors.borderColors,
                            borderWidth: 2
                        }]
                    };

                    new Chart(canvas.getContext('2d'), {
                        type: chartConfig.type,
                        data: chartData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            ...chartConfig.options
                        }
                    });

                } catch (error) {
                    console.error('Erreur lors de la création du graphique:', canvasId, error);
                    const ctx = canvas.getContext('2d');
                    ctx.font = '16px Arial';
                    ctx.fillStyle = '#dc3545';
                    ctx.textAlign = 'center';
                    ctx.fillText('Erreur de chargement', canvas.width / 2, canvas.height / 2);
                }
            }

            // Récupération des données PHP avec gestion d'erreur
            let candidaturesPa, candidaturesAccount, candidaturesCredit, candidaturesDisbursement, candidaturesPost;

            try {
                candidaturesPa = @json($candidatures_pa ?? []);
            } catch (e) {
                console.error('Erreur candidatures PA:', e);
                candidaturesPa = [];
            }

            try {
                candidaturesAccount = @json($candidatures_account_opening ?? []);
            } catch (e) {
                console.error('Erreur candidatures Account:', e);
                candidaturesAccount = [];
            }

            try {
                candidaturesCredit = @json($candidatures_credit_committee ?? []);
            } catch (e) {
                console.error('Erreur candidatures Credit:', e);
                candidaturesCredit = [];
            }

            try {
                candidaturesDisbursement = @json($candidatures_disbursement_in_progress ?? []);
            } catch (e) {
                console.error('Erreur candidatures Disbursement:', e);
                candidaturesDisbursement = [];
            }

            try {
                candidaturesPost = @json($candidatures_post_monitored ?? []);
            } catch (e) {
                console.error('Erreur candidatures Post:', e);
                candidaturesPost = [];
            }

            // Création des graphiques
            createChart('candidaturesPaChart', candidaturesPa, {
                type: 'bar',
                label: 'Candidatures PA',
                options: {
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Plan d\'affaires élaborés par partenaire'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            ticks: {
                                maxRotation: 45
                            }
                        }
                    }
                }
            });

            createChart('candidaturesAccountChart', candidaturesAccount, {
                type: 'bar',
                label: 'Ouvertures de comptes',
                options: {
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Ouvertures de comptes autorisés par partenaire '
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

            createChart('candidaturesCreditChart', candidaturesCredit, {
                type: 'doughnut',
                label: 'Comité de crédit',
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 10,
                                usePointStyle: true
                            }
                        },
                        title: {
                            display: true,
                            text: 'Comité de crédit par partenaire'
                        }
                    }
                }
            });

            createChart('candidaturesDisbursementChart', candidaturesDisbursement, {
                type: 'pie',
                label: 'Décaissements en cours',
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 10,
                                usePointStyle: true
                            }
                        },
                        title: {
                            display: true,
                            text: 'Décaissements en cours par partenaire'
                        }
                    }
                }
            });

            createChart('candidaturesPostChart', candidaturesPost, {
                type: 'doughnut',
                label: 'Financement',
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 10,
                                usePointStyle: true
                            }
                        },
                        title: {
                            display: true,
                            text: 'Financés par partenaire'
                        }
                    }
                }
            });
        });
    </script>
@endif
