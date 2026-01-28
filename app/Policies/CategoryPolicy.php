<?php

namespace App\Policies;

use App\Models\ResourceCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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
        // Any authenticated user can view the list of categories.
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ResourceCategory $resourceCategory)
    {
        // Any authenticated user can view a category.
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return false; // Only admins can do this
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ResourceCategory $resourceCategory)
    {
        return false; // Only admins can do this
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ResourceCategory $resourceCategory)
    {
        return false; // Only admins can do this
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ResourceCategory $resourceCategory)
    {
        return false; // Only admins can do this
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ResourceCategory $resourceCategory)
    {
        return false; // Only admins can do this
    }
}
