<?php

namespace App\Models;

use App\Models\Cohort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sessioncollective extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cohort_id',
        'lieu',
        'date',
        'heure',
    ];

    public function partenaires(): BelongsToMany
    {
        return $this->belongsToMany(Partenaire::class, 'partenaire_sessioncollective','sessioncollective_id','partenaire_id')->withPivot('type');
    }

    public function candidatures(): BelongsToMany
    {
        return $this->belongsToMany(Candidature::class, 'candidature_sessioncollective','sessioncollective_id','candidature_id')->withPivot('methode_prise_contact', 'commentaire','presence','presence_status');
    }
    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class, 'cohort_id', 'id');
    }
}
