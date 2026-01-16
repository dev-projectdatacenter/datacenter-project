<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use App\Services\ReservationValidationService;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;

class TestServicesController extends Controller
{
    /**
     * Injection de dépendances via le constructeur
     */
    public function __construct(
        private StatisticsService $stats,
        private ReservationValidationService $validation,
        private NotificationService $notification
    ) {}

    /**
     * Tester tous les services
     */
    public function test(): JsonResponse
    {
        try {
            // Tester StatisticsService
            $statisticsData = [
                'totalResources' => $this->stats->totalResources(),
                'availableResources' => $this->stats->availableResources(),
                'totalReservations' => $this->stats->totalReservations(),
                'totalUsers' => $this->stats->totalUsers(),
                'reservationsByStatus' => $this->stats->reservationsByStatus(),
            ];

            // Tester ReservationValidationService
            $resourceId = 1;
            $startDate = '2026-01-15';
            $endDate = '2026-01-17';
            $isAvailable = $this->validation->isAvailable($resourceId, $startDate, $endDate);

            $validationData = [
                'resourceId' => $resourceId,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'isAvailable' => $isAvailable,
            ];

            // Tester NotificationService
            $this->notification->notify("Test notification depuis le controller");
            $this->notification->reservationCreated(5);
            $this->notification->reservationStatusUpdated(5, 'approved');

            // Retourner une réponse JSON structurée
            return response()->json([
                'success' => true,
                'message' => 'Tous les services fonctionnent correctement',
                'data' => [
                    'statistics' => $statisticsData,
                    'validation' => $validationData,
                    'notifications' => [
                        'status' => 'Notifications envoyées avec succès',
                    ],
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du test des services',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}