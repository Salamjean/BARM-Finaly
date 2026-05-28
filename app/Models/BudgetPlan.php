<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPlan extends Model
{
    use HasFactory;

    protected $fillable = ['type','name', 'year', 'description', 'status', 'conversion_xof'];

    public function components()
    {
        return $this->hasMany(BudgetPlanComponent::class, 'budget_plan_id');
    }
}
