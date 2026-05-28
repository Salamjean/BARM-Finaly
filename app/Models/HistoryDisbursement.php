<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryDisbursement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'self_employment_monitored_payment_id',
        'amount_disbursement',
        'created_by',
        'report',
    ];

    public function selfEmploymentMonitoredPayment() : BelongsTo
    {
        return $this->belongsTo(SelfEmploymentMonitoredPayment::class,);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
