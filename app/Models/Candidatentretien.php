<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidatentretien extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entretien_id',
        'candidature_id',
        'presence',
        'comment',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'entretien_id' => 'integer',
        'candidature_id' => 'integer',
    ];

    public function entretien(): BelongsTo
    {
        return $this->belongsTo(Entretien::class, 'entretien_id', 'id');
    }

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class, 'candidature_id', 'id');
    }
}
