<?php

namespace App\Services;

use App\Models\User;
use App\Models\Resource;
use App\Models\Reservation;

class StatisticsService
{
    /**
     * Récupère le nombre total d'utilisateurs
     *
     * @return int
     */
    public function getTotalUsers(): int
    {
        return User::count();
    }

    /**
     * Récupère le nombre d'utilisateurs actifs
     *
     * @return int
     */
    public function getActiveUsers(): int
    {
        return User::where('status', 'active')->count();
    }

    /**
     * Get total number of resources
     *
     * @return int
     */
    public function totalResources(): int
    {
        return Resource::count();
    }

    /**
     * Get number of available resources
     *
     * @return int
     */
    public function availableResources(): int
    {
        return Resource::where('status', 'available')->count();
    }

    /**
     * Get total number of users (alias for getTotalUsers for backward compatibility)
     *
     * @return int
     */
    public function totalUsers(): int
    {
        return $this->getTotalUsers();
    }

    /**
     * Get total number of reservations
     *
     * @param int|null $userId Optional user ID to filter by user
     * @return int
     */
    public function totalReservations(?int $userId = null): int
    {
        $query = Reservation::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        return $query->count();
    }

    /**
     * Get reservations grouped by status
     *
     * @param int|null $userId Optional user ID to filter by user
     * @return array
     */
    public function reservationsByStatus(?int $userId = null): array
    {
        $query = Reservation::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        return $query->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }
}
