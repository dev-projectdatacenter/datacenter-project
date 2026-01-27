<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
    /**
     * Determine si l'utilisateur peut voir la réservation
     */
    public function view(User $user, Reservation $reservation): bool
    {
        // L'utilisateur peut voir sa propre réservation
        if ($reservation->user_id === $user->id) {
            return true;
        }

        // Admin peut voir toutes les réservations
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut voir les réservations des ressources qu'il gère
        if ($user->role->name === 'tech_manager' && $reservation->resource->managed_by === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut voir la liste des réservations
     */
    public function viewAny(User $user): bool
    {
        // Tous les utilisateurs authentifiés peuvent voir la liste des réservations
        return true;
    }

    /**
     * Determine si l'utilisateur peut créer une réservation
     */
    public function create(User $user): bool
    {
        // Seuls les utilisateurs (non-admins, non-tech-managers) peuvent créer des réservations
        return in_array($user->role->name, ['user', 'tech_manager', 'admin']);
    }

    /**
     * Determine si l'utilisateur peut créer une réservation pour une ressource spécifique
     */
    public function createForResource(User $user, $resource): bool
    {
        // La ressource doit être active
        if ($resource->status !== 'active') {
            return false;
        }

        // La ressource ne doit pas être en maintenance
        if ($resource->is_in_maintenance) {
            return false;
        }

        // Tous les utilisateurs authentifiés peuvent créer des réservations
        return in_array($user->role->name, ['user', 'tech_manager', 'admin']);
    }

    /**
     * Determine si l'utilisateur peut modifier la réservation
     */
    public function update(User $user, Reservation $reservation): bool
    {
        // L'utilisateur peut modifier sa propre réservation seulement si elle est en attente
        if ($reservation->user_id === $user->id && in_array($reservation->status, ['pending', 'approved'])) {
            return true;
        }

        // Admin peut modifier toutes les réservations
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut modifier les réservations des ressources qu'il gère
        if ($user->role->name === 'tech_manager' && $reservation->resource->managed_by === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut supprimer la réservation
     */
    public function delete(User $user, Reservation $reservation): bool
    {
        // L'utilisateur peut supprimer sa propre réservation seulement si elle est en attente
        if ($reservation->user_id === $user->id && $reservation->status === 'pending') {
            return true;
        }

        // Admin peut supprimer toutes les réservations
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut supprimer les réservations des ressources qu'il gère
        if ($user->role->name === 'tech_manager' && $reservation->resource->managed_by === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut approuver la réservation
     */
    public function approve(User $user, Reservation $reservation): bool
    {
        // Seuls les admin et tech managers peuvent approuver
        if (!in_array($user->role->name, ['admin', 'tech_manager'])) {
            return false;
        }

        // Admin peut approuver toutes les réservations
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut approuver seulement les réservations des ressources qu'il gère
        if ($user->role->name === 'tech_manager' && $reservation->resource->managed_by === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut refuser la réservation
     */
    public function reject(User $user, Reservation $reservation): bool
    {
        // Seuls les admin et tech managers peuvent refuser
        if (!in_array($user->role->name, ['admin', 'tech_manager'])) {
            return false;
        }

        // Admin peut refuser toutes les réservations
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut refuser seulement les réservations des ressources qu'il gère
        if ($user->role->name === 'tech_manager' && $reservation->resource->managed_by === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut annuler la réservation
     */
    public function cancel(User $user, Reservation $reservation): bool
    {
        // L'utilisateur peut annuler sa propre réservation si elle est approuvée ou active
        if ($reservation->user_id === $user->id && in_array($reservation->status, ['approved', 'active'])) {
            return true;
        }

        // Admin peut annuler toutes les réservations
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut annuler les réservations des ressources qu'il gère
        if ($user->role->name === 'tech_manager' && $reservation->resource->managed_by === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut marquer la réservation comme terminée
     */
    public function complete(User $user, Reservation $reservation): bool
    {
        // Seuls les admin et tech managers peuvent marquer comme terminée
        if (!in_array($user->role->name, ['admin', 'tech_manager'])) {
            return false;
        }

        // La réservation doit être active
        if ($reservation->status !== 'active') {
            return false;
        }

        // Admin peut terminer toutes les réservations
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut terminer seulement les réservations des ressources qu'il gère
        if ($user->role->name === 'tech_manager' && $reservation->resource->managed_by === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut voir l'historique des réservations
     */
    public function viewHistory(User $user): bool
    {
        // Tous les utilisateurs authentifiés peuvent voir leur historique
        return true;
    }

    /**
     * Determine si l'utilisateur peut voir les statistiques des réservations
     */
    public function viewStatistics(User $user): bool
    {
        // Admin peut voir toutes les statistiques
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut voir les statistiques des ressources qu'il gère
        if ($user->role->name === 'tech_manager') {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut exporter les réservations
     */
    public function export(User $user): bool
    {
        // Seuls admin et tech managers peuvent exporter
        return in_array($user->role->name, ['admin', 'tech_manager']);
    }
}
