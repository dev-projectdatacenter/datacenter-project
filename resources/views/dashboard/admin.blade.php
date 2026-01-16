<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Data Center</title>
    <!-- Chart.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        header {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 32px;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info {
            text-align: right;
        }

        .user-info p {
            color: #718096;
            margin: 5px 0;
        }

        .logout-btn {
            background: #e53e3e;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
            margin-top: 10px;
        }

        .logout-btn:hover {
            background: #c53030;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #667eea;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-card.resources {
            border-left-color: #3182ce;
        }

        .stat-card.available {
            border-left-color: #38a169;
        }

        .stat-card.reservations {
            border-left-color: #d69e2e;
        }

        .stat-card.users {
            border-left-color: #e53e3e;
        }

        .stat-label {
            color: #718096;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 36px;
            font-weight: bold;
            color: #2d3748;
        }

        .stat-change {
            font-size: 12px;
            color: #38a169;
            margin-top: 10px;
        }

        .section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .section h2 {
            font-size: 24px;
            color: #2d3748;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        .chart-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background: #f7fafc;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2d3748;
            border-bottom: 2px solid #e2e8f0;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
        }

        tbody tr {
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: #f7fafc;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .status-active {
            background: #dbeafe;
            color: #0c2d6b;
        }

        .status-inactive {
            background: #fee2e2;
            color: #7f1d1d;
        }

        .status-rejected {
            background: #fecaca;
            color: #991b1b;
        }

        .status-finished {
            background: #c7d2fe;
            color: #3730a3;
        }

        .status-empty {
            color: #a0aec0;
            font-style: italic;
        }

        footer {
            text-align: center;
            color: white;
            padding: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <div>
                <h1>
                    <span>⚙️</span>
                    Dashboard Administrateur
                </h1>
                <p style="color: #718096; margin-top: 5px;">Gestion complète du Data Center</p>
            </div>
            <div class="user-info">
                <p><strong>{{ $user->name }}</strong></p>
                <p>{{ $user->email }}</p>
                <form action="/logout-test" style="margin-top: 10px;">
                    <button class="logout-btn">Déconnexion</button>
                </form>
            </div>
        </header>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card resources">
                <div class="stat-label">📦 Ressources Totales</div>
                <div class="stat-value">{{ $statistics['totalResources'] }}</div>
                <div class="stat-change">+2 cette semaine</div>
            </div>

            <div class="stat-card available">
                <div class="stat-label">✅ Disponibles</div>
                <div class="stat-value">{{ $statistics['availableResources'] }}</div>
                <div class="stat-change">{{ round(($statistics['availableResources'] / $statistics['totalResources']) * 100, 1) }}% d'utilisation</div>
            </div>

            <div class="stat-card reservations">
                <div class="stat-label">📅 Réservations Totales</div>
                <div class="stat-value">{{ $statistics['totalReservations'] }}</div>
                <div class="stat-change">+5 depuis hier</div>
            </div>

            <div class="stat-card users">
                <div class="stat-label">👥 Utilisateurs</div>
                <div class="stat-value">{{ $statistics['totalUsers'] }}</div>
                <div class="stat-change">+1 nouvel utilisateur</div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="section">
            <h2>📊 Graphiques d'Analyse</h2>

            <div class="chart-row">
                <!-- Réservations par Statut - Pie Chart -->
                <div style="position: relative; height: 350px;">
                    <h3 style="margin-bottom: 15px; color: #2d3748;">Distribution des Réservations</h3>
                    <canvas id="reservationStatusChart"></canvas>
                </div>

                <!-- Utilisation des Ressources - Doughnut Chart -->
                <div style="position: relative; height: 350px;">
                    <h3 style="margin-bottom: 15px; color: #2d3748;">Taux d'Utilisation</h3>
                    <canvas id="resourceUtilizationChart"></canvas>
                </div>
            </div>

            <div class="chart-row">
                <!-- Réservations par Statut - Bar Chart -->
                <div style="position: relative; height: 350px;">
                    <h3 style="margin-bottom: 15px; color: #2d3748;">Réservations par Statut (Détail)</h3>
                    <canvas id="reservationBarChart"></canvas>
                </div>

                <!-- Statistiques Comparatives - Horizontal Bar -->
                <div style="position: relative; height: 350px;">
                    <h3 style="margin-bottom: 15px; color: #2d3748;">Statistiques Globales</h3>
                    <canvas id="globalStatsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="section">
            <h2>📋 Détail des Réservations par Statut</h2>
            <table>
                <thead>
                    <tr>
                        <th>Statut</th>
                        <th>Nombre</th>
                        <th>Pourcentage</th>
                        <th>Visualisation</th>
                    </tr>
                </thead>
                <tbody id="reservationTable">
                    <!-- Rempli par JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <footer>
            <p>🔐 Data Center Management System © 2026 - Tous les droits réservés</p>
        </footer>
    </div>

    <script>
        // Définir tous les statuts possibles avec leurs couleurs
        const allStatuses = {
            'pending': { color: '#fbbf24', label: 'Pending' },
            'approved': { color: '#34d399', label: 'Approved' },
            'active': { color: '#60a5fa', label: 'Active' },
            'rejected': { color: '#ef4444', label: 'Rejected' },
            'finished': { color: '#a78bfa', label: 'Finished' }
        };

        // Récupérer les données de la base de données
        const reservationDataFromDB = {
            @foreach ($statistics['reservationsByStatus'] as $status => $total)
                '{{ $status }}': {{ $total }},
            @endforeach
        };

        // Fusionner avec tous les statuts (ajouter 0 pour ceux manquants)
        const reservationData = {};
        const colors = [];
        const labels = [];

        Object.keys(allStatuses).forEach(status => {
            reservationData[status] = reservationDataFromDB[status] || 0;
            colors.push(allStatuses[status].color);
            labels.push(allStatuses[status].label);
        });

        // Remplir le tableau avec tous les statuts
        function populateTable() {
            const tableBody = document.getElementById('reservationTable');
            const total = Object.values(reservationData).reduce((a, b) => a + b, 0);

            let html = '';
            Object.entries(allStatuses).forEach(([status, info]) => {
                const count = reservationData[status];
                const percentage = total > 0 ? ((count / total) * 100).toFixed(1) : 0;
                const statusClass = 'status-' + status;

                html += `
                    <tr>
                        <td>
                            <span class="status-badge ${statusClass}">
                                ${info.label}
                            </span>
                        </td>
                        <td><strong>${count}</strong></td>
                        <td>${percentage}%</td>
                        <td>
                            <div style="background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
                                <div style="background: ${info.color}; height: 100%; width: ${percentage}%;"></div>
                            </div>
                        </td>
                    </tr>
                `;
            });

            tableBody.innerHTML = html;
        }

        populateTable();

        // Chart 1: Réservations par Statut (Pie Chart)
        const ctxPie = document.getElementById('reservationStatusChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: Object.values(reservationData),
                    backgroundColor: colors,
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Chart 2: Utilisation des Ressources (Doughnut Chart)
        const ctxDoughnut = document.getElementById('resourceUtilizationChart').getContext('2d');
        const availableResources = {{ $statistics['availableResources'] }};
        const totalResources = {{ $statistics['totalResources'] }};
        const usedResources = totalResources - availableResources;

        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Utilisées', 'Disponibles'],
                datasets: [{
                    data: [usedResources, availableResources],
                    backgroundColor: [
                        '#667eea',
                        '#d1fae5',
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Chart 3: Réservations par Statut (Bar Chart)
        const ctxBar = document.getElementById('reservationBarChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nombre de Réservations',
                    data: Object.values(reservationData),
                    backgroundColor: colors,
                    borderRadius: 8,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
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

        // Chart 4: Statistiques Globales (Horizontal Bar)
        const ctxGlobal = document.getElementById('globalStatsChart').getContext('2d');
        new Chart(ctxGlobal, {
            type: 'bar',
            data: {
                labels: ['Ressources', 'Réservations', 'Utilisateurs'],
                datasets: [{
                    label: 'Total',
                    data: [
                        {{ $statistics['totalResources'] }},
                        {{ $statistics['totalReservations'] }},
                        {{ $statistics['totalUsers'] }}
                    ],
                    backgroundColor: [
                        '#667eea',
                        '#764ba2',
                        '#f093fb',
                    ],
                    borderRadius: 8,
                    borderWidth: 0
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>