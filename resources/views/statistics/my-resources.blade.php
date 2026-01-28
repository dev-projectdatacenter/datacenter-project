{{-- resources/views/statistics/my-resources.blade.php --}}
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
            console.log('Initialisation des graphiques personnels...');
            
            // Données pour le graphique d'activité
            const activityLabels = @json($userStats['monthly_activity']->pluck('month'));
            const activityData = @json($userStats['monthly_activity']->pluck('count'));

            console.log('Données activité:', { activityLabels, activityData });
            
            // Conversion des numéros de mois en noms
            const monthNames = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
            const labels = activityLabels.map(month => monthNames[month - 1] || 'Mois ' + month);
            
            // Graphique ligne avec design pastel
            const activityCtx = document.getElementById('activityChart');
            if (activityCtx && typeof Chart !== 'undefined') {
                // Création d'un dégradé sous la courbe
                const gradient = activityCtx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(179, 209, 255, 0.4)');
                gradient.addColorStop(1, 'rgba(179, 209, 255, 0)');
                
                new Chart(activityCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Réservations mensuelles',
                            data: activityData,
                            fill: true,
                            backgroundColor: gradient,
                            borderColor: '#3498db',
                            borderWidth: 4,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#3498db',
                            pointBorderWidth: 3,
                            pointRadius: 6,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { display: false },
                            x: {
                                grid: { display: false },
                                ticks: { 
                                    font: { family: 'inherit', weight: '600' }, 
                                    color: '#8e8288' 
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
                console.log('Graphique activité créé');
            }
        });
    </script>
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="margin: 0;">Mes Statistiques</h1>
        <a href="{{ route('statistics.index') }}" class="btn btn-primary" style="background: #2a2d4f; border-radius: 12px; padding: 0.6rem 1.5rem;">
            <i class="fas fa-chart-bar"></i> Vue Globale
        </a>
    </div>

    <div class="stats-grid">
        <div class="stat-card stat-card-blue">
            <div class="stat-label">Mes Réservations</div>
            <div class="stat-value text-primary">{{ $userStats['my_reservations_count'] }}</div>
        </div>
        <div class="stat-card stat-card-orange">
            <div class="stat-label">Incidents Signalés</div>
            <div class="stat-value text-danger">{{ $userStats['my_incidents_count'] }}</div>
        </div>
        <div class="stat-card stat-card-mint">
            <div class="stat-label">Taux d'Utilisation</div>
            <div class="stat-value text-success">{{ $userStats['usage_rate'] ?? 0 }}%</div>
            <div class="progress-bar-container">
                <div class="progress-bar-fill bg-success" style="width: {{ $userStats['usage_rate'] ?? 0 }}%;"></div>
            </div>
        </div>
    </div>

    <div class="charts-container" style="grid-template-columns: 1fr;">
        <div class="chart-card">
            <h3>Mon Activité</h3>
            <div class="chart-wrapper">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
.resources-container {
    padding: 1.5rem 0;
}

.resources-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
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
    grid-template-columns: 1fr;
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

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 0.6rem 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    color: white;
    text-decoration: none;
}
</style>
@endsection
