<?php
/**
 * NotificationService.php
 * Service de notifications - Version pure Laravel
 * Géré par HALIMA - Jour 7 (CORRECTION)
 * CONTRAINTES: Laravel pur + CSS/JS personnalisé (sans jQuery, Bootstrap, Tailwind)
 */

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Créer une notification interne.
     * Version pure Laravel sans dépendances externes
     *
     * @param int $userId Destinataire
     * @param string $title Titre de la notification
     * @param string $message Corps du message
     * @param string $type Type (info, success, warning, error, reservation_approved, etc.)
     * @param int|null $referenceId ID optionnel de l'objet concerné
     * @return Notification
     */
    public static function create($userId, $title, $message, $type = 'info', $referenceId = null)
    {
        // Validation manuelle des entrées
        if (!is_numeric($userId)) {
            throw new \InvalidArgumentException('User ID must be numeric');
        }
        
        if (empty($title) || empty($message)) {
            throw new \InvalidArgumentException('Title and message are required');
        }
        
        $allowedTypes = ['info', 'success', 'warning', 'error', 'reservation_approved', 'reservation_rejected', 'reservation_cancelled', 'reservation_reminder'];
        if (!in_array($type, $allowedTypes)) {
            $type = 'info'; // Type par défaut
        }

        return Notification::create([
            'user_id' => (int) $userId,
            'type' => $type,
            'message' => $title . ' : ' . $message,
            'read' => false,
        ]);
    }

    /**
     * Créer une notification pour un utilisateur par son email
     */
    public static function createForEmail($email, $title, $message, $type = 'info', $referenceId = null)
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            throw new \Exception('User not found with email: ' . $email);
        }

        return self::create($user->id, $title, $message, $type, $referenceId);
    }

    /**
     * Créer des notifications pour plusieurs utilisateurs
     */
    public static function createBulk($userIds, $title, $message, $type = 'info', $referenceId = null)
    {
        $notifications = [];
        
        foreach ($userIds as $userId) {
            try {
                $notifications[] = self::create($userId, $title, $message, $type, $referenceId);
            } catch (\Exception $e) {
                // Continuer même si une notification échoue
                \Log::error('Failed to create notification for user ' . $userId . ': ' . $e->getMessage());
            }
        }

        return $notifications;
    }

    /**
     * Envoyer une notification de réservation approuvée
     */
    public static function reservationApproved($userId, $resourceName, $referenceId = null)
    {
        return self::create(
            $userId,
            'Réservation approuvée',
            "Votre réservation pour la ressource '{$resourceName}' a été approuvée.",
            'reservation_approved',
            $referenceId
        );
    }

    /**
     * Envoyer une notification de réservation refusée
     */
    public static function reservationRejected($userId, $resourceName, $reason = null, $referenceId = null)
    {
        $message = "Votre réservation pour la ressource '{$resourceName}' a été refusée.";
        if ($reason) {
            $message .= " Raison: {$reason}";
        }

        return self::create(
            $userId,
            'Réservation refusée',
            $message,
            'reservation_rejected',
            $referenceId
        );
    }

    /**
     * Envoyer une notification de réservation annulée
     */
    public static function reservationCancelled($userId, $resourceName, $referenceId = null)
    {
        return self::create(
            $userId,
            'Réservation annulée',
            "Votre réservation pour la ressource '{$resourceName}' a été annulée.",
            'reservation_cancelled',
            $referenceId
        );
    }

    /**
     * Envoyer un rappel de réservation
     */
    public static function reservationReminder($userId, $resourceName, $startDate, $referenceId = null)
    {
        return self::create(
            $userId,
            'Rappel de réservation',
            "Votre réservation pour '{$resourceName}' commence le {$startDate}.",
            'reservation_reminder',
            $referenceId
        );
    }

    /**
     * Envoyer une notification système
     */
    public static function systemNotification($userId, $message, $type = 'info')
    {
        return self::create(
            $userId,
            'Notification système',
            $message,
            $type
        );
    }

    /**
     * Envoyer une notification à tous les administrateurs
     */
    public static function notifyAdmins($title, $message, $type = 'info')
    {
        $adminUsers = User::where('role', 'admin')->get();
        $notifications = [];

        foreach ($adminUsers as $admin) {
            $notifications[] = self::create($admin->id, $title, $message, $type);
        }

        return $notifications;
    }

    /**
     * Envoyer une notification à tous les gestionnaires techniques
     */
    public static function notifyTechManagers($title, $message, $type = 'info')
    {
        $techManagers = User::where('role', 'tech_manager')->get();
        $notifications = [];

        foreach ($techManagers as $techManager) {
            $notifications[] = self::create($techManager->id, $title, $message, $type);
        }

        return $notifications;
    }

    /**
     * Compter les notifications non lues pour un utilisateur
     */
    public static function getUnreadCount($userId)
    {
        return Notification::where('user_id', $userId)
            ->where('read', false)
            ->count();
    }

    /**
     * Marquer toutes les notifications comme lues pour un utilisateur
     */
    public static function markAllAsRead($userId)
    {
        return Notification::where('user_id', $userId)
            ->where('read', false)
            ->update(['read' => true]);
    }

    /**
     * Supprimer les anciennes notifications (plus de 30 jours)
     */
    public static function cleanupOldNotifications()
    {
        return Notification::where('created_at', '<', now()->subDays(30))
            ->delete();
    }
}
