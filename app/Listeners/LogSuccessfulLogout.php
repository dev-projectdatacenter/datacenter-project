<?php

namespace App\Listeners;

use App\Services\ActivityLogService;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogout
{
    protected $activityLogService;

    /**
     * Create the event listener.
     */
    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event): void
    {
        if ($event->user) {
            $user = $event->user;
            $this->activityLogService->log('Déconnexion', "L'utilisateur {$user->name} s'est déconnecté.", $user->id);
        }
    }
}
