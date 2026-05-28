<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetiredPreregistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'mecano',
        'phone',
        'email',
        'message',
        'verified',
        'status',
        'admin_notes',
        'retired_id',
        'processed_at',
        'processed_by',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'processed_at' => 'datetime',
    ];

    /**
     * Relation avec le modèle Retired
     */
    public function retired()
    {
        return $this->belongsTo(Retired::class);
    }

    /**
     * Relation avec l'utilisateur qui a traité la demande
     */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Scope pour les demandes en attente
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope pour les demandes vérifiées
     */
    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    /**
     * Obtenir le nom complet
     */
    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
