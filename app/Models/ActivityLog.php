<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    // Nom exact de la table (important)
    protected $table = 'activity_logs';

    // Autoriser l'accès aux colonnes
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
    ];

    // Relation simple avec users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retourne la couleur associée à l'action
     *
     * @return string
     */
    public function getActionColor()
    {
        $action = strtolower($this->action);
        $colors = [
            'connexion' => 'action-login',
            'déconnexion' => 'action-logout',
            'creation' => 'action-create',
            'mise à jour' => 'action-update',
            'suppression' => 'action-delete',
            'erreur' => 'action-error',
            'avertissement' => 'action-warning',
        ];

        // Gérer les cas comme 'USER_CREATED', 'USER_UPDATED'
        if (str_contains($action, 'create')) return $colors['creation'];
        if (str_contains($action, 'update')) return $colors['mise à jour'];
        if (str_contains($action, 'delete')) return $colors['suppression'];

        return $colors[$action] ?? 'action-default';
    }

    /**
     * Retourne le libellé formaté de l'action
     *
     * @return string
     */
    public function getActionLabel()
    {
        $action = strtolower($this->action);
        $labels = [
            'connexion' => 'Connexion',
            'déconnexion' => 'Déconnexion',
            'creation' => 'Création',
            'mise à jour' => 'Mise à jour',
            'suppression' => 'Suppression',
            'erreur' => 'Erreur',
            'avertissement' => 'Avertissement',
        ];

        // Gérer les cas comme 'USER_CREATED', 'USER_UPDATED'
        if (str_contains($action, 'create')) return $labels['creation'];
        if (str_contains($action, 'update')) return $labels['mise à jour'];
        if (str_contains($action, 'delete')) return $labels['suppression'];

        return $labels[$action] ?? ucfirst($this->action);
    }
}
