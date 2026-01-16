<?php

namespace App\Http\Controllers;

use App\Services\ResourceStatisticsService;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    protected $statsService;

    public function __construct(ResourceStatisticsService $statsService)
    {
        $this->statsService = $statsService;
    }

    /**
     * Affiche le tableau de bord des statistiques.
     */
    public function index()
    {
        $generalStats = $this->statsService->getGeneralStats();
        $categoryDistribution = $this->statsService->getCategoryDistribution();
        $topResources = $this->statsService->getMostReservedResources();
        $healthStats = $this->statsService->getHealthStats();

        return view('statistics.index', compact(
            'generalStats',
            'categoryDistribution',
            'topResources',
            'healthStats'
        ));
    }

    /**
     * Affiche les statistiques personnelles de l'utilisateur.
     */
    public function myResources()
    {
        // En mode test/local, on simule l'utilisateur 1 (Ouarda par exemple)
        $userId = auth()->id() ?? 1;
        $userStats = $this->statsService->getUserStats($userId);

        return view('statistics.my-resources', compact('userStats'));
    }
}
