<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private StatisticsService $stats;

    public function __construct(StatisticsService $stats)
    {
        $this->stats = $stats;
    }

    public function index()
    {
        $user = Auth::user();

        $role = strtolower($user->role->name ?? 'guest');
        $role = str_replace('_', '-', $role); // TECH_MANAGER -> tech-manager

        // Statistiques communes
        $statistics = [
            'totalResources' => $this->stats->totalResources(),
            'availableResources' => $this->stats->availableResources(),
            'totalUsers' => $this->stats->totalUsers(),
        ];

        // Admin & Tech Manager = données globales
        if (in_array($role, ['admin', 'tech-manager'])) {

            $statistics['totalReservations'] = $this->stats->totalReservations();
            $statistics['reservationsByStatus'] = $this->stats->reservationsByStatus();

        } else {

            // Utilisateur simple = ses données seulement
            $statistics['totalReservations'] = $this->stats->totalReservations($user->id);
            $statistics['reservationsByStatus'] = $this->stats->reservationsByStatus($user->id);
        }

        // Alertes spéciales Tech Manager
        $reservations = [];
        $resources = [];
        $incidents = [];
        $users = [];
        $accountRequests = [];
        $activityLogs = [];
        $notifications = [];

        if ($role === 'tech-manager') {
            $statistics['pendingReservations'] = $this->stats->pendingReservations();
            $statistics['criticalResources'] = $this->stats->criticalResources();

            // Récupération des listes pour le tableau de bord
            $reservations = $this->stats->getAllReservations();
            $resources = $this->stats->getAllResources();
            $incidents = $this->stats->getPendingIncidents();
        }

        if ($role === 'admin') {
            // Données pour l'admin
            $users = \App\Models\User::with('role')->get();
            $accountRequests = \App\Models\AccountRequest::all();
            $activityLogs = \App\Models\ActivityLog::with('user')->latest()->take(10)->get();
        }

        if ($role === 'user') {
            // Données pour l'utilisateur : ses notifications
            $notifications = \App\Models\Notification::where('user_id', $user->id)->where('read', false)->orderBy('created_at', 'desc')->get();
        }

        if ($role === 'invite') {
            // Données pour l'invité : vue globale des ressources en lecture seule
            $resources = $this->stats->getAllResources();
        }

        return view("dashboard.$role", compact('statistics', 'user', 'reservations', 'resources', 'incidents', 'users', 'accountRequests', 'activityLogs', 'notifications'));
    }

    public function validateReservation($id)
    {
        $reservation = \App\Models\Reservation::findOrFail($id);
        $reservation->status = 'validated';
        $reservation->save();

        return redirect()->back()->with('success', 'Réservation validée.');
    }

    public function refuseReservation($id)
    {
        $reservation = \App\Models\Reservation::findOrFail($id);
        $reservation->status = 'refused';
        $reservation->save();

        return redirect()->back()->with('success', 'Réservation refusée.');
    }

    public function toggleMaintenance($id)
    {
        $resource = \App\Models\Resource::findOrFail($id);

        if ($resource->status === 'maintenance') {
            $resource->status = 'available';
        } else {
            $resource->status = 'maintenance';
        }

        $resource->save();

        return redirect()->back()->with('success', 'Statut de la ressource mis à jour.');
    }

    public function deleteIncident($id)
    {
        $incident = \App\Models\Incident::findOrFail($id);
        $incident->delete();

        return redirect()->back()->with('success', 'Incident supprimé avec succès.');
    }
}
