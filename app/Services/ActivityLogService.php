<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    /**
     * Enregistrer une activité
     */
    public static function log(string $action, string $description, ?int $userId = null, ?string $ipAddress = null)
    {
        $userId = $userId ?? (Auth::check() ? Auth::id() : null);
        $ipAddress = $ipAddress ?? request()->ip();

        return ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => $ipAddress,
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Enregistrer une connexion
     */
    public static function logLogin($user)
    {
        return self::log(
            'login',
            "Connexion de l'utilisateur {$user->name} ({$user->email})",
            $user->id
        );
    }

    /**
     * Enregistrer une déconnexion
     */
    public static function logLogout($user)
    {
        return self::log(
            'logout',
            "Déconnexion de l'utilisateur {$user->name} ({$user->email})",
            $user->id
        );
    }

    /**
     * Enregistrer une tentative de connexion échouée
     */
    public static function logFailedLogin($email)
    {
        return self::log(
            'failed_login',
            "Tentative de connexion échouée avec l'email: {$email}",
            null
        );
    }

    /**
     * Enregistrer la création d'un utilisateur
     */
    public static function logUserCreated($user, $createdBy = null)
    {
        return self::log(
            'user_created',
            "Création de l'utilisateur {$user->name} ({$user->email}) avec le rôle {$user->role}",
            $createdBy?->id
        );
    }

    /**
     * Enregistrer la modification d'un utilisateur
     */
    public static function logUserUpdated($user, $updatedBy = null)
    {
        return self::log(
            'user_updated',
            "Modification de l'utilisateur {$user->name} ({$user->email})",
            $updatedBy?->id
        );
    }

    /**
     * Enregistrer la suppression d'un utilisateur
     */
    public static function logUserDeleted($userName, $deletedBy = null)
    {
        return self::log(
            'user_deleted',
            "Suppression de l'utilisateur {$userName}",
            $deletedBy?->id
        );
    }

    /**
     * Enregistrer l'approbation d'une demande de compte
     */
    public static function logAccountRequestApproved($request, $approvedBy = null)
    {
        return self::log(
            'account_request_approved',
            "Approbation de la demande de compte de {$request->name} ({$request->email})",
            $approvedBy?->id
        );
    }

    /**
     * Enregistrer le refus d'une demande de compte
     */
    public static function logAccountRequestRejected($request, $rejectedBy = null)
    {
        return self::log(
            'account_request_rejected',
            "Refus de la demande de compte de {$request->name} ({$request->email})",
            $rejectedBy?->id
        );
    }

    /**
     * Récupérer les logs récents
     */
    public static function getRecentLogs($limit = 50)
    {
        return ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Récupérer les logs d'un utilisateur
     */
    public static function getUserLogs($userId, $limit = 100)
    {
        return ActivityLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Récupérer les logs par action
     */
    public static function getLogsByAction($action, $limit = 100)
    {
        return ActivityLog::where('action', $action)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
