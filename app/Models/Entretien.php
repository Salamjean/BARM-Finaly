<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entretien extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'autor_id',
        'type',
        'parcours',
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

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id', 'id');
    }

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class, 'cohort_id', 'id');
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class);
    }

    public function candidatentretiens(): HasMany
    {
        return $this->hasMany(Candidatentretien::class);
    }

}
