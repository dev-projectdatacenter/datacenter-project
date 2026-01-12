@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-space-cadet">Catalogue des Ressources</h1>
            <p class="text-muted">Explorez et réservez les équipements du Data Center.</p>
        </div>
        <button class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter un équipement</button>
    </div>

    <div class="card p-3 mb-4">
        <div class="grid grid-4" style="gap: 1rem; align-items: end;">
            
            <div class="form-group mb-0">
                <label class="form-label text-xs">Recherche rapide</label>
                <input type="text" class="form-control" placeholder="Ex: Serveur Dell, GPU...">
            </div>

            <div class="form-group mb-0">
                <label class="form-label text-xs">Catégorie</label>
                <select class="form-control">
                    <option value="">Toutes les catégories</option>
                    <option value="serveur">Serveurs Physiques</option>
                    <option value="vm">Machines Virtuelles (VM)</option>
                    <option value="stockage">Stockage / NAS</option>
                    <option value="reseau">Équipements Réseau</option>
                </select>
            </div>

            <div class="form-group mb-0">
                <label class="form-label text-xs">Disponibilité</label>
                <select class="form-control">
                    <option value="">Tout voir</option>
                    <option value="dispo">✅ Disponible</option>
                    <option value="occupe">⚠️ Réservé / Occupé</option>
                    <option value="maintenance">❌ En Maintenance</option>
                </select>
            </div>

            <div>
                <button class="btn btn-outline w-100" style="border: 1px solid var(--border-color);">
                    <i class="fas fa-filter"></i> Appliquer
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-3">

        <div class="card p-0 overflow-hidden shadow-sm h-100">
            <div style="height: 6px; background-color: var(--success);"></div>
            <div class="p-4">
                <div class="d-flex justify-between align-start mb-2">
                    <div class="icon-box bg-light text-space-cadet p-2 rounded">
                        <i class="fas fa-server fa-2x"></i>
                    </div>
                    <span class="badge badge-success">Disponible</span>
                </div>
                
                <h3 class="text-lg font-bold mb-1">Dell PowerEdge R740</h3>
                <p class="text-xs text-muted font-bold mb-3">SERVEUR PHYSIQUE • RACK A1</p>
                
                <ul class="text-sm text-muted mb-4" style="list-style: none; padding: 0;">
                    <li class="mb-1"><i class="fas fa-microchip w-5"></i> 2x Intel Xeon Gold (48 Cores)</li>
                    <li class="mb-1"><i class="fas fa-memory w-5"></i> 256 Go RAM DDR4</li>
                    <li class="mb-1"><i class="fas fa-hdd w-5"></i> 4x 2To SSD NVMe</li>
                </ul>

                <div class="d-flex gap-2">
                    <a href="{{ url('/resources/1') }}" class="btn btn-outline w-100 text-xs" style="border: 1px solid var(--border-color);">Détails</a>
                    <a href="{{ url('/reservations/create') }}" class="btn btn-primary w-100 text-xs">Réserver</a>
                </div>
            </div>
        </div>

        <div class="card p-0 overflow-hidden shadow-sm h-100">
            <div style="height: 6px; background-color: var(--warning);"></div>
            <div class="p-4">
                <div class="d-flex justify-between align-start mb-2">
                    <div class="icon-box bg-light text-primary p-2 rounded">
                        <i class="fas fa-cloud fa-2x"></i>
                    </div>
                    <span class="badge badge-warning">Occupé</span>
                </div>
                
                <h3 class="text-lg font-bold mb-1">VM Ubuntu Cluster AI</h3>
                <p class="text-xs text-muted font-bold mb-3">VIRTUALISATION • NODE 04</p>
                
                <ul class="text-sm text-muted mb-4" style="list-style: none; padding: 0;">
                    <li class="mb-1"><i class="fas fa-microchip w-5"></i> vCPU 16 Cores</li>
                    <li class="mb-1"><i class="fas fa-memory w-5"></i> 64 Go RAM</li>
                    <li class="mb-1"><i class="fab fa-linux w-5"></i> Ubuntu 22.04 LTS</li>
                </ul>

                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline w-100 text-xs" style="border: 1px solid var(--border-color);">Détails</a>
                    <button class="btn btn-outline-secondary w-100 text-xs" disabled title="Disponible le 15 Jan">File d'attente</button>
                </div>
            </div>
        </div>

        <div class="card p-0 overflow-hidden shadow-sm h-100" style="opacity: 0.8;">
            <div style="height: 6px; background-color: var(--danger);"></div>
            <div class="p-4">
                <div class="d-flex justify-between align-start mb-2">
                    <div class="icon-box bg-light text-danger p-2 rounded">
                        <i class="fas fa-tools fa-2x"></i>
                    </div>
                    <span class="badge badge-danger">Maintenance</span>
                </div>
                
                <h3 class="text-lg font-bold mb-1">Switch Cisco Core</h3>
                <p class="text-xs text-muted font-bold mb-3">RÉSEAU • SALLE B</p>
                
                <ul class="text-sm text-muted mb-4" style="list-style: none; padding: 0;">
                    <li class="mb-1"><i class="fas fa-network-wired w-5"></i> 48 Ports 10GbE</li>
                    <li class="mb-1"><i class="fas fa-shield-alt w-5"></i> VLAN Configuré</li>
                    <li class="mb-1 text-danger"><i class="fas fa-exclamation-circle w-5"></i> Panne ventilateur</li>
                </ul>

                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline w-100 text-xs" style="border: 1px solid var(--border-color);">Fiche technique</a>
                </div>
            </div>
        </div>

        <div class="card p-0 overflow-hidden shadow-sm h-100">
            <div style="height: 6px; background-color: var(--success);"></div>
            <div class="p-4">
                <div class="d-flex justify-between align-start mb-2">
                    <div class="icon-box bg-light text-space-cadet p-2 rounded">
                        <i class="fas fa-hdd fa-2x"></i>
                    </div>
                    <span class="badge badge-success">Disponible</span>
                </div>
                
                <h3 class="text-lg font-bold mb-1">NAS Synology Pro</h3>
                <p class="text-xs text-muted font-bold mb-3">STOCKAGE • RACK C2</p>
                
                <ul class="text-sm text-muted mb-4" style="list-style: none; padding: 0;">
                    <li class="mb-1"><i class="fas fa-database w-5"></i> 40 To RAID 5</li>
                    <li class="mb-1"><i class="fas fa-bolt w-5"></i> Accès Haut Débit</li>
                    <li class="mb-1"><i class="fas fa-lock w-5"></i> Chiffré AES-256</li>
                </ul>

                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline w-100 text-xs" style="border: 1px solid var(--border-color);">Détails</a>
                    <a href="{{ url('/reservations/create') }}" class="btn btn-primary w-100 text-xs">Réserver</a>
                </div>
            </div>
        </div>

    </div> <div class="d-flex justify-center mt-4">
        <ul class="pagination">
            <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </div>

</div>
@endsection