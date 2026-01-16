@extends('layouts.app')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: start;">
        <div>
            <h1>Mes Statistiques</h1>
            <p style="color: #666;">Aperçu de votre activité et de vos ressources réservées.</p>
        </div>
        <a href="{{ route('statistics.index') }}" style="color: #3498db; text-decoration: none; font-weight: bold;">Vue Globale &rarr;</a>
    </div>

    {{-- Chiffres Clés Personnels --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd; text-align: center; border-left: 5px solid #3498db;">
            <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Mes Réservations</div>
            <div style="font-size: 2.5rem; font-weight: bold; color: #2c3e50;">{{ $userStats['my_reservations_count'] }}</div>
        </div>
        <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd; text-align: center; border-left: 5px solid #2ecc71;">
            <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Sessions Actives</div>
            <div style="font-size: 2.5rem; font-weight: bold; color: #2c3e50;">{{ $userStats['my_active_reservations'] }}</div>
        </div>
        <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd; text-align: center; border-left: 5px solid #e74c3c;">
            <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Incidents Signalés</div>
            <div style="font-size: 2.5rem; font-weight: bold; color: #2c3e50;">{{ $userStats['my_incidents_count'] }}</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
        {{-- Graphique d'activité (Simulation de ligne) --}}
        <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd;">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem;">Activité sur les 7 derniers jours</h3>
            <div style="height: 350px;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>

    <div style="margin-top: 2rem; text-align: center;">
        <a href="{{ route('resources.index') }}" style="color: #666; text-decoration: none;">&larr; Retour à la gestion</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simulation de données d'activité pour les 7 derniers jours
        const labels = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        const data = [1, 3, 2, 5, 4, 2, 3]; // Exemple de données

        if (typeof DataCenterCharts !== 'undefined') {
            DataCenterCharts.createLineChart('activityChart', labels, data, 'Heures d\'utilisation');
        }
    });
</script>
@endsection
