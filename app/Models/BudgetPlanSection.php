<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetPlanSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_plan_sub_component_id',
        'code',
        'title',
        
    ];


    public function subComponent(): BelongsTo
    {
        return $this->belongsTo(BudgetPlanSubComponent::class, 'budget_plan_sub_component_id');
    }

    public function parts()
    {
        return $this->hasMany(BudgetPlanPart::class, 'budget_plan_section_id');
    }

    public function activities()
    {
        return $this->hasMany(BudgetPlanActivity::class, 'budget_plan_section_id');
    }
}
