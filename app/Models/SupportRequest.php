<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'urgency',
        'resource_id',
        'notes',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $with = [
        'user',
        'resource'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeByUrgency($query, $urgency)
    {
        return $query->where('urgency', $urgency);
    }

    // Méthodes
    public function markAsInProgress()
    {
        $this->status = 'in_progress';
        $this->updated_at = now();
        $this->save();
    }

    public function markAsResolved()
    {
        $this->status = 'resolved';
        $this->updated_at = now();
        $this->save();
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    public function isResolved()
    {
        return $this->status === 'resolved';
    }

    public function getUrgencyLabelAttribute()
    {
        return [
            'low' => 'Faible',
            'medium' => 'Moyenne',
            'high' => 'Élevée',
            'critical' => 'Critique'
        ][$this->urgency] ?? 'Non défini';
    }

    public function getStatusLabelAttribute()
    {
        return [
            'pending' => 'En attente',
            'in_progress' => 'En cours',
            'resolved' => 'Résolu'
        ][$this->status] ?? 'Inconnu';
    }
}
