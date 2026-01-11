@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-space-cadet">Gestion des Ressources</h1>
            <p class="text-muted">Espace Responsable Technique (Zone Cluster A)</p>
        </div>
        <div>
            <span class="badge badge-success">Systèmes Opérationnels : 98%</span>
        </div>
    </div>

    <div class="grid grid-3 mb-4">
        <div class="card p-4 border-left-warning shadow-sm">
            <div class="d-flex justify-between align-center">
                <div>
                    <div class="text-muted text-uppercase text-xs font-bold">Demandes en attente</div>
                    <div class="text-2xl font-bold text-dark mt-1">4</div>
                </div>
                <div class="icon-circle bg-warning-light text-warning">
                    <i class="fas fa-inbox"></i>
                </div>
            </div>
            <div class="text-xs text-muted mt-2">Nécessite votre validation</div>
        </div>

        <div class="card p-4 border-left-info shadow-sm">
            <div class="d-flex justify-between align-center">
                <div>
                    <div class="text-muted text-uppercase text-xs font-bold">Allocations Actives</div>
                    <div class="text-2xl font-bold text-dark mt-1">18</div>
                </div>
                <div class="icon-circle bg-info-light text-info">
                    <i class="fas fa-server"></i>
                </div>
            </div>
            <div class="text-xs text-muted mt-2">Sur 25 machines disponibles</div>
        </div>

        <div class="card p-4 border-left-danger shadow-sm">
            <div class="d-flex justify-between align-center">
                <div>
                    <div class="text-muted text-uppercase text-xs font-bold">Incidents / Maintenance</div>
                    <div class="text-2xl font-bold text-dark mt-1">1</div>
                </div>
                <div class="icon-circle bg-danger-light text-danger">
                    <i class="fas fa-tools"></i>
                </div>
            </div>
            <div class="text-xs text-danger mt-2">Serveur S-04 (Surchauffe)</div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header border-bottom p-3">
            <h3 class="m-0 text-lg">Dernières demandes reçues</h3>
        </div>
        <div class="card-body p-0">
            <table class="table w-100">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="p-3 text-left">Demandeur</th>
                        <th class="p-3 text-left">Ressource demandée</th>
                        <th class="p-3 text-left">Période</th>
                        <th class="p-3 text-left">Motif</th>
                        <th class="p-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-bottom">
                        <td class="p-3">
                            <div class="font-bold">Ahmed Etudiant</div>
                            <div class="text-xs text-muted">Doctorant</div>
                        </td>
                        <td class="p-3">GPU Cluster (Nvidia A100)</td>
                        <td class="p-3">15 Jan - 20 Jan</td>
                        <td class="p-3 text-sm">"Entraînement modèle IA"</td>
                        <td class="p-3 text-right">
                            <button class="btn btn-sm btn-success mr-1" title="Approuver"><i class="fas fa-check"></i></button>
                            <button class="btn btn-sm btn-danger" title="Refuser"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3">
                            <div class="font-bold">Sarah Ingénieur</div>
                            <div class="text-xs text-muted">Département IT</div>
                        </td>
                        <td class="p-3">Serveur Web (Linux)</td>
                        <td class="p-3">16 Jan - 17 Jan</td>
                        <td class="p-3 text-sm">"Test déploiement App"</td>
                        <td class="p-3 text-right">
                             <button class="btn btn-sm btn-success mr-1"><i class="fas fa-check"></i></button>
                             <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="text-lg font-bold mb-3 mt-4">État du parc matériel</h3>
    <div class="grid grid-2">
        <div class="card p-3 d-flex justify-between align-center">
            <div>
                <strong>Serveur Rack A1</strong>
                <div class="text-xs text-success">En ligne - Charge 45%</div>
            </div>
            <button class="btn btn-sm btn-outline-secondary">Détails</button>
        </div>
        <div class="card p-3 d-flex justify-between align-center border-left-danger">
            <div>
                <strong>Serveur Rack A2</strong>
                <div class="text-xs text-danger">Hors ligne (Maintenance)</div>
            </div>
            <button class="btn btn-sm btn-danger">Relancer</button>
        </div>
    </div>

</div>
@endsection