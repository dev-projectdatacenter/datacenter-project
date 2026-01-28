<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    
    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'notifications';
    
    /**
     * Les champs pouvant être remplis en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'message',
        'read',
    ];

    /**
     * Relation : une notification appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
