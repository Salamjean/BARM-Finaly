<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnualBudgetEstablishment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'annual_budget_id',
        'chief_id',
        'cell_id',
        'elements',
        'elements_retained',
        'date',
        'description',
        'summary',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'annual_budget_id' => 'integer',
        'chief_id' => 'integer',
    ];

    public function annualBudget()
    {
        return $this->belongsTo(AnnualBudget::class);
    }

    public function chief()
    {
        return $this->belongsTo(User::class, 'chief_id', 'id');
    }
}
