{{-- resources/views/statistics/index.blade.php --}}
@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/statistics.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Configuration des couleurs pastel
        const pastelColors = ['#b3d1ff', '#b8e2d2', '#f9e8ad', '#ffcc99', '#e2e8f0'];
        
        window.addEventListener('load', function() {
            console.log('Initialisation des graphiques...');
            
            // Données pour les graphiques
            const categoryLabels = @json($categoryDistribution->pluck('name'));
            const categoryData = @json($categoryDistribution->pluck('resources_count'));
            const topResourcesLabels = @json($topResources->pluck('name'));
            const topResourcesData = @json($topResources->pluck('reservations_count'));

            console.log('Données:', { categoryLabels, categoryData, topResourcesLabels, topResourcesData });
            
            // Graphique camembert (doughnut) avec design pastel
            const categoryCtx = document.getElementById('categoryChart');
            if (categoryCtx && typeof Chart !== 'undefined') {
                new Chart(categoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: categoryLabels,
                        datasets: [{
                            data: categoryData,
                            backgroundColor: pastelColors,
                            borderColor: '#ffffff',
                            borderWidth: 5,
                            hoverOffset: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        borderRadius: 20,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: { family: 'inherit', size: 11, weight: '600' },
                                    color: '#64748b'
                                }
                            }
                        }
                    }
                });
                console.log('Graphique catégories créé');
            }
            
            // Graphique barres horizontal avec design pastel
            const topResourcesCtx = document.getElementById('topResourcesChart');
            if (topResourcesCtx && typeof Chart !== 'undefined') {
                new Chart(topResourcesCtx, {
                    type: 'bar',
                    data: {
                        labels: topResourcesLabels,
                        datasets: [{
                            label: 'Réservations',
                            data: topResourcesData,
                            backgroundColor: '#b3d1ff',
                            borderRadius: 8,
                            borderSkipped: false,
                            barThickness: 40
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { family: 'inherit', weight: '600' }, color: '#64748b' }
                            },
                            y: {
                                grid: { display: false },
                                ticks: {
                                    font: { family: 'inherit', weight: '600', size: 11 },
                                    color: '#2c3e50'
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
                console.log('Graphique top ressources créé');
            }
        });
    </script>
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="margin: 0;">Tableau de Bord Statistique</h1>
        <a href="{{ route('statistics.my_resources') }}" class="btn btn-primary" style="background: #2a2d4f; border-radius: 12px; padding: 0.6rem 1.5rem;">
            <i class="fas fa-user-chart"></i> Mes Statistiques
        </a>
    </div>

    <div class="stats-grid">
        <div class="stat-card stat-card-mint">
            <div class="stat-label">Taux d'Occupation</div>
            <div class="stat-value text-success">{{ $generalStats['occupancy_rate'] }}%</div>
            <div class="progress-bar-container">
                  <div class="progress-bar-fill bg-success" style="width: {{ $generalStats['occupancy_rate'] }}%;"></div>
            </div>
        </div>
        <div class="stat-card stat-card-blue">
            <div class="stat-label">Total Ressources</div>
            <div class="stat-value text-primary">{{ $generalStats['total_resources'] }}</div>
        </div>
        <div class="stat-card stat-card-orange">
            <div class="stat-label">Incidents Actifs</div>
            <div class="stat-value text-danger">{{ $healthStats['open_incidents'] }}</div>
        </div>
    </div>

    <div class="charts-container">
        <div class="chart-card">
            <h3>Répartition par Catégorie</h3>
            <div class="chart-wrapper">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <h3>Top Ressources</h3>
            <div class="chart-wrapper">
                <canvas id="topResourcesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
.resources-container {
    padding: 1.5rem 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 2rem;
    border-radius: 25px;
    border: none;
    text-align: left;
    box-shadow: 0 10px 20px rgba(74, 63, 68, 0.05);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(74, 63, 68, 0.08);
}

.stat-label {
    font-size: 0.9rem;
    color: #64748b;
    margin-bottom: 1rem;
    font-weight: 600;
    text-transform: capitalize;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.progress-bar-container {
    background: rgba(0, 0, 0, 0.05);
    border-radius: 10px;
    height: 8px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    transition: width 0.5s ease;
    border-radius: 10px;
}

.charts-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.chart-card {
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(74, 63, 68, 0.08);
    transition: all 0.3s ease;
}

.chart-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(74, 63, 68, 0.12);
}

.chart-card h3 {
    margin-top: 0;
    margin-bottom: 1.5rem;
    text-align: left;
    color: #2c3e50;
    font-size: 1.2rem;
    font-weight: 700;
}

.chart-wrapper {
    height: 300px;
    position: relative;
    width: 100%;
}

.chart-wrapper canvas {
    max-height: 100%;
    max-width: 100%;
}

/* Backgrounds des cartes stat */
.stat-card-mint {
    border-top: 6px solid #b8e2d2;
}

.stat-card-blue {
    border-top: 6px solid #b3d1ff;
}

.stat-card-yellow {
    border-top: 6px solid #f9e8ad;
}

.stat-card-orange {
    border-top: 6px solid #ffcc99;
}

/* Helpers Couleurs Textes */
.text-success {
    color: #27ae60;
}

.text-primary {
    color: #3498db;
}

.text-danger {
    color: #e74c3c;
}

.text-warning {
    color: #f39c12;
}

.bg-success {
    background-color: #b8e2d2;
}

.bg-primary {
    background-color: #b3d1ff;
}

.bg-warning {
    background-color: #f9e8ad;
}

.bg-danger {
    background-color: #ffcc99;
}
</style>
@endsection
