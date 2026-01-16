<?php
/**
 * StatisticsController.php
 * Statistiques et graphiques
 * Géré par OUARDA
 */

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Reservation;
use App\Models\User;
use App\Models\ResourceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Statistiques globales (Admin)
     */
    public function global()
    {
        $stats = [
            'total_resources' => Resource::count(),
            'active_resources' => Resource::where('status', 'active')->count(),
            'total_reservations' => Reservation::count(),
            'active_reservations' => Reservation::where('status', 'active')->count(),
            'total_users' => User::count(),
            'pending_requests' => Reservation::where('status', 'pending')->count(),
        ];

        $occupancyRate = $this->calculateOccupancyRate();
        $topResources = $this->getTopResources();
        $categoryStats = $this->getCategoryStats();

        return view('statistics.global', compact('stats', 'occupancyRate', 'topResources', 'categoryStats'));
    }

    /**
     * Statistiques des ressources gérées (Tech Manager)
     */
    public function myResources()
    {
        $resources = Resource::where('managed_by', auth()->id())->get();
        
        $stats = [
            'total_resources' => $resources->count(),
            'active_resources' => $resources->where('status', 'active')->count(),
            'in_maintenance' => $resources->where('is_in_maintenance', true)->count(),
            'pending_reservations' => Reservation::whereIn('resource_id', $resources->pluck('id'))
                ->where('status', 'pending')->count(),
        ];

        $resourceUtilization = $this->getResourceUtilization($resources);
        $recentActivities = $this->getRecentActivities($resources);

        return view('statistics.my-resources', compact('stats', 'resourceUtilization', 'recentActivities'));
    }

    /**
     * Statistiques personnelles (User)
     */
    public function personal()
    {
        $user = auth()->user();
        
        $stats = [
            'total_reservations' => $user->reservations()->count(),
            'active_reservations' => $user->reservations()->where('status', 'active')->count(),
            'pending_reservations' => $user->reservations()->where('status', 'pending')->count(),
            'completed_reservations' => $user->reservations()->where('status', 'completed')->count(),
        ];

        $reservationHistory = $user->reservations()
            ->with('resource')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('statistics.personal', compact('stats', 'reservationHistory'));
    }

    /**
     * API pour les données du graphique d'utilisation
     */
    public function usageChartData(Request $request)
    {
        $period = $request->get('period', 'month'); // week, month, year
        
        $data = Reservation::selectRaw('DATE(start_date) as date, COUNT(*) as count')
            ->where('start_date', '>=', $this->getStartDate($period))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($data);
    }

    /**
     * API pour le taux d'occupation
     */
    public function occupancyRateData()
    {
        $rate = $this->calculateOccupancyRate();
        return response()->json(['rate' => $rate]);
    }

    /**
     * API pour les ressources les plus utilisées
     */
    public function topResourcesData()
    {
        $topResources = $this->getTopResources();
        return response()->json($topResources);
    }

    // Méthodes privées

    private function calculateOccupancyRate()
    {
        $totalResources = Resource::where('status', 'active')->count();
        if ($totalResources === 0) return 0;

        $activeReservations = Reservation::where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->distinct('resource_id')
            ->count();

        return round(($activeReservations / $totalResources) * 100, 2);
    }

    private function getTopResources($limit = 10)
    {
        return Resource::withCount(['reservations' => function ($query) {
                $query->where('status', '!=', 'cancelled');
            }])
            ->orderBy('reservations_count', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getCategoryStats()
    {
        return ResourceCategory::withCount(['resources' => function ($query) {
                $query->where('status', 'active');
            }])
            ->withCount(['reservations' => function ($query) {
                $query->where('status', 'active');
            }])
            ->get();
    }

    private function getResourceUtilization($resources)
    {
        $utilization = [];
        
        foreach ($resources as $resource) {
            $totalHours = $resource->reservations()
                ->where('status', 'completed')
                ->selectRaw('SUM(TIMESTAMPDIFF(HOUR, start_date, end_date)) as total_hours')
                ->value('total_hours') ?? 0;

            $utilization[] = [
                'resource' => $resource,
                'total_hours' => $totalHours,
                'reservation_count' => $resource->reservations()->count(),
            ];
        }

        return $utilization;
    }

    private function getRecentActivities($resources)
    {
        return Reservation::whereIn('resource_id', $resources->pluck('id'))
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    private function getStartDate($period)
    {
        switch ($period) {
            case 'week':
                return now()->subWeek();
            case 'month':
                return now()->subMonth();
            case 'year':
                return now()->subYear();
            default:
                return now()->subMonth();
        }
    }
}
