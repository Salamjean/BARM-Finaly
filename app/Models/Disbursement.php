<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disbursement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'self_employment_monitored_payment_id',
        'document_file',
        'date_hour_submission_document',
        'amount_disbursement',
        'created_by',
        'authorization',
        'authorization_file',
        'authorization_date',
        'authorization_created_by',
        'reason',
        'report_date',
        'report_created_by',
        'report_file',
        'report_signed_date',
        'report_signed_created_by',
        'report_signed_file',
        'date_disbursement',
        'loan_set_up_date',
        'disbursement_submission_by',
        'file_disbursement',
        'status',
    ];

    public function selfEmploymentMonitoredPayment() : BelongsTo
    {
        return $this->belongsTo(SelfEmploymentMonitoredPayment::class,);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function authorizationCreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'authorization_created_by');
    }

    public function reportCreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'report_created_by');
    }
}
