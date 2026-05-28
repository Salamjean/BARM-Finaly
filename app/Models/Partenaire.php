<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partenaire extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function candidatures(): BelongsToMany
    {
        return $this->belongsToMany(Candidature::class, 'candidaturepartenaires','candidature_id','partenaire_id')->withPivot('status','partner_financial_id','other_partner_financial');
    }

    public function sessioncollectives(): BelongsToMany
    {
        return $this->belongsToMany(Sessioncollective::class, 'partenaire_sessioncollective','sessioncollective_id','partenaire_id')->withPivot('type');
    }

    public function rdvpartenaires(): HasMany
    {
        return $this->hasMany(Rdvpartner::class);
    }

    public function formationPartenaire(): BelongsTo
    {
        return $this->belongsTo(Partenaire::class, 'id');
    }

    public function commissions(): BelongsToMany
    {
        return $this->belongsToMany(Commission::class,'commissionpartenaires','commission_id','partenaire_id')->withPivot('type');
    }

    public function profilage()
    {
        return $this->hasOne(Profilage::class);
    }
}
