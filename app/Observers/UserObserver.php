<?php

namespace App\Observers;

use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        ActivityLogService::log(
            'user_created',
            "L'utilisateur {$user->name} a été créé avec le rôle " . ($user->role->name ?? 'N/A') . ".",
            Auth::id()
        );
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $changes = [];
        if ($user->wasChanged('role_id')) {
            $changes[] = "le rôle a été changé en " . ($user->role->name ?? 'N/A');
        }
        if ($user->wasChanged('status')) {
            $changes[] = "le statut a été changé en {$user->status}";
        }

        if (!empty($changes)) {
            $description = "L'utilisateur {$user->name} a été mis à jour : " . implode(', ', $changes) . ".";
            ActivityLogService::log('user_updated', $description, Auth::id());
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        ActivityLogService::log(
            'user_deleted',
            "L'utilisateur {$user->name} a été supprimé.",
            Auth::id()
        );
    }
}
