<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisbursementDeadline extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date_refund',
        'status',
        'amount',
        'self_employment_monitored_payment_id',
        'reminder_dates',
        'date_expiry',
        'created_by',
        'updated_by',
    ];

    public function selfEmploymentMonitoredPayment()
    {
        return $this->belongsTo(SelfEmploymentMonitoredPayment::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
