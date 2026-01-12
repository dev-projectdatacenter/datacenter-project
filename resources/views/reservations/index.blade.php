@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-space-cadet">Mes Réservations</h1>
            <p class="text-muted">Suivez l'état de vos demandes et votre historique.</p>
        </div>
        <a href="{{ url('/catalogue') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle" style="margin-right: 8px;"></i> Nouvelle demande
        </a>
    </div>

    <div class="mb-4" style="border-bottom: 1px solid var(--border-color);">
        <button class="btn btn-sm" style="border-bottom: 2px solid var(--primary); color: var(--primary); border-radius: 0; background: transparent;">Toutes (14)</button>
        <button class="btn btn-sm" style="color: var(--text-muted); background: transparent;">En attente (1)</button>
        <button class="btn btn-sm" style="color: var(--text-muted); background: transparent;">Actives (2)</button>
        <button class="btn btn-sm" style="color: var(--text-muted); background: transparent;">Terminées (10)</button>
    </div>

    <div class="card p-0 overflow-hidden">
        <table class="table w-100">
            <thead class="bg-light text-muted">
                <tr>
                    <th class="p-3 text-left">Ressource</th>
                    <th class="p-3 text-left">Période</th>
                    <th class="p-3 text-left">Durée</th>
                    <th class="p-3 text-left">Statut</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                
                <tr class="border-bottom">
                    <td class="p-3">
                        <div class="d-flex align-center">
                            <div class="icon-circle bg-light text-primary shadow-sm mr-1" style="width: 32px; height: 32px; font-size: 0.9rem;">
                                <i class="fas fa-server"></i>
                            </div>
                            <div>
                                <div class="font-bold text-dark">Dell PowerEdge R740</div>
                                <div class="text-xs text-muted">Pour : Analyse Big Data</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-3 text-sm">
                        <div>12 Jan 2026 - 10:00</div>
                        <div class="text-muted">14 Jan 2026 - 18:00</div>
                    </td>
                    <td class="p-3 text-sm">3 jours</td>
                    <td class="p-3">
                        <span class="badge badge-warning">En attente</span>
                    </td>
                    <td class="p-3 text-right">
                        <button class="btn btn-sm btn-outline-danger" style="border: 1px solid #fee2e2; color: #991b1b;">Annuler</button>
                    </td>
                </tr>

                <tr class="border-bottom" style="background-color: #f0fdf4;"> <td class="p-3">
                        <div class="d-flex align-center">
                            <div class="icon-circle bg-white text-success shadow-sm mr-1" style="width: 32px; height: 32px; font-size: 0.9rem;">
                                <i class="fas fa-cloud"></i>
                            </div>
                            <div>
                                <div class="font-bold text-dark">VM Ubuntu Cluster 2</div>
                                <div class="text-xs text-muted">Pour : Projet IA</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-3 text-sm">
                        <div class="font-bold text-success">Maintenant</div>
                        <div class="text-muted">Fin : 10 Jan 2026</div>
                    </td>
                    <td class="p-3 text-sm">5 jours</td>
                    <td class="p-3">
                        <span class="badge badge-success">Active</span>
                    </td>
                    <td class="p-3 text-right">
                        <a href="{{ url('/resources/1') }}" class="btn btn-sm btn-outline-primary">Accéder</a>
                    </td>
                </tr>

                <tr class="border-bottom" style="opacity: 0.7;">
                    <td class="p-3">
                        <div class="d-flex align-center">
                            <div class="icon-circle bg-light text-muted mr-1" style="width: 32px; height: 32px; font-size: 0.9rem;">
                                <i class="fas fa-hdd"></i>
                            </div>
                            <div>
                                <div class="font-bold text-muted">Baie de Stockage SAN</div>
                                <div class="text-xs text-muted">Pour : Backup Mensuel</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-3 text-sm">01 Jan - 02 Jan</td>
                    <td class="p-3 text-sm">24h</td>
                    <td class="p-3">
                        <span class="badge badge-danger">Refusée</span>
                    </td>
                    <td class="p-3 text-right">
                        <button class="btn btn-sm btn-outline-secondary">Voir motif</button>
                    </td>
                </tr>

                <tr>
                    <td class="p-3">
                        <div class="d-flex align-center">
                            <div class="icon-circle bg-light text-muted mr-1" style="width: 32px; height: 32px; font-size: 0.9rem;">
                                <i class="fas fa-network-wired"></i>
                            </div>
                            <div>
                                <div class="font-bold text-dark">Switch Cisco Lab</div>
                                <div class="text-xs text-muted">Pour : TP Réseau</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-3 text-sm">15 Déc - 16 Déc 2025</td>
                    <td class="p-3 text-sm">2 jours</td>
                    <td class="p-3">
                        <span class="badge" style="background: #e2e8f0; color: #475569;">Terminée</span>
                    </td>
                    <td class="p-3 text-right">
                        <button class="btn btn-sm btn-outline w-100" style="border: 1px solid var(--border-color);">Relancer</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-center mt-4">
        <ul class="pagination">
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
        </ul>
    </div>

</div>
@endsection