<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Console\Command;

class ActivateReservations extends Command
{
    protected $signature = 'reservations:activate';

    protected $description = 'Activer automatiquement les réservations approuvées dont la date de début est atteinte';

    public function handle(): int
    {
        $now = now();

        $reservations = Reservation::with('resource')
            ->where('status', 'approved')
            ->where('start_date', '<=', $now)
            ->where('end_date', '>', $now)
            ->get();

        $activatedCount = 0;
        $touchedResourceIds = [];

        foreach ($reservations as $reservation) {
            $reservation->update(['status' => 'active']);
            $activatedCount++;

            if ($reservation->resource_id) {
                $touchedResourceIds[$reservation->resource_id] = true;
            }
        }

        foreach (array_keys($touchedResourceIds) as $resourceId) {
            $resource = Resource::find($resourceId);
            if ($resource) {
                $this->updateResourceStatus($resource);
            }
        }

        $this->info("{$activatedCount} réservation(s) activée(s).");

        return self::SUCCESS;
    }

    private function updateResourceStatus(Resource $resource): void
    {
        if ($resource->status === 'maintenance') {
            return;
        }

        $hasBlockingReservations = $resource->reservations()
            ->whereIn('status', ['approved', 'active'])
            ->where('end_date', '>', now())
            ->exists();

        $resource->update([
            'status' => $hasBlockingReservations ? 'busy' : 'available',
        ]);
    }
}
