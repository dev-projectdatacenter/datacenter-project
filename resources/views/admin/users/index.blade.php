@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-space-cadet">Gestion des Utilisateurs</h1>
            <p class="text-muted">Gérez les comptes, les rôles et les permissions d'accès.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline bg-white text-muted" style="border: 1px solid var(--border-color);">
                <i class="fas fa-download"></i> Exporter
            </button>
            <button class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Nouvel Utilisateur
            </button>
        </div>
    </div>

    <div class="card p-3 mb-4">
        <div class="d-flex gap-3 align-center">
            <div style="flex: 1;">
                <input type="text" class="form-control" placeholder="Rechercher par nom, email...">
            </div>
            <select class="form-control" style="width: 200px;">
                <option>Tous les rôles</option>
                <option>Administrateur</option>
                <option>Responsable Technique</option>
                <option>Utilisateur Standard</option>
            </select>
            <select class="form-control" style="width: 200px;">
                <option>Statut: Actif</option>
                <option>Banni</option>
                <option>En attente</option>
            </select>
            <button class="btn btn-primary">Filtrer</button>
        </div>
    </div>

    <div class="card p-0 overflow-hidden">
        <table class="table w-100">
            <thead class="bg-light border-bottom">
                <tr>
                    <th class="p-3 text-left">Utilisateur</th>
                    <th class="p-3 text-left">Rôle</th>
                    <th class="p-3 text-left">Département</th>
                    <th class="p-3 text-left">Dernière connexion</th>
                    <th class="p-3 text-left">Statut</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                
                <tr class="border-bottom">
                    <td class="p-3">
                        <div class="d-flex align-center">
                            <div class="icon-circle bg-primary text-white mr-2 font-bold" style="width: 35px; height: 35px; font-size: 0.9rem;">CA</div>
                            <div>
                                <div class="font-bold text-space-cadet">Chaymae Admin</div>
                                <div class="text-xs text-muted">chaymae@datacenter.ma</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-3"><span class="badge badge-primary">Administrateur</span></td>
                    <td class="p-3 text-sm">Direction IT</td>
                    <td class="p-3 text-sm text-muted">Il y a 2 min</td>
                    <td class="p-3"><span class="badge badge-success">Actif</span></td>
                    <td class="p-3 text-right">
                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button>
                    </td>
                </tr>

                <tr class="border-bottom">
                    <td class="p-3">
                        <div class="d-flex align-center">
                            <div class="icon-circle bg-light text-dark mr-2 font-bold border" style="width: 35px; height: 35px; font-size: 0.9rem;">AK</div>
                            <div>
                                <div class="font-bold text-space-cadet">Ahmed Kamal</div>
                                <div class="text-xs text-muted">ahmed.k@univ.ma</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-3"><span class="badge badge-warning">Responsable</span></td>
                    <td class="p-3 text-sm">Labo Big Data</td>
                    <td class="p-3 text-sm text-muted">Hier, 18:30</td>
                    <td class="p-3"><span class="badge badge-success">Actif</span></td>
                    <td class="p-3 text-right">
                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button>
                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-ban"></i></button>
                    </td>
                </tr>

                <tr class="border-bottom">
                    <td class="p-3">
                        <div class="d-flex align-center">
                            <div class="icon-circle bg-light text-dark mr-2 font-bold border" style="width: 35px; height: 35px; font-size: 0.9rem;">LS</div>
                            <div>
                                <div class="font-bold text-space-cadet">Leila Sarah</div>
                                <div class="text-xs text-muted">leila.s@etudiant.ma</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-3"><span class="badge bg-light text-dark border">Utilisateur</span></td>
                    <td class="p-3 text-sm">Génie Info</td>
                    <td class="p-3 text-sm text-muted">10 Jan 2026</td>
                    <td class="p-3"><span class="badge badge-danger">Bloqué</span></td> <td class="p-3 text-right">
                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button>
                        <button class="btn btn-sm btn-outline-success" title="Débloquer"><i class="fas fa-unlock"></i></button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="d-flex justify-between align-center mt-3">
        <div class="text-xs text-muted">Affichage de 1 à 3 sur 45 utilisateurs</div>
        <nav>
            <ul class="pagination">
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                <li class="page-item active"><span class="page-link">1</span></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
        </nav>
    </div>

</div>
@endsection