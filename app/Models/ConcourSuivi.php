<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConcourSuivi extends Model
{
    use HasFactory;

    protected $table = 'concour_suivis';

    protected $fillable = [
        'candidature_id',
        'date_choix',
        'intitule_concours',
        'type_concours',
        'prepa_date_debut',
        'prepa_date_fin',
        'prepa_statut',
        'prepa_obs',
        'dossier_r1_date',
        'dossier_r1_statut',
        'dossier_r1_obs',
        'dossier_r1_file',
        'dossier_r2_date',
        'dossier_r2_statut',
        'dossier_r2_obs',
        'dossier_r2_file',
        'choix_final_statut',
        'choix_final_date',
        'choix_final_recu',
        'choix_final_motif',
        'resultat_statut',
        'resultat_date',
        'resultat_attestation',
        'resultat_affectation',
        'resultat_obs',
        'autor_id',
    ];

    protected $casts = [
        'date_choix' => 'date',
        'prepa_date_debut' => 'date',
        'prepa_date_fin' => 'date',
        'dossier_r1_date' => 'date',
        'dossier_r2_date' => 'date',
        'choix_final_date' => 'date',
        'resultat_date' => 'date',
    ];

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class, 'candidature_id');
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id');
    }
}
