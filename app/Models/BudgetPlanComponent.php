<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPlanComponent extends Model
{
    use HasFactory;

    protected $fillable = ['budget_plan_id', 'code', 'title', 'amount'];

    public function budgetPlan()
    {
        return $this->belongsTo(BudgetPlan::class, 'budget_plan_id');
    }

    public function subComponents()
    {
        return $this->hasMany(BudgetPlanSubComponent::class, 'budget_plan_component_id');
    }
}
