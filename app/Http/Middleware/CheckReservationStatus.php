<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Reservation;
use Carbon\Carbon;

class CheckReservationStatus
{
    public function handle($request, Closure $next)
    {
        // Mettre à jour les résérations qui doivent changer de statut
        $this->updateReservationStatuses();
        
        return $next($request);
    }
    
    private function updateReservationStatuses()
    {
        // 1. Mettre à jour les réservations qui doivent devenir "active"
        Reservation::where('status', 'approved')
            ->where('start_date', '<=', now())
            ->where('end_date', '>', now())
            ->update(['status' => 'active']);
            
        // 2. Mettre à jour les réservations qui doivent devenir "completed"
        Reservation::where('status', 'active')
            ->where('end_date', '<=', now())
            ->update(['status' => 'completed']);
            
        // 3. Mettre à jour le statut des ressources
        $resources = \App\Models\Resource::with('reservations')->get();
        
        foreach ($resources as $resource) {
            $activeReservations = $resource->reservations()
                ->whereIn('status', ['approved', 'active'])
                ->where('end_date', '>', now())
                ->count();
                
            if ($activeReservations > 0) {
                $resource->update(['status' => 'busy']);
            } else {
                $resource->update(['status' => 'available']);
            }
        }
    }
}
