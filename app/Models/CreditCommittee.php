<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditCommittee extends Model
{
    use HasFactory;

    protected  $fillable = [
        'pv_committee_id',
        'candidature_id',
        'agency',
        'amount_agreed',
        'deferred_months',
        'loan_duration',
        'pension',
        'pension_partner_financial',

        'amount_ten_percent',
        'ten_percent_updated_by',
        'datetime_ten_percent',
        
        'status',
        'motif_ajournement',
    ];

    public function pvCommittee(): BelongsTo
    {
        return $this->belongsTo(PvCommittee::class);
    } 

    public function candidature() : BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    } 
}
