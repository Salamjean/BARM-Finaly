<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidatentreprise extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'candidature_id',
        'entreprise',
        'date_mise_disposition',
        'statut',
        'service',
        'poste',
        'lettre_recommandation',
        'type_contrat',
        'date_db',
        'date_fin',
        'contrat',
        'localisation',
        'commentaire',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_mise_disposition' => 'date',
        'date_db' => 'date',
        'date_fin' => 'date',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }
}
