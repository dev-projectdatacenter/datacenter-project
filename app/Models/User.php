<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les champs pouvant être remplis en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',    // pour relier l'utilisateur à un rôle
        'phone',      // numéro de téléphone optionnel
        'status',     // active / inactive / blocked
    ];

    /**
     * Les champs à cacher lors de la sérialisation (API / JSON).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les casts pour transformer automatiquement les types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec les notifications
     */
    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class, 'user_id');
    }
    
    /**
     * Obtenir le nombre de notifications non lues
     * 
     * @return int
     */
    public function unreadNotificationsCount()
    {
        return $this->notifications()->where('read', false)->count();
    }

    /**
     * Accesseur pour vérifier si l'utilisateur est actif
     */
    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    /**
     * Charger automatiquement la relation role.
     *
     * @var array<int, string>
     */
    protected $with = ['role'];

    /**
     * Relation : un utilisateur appartient à un rôle.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Vérifier si l'utilisateur a un rôle spécifique.
     */
    public function hasRole($roleName)
    {
        if (!$this->role) {
            return false;
        }
        
        return $this->role->name === $roleName;
    }

    /**
     * Vérifier si l'utilisateur a l'un des rôles spécifiés.
     */
    public function hasAnyRole($roles)
    {
        if (!$this->role) {
            return false;
        }
        
        if (is_string($roles)) {
            $roles = [$roles];
        }
        
        return in_array($this->role->name, $roles);
    }

    /**
     * Obtenir le nom du rôle de l'utilisateur.
     */
    public function getRoleName()
    {
        return $this->role ? $this->role->name : null;
    }

    /**
     * Vérifier si l'utilisateur est un administrateur.
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Vérifier si l'utilisateur est un tech manager.
     */
    public function isTechManager()
    {
        return $this->hasRole('tech_manager');
    }

    /**
     * Vérifier si l'utilisateur est un utilisateur normal.
     */
    public function isUser()
    {
        return $this->hasRole('user');
    }

    /**
     * Relation : un utilisateur peut avoir plusieurs réservations.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Relation : un utilisateur peut signaler plusieurs incidents.
     */
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    /**
     * Relation : un utilisateur peut avoir plusieurs logs d'activité.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
