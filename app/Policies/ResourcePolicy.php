<?php

namespace App\Policies;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcePolicy
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
     * Determine whether anyone can view the list of resources.
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether anyone can view a specific resource.
     */
    public function view(?User $user, Resource $resource)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        // Admins are handled by before(). Tech managers can also create resources.
        return $user->role->name === 'tech_manager';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Resource $resource)
    {
        // Admins are handled by before().
        // A tech manager can only update resources they are assigned to manage.
        return $user->role->name === 'tech_manager' && $user->id === $resource->managed_by_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Resource $resource)
    {
        // Admins are handled by before().
        // A tech manager can only delete resources they are assigned to manage.
        return $user->role->name === 'tech_manager' && $user->id === $resource->managed_by_id;
    }

    /**
     * Determine whether a user can add a comment.
     */
    public function addComment(User $user, Resource $resource)
    {
        // Any authenticated user can comment.
        return in_array($user->role->name, ['user', 'tech_manager', 'admin']);
    }
}
