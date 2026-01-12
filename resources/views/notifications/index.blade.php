@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-space-cadet">Notifications</h1>
            <p class="text-muted">Vos alertes et messages récents.</p>
        </div>
        <button class="btn btn-outline text-sm" style="border: 1px solid var(--border-color);">
            <i class="fas fa-check-double"></i> Tout marquer comme lu
        </button>
    </div>

    <div class="card p-0 overflow-hidden">
        
        <div class="p-4 border-bottom" style="background-color: #fff; border-left: 4px solid var(--success);">
            <div class="d-flex justify-between align-start">
                <div class="d-flex">
                    <div class="icon-circle bg-light text-success mr-1" style="min-width: 40px;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div style="margin-left: 1rem;">
                        <h3 class="text-md font-bold text-dark mb-1">Réservation Approuvée</h3>
                        <p class="text-sm text-muted mb-2">
                            Votre demande pour le <strong>Serveur Dell R740</strong> (15 Jan - 18 Jan) a été validée par le responsable technique.
                        </p>
                        <a href="{{ url('/reservations/1') }}" class="text-xs text-primary font-bold">Voir la réservation &rarr;</a>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs text-muted">Il y a 2h</span>
                    <div style="width: 10px; height: 10px; background-color: var(--primary); border-radius: 50%; display: inline-block; margin-left: 10px;"></div>
                </div>
            </div>
        </div>

        <div class="p-4 border-bottom" style="background-color: #fff; border-left: 4px solid var(--warning);">
            <div class="d-flex justify-between align-start">
                <div class="d-flex">
                    <div class="icon-circle bg-light text-warning mr-1" style="min-width: 40px;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div style="margin-left: 1rem;">
                        <h3 class="text-md font-bold text-dark mb-1">Maintenance Planifiée</h3>
                        <p class="text-sm text-muted">
                            Attention, une intervention aura lieu sur le <strong>Cluster B</strong> ce Samedi de 22h à 02h. Vos ressources pourraient être inaccessibles.
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs text-muted">Hier</span>
                    <div style="width: 10px; height: 10px; background-color: var(--primary); border-radius: 50%; display: inline-block; margin-left: 10px;"></div>
                </div>
            </div>
        </div>

        <div class="p-4 border-bottom" style="background-color: #f8fafc; opacity: 0.8;"> <div class="d-flex justify-between align-start">
                <div class="d-flex">
                    <div class="icon-circle bg-light text-muted mr-1" style="min-width: 40px;">
                        <i class="fas fa-info"></i>
                    </div>
                    <div style="margin-left: 1rem;">
                        <h3 class="text-md font-bold text-muted mb-1">Bienvenue sur la plateforme</h3>
                        <p class="text-sm text-muted">
                            Votre compte a été créé avec succès. N'oubliez pas de compléter votre profil.
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs text-muted">10 Jan</span>
                </div>
            </div>
        </div>

         <div class="p-4 border-bottom" style="background-color: #f8fafc; opacity: 0.8; border-left: 4px solid transparent;">
            <div class="d-flex justify-between align-start">
                <div class="d-flex">
                    <div class="icon-circle bg-light text-danger mr-1" style="min-width: 40px;">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div style="margin-left: 1rem;">
                        <h3 class="text-md font-bold text-muted mb-1">Demande Refusée</h3>
                        <p class="text-sm text-muted mb-2">
                            Votre demande pour "Stockage SAN" a été refusée. Motif : Capacité insuffisante.
                        </p>
                        <a href="#" class="text-xs text-muted font-bold" style="text-decoration: underline;">Voir détails</a>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs text-muted">08 Jan</span>
                </div>
            </div>
        </div>

    </div>

    <div class="d-flex justify-center mt-4">
        <span class="text-xs text-muted">Affichage des 4 dernières notifications</span>
    </div>

</div>
@endsection