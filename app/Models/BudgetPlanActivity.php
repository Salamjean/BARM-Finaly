<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPlanActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_plan_section_id',
        'code',
        'title',
        'p_objective_q1',
        'p_objective_q2',
        'p_objective_q3',
        'p_objective_q4',
        'p_objective_annual',
        'execution_zone',
        'company',
        'ca_investment',
        'ca_service',
        'ca_transfer',
        'ca_personal',
        'ca_total',
        'entity',
        'observation',
    ];


    public function section()
    {
        return $this->belongsTo(BudgetPlanSection::class, 'budget_plan_section_id');
    }
}
