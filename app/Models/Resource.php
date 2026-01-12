<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
     /**
     * Champs pouvant être remplis en masse
     */
    protected $fillable = [
        'category_id',
        'name',
        'status',       // available / busy / maintenance
        'cpu',
        'ram',
        'storage',
        'os',
        'location',
    ];

    /**
     * Relation : une ressource appartient à une catégorie
     */
    public function category()
    {
        return $this->belongsTo(ResourceCategory::class);
    }

    /**
     * Relation : une ressource peut avoir plusieurs réservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Relation : une ressource peut avoir plusieurs maintenances
     */
    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * Relation : une ressource peut avoir plusieurs incidents
     */
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
}
