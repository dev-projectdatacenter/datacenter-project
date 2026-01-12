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
}
