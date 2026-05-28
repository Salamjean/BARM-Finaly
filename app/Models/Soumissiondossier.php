<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Soumissiondossier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'candidature_id',
        'intitule_concours1',
        'type_concours1',
        'intitule_concours2',
        'type_concours2',
        'date1',
        'date2',
        'autor_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }
}
