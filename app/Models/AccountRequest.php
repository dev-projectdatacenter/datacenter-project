<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountRequest extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',          // pending / approved / rejected
        'role_requested',  // user / tech_manager / admin
    ];

    /**
     * Les casts pour transformer automatiquement les types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Obtenir le statut formaté en français
     */
    public function getStatusFormattedAttribute()
    {
        return match($this->status) {
            'pending' => 'En attente',
            'approved' => 'Approuvée',
            'rejected' => 'Refusée',
            default => 'Inconnu'
        };
    }

    /**
     * Obtenir le rôle demandé formaté en français
     */
    public function getRoleRequestedFormattedAttribute()
    {
        return match($this->role_requested) {
            'user' => 'Utilisateur interne',
            'tech_manager' => 'Responsable technique',
            'admin' => 'Administrateur',
            default => 'Non spécifié'
        };
    }

    /**
     * Vérifier si la demande est en attente
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Vérifier si la demande est approuvée
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Relation avec l'utilisateur créé après approbation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'administrateur qui a approuvé
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relation avec l'administrateur qui a refusé
     */
    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
