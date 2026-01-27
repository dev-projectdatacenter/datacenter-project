<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Console\Command;

class CompleteReservations extends Command
{
    protected $signature = 'reservations:complete';

    protected $description = 'Terminer automatiquement les réservations actives dont la date de fin est passée';

    public function handle(): int
    {
        $now = now();

        $reservations = Reservation::with('resource')
            ->where('status', 'active')
            ->where('end_date', '<=', $now)
            ->get();

        $completedCount = 0;
        $touchedResourceIds = [];

        foreach ($reservations as $reservation) {
            $reservation->update(['status' => 'completed']);
            $completedCount++;

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

        $this->info("{$completedCount} réservation(s) terminée(s).");

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
