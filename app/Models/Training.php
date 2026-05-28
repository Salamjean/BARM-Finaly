<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Training extends Model
{
    use HasFactory;

    protected $table = 'trainings';

    protected $fillable = [
        'cohort_id', 'partner_technicial_id', 'title', 'description', 'observation', 'beging_date', 'end_date', 'status',
        'file_presence'
    ];

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partenaire::class, 'partner_technicial_id', 'id');
    }

    public function participations(): HasMany
    {
        return $this->hasMany(TrainingParticipation::class);
    }
}
