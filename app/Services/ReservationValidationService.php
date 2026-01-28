<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Resource;
use App\Models\Maintenance;
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

        \Log::info("=== Vérification disponibilité ===");
        \Log::info("Resource ID: {$resourceId}");
        \Log::info("Période demandée: {$startDate} → {$endDate}");

        // 1. Vérifier si la ressource existe et est disponible
        $resource = Resource::find($resourceId);
        \Log::info("Ressource trouvée: " . ($resource ? 'OUI' : 'NON'));
        if ($resource) {
            \Log::info("Statut de la ressource: " . $resource->status);
        }
        
        // Accepter uniquement les statuts valides de RESSOURCES
        if (!$resource || !in_array($resource->status, ['available', 'busy'])) {
            \Log::info("Ressource non disponible ou n'existe pas");
            return false;
        }

        // 2. Vérifier les chevauchements (Overlapping)
        // La logique : (DateDébut1 < DateFin2) ET (DateFin1 > DateDébut2)
        $query = Reservation::where('resource_id', $resourceId)
            ->whereIn('status', ['approved', 'pending', 'active']) // Réservations actives bloquent aussi
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

        // Afficher les réservations conflictuelles trouvées
        $conflicts = $query->get();
        \Log::info("Nombre de conflits trouvés: " . $conflicts->count());
        
        foreach ($conflicts as $conflict) {
            \Log::info("Conflit - ID: {$conflict->id}, Début: {$conflict->start_date}, Fin: {$conflict->end_date}, Status: {$conflict->status}");
        }

        // Si le compteur est à 0, c'est libre pour les réservations !
        $isAvailable = $query->count() === 0;
        
        // 3. Vérifier les chevauchements avec les maintenances
        if ($isAvailable) {
            $maintenanceQuery = Maintenance::where('resource_id', $resourceId)
                ->where(function ($q) use ($start, $end) {
                    $q->where(function ($sub) use ($start, $end) {
                        $sub->where('start_date', '<', $end)
                            ->where('end_date', '>', $start);
                    });
                });

            $maintenanceConflicts = $maintenanceQuery->get();
            \Log::info("Nombre de conflits de maintenance trouvés: " . $maintenanceConflicts->count());
            
            foreach ($maintenanceConflicts as $conflict) {
                \Log::info("Conflit maintenance - ID: {$conflict->id}, Début: {$conflict->start_date}, Fin: {$conflict->end_date}, Raison: {$conflict->reason}");
            }

            $isAvailable = $maintenanceQuery->count() === 0;
        }
        
        \Log::info("Résultat: " . ($isAvailable ? 'DISPONIBLE' : 'NON DISPONIBLE'));
        \Log::info("=== Fin vérification ===");

        return $isAvailable;
    }
}
