{{-- resources/views/statistics/index.blade.php --}}
@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/statistics.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/charts.js') }}"></script>
    <script src="{{ asset('js/statistics.js') }}" defer></script>
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
                <canvas id="categoryChart" 
                        data-labels='{!! json_encode($categoryDistribution->pluck("name")) !!}'
                        data-values='{!! json_encode($categoryDistribution->pluck("resources_count")) !!}'
                        data-colors='["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF"]'>
                </canvas>
            </div>
        </div>
        <div class="chart-card">
            <h3>Top Ressources</h3>
            <div class="chart-wrapper">
                <canvas id="topResourcesChart"
                        data-labels='{!! json_encode($topResources->pluck("name")) !!}'
                        data-values='{!! json_encode($topResources->pluck("reservations_count")) !!}'
                        data-colors='["#FF9F40", "#FF6384", "#C9CBCF", "#4BC0C0", "#36A2EB"]'>
                </canvas>
            </div>
        </div>
    </div>
</div>

@endsection
