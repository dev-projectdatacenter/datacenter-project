<?php

namespace App\Services;

use App\Models\Resource;
use App\Models\Reservation;
use App\Models\User;

class StatisticsService
{
    // Total ressources
    public function totalResources(): int
    {
        return Resource::count();
    }

    // Ressources disponibles
    public function availableResources(): int
    {
        return Resource::where('status', 'available')->count();
    }

    // Total réservations
    public function totalReservations(?int $userId = null): int
    {
        $query = Reservation::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->count();
    }

    // Réservations groupées par statut
    public function reservationsByStatus(?int $userId = null): array
    {
        $query = Reservation::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }

    // Total utilisateurs
    public function totalUsers(): int
    {
        return User::count();
    }

    // Réservations en attente (pending)
    public function pendingReservations(): int
    {
        return Reservation::where('status', 'pending')->count();
    }


    // Ressources critiques (busy)
    public function criticalResources(): int
    {
        return Resource::where('status', 'busy')->count();
    }

    // --- New Methods for Tech Manager Dashboard List View ---

    public function getAllReservations()
    {
        return Reservation::with(['user', 'resource'])->orderBy('created_at', 'desc')->get();
    }

    public function getAllResources()
    {
        return Resource::with('category')->get();
    }

    public function getPendingIncidents()
    {
        return \App\Models\Incident::where('status', 'open')->with(['user', 'resource'])->get();
    }

    // Calculate total reservation hours for a user
    public function monthlyHours(?int $userId = null): float
    {
        $query = Reservation::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->selectRaw('SUM(TIMESTAMPDIFF(HOUR, start_date, end_date)) as total_hours')
            ->value('total_hours') ?? 0;
    }

}
