<?php
require_once __DIR__ . './../../../Controllers/AdminController.php';
// Example: get different datasets for demonstration
$paymentDistribution = AdminController::getPaymentDistribution();
$companyDistribution = AdminController::getCompanyDistributionByPlan();
$userData = AdminController::getUsers();
$totalRevenue = AdminController::getPayment(); // You need to implement this
echo "<script>
    window.paymentDistribution = " . json_encode($paymentDistribution) . ";
    window.companyDistribution = " . json_encode($companyDistribution) . ";
    window.userData = " . json_encode($userData) . ";
    window.totalRevenue = " . json_encode($totalRevenue) . ";
</script>";
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" />
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script defer>
    window.addEventListener('DOMContentLoaded', function() {
        // Chart datasets
        const datasets = {
            payment: {
                data: window.paymentDistribution || [],
                label: "Payment Status Distribution"
            },
            company: {
                data: window.companyDistribution || [],
                label: "Company Subscription Distribution"
            }
        };

        // Chart colors
        const backgroundColors = [
            'rgba(99, 102, 241, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(251, 191, 36, 0.8)',
            'rgba(236, 72, 153, 0.8)',
            'rgba(59, 130, 246, 0.8)'
        ];

        // Chart.js config generator
        function getPieConfig(rawData) {
            const labels = rawData.map(item => item['0'] ? item['0'].charAt(0).toUpperCase() + item['0'].slice(1) : item.label);
            const data = rawData.map(item => parseInt(item.count, 10));
            return {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: backgroundColors,
                        borderWidth: 1,
                        borderColor: '#18181b',
                        hoverOffset: 4,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        datalabels: {
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 16
                            },
                            formatter: (value, ctx) => {
                                let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                let percentage = sum ? (value * 100 / sum) : 0;
                                return percentage > 5 ? percentage.toFixed(0) + '%' : '';
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed;
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            };
        }

        // Initial chart
        const pieCtx = document.getElementById('pie');
        let currentType = 'payment';
        let pieChart = new Chart(pieCtx, getPieConfig(datasets[currentType].data));

        // Chart switcher
        document.querySelectorAll('.chart-switch-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentType = this.dataset.type;
                pieChart.destroy();
                pieChart = new Chart(pieCtx, getPieConfig(datasets[currentType].data));
                document.getElementById('pie-title').textContent = datasets[currentType].label;
                // Update legend
                const labels = pieChart.data.labels;
                const legendContainer = document.getElementById('pie-legend');
                legendContainer.innerHTML = labels.map((label, idx) => `
                <div class="flex items-center mr-4 mb-2">
                    <span class="inline-block w-3 h-3 mr-2 rounded-full" style="background:${backgroundColors[idx % backgroundColors.length]}"></span>
                    <span class="capitalize">${label}</span>
                </div>
            `).join('');
            });
        });

        // Initial legend
        const labels = pieChart.data.labels;
        const legendContainer = document.getElementById('pie-legend');
        legendContainer.innerHTML = labels.map((label, idx) => `
        <div class="flex items-center mr-4 mb-2">
            <span class="inline-block w-3 h-3 mr-2 rounded-full" style="background:${backgroundColors[idx % backgroundColors.length]}"></span>
            <span class="capitalize">${label}</span>
        </div>
    `).join('');

        // --- Line Chart for User Registrations (ONLY ALL) ---
        function getUserRegistrationsPerDay(userData) {
            const counts = {};
            userData.forEach(user => {
                const dateStr = (user.created_at || user[7] || '').slice(0, 10);
                if (dateStr) {
                    counts[dateStr] = (counts[dateStr] || 0) + 1;
                }
            });
            const dates = Object.keys(counts).sort();
            const values = dates.map(date => counts[date]);
            return {
                dates,
                values
            };
        }

        let lineChart;

        function renderLineChart() {
            const userRegData = getUserRegistrationsPerDay(window.userData || []);
            const ctx = document.getElementById('line');
            if (lineChart) {
                lineChart.destroy();
            }
            lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: userRegData.dates,
                    datasets: [{
                        label: "User Registrations",
                        data: userRegData.values,
                        fill: false,
                        borderColor: 'rgba(99, 102, 241, 1)',
                        backgroundColor: 'rgba(99, 102, 241, 0.2)',
                        tension: 0.3,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Registrations: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Users'
                            },
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
            document.getElementById('line-title').textContent = "User Registrations";
        }

        // Initial render
        renderLineChart();

        // --- Monthly Revenue Trends Chart ---
        function getMonthlyRevenueData(payments) {
            const monthlyTotals = {};
            payments.forEach(payment => {
                // Use payment_date or created_at for the month
                const dateStr = (payment.payment_date || payment.created_at || payment[3] || payment[6] || '').slice(0, 7); // "YYYY-MM"
                if (dateStr) {
                    const amount = parseFloat(payment.amount || payment[2] || 0);
                    if (!isNaN(amount)) {
                        monthlyTotals[dateStr] = (monthlyTotals[dateStr] || 0) + amount;
                    }
                }
            });
            const months = Object.keys(monthlyTotals).sort();
            const totals = months.map(month => monthlyTotals[month]);
            return {
                months,
                totals
            };
        }

        // Render Monthly Revenue Line Chart
        function renderRevenueLineChart() {
            const revenueData = getMonthlyRevenueData(window.totalRevenue || []);
            const ctx = document.getElementById('revenue-line');
            if (window.revenueLineChart) {
                window.revenueLineChart.destroy();
            }
            window.revenueLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: revenueData.months,
                    datasets: [{
                        label: 'Monthly Revenue',
                        data: revenueData.totals,
                        fill: true,
                        borderColor: 'rgba(16, 185, 129, 1)',
                        backgroundColor: 'rgba(16, 185, 129, 0.15)',
                        tension: 0.3,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Revenue: $${context.parsed.y.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2})}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Revenue ($)'
                            },
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        // Initial render for revenue chart
        renderRevenueLineChart();
    });
</script>
<div class="grid gap-2 mb-5 md:grid-cols-3 sm:grid-cols-2 grid-cols-1">
    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="flex items-center justify-between mb-4">
            <h4 id="pie-title" class="font-semibold text-gray-800 dark:text-gray-300">
                Payment Status Distribution
            </h4>
            <div class="relative w-64">
                <button id="chartDropdownBtn" class="w-full px-4 bg-gray-700  rounded-lg shadow-sm flex items-center justify-between text-white ">
                    <span id="chartDropdownLabel" class="truncate">Payments</span>
                    <svg class="w-5 h-5 ml-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="chartDropdownMenu" class="absolute left-0 mt-2 w-full bg-white border border-gray-200 rounded-lg shadow-lg z-10 hidden">
                    <button class="chart-switch-btn flex items-center w-full px-4 py-2 text-left hover:bg-blue-100 text-black rounded-t-lg" data-type="payment">
                        <span class="flex-1">Payments</span>
                        <svg class="w-4 h-4      opacity-0 group-checked:opacity-100" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                    <button class="chart-switch-btn flex items-center w-full px-4 py-2 text-left hover:bg-blue-100 text-black rounded-b-lg" data-type="company">
                        <span class="flex-1">Companies</span>
                        <svg class="w-4 h-4 text-gray-600 opacity-0 group-checked:opacity-100" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const btn = document.getElementById('chartDropdownBtn');
                    const menu = document.getElementById('chartDropdownMenu');
                    const label = document.getElementById('chartDropdownLabel');
                    let selectedType = 'payment';

                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        menu.classList.toggle('hidden');
                    });

                    document.querySelectorAll('.chart-switch-btn').forEach(item => {
                        item.addEventListener('click', function() {
                            label.textContent = this.textContent.trim();
                            menu.classList.add('hidden');
                            selectedType = this.dataset.type;
                            updateDropdownSelection();
                        });
                    });

                    document.addEventListener('click', function(e) {
                        if (!btn.contains(e.target)) {
                            menu.classList.add('hidden');
                        }
                    });

                    function updateDropdownSelection() {
                        document.querySelectorAll('.chart-switch-btn').forEach(item => {
                            if (item.dataset.type === selectedType) {
                                item.classList.add('bg-gray-600', 'text-white', 'font-semibold');
                                item.querySelector('svg').classList.remove('opacity-0');
                            } else {
                                item.classList.remove('bg-gray-600', 'text-white', 'font-semibold');
                                item.querySelector('svg').classList.add('opacity-0');
                            }
                        });
                    }
                    updateDropdownSelection();
                });
            </script>
        </div>
        <canvas id="pie" class="w-full" height="300"></canvas>
        <div class="flex flex-wrap justify-center mt-4 text-sm text-gray-600 dark:text-gray-400" id="pie-legend"></div>
    </div>
    <!-- Line Chart (User Registrations Only) -->
    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="flex items-center justify-between mb-4">
            <h4 class="font-semibold text-gray-800 dark:text-gray-300" id="line-title">User Registrations</h4>
        </div>
        <canvas id="line" class="w-full" height="300"></canvas>
        <div class="flex flex-wrap justify-center mt-4 text-sm text-gray-600 dark:text-gray-400" id="line-legend"></div>
    </div>

    <!-- Monthly Revenue Trends Chart -->
    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="flex items-center justify-between mb-4">
            <h4 class="font-semibold text-gray-800 dark:text-gray-300" id="revenue-line-title">Monthly Revenue Trends</h4>
        </div>
        <canvas id="revenue-line" class="w-full" height="300"></canvas>
    </div>
</div>
