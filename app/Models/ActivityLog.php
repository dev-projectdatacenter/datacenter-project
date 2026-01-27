<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
       // Champs pouvant être remplis en masse
    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'description',
    ];

    /**
     * Relation : un log d'activité appartient à un utilisateur.
     */
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
