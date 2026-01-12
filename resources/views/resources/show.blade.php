@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="mb-4" style="font-size: 0.9rem; color: var(--text-muted);">
        <a href="{{ url('/catalogue') }}" style="color: var(--text-muted);">Catalogue</a> 
        <span style="margin: 0 5px;">/</span> 
        <span style="color: var(--text-main); font-weight: bold;">Dell PowerEdge R740</span>
    </div>

    <div class="card p-4 mb-4" style="border-left: 5px solid var(--success);">
        <div class="d-flex justify-between align-center">
            <div class="d-flex align-center" style="gap: 1.5rem;">
                <div style="background-color: var(--bg-body); padding: 1.5rem; border-radius: var(--radius); color: var(--space-cadet); font-size: 2.5rem;">
                    <i class="fas fa-server"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-space-cadet m-0" style="margin-bottom: 0.25rem;">Dell PowerEdge R740</h1>
                    <p class="text-muted m-0">Serveur Physique • Rack A1 • Asset ID: #SRV-001</p>
                </div>
            </div>
            <div style="text-align: right;">
                <span class="badge badge-success mb-1" style="font-size: 1rem; padding: 0.5rem 1rem;">Disponible</span>
                <div class="text-xs text-muted" style="margin-top: 0.5rem;">Dernière maintenance : 10/12/2025</div>
            </div>
        </div>
    </div>

    <div class="grid grid-3">
        
        <div class="span-2">
            
            <div class="card p-4 mb-4">
                <h3 class="text-lg font-bold mb-3 border-bottom pb-2">Caractéristiques Techniques</h3>
                
                <div class="grid grid-2" style="gap: 1.5rem;">
                    <div>
                        <div class="text-xs text-muted font-bold text-uppercase mb-1">Processeur (CPU)</div>
                        <div class="font-bold text-dark"><i class="fas fa-microchip" style="color: var(--primary); width: 20px;"></i> 2x Intel Xeon Gold</div>
                        <div class="text-sm text-muted">2.50 GHz, 48 Cores Total</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted font-bold text-uppercase mb-1">Mémoire (RAM)</div>
                        <div class="font-bold text-dark"><i class="fas fa-memory" style="color: var(--primary); width: 20px;"></i> 256 Go DDR4</div>
                        <div class="text-sm text-muted">ECC Registred (Extensible)</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted font-bold text-uppercase mb-1">Stockage</div>
                        <div class="font-bold text-dark"><i class="fas fa-hdd" style="color: var(--primary); width: 20px;"></i> 4x 2To SSD NVMe</div>
                        <div class="text-sm text-muted">RAID 5 Configuré</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted font-bold text-uppercase mb-1">Réseau</div>
                        <div class="font-bold text-dark"><i class="fas fa-network-wired" style="color: var(--primary); width: 20px;"></i> 2x 10GbE SFP+</div>
                        <div class="text-sm text-muted">Double lien (LACP)</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted font-bold text-uppercase mb-1">Système d'exploitation</div>
                        <div class="font-bold text-dark"><i class="fab fa-linux" style="color: var(--primary); width: 20px;"></i> Ubuntu Server 22.04</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted font-bold text-uppercase mb-1">Localisation</div>
                        <div class="font-bold text-dark"><i class="fas fa-map-marker-alt" style="color: var(--primary); width: 20px;"></i> Salle Serveur B</div>
                    </div>
                </div>
            </div>

            <div class="card p-4">
                <h3 class="text-lg font-bold mb-3 border-bottom pb-2">Usage Recommandé</h3>
                <p class="text-muted text-sm" style="line-height: 1.6;">
                    Ce serveur est optimisé pour les calculs intensifs (HPC), l'entraînement de modèles d'IA légers ou la virtualisation de plusieurs environnements. 
                    <br><br>
                    <strong>Logiciels pré-installés :</strong> Docker, Kubernetes, Python 3.9, Drivers NVIDIA (si GPU attaché).
                    <br>
                    <em>Note : Veuillez libérer l'espace disque temporaire (/tmp) après vos calculs.</em>
                </p>
            </div>
        </div>

        <div>
            
            <div class="card p-4 mb-4 text-center">
                <h3 class="text-lg font-bold mb-3">Réserver cette ressource</h3>
                <p class="text-sm text-muted mb-4">La ressource est libre actuellement.</p>
                
                <a href="{{ url('/reservations/create') }}" class="btn btn-primary w-100 mb-2" style="padding: 1rem;">
                    <i class="far fa-calendar-check" style="margin-right: 8px;"></i> Faire une demande
                </a>
                
                <button class="btn btn-outline-danger w-100 text-sm" style="margin-top: 0.5rem;">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i> Signaler un problème
                </button>
            </div>

            <div class="card p-4">
                <h3 class="text-md font-bold mb-3">Disponibilité (Jan 2026)</h3>
                
                <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; text-align: center; font-size: 0.8rem; margin-bottom: 1rem;">
                    <div class="text-muted">L</div><div class="text-muted">M</div><div class="text-muted">M</div><div class="text-muted">J</div><div class="text-muted">V</div><div class="text-muted">S</div><div class="text-muted">D</div>
                    
                    <div style="opacity: 0.3;">29</div><div style="opacity: 0.3;">30</div><div style="opacity: 0.3;">31</div>
                    <div style="padding: 4px;">1</div><div style="padding: 4px;">2</div><div style="padding: 4px;">3</div><div style="padding: 4px;">4</div>
                    
                    <div style="background:#fee2e2; color:#991b1b; border-radius:4px; padding:4px;" title="Maintenance">5</div>
                    <div style="background:#fee2e2; color:#991b1b; border-radius:4px; padding:4px;">6</div>
                    <div style="padding: 4px;">7</div><div style="padding: 4px;">8</div><div style="padding: 4px;">9</div><div style="padding: 4px;">10</div><div style="padding: 4px;">11</div>
                    
                    <div style="background:#fef3c7; color:#92400e; border-radius:4px; padding:4px;" title="Réservé">12</div>
                    <div style="background:#fef3c7; color:#92400e; border-radius:4px; padding:4px;">13</div>
                    <div style="padding: 4px; border: 1px solid var(--primary); color: var(--primary); font-weight: bold; border-radius: 4px;">14</div>
                    <div style="padding: 4px;">15</div><div style="padding: 4px;">16</div><div style="padding: 4px;">17</div><div style="padding: 4px;">18</div>
                </div>

                <div class="d-flex justify-center" style="gap: 10px; font-size: 0.75rem; color: var(--text-muted);">
                    <span class="d-flex align-center"><span style="width:8px; height:8px; background:var(--bg-body); border:1px solid #ccc; margin-right:4px; border-radius:50%;"></span>Libre</span>
                    <span class="d-flex align-center"><span style="width:8px; height:8px; background:#fef3c7; margin-right:4px; border-radius:50%;"></span>Réservé</span>
                    <span class="d-flex align-center"><span style="width:8px; height:8px; background:#fee2e2; margin-right:4px; border-radius:50%;"></span>Maint.</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection