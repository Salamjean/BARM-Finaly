<?php

namespace App\Models;

use App\Models\Candidatentretien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CandidaturePartenaire extends Model
{
    use HasFactory;

    protected $table = 'candidaturepartenaires';

    protected $guarded = [];

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class, 'candidature_id', 'id');
    }

    public function partenaire(): BelongsTo
    {
        return $this->belongsTo(Partenaire::class, 'partenaire_id', 'id');
    }

    public function partenaires(): BelongsToMany
    {
        return $this->belongsToMany(Partenaire::class, 'candidaturepartenaires','candidature_id','partenaire_id')->withPivot('status','partner_financial_id','other_partner_financial');
    }

}
