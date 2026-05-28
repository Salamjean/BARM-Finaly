<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SelfEmploymentMonitoredPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidature_id',
        'created_by',

        'account_opening',
        'account_opening_updated_by',
        'datetime_plug_removal',

        'file',
        'authorization_approved',
        'datetime_authorization_approved',
        'authorization_approved_updated_by',

        'open_disbursement',
        'disbursement_form',
        'status_disbursement',
        'report_disbursement',

        'signed_disbursement_document',

        'loan_set_up_date',
        'loan_set_up_date_by',
    ];

    public function candidature() : BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function disbursements() : HasMany
    {
        return $this->hasMany(Disbursement::class);
    }

    public function disbursementDeadlines(): HasMany
    {
        return $this->hasMany(DisbursementDeadline::class);
    }
}
