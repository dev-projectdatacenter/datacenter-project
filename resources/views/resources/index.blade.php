@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-space-cadet">Gestion de l'Inventaire</h1>
            <p class="text-muted">Liste administrative de toutes les ressources.</p>
        </div>
        <a href="{{ url('/resources/create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un équipement
        </a>
    </div>

    <div class="card p-0 overflow-hidden">
        <table class="table w-100">
            <thead class="bg-light border-bottom">
                <tr>
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Nom de la ressource</th>
                    <th class="p-3 text-left">Catégorie</th>
                    <th class="p-3 text-left">Localisation</th>
                    <th class="p-3 text-left">Statut</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-bottom">
                    <td class="p-3 text-muted">#RES-001</td>
                    <td class="p-3 font-bold text-space-cadet">Dell PowerEdge R740</td>
                    <td class="p-3"><span class="badge bg-light text-dark border">Serveur Physique</span></td>
                    <td class="p-3 text-sm">Rack A1 - Salle B</td>
                    <td class="p-3"><span class="badge badge-success">Disponible</span></td>
                    <td class="p-3 text-right">
                        <a href="{{ url('/resources/1') }}" class="btn btn-sm btn-outline-primary" title="Voir"><i class="fas fa-eye"></i></a>
                        <button class="btn btn-sm btn-outline-secondary" title="Éditer"><i class="fas fa-pen"></i></button>
                        <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>

                <tr class="border-bottom">
                    <td class="p-3 text-muted">#RES-002</td>
                    <td class="p-3 font-bold text-space-cadet">VM Ubuntu Cluster AI</td>
                    <td class="p-3"><span class="badge bg-light text-dark border">Machine Virtuelle</span></td>
                    <td class="p-3 text-sm">Cluster Node 04</td>
                    <td class="p-3"><span class="badge badge-warning">Occupé</span></td>
                    <td class="p-3 text-right">
                        <a href="{{ url('/resources/1') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button>
                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>

                <tr>
                    <td class="p-3 text-muted">#RES-003</td>
                    <td class="p-3 font-bold text-space-cadet">Switch Cisco Core</td>
                    <td class="p-3"><span class="badge bg-light text-dark border">Réseau</span></td>
                    <td class="p-3 text-sm">Salle Serveur B</td>
                    <td class="p-3"><span class="badge badge-danger">Maintenance</span></td>
                    <td class="p-3 text-right">
                        <a href="{{ url('/resources/1') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button>
                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-end mt-3">
        <nav>
            <ul class="pagination">
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                <li class="page-item active"><span class="page-link">1</span></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
        </nav>
    </div>

</div>
@endsection