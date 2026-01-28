<?php

namespace App\Policies;

use App\Models\ResourceComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourceCommentPolicy
{
    use HandlesAuthorization;

    /**
     * Grant moderation abilities to administrators and tech managers.
     */
    public function before(User $user, $ability)
    {
        if (in_array($user->role->name, ['admin', 'tech_manager'])) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        // Any authenticated user can create a comment.
        return in_array($user->role->name, ['user', 'tech_manager', 'admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ResourceComment $resourceComment)
    {
        // Admins/Techs are handled by before().
        // Users can only delete their own comments.
        return $user->id === $resourceComment->user_id;
    }
}
