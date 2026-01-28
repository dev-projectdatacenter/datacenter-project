<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;

class UpdateReservationStatus extends Command
{
    protected $signature = 'reservations:update-status';
    protected $description = 'Mettre à jour automatiquement le statut des réservations';

    public function handle()
    {
        $this->info('Mise à jour des statuts de réservations...');
        
        $updatedCount = 0;
        
        // 1. Mettre à jour les réservations qui doivent devenir "active"
        $approvedReservations = Reservation::where('status', 'approved')
            ->where('start_date', '<=', now())
            ->where('end_date', '>', now())
            ->get();
            
        foreach ($approvedReservations as $reservation) {
            $reservation->update(['status' => 'active']);
            $this->info("Réservation #{$reservation->id} passée à 'active'");
            $updatedCount++;
        }
        
        // 2. Mettre à jour les réservations qui doivent devenir "completed"
        $activeReservations = Reservation::where('status', 'active')
            ->where('end_date', '<=', now())
            ->get();
            
        foreach ($activeReservations as $reservation) {
            $reservation->update(['status' => 'completed']);
            $this->info("Réservation #{$reservation->id} passée à 'completed'");
            $updatedCount++;
        }
        
        // 3. Mettre à jour le statut des ressources
        $this->updateResourceStatuses();
        
        $this->info("Mise à jour terminée. {$updatedCount} réservations mises à jour.");
        
        return 0;
    }
    
    private function updateResourceStatuses()
    {
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
