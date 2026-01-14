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
        'created_at'
    ];

    // Relation simple avec users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
