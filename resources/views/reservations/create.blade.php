@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="mb-4">
        <a href="{{ url('/resources/1') }}" class="text-muted text-sm">
            <i class="fas fa-arrow-left"></i> Retour à la ressource
        </a>
    </div>

    <h1 class="text-2xl font-bold text-space-cadet mb-4">Nouvelle Réservation</h1>

    <div class="grid grid-3">
        
        <div class="span-2">
            <div class="card p-4">
                <form action="#" method="POST"> @csrf
                    
                    <h3 class="text-lg font-bold mb-3">1. Période souhaitée</h3>
                    <div class="grid grid-2 mb-4" style="gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label text-xs">Date de début</label>
                            <input type="datetime-local" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label text-xs">Date de fin</label>
                            <input type="datetime-local" class="form-control">
                        </div>
                    </div>

                    <h3 class="text-lg font-bold mb-3 mt-4">2. Détails du projet</h3>
                    
                    <div class="form-group mb-3">
                        <label class="form-label text-xs">Titre du projet / Thèse</label>
                        <input type="text" class="form-control" placeholder="Ex: Analyse Big Data Covid-19">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label text-xs">Description de l'usage</label>
                        <textarea class="form-control" rows="4" placeholder="Décrivez pourquoi vous avez besoin de cette ressource spécifique..."></textarea>
                        <p class="text-xs text-muted mt-1">Ce motif sera lu par le Responsable Technique pour validation.</p>
                    </div>

                    <div class="mb-4 p-3 bg-light rounded">
                        <label class="d-flex align-center cursor-pointer">
                            <input type="checkbox" style="margin-right: 10px;">
                            <span class="text-sm">J'ai besoin d'une installation logicielle spécifique (Docker, Anaconda...)</span>
                        </label>
                    </div>

                    <div class="d-flex justify-end gap-2 border-top pt-3">
                        <a href="{{ url('/catalogue') }}" class="btn btn-outline-secondary">Annuler</a>
                        <button type="button" class="btn btn-primary px-4">Envoyer la demande</button>
                    </div>
                </form>
            </div>
        </div>

        <div>
            <div class="card p-4 bg-light border-left-primary">
                <h3 class="text-md font-bold text-space-cadet mb-3">Ressource sélectionnée</h3>
                
                <div class="d-flex align-center mb-3">
                    <div class="icon-circle bg-white text-primary shadow-sm mr-1">
                        <i class="fas fa-server"></i>
                    </div>
                    <div>
                        <div class="font-bold">Dell PowerEdge R740</div>
                        <div class="text-xs text-muted">Serveur Physique • Rack A1</div>
                    </div>
                </div>

                <ul class="text-sm text-muted mb-4 pl-3" style="list-style: disc;">
                    <li>2x Intel Xeon Gold</li>
                    <li>256 Go RAM</li>
                    <li>Accès SSH root</li>
                </ul>

                <div class="alert alert-warning text-xs p-2 mb-0" style="background: #fffbeb; border: 1px solid #fcd34d; color: #92400e; border-radius: 4px;">
                    <i class="fas fa-info-circle"></i> <strong>Note :</strong> Cette ressource nécessite une validation manuelle par un administrateur. Délai moyen : 4h.
                </div>
            </div>
        </div>

    </div>
</div>
@endsection