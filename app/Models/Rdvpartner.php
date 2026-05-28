<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rdvpartner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'partenaire_id',
        'candidature_id',
        'date',
        'heure',
        'lieu',
        'rapport',
        'presence',
    ];

    public function partenaire(): BelongsTo
    {
        return $this->belongsTo(Partenaire::class);
    }

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }
}
