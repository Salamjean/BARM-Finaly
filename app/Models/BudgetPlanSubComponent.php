<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPlanSubComponent extends Model
{
    use HasFactory;

    protected $fillable = ['budget_plan_component_id', 'code', 'title', 'amount'];

    public function component()
    {
        return $this->belongsTo(BudgetPlanComponent::class, 'budget_plan_component_id');
    }

    public function sections()
    {
        return $this->hasMany(BudgetPlanSection::class, 'budget_plan_sub_component_id');
    }
}
