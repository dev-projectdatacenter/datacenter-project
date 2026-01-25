<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image_url'];

    /**
     * Une catégorie peut avoir plusieurs ressources.
     */
    public function resources()
    {
        return $this->hasMany(Resource::class, 'category_id');
    }
}
