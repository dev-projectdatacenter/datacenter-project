@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-space-cadet">Mon Profil</h1>
        <p class="text-muted">Gérez vos informations personnelles et vos préférences de sécurité.</p>
    </div>

    <form action="#" method="POST"> @csrf
        
        <div class="grid grid-3">
            
            <div class="span-2">
                <div class="card p-4 mb-4">
                    <h3 class="text-md font-bold text-primary mb-3 border-bottom pb-2">Informations Générales</h3>
                    
                    <div class="grid grid-2 mb-3" style="gap: 1.5rem;">
                        <div class="form-group">
                            <label class="form-label text-xs">Prénom</label>
                            <input type="text" class="form-control" value="Chaymae" name="firstname">
                        </div>
                        <div class="form-group">
                            <label class="form-label text-xs">Nom</label>
                            <input type="text" class="form-control" value="Admin" name="lastname">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label text-xs">Adresse Email</label>
                        <input type="email" class="form-control bg-light" value="chaymae@datacenter.ma" disabled>
                        <p class="text-xs text-muted mt-1">Contactez l'administrateur pour changer votre email.</p>
                    </div>

                    <div class="grid grid-2 mb-3" style="gap: 1.5rem;">
                        <div class="form-group">
                            <label class="form-label text-xs">Téléphone</label>
                            <input type="text" class="form-control" value="+212 6 00 00 00 00">
                        </div>
                        <div class="form-group">
                            <label class="form-label text-xs">Poste / Rôle</label>
                            <input type="text" class="form-control bg-light" value="Administrateur Système" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-xs">Laboratoire / Département</label>
                        <select class="form-control">
                            <option value="info">Génie Informatique & Réseaux</option>
                            <option value="elec">Génie Électrique</option>
                            <option value="data">Big Data Lab</option>
                        </select>
                    </div>
                </div>

                <div class="card p-4">
                    <h3 class="text-md font-bold text-primary mb-3 border-bottom pb-2">Préférences</h3>
                    
                    <div class="d-flex align-center justify-between mb-3 border-bottom pb-2">
                        <div>
                            <div class="font-bold text-sm">Notifications par Email</div>
                            <div class="text-xs text-muted">Recevoir une alerte quand une réservation est validée.</div>
                        </div>
                        <input type="checkbox" checked>
                    </div>

                    <div class="d-flex align-center justify-between">
                        <div>
                            <div class="font-bold text-sm">Alertes Maintenance</div>
                            <div class="text-xs text-muted">Être prévenu des arrêts serveurs planifiés.</div>
                        </div>
                        <input type="checkbox" checked>
                    </div>
                </div>
            </div>

            <div>
                
                <div class="card p-4 mb-4 text-center">
                    <div class="mx-auto mb-3 d-flex justify-center align-center font-bold text-white shadow-sm" 
                         style="width: 100px; height: 100px; background-color: var(--primary); border-radius: 50%; font-size: 2rem;">
                        CA
                    </div>
                    <h3 class="font-bold text-dark">Chaymae Admin</h3>
                    <p class="text-xs text-muted mb-3">Administrateur</p>
                    <button type="button" class="btn btn-sm btn-outline w-100" style="border: 1px solid var(--border-color);">
                        <i class="fas fa-camera"></i> Changer la photo
                    </button>
                </div>

                <div class="card p-4">
                    <h3 class="text-md font-bold text-danger mb-3 border-bottom pb-2">Sécurité</h3>
                    
                    <div class="form-group mb-3">
                        <label class="form-label text-xs">Mot de passe actuel</label>
                        <input type="password" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label text-xs">Nouveau mot de passe</label>
                        <input type="password" class="form-control">
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label text-xs">Confirmer le nouveau</label>
                        <input type="password" class="form-control">
                    </div>

                    <button class="btn btn-outline-danger w-100 text-sm">
                        Mettre à jour le mot de passe
                    </button>
                </div>

            </div>
        </div>

        <div class="mt-4 text-right">
            <button type="submit" class="btn btn-primary px-5 py-2">
                <i class="fas fa-save mr-1"></i> Enregistrer les modifications
            </button>
        </div>

    </form>
</div>
@endsection