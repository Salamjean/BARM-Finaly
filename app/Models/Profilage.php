<?php

namespace App\Models;

use App\Models\Partenaire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profilage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cohort_id',
        'sessioncollective_id',
        'partenaire_id',
        'start_date',
        'end_date',
        'end',
    ];

    public function partenaire(): BelongsTo
    {
        return $this->belongsTo(Partenaire::class, 'partenaire_id', 'id');
    }

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class, 'cohort_id', 'id');
    }

    public function sessioncollective(): BelongsTo
    {
        return $this->belongsTo(Sessioncollective::class, 'sessioncollective_id', 'id');
    }

    public function candidatures(): BelongsToMany
    {
        return $this->belongsToMany(Candidature::class, 'candidatprofilages','profilage_id','candidature_id')->withPivot('profile');
    }
}
