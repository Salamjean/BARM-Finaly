<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = ['date','cohort_id', 'rapport','lieu','number', 'file_presence', 'file_presence_partner'];

    public function cohort() : BelongsTo
    {
        return $this->belongsTo(Cohort::class, 'cohort_id', 'id');
    }

    public function candidatures(): BelongsToMany
    {
        return
        $this->belongsToMany(Candidature::class,'commissioncandidats','commission_id','candidature_id')->withPivot('partner_financial_id','other_partner_financial','decision','comment');
    }
    

    public function partenaires(): BelongsToMany
    {
        return $this->belongsToMany(Partenaire::class,'commissionpartenaires','commission_id','partenaire_id')->withPivot('type');
    }

    public function juries(): HasMany
    {
        return $this->hasMany(CommissionJury::class, 'commission_id', 'id');
    }
}
