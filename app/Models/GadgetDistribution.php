<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GadgetDistribution extends Model
{
    use HasFactory;

    protected $table = 'gadget_distributions';

    protected $fillable = [
        'reference',
        'title',
        'sub_title',
        'distribution_date',
    ];

    public function distributions(): HasMany
    {
        return $this->hasMany(DistributionItem::class);
    }
}
