<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'gadget_id',
        'gadget_distribution_id',
        'quantity',
    ];


    public function gadget(): BelongsTo
    {
        return $this->belongsTo(Gadget::class);
    }

    public function distribution(): BelongsTo
    {
        return $this->belongsTo(GadgetDistribution::class, 'gadget_distribution_id');
    }


}
