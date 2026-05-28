<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionJury extends Model
{
    use HasFactory;

    protected $table = 'commission_juries';

    protected $fillable = [
        'commission_id',
        'partner_id',
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id', 'id');
    }

    public function partner()
    {
        return $this->belongsTo(Partenaire::class, 'partner_id', 'id');
    }
}
