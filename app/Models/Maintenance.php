<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;
    /**
     * Champs pouvant être remplis en masse
     */
    protected $fillable = [
        'resource_id',
        'start_date',
        'end_date',
        'reason',
    ];

    /**
     * Relation : une maintenance appartient à une ressource
     */
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
