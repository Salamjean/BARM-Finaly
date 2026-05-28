<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnnualBudget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'personal_id',
        'title',
        'description',
        'year',
        'date',
        'summary',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function personal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'personal_id', 'id');
    }

    public function budgetByCell(): HasMany
    {
        return $this->hasMany(AnnualBudgetEstablishment::class);
    }
}
