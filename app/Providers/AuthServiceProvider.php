<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\ResourcePolicy;
use App\Policies\ReservationPolicy;
use App\Policies\IncidentPolicy;
use App\Policies\MaintenancePolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ResourceCommentPolicy;
use App\Models\Resource;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Incident;
use App\Models\Maintenance;
use App\Models\ResourceCategory;
use App\Models\ResourceComment;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Resource::class => ResourcePolicy::class,
        Reservation::class => ReservationPolicy::class,
        Incident::class => IncidentPolicy::class,
        Maintenance::class => MaintenancePolicy::class,
        ResourceCategory::class => CategoryPolicy::class,
        ResourceComment::class => ResourceCommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Accorde toutes les permissions à l'administrateur
        Gate::before(function ($user, $ability) {
            if ($user->role->name === 'admin') {
                return true;
            }
        });

        // ====================================================================
        // PERMISSIONS GLOBALES PAR RÔLE (GATES)
        // ====================================================================

        // Rôle Administrateur
        Gate::define('access-admin-dashboard', function (User $user) {
            return $user->role->name === 'admin';
        });

        // Rôle Responsable Technique
        Gate::define('access-tech-dashboard', function (User $user) {
            return in_array($user->role->name, ['admin', 'tech_manager']);
        });

        // Rôle Utilisateur
        Gate::define('access-user-dashboard', function (User $user) {
            return in_array($user->role->name, ['user', 'tech_manager', 'admin']);
        });

        // Voir les statistiques personnelles (pour Techs et Users)
        Gate::define('view-personal-statistics', function (User $user) {
            return in_array($user->role->name, ['tech_manager', 'user']);
        });

        // ====================================================================
        // PERMISSIONS SPÉCIFIQUES
        // ====================================================================

        // Gestion des utilisateurs (Admin seulement)
        Gate::define('manage-users', function (User $user) {
            return $user->role->name === 'admin';
        });

        // Voir les logs (Admin seulement)
        Gate::define('view-logs', function (User $user) {
            return $user->role->name === 'admin';
        });

        // Voir les statistiques globales (Admin seulement)
        Gate::define('view-global-statistics', function (User $user) {
            return $user->role->name === 'admin';
        });

        // Gérer les demandes de compte (Admin seulement)
        Gate::define('manage-account-requests', function (User $user) {
            return $user->role->name === 'admin';
        });

        // Laisser un commentaire (Tout utilisateur authentifié)
        Gate::define('add-comment', function (User $user) {
            return in_array($user->role->name, ['user', 'tech_manager', 'admin']);
        });
    }
}
