@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-space-cadet">Statistiques & Reporting</h1>
            <p class="text-muted">Analysez l'utilisation des ressources du Data Center.</p>
        </div>
        <div class="card p-1 d-flex align-center" style="border-radius: 50px;">
            <button class="btn btn-sm btn-primary rounded-pill">7 Jours</button>
            <button class="btn btn-sm text-muted">30 Jours</button>
            <button class="btn btn-sm text-muted">Année</button>
        </div>
    </div>

    <div class="grid grid-4 mb-4" style="gap: 1.5rem;">
        
        <div class="card p-4 border-left-primary">
            <div class="text-muted text-xs font-bold uppercase mb-1">Taux d'occupation</div>
            <div class="d-flex justify-between align-center">
                <h2 class="text-2xl font-bold text-dark">78%</h2>
                <i class="fas fa-server text-gray-300 fa-2x opacity-25"></i>
            </div>
            <div class="text-xs text-success mt-2"><i class="fas fa-arrow-up"></i> +5% cette semaine</div>
        </div>

        <div class="card p-4 border-left-success">
            <div class="text-muted text-xs font-bold uppercase mb-1">Réservations Actives</div>
            <div class="d-flex justify-between align-center">
                <h2 class="text-2xl font-bold text-dark">12</h2>
                <i class="fas fa-calendar-check text-gray-300 fa-2x opacity-25"></i>
            </div>
            <div class="text-xs text-muted mt-2">Sur 45 slots disponibles</div>
        </div>

        <div class="card p-4 border-left-warning">
            <div class="text-muted text-xs font-bold uppercase mb-1">Demandes en attente</div>
            <div class="d-flex justify-between align-center">
                <h2 class="text-2xl font-bold text-dark">3</h2>
                <i class="fas fa-clock text-gray-300 fa-2x opacity-25"></i>
            </div>
            <div class="text-xs text-warning mt-2">Action requise</div>
        </div>

        <div class="card p-4 border-left-danger">
            <div class="text-muted text-xs font-bold uppercase mb-1">Incidents</div>
            <div class="d-flex justify-between align-center">
                <h2 class="text-2xl font-bold text-dark">1</h2>
                <i class="fas fa-exclamation-triangle text-gray-300 fa-2x opacity-25"></i>
            </div>
            <div class="text-xs text-muted mt-2">Résolus: 4</div>
        </div>
    </div>

    <div class="grid grid-2 mb-4" style="gap: 1.5rem;">
        
        <div class="card p-4">
            <h3 class="font-bold text-lg mb-4 text-space-cadet">Évolution des Réservations</h3>
            <div class="bg-light w-100 d-flex align-center justify-center text-muted" style="height: 300px; border-radius: 8px; border: 2px dashed #ccc;">
                <div class="text-center">
                    <i class="fas fa-chart-line fa-3x mb-2"></i>
                    <p>Zone pour Graphique (Chart.js)</p>
                    <small>Données mensuelles</small>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <h3 class="font-bold text-lg mb-4 text-space-cadet">Répartition par Département</h3>
            <div class="bg-light w-100 d-flex align-center justify-center text-muted" style="height: 300px; border-radius: 8px; border: 2px dashed #ccc;">
                <div class="text-center">
                    <i class="fas fa-chart-pie fa-3x mb-2"></i>
                    <p>Zone pour Graphique Circulaire</p>
                    <small>Info / Elec / Méca</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="p-4 border-bottom">
            <h3 class="font-bold text-lg text-space-cadet">Top 5 - Utilisateurs les plus actifs</h3>
        </div>
        <table class="table w-100">
            <thead class="bg-light">
                <tr>
                    <th class="p-3 text-left">Utilisateur</th>
                    <th class="p-3 text-left">Département</th>
                    <th class="p-3 text-left">Heures de calcul</th>
                    <th class="p-3 text-right">Nombre de réservations</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-bottom">
                    <td class="p-3 font-bold">Ahmed Kamal</td>
                    <td class="p-3">Big Data Lab</td>
                    <td class="p-3">120h</td>
                    <td class="p-3 text-right">15</td>
                </tr>
                <tr class="border-bottom">
                    <td class="p-3 font-bold">Sarah Engineer</td>
                    <td class="p-3">Génie Électrique</td>
                    <td class="p-3">85h</td>
                    <td class="p-3 text-right">8</td>
                </tr>
                <tr>
                    <td class="p-3 font-bold">Karim Doctorant</td>
                    <td class="p-3">IA & Systèmes</td>
                    <td class="p-3">60h</td>
                    <td class="p-3 text-right">12</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<style>
    /* Petites classes utilitaires pour les bordures de couleur des cartes */
    .border-left-primary { border-left: 4px solid var(--primary); }
    .border-left-success { border-left: 4px solid var(--success); }
    .border-left-warning { border-left: 4px solid var(--warning); }
    .border-left-danger { border-left: 4px solid var(--danger); }
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
</style>
@endsection