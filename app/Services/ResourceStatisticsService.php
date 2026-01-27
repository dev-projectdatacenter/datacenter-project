<?php

namespace App\Services;

use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\Reservation;
use App\Models\Incident;
use App\Models\Maintenance;
use Illuminate\Support\Facades\DB;

class ResourceStatisticsService
{
    /**
     * Récupère les statistiques générales du parc.
     */
    public function getGeneralStats()
    {
        $totalResources = Resource::count();
        $busyResources = Resource::where('status', 'busy')->count();
        
        return [
            'total_resources' => $totalResources,
            'busy_resources' => $busyResources,
            'available_resources' => Resource::where('status', 'available')->count(),
            'maintenance_resources' => Resource::where('status', 'maintenance')->count(),
            'occupancy_rate' => $totalResources > 0 ? round(($busyResources / $totalResources) * 100, 1) : 0,
        ];
    }

    /**
     * Récupère la répartition des ressources par catégorie.
     */
    public function getCategoryDistribution()
    {
        return ResourceCategory::withCount('resources')->get();
    }

    /**
     * Récupère les ressources les plus sollicitées (Top 5).
     */
    public function getMostReservedResources()
    {
        // On compte les réservations par ressource
        return Resource::withCount('reservations')
            ->orderBy('reservations_count', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * Récupère les statistiques générales complètes.
     */
    public function getGeneralStatsComplete()
    {
        $totalResources = Resource::count();
        $availableResources = Resource::where('status', 'available')->count();
        $busyResources = Resource::where('status', 'busy')->count();
        $maintenanceResources = Resource::where('status', 'maintenance')->count();
        
        return [
            'total_resources' => $totalResources,
            'available_resources' => $availableResources,
            'busy_resources' => $busyResources,
            'maintenance_resources' => $maintenanceResources,
            'occupancy_rate' => $totalResources > 0 ? round(($busyResources / $totalResources) * 100, 1) : 0,
        ];
    }

    /**
     * Récupère les statistiques sur la santé du parc (Incidents & Maintenances).
     */
    public function getHealthStats()
    {
        return [
            'open_incidents' => Incident::where('status', 'open')->count(),
            'total_incidents' => Incident::count(),
            'active_maintenances' => Maintenance::where('start_date', '<=', now())
                                             ->where('end_date', '>=', now())
                                             ->count(),
            'total_maintenances' => Maintenance::count(),
        ];
    }

    /**
     * Récupère les statistiques spécifiques à un utilisateur.
     */
    public function getUserStats($userId)
    {
        // On prépare les 6 derniers mois avec 0 par défaut
        $monthlyActivity = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyActivity->put($month->format('n'), [
                'month' => $month->format('n'),
                'count' => 0
            ]);
        }

        // On récupère les vraies données
        $realData = Reservation::where('user_id', $userId)
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        // On fusionne les données réelles avec les 0
        foreach ($realData as $data) {
            $monthlyActivity->put($data->month, [
                'month' => (int)$data->month,
                'count' => (int)$data->count
            ]);
        }

        return [
            'my_reservations_count' => Reservation::where('user_id', $userId)->count(),
            'my_active_reservations' => Reservation::where('user_id', $userId)
                                                 ->where('status', 'active')
                                                 ->count(),
            'my_incidents_count' => Incident::where('user_id', $userId)->count(),
            'monthly_activity' => $monthlyActivity->values(),
        ];
    }
}
