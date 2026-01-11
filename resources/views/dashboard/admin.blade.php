@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-space-cadet">Administration Globale</h1>
            <p class="text-muted">Supervision du Data Center & Gestion des Accès</p>
        </div>
        <div class="d-flex align-center">
            <span class="text-sm text-muted mr-1">Dernière sauvegarde : 10:00 AM</span>
            <button class="btn btn-primary btn-sm"><i class="fas fa-cog"></i> Paramètres</button>
        </div>
    </div>

    <div class="grid grid-4 mb-4">
        <div class="card p-3 shadow-sm border-left-primary">
            <div class="text-muted text-uppercase text-xs font-bold">Total Utilisateurs</div>
            <div class="text-2xl font-bold text-dark mt-1">142</div>
            <div class="text-xs text-success">+5 cette semaine</div>
        </div>
        <div class="card p-3 shadow-sm border-left-info">
            <div class="text-muted text-uppercase text-xs font-bold">Ressources Total</div>
            <div class="text-2xl font-bold text-dark mt-1">56</div>
            <div class="text-xs text-muted">Serveurs, VMs, Switchs</div>
        </div>
        <div class="card p-3 shadow-sm border-left-success">
            <div class="text-muted text-uppercase text-xs font-bold">Taux d'Occupation</div>
            <div class="text-2xl font-bold text-dark mt-1">68%</div>
            <div class="text-xs text-success">Optimal</div>
        </div>
        <div class="card p-3 shadow-sm border-left-danger">
            <div class="text-muted text-uppercase text-xs font-bold">Alertes Système</div>
            <div class="text-2xl font-bold text-dark mt-1">2</div>
            <div class="text-xs text-danger">Action requise</div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header border-bottom p-3 d-flex justify-between align-center">
            <h3 class="m-0 text-lg">Utilisateurs & Droits</h3>
            <div>
                <input type="text" placeholder="Rechercher..." class="form-input" style="padding: 0.4rem; font-size: 0.9rem; width: 200px;">
                <button class="btn btn-sm btn-primary ml-1"><i class="fas fa-user-plus"></i> Ajouter</button>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table w-100">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="p-3 text-left">Utilisateur</th>
                        <th class="p-3 text-left">Rôle</th>
                        <th class="p-3 text-left">Statut</th>
                        <th class="p-3 text-left">Dernière activité</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-bottom">
                        <td class="p-3">
                            <div class="font-bold">Chaymae Admin</div>
                            <div class="text-xs text-muted">chaymae@datacenter.ma</div>
                        </td>
                        <td class="p-3"><span class="badge badge-primary">Administrateur</span></td>
                        <td class="p-3"><span class="text-success text-xs font-bold">● ACTIF</span></td>
                        <td class="p-3 text-sm text-muted">À l'instant</td>
                        <td class="p-3 text-right">
                            <button class="btn btn-sm btn-outline-secondary" disabled>Éditer</button>
                        </td>
                    </tr>
                    
                    <tr class="border-bottom">
                        <td class="p-3">
                            <div class="font-bold">Karim Tech</div>
                            <div class="text-xs text-muted">karim@tech.ma</div>
                        </td>
                        <td class="p-3"><span class="badge badge-info">Responsable</span></td>
                        <td class="p-3"><span class="text-success text-xs font-bold">● ACTIF</span></td>
                        <td class="p-3 text-sm text-muted">Il y a 2h</td>
                        <td class="p-3 text-right">
                            <button class="btn btn-sm btn-outline-primary">Gérer</button>
                        </td>
                    </tr>

                    <tr class="border-bottom">
                        <td class="p-3">
                            <div class="font-bold">Nouvel Inscrit</div>
                            <div class="text-xs text-muted">guest@gmail.com</div>
                        </td>
                        <td class="p-3"><span class="badge badge-warning">Invité</span></td>
                        <td class="p-3"><span class="text-warning text-xs font-bold">● EN ATTENTE</span></td>
                        <td class="p-3 text-sm text-muted">Hier</td>
                        <td class="p-3 text-right">
                            <button class="btn btn-sm btn-success mr-1"><i class="fas fa-check"></i> Valider</button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top text-center">
            <a href="#" class="text-sm text-primary font-bold">Voir tous les utilisateurs (142)</a>
        </div>
    </div>

    <div class="grid grid-2">
        <div class="card p-4">
            <h3 class="text-lg font-bold mb-2">Maintenance Planifiée</h3>
            <p class="text-muted text-sm mb-3">Gérer les périodes d'indisponibilité globale.</p>
            <div class="alert alert-warning mb-3" style="background: #fffbeb; border: 1px solid #fcd34d; color: #92400e; padding: 0.75rem; border-radius: 4px; font-size: 0.9rem;">
                <i class="fas fa-exclamation-triangle"></i> Maintenance Switch Core - Samedi 22h
            </div>
            <button class="btn btn-outline w-100" style="border: 1px solid var(--border-color);">Planifier une maintenance</button>
        </div>

        <div class="card p-4">
            <h3 class="text-lg font-bold mb-2">Catalogue des Ressources</h3>
            <p class="text-muted text-sm mb-3">Ajouter ou modifier les équipements disponibles.</p>
            <div class="d-flex align-center justify-between mb-2">
                <span>Serveurs Physiques</span>
                <span class="font-bold">12</span>
            </div>
            <div class="d-flex align-center justify-between mb-3">
                <span>Machines Virtuelles</span>
                <span class="font-bold">34</span>
            </div>
            <a href="#" class="btn btn-primary w-100">Gérer le catalogue</a>
        </div>
    </div>

</div>
@endsection