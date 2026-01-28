<?php

namespace App\Policies;

use App\Models\Incident;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncidentPolicy
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
        return true; // Filtered in controller
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Incident $incident)
    {
        // Un responsable technique peut voir les détails de n'importe quel incident.
        // La gestion (modification/suppression) est restreinte dans les autres méthodes.
        if ($user->role->name === 'tech_manager') {
            return true;
        }

        // Un utilisateur ne peut voir que ses propres incidents.
        return $user->id === $incident->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return in_array($user->role->name, ['user', 'tech_manager', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Incident $incident)
    {
        if ($user->role->name === 'tech_manager') {
            return $incident->resource && $incident->resource->managed_by_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Incident $incident)
    {
        if ($user->role->name === 'tech_manager') {
            return $incident->resource && $incident->resource->managed_by_id === $user->id;
        }

        return false;
    }
}
