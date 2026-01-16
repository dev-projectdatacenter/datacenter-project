@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 2rem;">
        <div>
            <h1>Statistiques du Data Center</h1>
            <p style="color: #666;">Aperçu en temps réel de l'état et de l'utilisation de vos infrastructures.</p>
        </div>
        <a href="{{ route('statistics.my_resources') }}" class="btn" style="background: #2ecc71; color: white; padding: 0.6rem 1.2rem; border-radius: 4px; text-decoration: none; font-weight: bold;">Mes Statistiques &rarr;</a>
    </div>

    {{-- Chiffres Clés --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd; text-align: center;">
            <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Taux d'Occupation</div>
            <div style="font-size: 2rem; font-weight: bold; color: #2ecc71;">{{ $generalStats['occupancy_rate'] }}%</div>
            <div style="margin-top: 10px; background: #eee; height: 8px; border-radius: 4px; overflow: hidden;">
                <div style="background: #2ecc71; height: 100%; width: {{ $generalStats['occupancy_rate'] }}%;"></div>
            </div>
        </div>
        <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd; text-align: center;">
            <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Total Ressources</div>
            <div style="font-size: 2rem; font-weight: bold; color: #3498db;">{{ $generalStats['total_resources'] }}</div>
            <div style="font-size: 0.8rem; color: #999;">Équipements actifs</div>
        </div>
        <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd; text-align: center;">
            <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Incidents Ouverts</div>
            <div style="font-size: 2rem; font-weight: bold; color: #e74c3c;">{{ $healthStats['open_incidents'] }}</div>
            <div style="font-size: 0.8rem; color: #999;">Sur {{ $healthStats['total_incidents'] }} signalés</div>
        </div>
        <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd; text-align: center;">
            <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Maintenances</div>
            <div style="font-size: 2rem; font-weight: bold; color: #f39c12;">{{ $healthStats['active_maintenances'] }}</div>
            <div style="font-size: 0.8rem; color: #999;">En cours d'exécution</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
        {{-- Répartition par catégorie (Camembert) --}}
        <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd;">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem; text-align: center;">Répartition par Catégorie</h3>
            <div style="height: 300px;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        {{-- Top Ressources (Barres) --}}
        <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd;">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem; text-align: center;">Top 5 Ressources les plus réservées</h3>
            <div style="height: 300px;">
                <canvas id="topResourcesChart"></canvas>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 2rem; text-align: center; display: flex; justify-content: center; gap: 1rem;">
        <a href="{{ route('statistics.index') }}" class="btn" style="background: #3498db; color: white; padding: 0.6rem 1.2rem; border-radius: 4px; text-decoration: none; font-weight: bold;">Actualiser</a>
        <a href="{{ route('resources.index') }}" style="color: #666; text-decoration: none; padding-top: 0.6rem;">&larr; Retour à la gestion</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Données pour les catégories
        const catLabels = {!! json_encode($categoryDistribution->pluck('name')) !!};
        const catData = {!! json_encode($categoryDistribution->pluck('resources_count')) !!};
        
        // Données pour le top ressources
        const resLabels = {!! json_encode($topResources->pluck('name')) !!};
        const resData = {!! json_encode($topResources->pluck('reservations_count')) !!};

        // Initialisation des graphiques via notre helper charts.js
        if (typeof DataCenterCharts !== 'undefined') {
            DataCenterCharts.createPieChart('categoryChart', catLabels, catData, 'Équipements');
            DataCenterCharts.createBarChart('topResourcesChart', resLabels, resData, 'Réservations');
        }
    });
</script>
@endsection
