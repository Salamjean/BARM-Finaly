<div class="container pt-3">
    <div class="row g-5">
        <div class="d-flex justify-content-center gap-5">
            <div class="col-md-6 card p-3 shadow-none">
                <div class="accordion-body">
                    <canvas id="adherentsByCondition"></canvas>
                </div>
            </div>

            <div class="col-md-3 card p-3 shadow-none">
                <div class="accordion-body">
                    <canvas id="adherentsByOrientation"></canvas>
                </div>
            </div>

            <div class="col-md-3 card p-3 shadow-none">
                <div class="accordion-body">
                    <canvas id="adherentsByCommission"></canvas>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-5">
            <div class="col-md-6 card p-3 shadow-none">
                <div class="accordion-body">
                    <canvas id="adherentsByConditionFinanciere"></canvas>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-5">

            <div class="col-md-6 card p-3 shadow-none">
                <div class="accordion-body">
                    <canvas id="adherentsByGrade"></canvas>
                </div>
            </div>
            <div class="col-md-6 card p-3 shadow-none">
                <div class="accordion-body">
                    <canvas id="adherentsByPartner"></canvas>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-center gap-5">
            <div class="col-md-6 card p-3 shadow-none">
                <div class="accordion-body">
                    <canvas id="disbursementsCountByPartner"></canvas>
                </div>
            </div>

            <div class="col-md-6 card p-3 shadow-none">
                <div class="accordion-body">
                    <canvas id="disbursementsAmountByPartner"></canvas>
                </div>
            </div>
        </div>



    </div>
</div>

@push('js-push')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const adherentsByCondition = @json($adherents_by_condition);
            new Chart(document.getElementById('adherentsByCondition').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: Object.keys(adherentsByCondition),
                    datasets: [{
                        label: 'Nombre d\'adhérents par condition',
                        data: Object.values(adherentsByCondition),
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Répartition des adhérents par condition'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const adherentsByOrientation = @json($adherents_by_orientation);
            new Chart(document.getElementById('adherentsByOrientation').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: Object.keys(adherentsByOrientation),
                    datasets: [{
                        label: 'Adhérents par orientation',
                        data: Object.values(adherentsByOrientation),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Répartition des adhérents par orientation'
                        }
                    }
                }
            });

            const adherentsByGrade = @json($adherents_by_grade);
            new Chart(document.getElementById('adherentsByGrade').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: Object.keys(adherentsByGrade),
                    datasets: [{
                        label: 'Adhérents par grade',
                        data: Object.values(adherentsByGrade),
                        backgroundColor: [
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 205, 86, 0.2)'
                        ],
                        borderColor: [
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Répartition des adhérents par grade'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const adherentsByCommission = @json($adherents_by_commission);
            new Chart(document.getElementById('adherentsByCommission').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: Object.keys(adherentsByCommission),
                    datasets: [{
                        label: 'Adhérents par décision de commission',
                        data: Object.values(adherentsByCommission),
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
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Répartition des adhérents par décision de commission'
                        }
                    }
                }
            });

            const adherentsByConditionFinanciere = @json($adherents_by_condition_financiere ?? []);
            new Chart(document.getElementById('adherentsByConditionFinanciere').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: Object.keys(adherentsByConditionFinanciere),
                    datasets: [{
                        label: 'Nombre d\'adhérents par condition financière',
                        data: Object.values(adherentsByConditionFinanciere),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Répartition des adhérents par condition financière'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            const partnersCount = @json($adherents_by_partner_technicial);
            new Chart(document.getElementById('adherentsByPartner').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: Object.keys(partnersCount),
                    datasets: [{
                        label: 'Adhérents par partenaires',
                        data: Object.values(partnersCount),
                        backgroundColor: Object.keys(partnersCount).map((_, index) => {
                            const hue = (index * 360) / Object.keys(partnersCount).length;
                            return `hsla(${hue}, 70%, 60%, 0.2)`;
                        }),
                        borderColor: Object.keys(partnersCount).map((_, index) => {
                            const hue = (index * 360) / Object.keys(partnersCount).length;
                            return `hsla(${hue}, 70%, 40%, 1)`;
                        }),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Répartition des adhérents par partenaires'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Graphique: Nombre de financements terminés par partenaire technique
            const disbursementsCount = @json($disbursements_count_by_partner ?? []);
            new Chart(document.getElementById('disbursementsCountByPartner').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: Object.keys(disbursementsCount),
                    datasets: [{
                        label: 'Nombre de decaissements terminés',
                        data: Object.values(disbursementsCount),
                        backgroundColor: Object.keys(disbursementsCount).map((_, index) => {
                            const hue = (index * 360) / Object.keys(disbursementsCount).length;
                            return `hsla(${hue}, 80%, 50%, 0.5)`;
                        }),
                        borderColor: Object.keys(disbursementsCount).map((_, index) => {
                            const hue = (index * 360) / Object.keys(disbursementsCount).length;
                            return `hsla(${hue}, 80%, 40%, 1)`;
                        }),
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Nombre de décaissements terminés par partenaire technique'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Graphique: Montant total des financements terminés par partenaire technique
            const disbursementsAmount = @json($disbursements_amount_by_partner ?? []);
            new Chart(document.getElementById('disbursementsAmountByPartner').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: Object.keys(disbursementsAmount),
                    datasets: [{
                        label: 'Montant total des financements (FCFA)',
                        data: Object.values(disbursementsAmount),
                        backgroundColor: Object.keys(disbursementsAmount).map((_, index) => {
                            const hue = 120 + (index * 240) / Object.keys(disbursementsAmount).length;
                            return `hsla(${hue}, 70%, 50%, 0.6)`;
                        }),
                        borderColor: Object.keys(disbursementsAmount).map((_, index) => {
                            const hue = 120 + (index * 240) / Object.keys(disbursementsAmount).length;
                            return `hsla(${hue}, 70%, 35%, 1)`;
                        }),
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Montant total des financements terminés par partenaire technique'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('fr-FR', {
                                            style: 'currency',
                                            currency: 'XOF',
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 0
                                        }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
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
                        }
                    }
                }
            });
        });
    </script>
@endpush
