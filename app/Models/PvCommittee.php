<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PvCommittee extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_financial_id',
        'reference',
        'date',
        'status',
    ];

    public function creditCommittees()
    {
        return $this->hasMany(CreditCommittee::class);
    }
}
