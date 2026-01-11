@extends('layouts.app') @section('content')
<div class="dashboard-container">
    
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-space-cadet">Mon Espace</h1>
            <p class="text-muted">Bienvenue, Chaymae (Utilisateur)</p>
        </div>
        <a href="{{ url('/reservations/create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nouvelle Réservation
        </a>
    </div>

    <div class="grid grid-3 mb-4">
        <div class="card p-4 border-left-primary">
            <div class="text-muted text-uppercase text-xs font-bold">Réservations Actives</div>
            <div class="text-2xl font-bold text-dark mt-1">2</div>
            <div class="text-xs text-success mt-1"><i class="fas fa-check"></i> En cours d'utilisation</div>
        </div>

        <div class="card p-4 border-left-warning">
            <div class="text-muted text-uppercase text-xs font-bold">En Attente</div>
            <div class="text-2xl font-bold text-dark mt-1">1</div>
            <div class="text-xs text-warning mt-1"><i class="fas fa-clock"></i> Validation requise</div>
        </div>

        <div class="card p-4 border-left-info">
            <div class="text-muted text-uppercase text-xs font-bold">Total Réservations</div>
            <div class="text-2xl font-bold text-dark mt-1">14</div>
            <div class="text-xs text-muted mt-1">Depuis janvier</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom p-3 d-flex justify-between">
            <h3 class="m-0 text-lg">Mes Réservations Récentes</h3>
            <a href="#" class="text-sm text-primary">Voir tout l'historique</a>
        </div>
        <div class="card-body p-0">
            <table class="table w-100">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="p-3 text-left">Ressource</th>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-left">Statut</th> <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-bottom">
                        <td class="p-3">
                            <div class="font-bold">Serveur Dell PowerEdge</div>
                            <div class="text-xs text-muted">CPU: 64 Cores - RAM: 128Go</div>
                        </td>
                        <td class="p-3">12 Jan - 14 Jan 2026</td>
                        <td class="p-3"><span class="badge badge-warning">En attente</span></td>
                        <td class="p-3 text-right">
                            <button class="btn btn-sm btn-outline-danger">Annuler</button>
                        </td>
                    </tr>
                    
                    <tr class="border-bottom">
                        <td class="p-3">
                            <div class="font-bold">VM Ubuntu Cluster 2</div>
                            <div class="text-xs text-muted">Pour projet Big Data</div>
                        </td>
                        <td class="p-3">05 Jan - 10 Jan 2026</td>
                        <td class="p-3"><span class="badge badge-success">Approuvée</span></td>
                        <td class="p-3 text-right">
                            <button class="btn btn-sm btn-outline-primary">Détails</button>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3">
                            <div class="font-bold">Baie de Stockage SAN</div>
                            <div class="text-xs text-muted">50 TB</div>
                        </td>
                        <td class="p-3">01 Jan - 02 Jan 2026</td>
                        <td class="p-3"><span class="badge badge-danger">Refusée</span></td>
                        <td class="p-3 text-right">
                            <button class="btn btn-sm btn-outline-secondary">Voir motif</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection