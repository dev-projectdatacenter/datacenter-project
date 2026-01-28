<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;
use App\Models\Reservation;
use App\Models\Resource;
use App\Models\Incident;
use App\Models\User;
use App\Models\AccountRequest;
use App\Models\ActivityLog;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as BaseController;

class DashboardController extends BaseController
{
    private StatisticsService $stats;

    public function __construct(StatisticsService $stats)
    {
        $this->stats = $stats;
    }

    /**
     * Vérifie la disponibilité d'une ressource pour une période donnée
     */
    protected function checkReservationAvailability($resourceId, $startDate, $endDate, $excludeReservationId = null)
    {
        $query = Reservation::where('resource_id', $resourceId)
            ->where('status', '!=', 'cancelled')
            ->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function($q) use ($startDate, $endDate) {
                      $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                  });
            });

        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        return $query->doesntExist();
    }

    public function index()
    {
        $user = Auth::user();

        $role = strtolower($user->role->name ?? 'guest');
        // Convertir les noms de rôles pour correspondre aux noms de vues
        $viewName = match($role) {
            'tech_manager' => 'tech',
            'tech-manager' => 'tech',
            default => $role
        };

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

        if ($role === 'tech_manager' || $role === 'tech-manager') {
            $statistics['pendingReservations'] = Reservation::where('status', 'pending')->count();
            $statistics['criticalResources'] = Resource::where('status', 'maintenance')
                ->count();

            // Récupération des listes pour le tableau de bord
            $reservations = Reservation::with(['user', 'resource'])
                ->latest()
                ->take(10)
                ->get();
                
            $resources = Resource::latest()
                ->take(10)
                ->get();
                
            $incidents = Incident::where('status', 'pending')
                ->with('user')
                ->latest()
                ->take(10)
                ->get();
        }

        if ($role === 'admin') {
            // Données pour l'admin
            $users = User::with('role')->get();
            $accountRequests = AccountRequest::all();
            $activityLogs = ActivityLog::with('user')->latest()->take(10)->get();
        }

        if ($role === 'user') {
            // Données pour l'utilisateur : ses notifications
            $notifications = Notification::where('user_id', $user->id)
                ->where('read', false)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        if ($role === 'invite') {
            // Données pour l'invité : vue globale des ressources en lecture seule
            $resources = $this->stats->getAllResources();
        }

        return view("dashboard.$viewName", compact('statistics', 'user', 'reservations', 'resources', 'incidents', 'users', 'accountRequests', 'activityLogs', 'notifications'));
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

    public function admin()
    {
        return $this->index();
    }

    public function tech()
    {
        return $this->index();
    }

    public function user()
    {
        return $this->index();
    }

    public function guest()
    {
        $statistics = [
            'totalResources' => Resource::count(),
            'availableResources' => Resource::where('status', 'active')->count(),
            'categories' => \App\Models\ResourceCategory::count(),
        ];
        
        return view('dashboard.invite', compact('statistics'));
    }

    // API methods
    public function adminStats()
    {
        // Return JSON stats for admin
        return response()->json($this->stats->getAdminStats());
    }

    public function adminRecentActivities()
    {
        return response()->json($this->stats->getRecentActivities());
    }

    public function adminSystemStatus()
    {
        return response()->json($this->stats->getSystemStatus());
    }

    public function techStats()
    {
        return response()->json($this->stats->getTechStats());
    }

    public function techPendingReservations()
    {
        return response()->json($this->stats->getPendingReservations());
    }

    public function techResourceStatus()
    {
        return response()->json($this->stats->getResourceStatus());
    }

    public function userStats()
    {
        $user = Auth::user();
        return response()->json($this->stats->getUserStats($user->id));
    }

    public function userActiveReservations()
    {
        $user = Auth::user();
        return response()->json($this->stats->getUserActiveReservations($user->id));
    }

    public function userRecentActivity()
    {
        $user = Auth::user();
        return response()->json($this->stats->getUserRecentActivity($user->id));
    }

    public function guestResourceOverview()
    {
        return response()->json($this->stats->getResourceOverview());
    }
}