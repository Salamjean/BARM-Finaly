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
        'phone2',
        'residence',
        'axe_auto_emploi',
        'auto_emploi_projet1',
        'auto_emploi_projet2',
        'axe_entreprise_privee',
        'entreprise_privee_emploi',
        'entreprise_privee_formation1',
        'entreprise_privee_formation2',
        'axe_fonction_publique',
        'fonction_publique_diplome',
        'fonction_publique_emploi1',
        'fonction_publique_emploi2',
        'verified',
        'retired_date',
        'status',
        'admin_notes',
        'retired_id',
        'processed_at',
        'processed_by',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'axe_auto_emploi' => 'boolean',
        'axe_entreprise_privee' => 'boolean',
        'axe_fonction_publique' => 'boolean',
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
