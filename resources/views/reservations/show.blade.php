@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="mb-4">
        <a href="{{ url('/mes-reservations') }}" class="text-muted text-sm">
            <i class="fas fa-arrow-left"></i> Retour à mes réservations
        </a>
    </div>

    <div class="card p-4 mb-4 border-left-warning"> <div class="d-flex justify-between align-center">
            <div>
                <div class="text-sm text-muted text-uppercase font-bold mb-1">Réservation #RES-2026-042</div>
                <h1 class="text-2xl font-bold text-space-cadet m-0">Demande en cours de traitement</h1>
            </div>
            <div class="text-right">
                <span class="badge badge-warning" style="font-size: 1rem; padding: 0.5rem 1rem;">
                    <i class="fas fa-clock"></i> En Attente
                </span>
                <div class="text-xs text-muted mt-2">Soumis le 12 Jan 2026</div>
            </div>
        </div>
    </div>

    <div class="grid grid-3">
        
        <div class="span-2">
            <div class="card p-4 h-100">
                <h3 class="text-lg font-bold text-primary mb-3 border-bottom pb-2">Détails du projet</h3>
                
                <div class="grid grid-2 mb-4" style="gap: 1.5rem;">
                    <div>
                        <div class="text-xs text-muted font-bold text-uppercase mb-1">Date de début</div>
                        <div class="font-bold text-dark text-lg">15 Jan 2026</div>
                        <div class="text-sm text-muted">09:00 AM</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted font-bold text-uppercase mb-1">Date de fin</div>
                        <div class="font-bold text-dark text-lg">18 Jan 2026</div>
                        <div class="text-sm text-muted">18:00 PM</div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="text-xs text-muted font-bold text-uppercase mb-1">Durée totale</div>
                    <div class="font-bold"><i class="fas fa-hourglass-half text-primary"></i> 3 Jours et 9 Heures</div>
                </div>

                <div class="mb-4">
                    <div class="text-xs text-muted font-bold text-uppercase mb-1">Titre du projet</div>
                    <div class="font-bold text-dark">Analyse prédictive des données climatiques (Thèse)</div>
                </div>

                <div class="mb-4">
                    <div class="text-xs text-muted font-bold text-uppercase mb-2">Motif / Justification</div>
                    <div class="p-3 bg-light rounded text-sm text-muted" style="border: 1px solid var(--border-color); line-height: 1.6;">
                        "J'ai besoin de cette ressource pour entraîner un modèle de Machine Learning sur un grand dataset (50 Go). 
                        Mon ordinateur personnel n'a pas assez de RAM pour charger les données. 
                        J'utiliserai Python et TensorFlow."
                    </div>
                </div>

                </div>
        </div>

        <div>
            <div class="card p-4 mb-4">
                <h3 class="text-md font-bold text-space-cadet mb-3">Ressource concernée</h3>
                
                <div class="d-flex align-center mb-3">
                    <div class="icon-box bg-light text-space-cadet p-2 rounded mr-1">
                        <i class="fas fa-server fa-2x"></i>
                    </div>
                    <div>
                        <div class="font-bold text-lg">Dell PowerEdge R740</div>
                        <div class="text-xs text-muted">Rack A1 • Serveur Physique</div>
                    </div>
                </div>

                <ul class="text-sm text-muted mb-4 pl-3" style="list-style: circle;">
                    <li>48 Cores CPU</li>
                    <li>256 Go RAM</li>
                    <li>Ubuntu Server</li>
                </ul>

                <a href="{{ url('/resources/1') }}" class="btn btn-outline w-100 text-xs" style="border: 1px solid var(--border-color);">
                    Voir la fiche technique
                </a>
            </div>

            <div class="card p-4 text-center">
                <h3 class="text-md font-bold mb-3">Actions</h3>
                
                <p class="text-xs text-muted mb-3">Vous pouvez annuler cette demande tant qu'elle n'est pas traitée.</p>
                <button class="btn btn-outline-danger w-100 mb-2">
                    <i class="fas fa-trash-alt mr-1"></i> Annuler la demande
                </button>

                </div>
        </div>

    </div>
</div>
@endsection