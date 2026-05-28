<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidatsadmi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'candidature_id',
        'inscriptionconcour_id',
        'intitule_concours',
        'type_concours',
        'autor_id',
        'attestation',
        'affectation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'date',
    ];

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }

    public function concours(): BelongsTo
    {
        return $this->belongsTo(Inscriptionconcour::class, 'inscriptionconcour_id', 'id');
    }
}
