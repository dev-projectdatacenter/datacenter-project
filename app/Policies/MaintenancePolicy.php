<?php

namespace App\Policies;

use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaintenancePolicy
{
    use HandlesAuthorization;

    /**
     * Grant all abilities to administrators.
     */
    public function before(User $user, $ability)
    {
        if ($user->role->name === 'admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return true; // All authenticated users can see maintenances
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Maintenance $maintenance)
    {
        return true; // All authenticated users can see a specific maintenance
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->role->name === 'tech_manager';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Maintenance $maintenance)
    {
        // A tech manager can only update maintenances for resources they manage.
        return $user->id === $maintenance->resource->managed_by_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Maintenance $maintenance)
    {
        // A tech manager can only delete maintenances for resources they manage.
        return $user->id === $maintenance->resource->managed_by_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Maintenance $maintenance)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Maintenance $maintenance)
    {
        return false;
    }
}
