<?php

namespace App\Policies;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResourcePolicy
{
    /**
     * Determine si l'utilisateur peut voir la ressource
     */
    public function view(User $user, Resource $resource): bool
    {
        // Tous les utilisateurs authentifiés peuvent voir les ressources
        return true;
    }

    /**
     * Determine si l'utilisateur peut voir la liste des ressources
     */
    public function viewAny(User $user): bool
    {
        // Tous les utilisateurs authentifiés peuvent voir la liste
        return true;
    }

    /**
     * Determine si l'utilisateur peut créer une ressource
     */
    public function create(User $user): bool
    {
        // Seuls les admin et tech managers peuvent créer des ressources
        return in_array($user->role->name, ['admin', 'tech_manager']);
    }

    /**
     * Determine si l'utilisateur peut modifier la ressource
     */
    public function update(User $user, Resource $resource): bool
    {
        // Admin peut modifier toutes les ressources
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut modifier seulement les ressources qu'il gère
        if ($user->role->name === 'tech_manager' && $resource->managed_by === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut supprimer la ressource
     */
    public function delete(User $user, Resource $resource): bool
    {
        // Admin peut supprimer toutes les ressources
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut supprimer seulement les ressources qu'il gère
        if ($user->role->name === 'tech_manager' && $resource->managed_by === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut restaurer la ressource
     */
    public function restore(User $user, Resource $resource): bool
    {
        // Seul l'admin peut restaurer des ressources
        return $user->role->name === 'admin';
    }

    /**
     * Determine si l'utilisateur peut supprimer définitivement la ressource
     */
    public function forceDelete(User $user, Resource $resource): bool
    {
        // Seul l'admin peut supprimer définitivement des ressources
        return $user->role->name === 'admin';
    }

    /**
     * Determine si l'utilisateur peut mettre la ressource en maintenance
     */
    public function maintenance(User $user, Resource $resource): bool
    {
        // Admin peut mettre n'importe quelle ressource en maintenance
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut mettre seulement les ressources qu'il gère en maintenance
        if ($user->role->name === 'tech_manager' && $resource->managed_by === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut voir les statistiques de la ressource
     */
    public function viewStatistics(User $user, Resource $resource): bool
    {
        // Admin peut voir toutes les statistiques
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut voir les statistiques des ressources qu'il gère
        if ($user->role->name === 'tech_manager' && $resource->managed_by === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut gérer les réservations de cette ressource
     */
    public function manageReservations(User $user, Resource $resource): bool
    {
        // Admin peut gérer toutes les réservations
        if ($user->role->name === 'admin') {
            return true;
        }

        // Tech manager peut gérer les réservations des ressources qu'il gère
        if ($user->role->name === 'tech_manager' && $resource->managed_by === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine si l'utilisateur peut réserver cette ressource
     */
    public function reserve(User $user, Resource $resource): bool
    {
        // La ressource doit être active
        if ($resource->status !== 'active') {
            return false;
        }

        // La ressource ne doit pas être en maintenance
        if ($resource->is_in_maintenance) {
            return false;
        }

        // Tous les utilisateurs authentifiés (sauf guests) peuvent réserver
        return in_array($user->role->name, ['user', 'tech_manager', 'admin']);
    }
}
