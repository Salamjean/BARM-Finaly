<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inscriptionconcour extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'candidature_id',
        'date',
        'recu',
        'intitule_concours',
        'type_concours',
        'status',
        'autor_id',
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

    public function admi(): HasOne
    {
        return $this->hasOne(Candidatsadmi::class, 'inscriptionconcour_id', 'id');
    }

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }

    
}
