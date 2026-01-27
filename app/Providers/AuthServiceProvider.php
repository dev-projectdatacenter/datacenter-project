<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\ResourcePolicy;
use App\Policies\ReservationPolicy;
use App\Models\Resource;
use App\Models\Reservation;
use App\Models\User;

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
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gates pour les permissions générales
        Gate::define('admin', function (User $user) {
            return $user->role->name === 'admin';
        });

        Gate::define('tech-manager', function (User $user) {
            return $user->role->name === 'tech_manager';
        });

        Gate::define('user', function (User $user) {
            return $user->role->name === 'user';
        });

        Gate::define('manage-users', function (User $user) {
            return $user->role->name === 'admin';
        });

        Gate::define('view-logs', function (User $user) {
            return $user->role->name === 'admin';
        });

        Gate::define('manage-resources', function (User $user) {
            return in_array($user->role->name, ['admin', 'tech_manager']);
        });

        Gate::define('create-reservations', function (User $user) {
            return in_array($user->role->name, ['user', 'tech_manager', 'admin']);
        });

        Gate::define('approve-reservations', function (User $user) {
            return in_array($user->role->name, ['admin', 'tech_manager']);
        });

        Gate::define('view-statistics', function (User $user) {
            return in_array($user->role->name, ['admin', 'tech_manager']);
        });

        Gate::define('manage-account-requests', function (User $user) {
            return $user->role->name === 'admin';
        });

        // Gates pour les actions spécifiques
        Gate::define('edit-own-profile', function (User $user, User $profileUser) {
            return $user->id === $profileUser->id;
        });

        Gate::define('delete-own-account', function (User $user, User $targetUser) {
            return $user->id === $targetUser->id && $user->role->name !== 'admin';
        });

        Gate::define('access-admin-panel', function (User $user) {
            return $user->role->name === 'admin';
        });

        Gate::define('access-tech-panel', function (User $user) {
            return in_array($user->role->name, ['admin', 'tech_manager']);
        });
    }
}
