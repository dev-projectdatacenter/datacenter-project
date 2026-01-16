{{-- resources/views/statistics/my-resources.blade.php --}}
@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/statistics.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header">
        <h1>Mes Statistiques</h1>
        <a href="{{ route('statistics.index') }}" class="btn">Vue Globale</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Mes Réservations</div>
            <div class="stat-value">{{ $userStats['my_reservations_count'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Incidents Signalés</div>
            <div class="stat-value text-danger">{{ $userStats['my_incidents_count'] }}</div>
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

@push('scripts')
    <script src="{{ asset('js/statistics.js') }}" defer></script>
@endpush
@endsection
