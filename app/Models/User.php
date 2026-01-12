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
    ];

    /**
     * Relation : un utilisateur appartient à un rôle.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
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
