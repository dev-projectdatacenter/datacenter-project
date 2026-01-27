<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Resource;
use Carbon\Carbon;

class ReservationValidationService
{
    /**
     * Vérifie si une ressource est disponible pour une période donnée.
     *
     * @param int $resourceId
     * @param string $startDate
     * @param string $endDate
     * @param int|null $excludeReservationId ID d'une réservation à exclure (cas de modification)
     * @return bool
     */
    public function checkAvailability($resourceId, $startDate, $endDate, $excludeReservationId = null)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // 1. Vérifier si la ressource existe et est disponible
        $resource = Resource::find($resourceId);
        if (!$resource || $resource->status !== 'available') {
            return false;
        }

        // 2. Vérifier les chevauchements (Overlapping)
        // La logique : (DateDébut1 < DateFin2) ET (DateFin1 > DateDébut2)
        $query = Reservation::where('resource_id', $resourceId)
            ->whereIn('status', ['approved', 'pending']) // Réservations approuvées ou en attente bloquent
            ->where(function ($q) use ($start, $end) {
                $q->where(function ($sub) use ($start, $end) {
                    $sub->where('start_date', '<', $end)
                        ->where('end_date', '>', $start);
                });
            });

        // Si on modifie sa propre réservation, on ne doit pas se bloquer soi-même
        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        // Si le compteur est à 0, c'est libre !
        return $query->count() === 0;
    }
}
