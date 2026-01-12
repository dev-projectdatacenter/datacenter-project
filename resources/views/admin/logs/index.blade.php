@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-space-cadet">Journal d'activité (Logs)</h1>
            <p class="text-muted">Historique complet des actions et incidents système.</p>
        </div>
        <button class="btn btn-outline bg-white text-dark border">
            <i class="fas fa-file-csv"></i> Exporter CSV
        </button>
    </div>

    <div class="card p-3 mb-4 bg-light border-0">
        <div class="d-flex gap-3 align-center">
            <div style="flex: 1;">
                <label class="text-xs font-bold text-muted uppercase">Recherche</label>
                <input type="text" class="form-control" placeholder="Utilisateur, IP, ID Ressource...">
            </div>
            <div style="width: 150px;">
                <label class="text-xs font-bold text-muted uppercase">Niveau</label>
                <select class="form-control">
                    <option>Tous</option>
                    <option>INFO</option>
                    <option>WARNING</option>
                    <option>DANGER</option>
                </select>
            </div>
            <div style="width: 180px;">
                <label class="text-xs font-bold text-muted uppercase">Date</label>
                <input type="date" class="form-control">
            </div>
            <div class="d-flex align-end">
                <button class="btn btn-primary h-100" style="margin-top: 0.4rem;">Filtrer</button>
            </div>
        </div>
    </div>

    <div class="card p-0 overflow-hidden shadow-sm">
        <table class="table w-100" style="font-size: 0.9rem;">
            <thead class="bg-space-cadet text-white">
                <tr>
                    <th class="p-3 text-left">Horodatage</th>
                    <th class="p-3 text-left">Niveau</th>
                    <th class="p-3 text-left">Utilisateur</th>
                    <th class="p-3 text-left">Action / Message</th>
                    <th class="p-3 text-left">IP Source</th>
                    <th class="p-3 text-right">Détails</th>
                </tr>
            </thead>
            <tbody class="font-mono"> <tr class="border-bottom bg-red-light">
                    <td class="p-3 text-muted">2026-01-12 10:45:22</td>
                    <td class="p-3"><span class="badge badge-danger">DANGER</span></td>
                    <td class="p-3 font-bold">Système</td>
                    <td class="p-3 text-danger">Échec sauvegarde automatique DB</td>
                    <td class="p-3 text-muted">127.0.0.1</td>
                    <td class="p-3 text-right"><i class="fas fa-search cursor-pointer"></i></td>
                </tr>

                <tr class="border-bottom">
                    <td class="p-3 text-muted">2026-01-12 09:30:15</td>
                    <td class="p-3"><span class="badge badge-warning">WARNING</span></td>
                    <td class="p-3">Chaymae Admin</td>
                    <td class="p-3">Suppression Ressource #RES-003</td>
                    <td class="p-3 text-muted">192.168.1.15</td>
                    <td class="p-3 text-right"><i class="fas fa-search cursor-pointer"></i></td>
                </tr>

                <tr class="border-bottom">
                    <td class="p-3 text-muted">2026-01-12 08:00:01</td>
                    <td class="p-3"><span class="badge badge-success">INFO</span></td>
                    <td class="p-3">Ahmed Kamal</td>
                    <td class="p-3">Connexion réussie (Login)</td>
                    <td class="p-3 text-muted">10.0.0.45</td>
                    <td class="p-3 text-right"><i class="fas fa-search cursor-pointer"></i></td>
                </tr>

                <tr class="border-bottom">
                    <td class="p-3 text-muted">2026-01-11 18:22:10</td>
                    <td class="p-3"><span class="badge badge-primary">UPDATE</span></td>
                    <td class="p-3">Sarah Engineer</td>
                    <td class="p-3">Modification profil utilisateur</td>
                    <td class="p-3 text-muted">192.168.1.20</td>
                    <td class="p-3 text-right"><i class="fas fa-search cursor-pointer"></i></td>
                </tr>

                <tr class="border-bottom">
                    <td class="p-3 text-muted">2026-01-11 14:05:00</td>
                    <td class="p-3"><span class="badge badge-warning">AUTH</span></td>
                    <td class="p-3 text-muted">Inconnu</td>
                    <td class="p-3">Mot de passe incorrect (3 tentatives)</td>
                    <td class="p-3 text-muted">45.23.12.99</td>
                    <td class="p-3 text-right"><i class="fas fa-search cursor-pointer"></i></td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="mt-3 text-center text-xs text-muted">
        Affichage des 50 derniers événements sur 14,203 entrées.
    </div>

</div>

<style>
    /* Style spécifique pour la page Logs */
    .font-mono { font-family: 'Courier New', Courier, monospace; }
    .bg-red-light { background-color: #fff5f5; }
    .badge-primary { background-color: #3498db; color: white; }
    .cursor-pointer { cursor: pointer; color: var(--primary); }
</style>
@endsection