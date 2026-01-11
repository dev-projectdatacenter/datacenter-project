@extends('layouts.app')

@section('content')
    <div class="d-flex justify-between items-center mb-4">
        <h1>Page de Test du Design System</h1>
        <button class="btn btn-primary">
            + Créer une ressource
        </button>
    </div>

   

    <div class="grid grid-3 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-between">
                <span>Serveurs</span>
                <span class="badge badge-success">Actif</span>
            </div>
            <p class="text-muted">Gestion des serveurs physiques.</p>
            <div class="text-primary font-bold text-center" style="font-size: 2rem;">12</div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-between">
                <span>Réservations</span>
                <span class="badge badge-warning">En attente</span>
            </div>
            <p class="text-muted">Demandes à valider.</p>
            <div class="text-center" style="font-size: 2rem;">5</div>
        </div>

        <div class="card">
            <div class="card-header">
                <span>Alertes</span>
            </div>
            <p class="text-danger">Température critique salle B.</p>
            <button class="btn btn-danger w-100 mt-2">Voir l'incident</button>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Liste des Utilisateurs </div>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Chayma</td>
                        <td>Chayma@gmail.ma</td>
                        <td><span class="badge badge-success">Admin</span></td>
                        <td class="td-actions">
                            <button class="btn btn-primary p-1">Modifier</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Fatima Zahrae</td>
                        <td>fatimaZahrae@gmail.ma</td>
                        <td><span class="badge badge-success">Utilisateur</span></td>
                        <td class="td-actions">
                            <button class="btn btn-primary p-1">Modifier</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Ouarda</td>
                        <td>Ouarda@gmail.ma</td>
                        <td><span class="badge badge-success">Utilisateur</span></td>
                        <td class="td-actions">
                            <button class="btn btn-primary p-1">Modifier</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Halima</td>
                        <td>Halima@gmail.ma</td>
                        <td><span class="badge badge-success">Utilisateur</span></td>
                        <td class="td-actions">
                            <button class="btn btn-primary p-1">Modifier</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Fatima</td>
                        <td>Fatima@gmail.ma</td>
                        <td><span class="badge badge-success">Utilisateur</span></td>
                        <td class="td-actions">
                            <button class="btn btn-primary p-1">Modifier</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection