<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingParticipation extends Model
{
    use HasFactory;

    protected $table = 'training_participations';

    protected $fillable = [
        'training_id',
        'candidature_id',
        'observation',
        'participation',
        'moment',
    ];

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }
}
