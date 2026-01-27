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
        $colors = [
            'create' => 'action-create',
            'update' => 'action-update',
            'delete' => 'action-delete',
            'login' => 'action-login',
            'logout' => 'action-logout',
            'error' => 'action-error',
            'warning' => 'action-warning',
            'default' => 'action-default'
        ];

        return $colors[strtolower($this->action)] ?? $colors['default'];
    }

    /**
     * Retourne le libellé formaté de l'action
     *
     * @return string
     */
    public function getActionLabel()
    {
        $labels = [
            'create' => 'Création',
            'update' => 'Mise à jour',
            'delete' => 'Suppression',
            'login' => 'Connexion',
            'logout' => 'Déconnexion',
            'error' => 'Erreur',
            'warning' => 'Avertissement'
        ];

        return $labels[strtolower($this->action)] ?? ucfirst($this->action);
    }
}
