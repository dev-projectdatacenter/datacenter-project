{{-- resources/views/statistics/index.blade.php --}}
@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/statistics.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header">
        <h1>Tableau de Bord Statistiques</h1>
        <a href="{{ route('statistics.my_resources') }}" class="btn btn-primary">Mes Stats</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Taux d'Occupation</div>
            <div class="stat-value text-success">{{ $generalStats['occupancy_rate'] }}%</div>
            <div class="progress-bar-container">
                <div class="progress-bar-fill bg-success" style="width: {{ $generalStats['occupancy_rate'] }}%;"></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Ressources</div>
            <div class="stat-value text-primary">{{ $generalStats['total_resources'] }}</div>
        </div>
        <div class="stat-card">
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
                        data-values='{!! json_encode($categoryDistribution->pluck("resources_count")) !!}'>
                </canvas>
            </div>
        </div>
        <div class="chart-card">
            <h3>Top Ressources</h3>
            <div class="chart-wrapper">
                <canvas id="topResourcesChart"
                        data-labels='{!! json_encode($topResources->pluck("name")) !!}'
                        data-values='{!! json_encode($topResources->pluck("reservations_count")) !!}'>
                </canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/statistics.js') }}" defer></script>
@endpush
@endsection
