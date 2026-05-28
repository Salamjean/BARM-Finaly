<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPlanPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_plan_section_id',
        'total_execution',
        'code',
        'title',
        'details',
        'cost_total_project',
        'commitments',
        'percent_commitments',
        'cost_q1',
        'cost_q2',
        'cost_q3',
        'cost_q4',
        'cost_total_year',
        'chronogram_q1',
        'chronogram_q2',
        'chronogram_q3',
        'chronogram_q4',
        'comments',
        'phase',
    ];


    public function section()
    {
        return $this->belongsTo(BudgetPlanSection::class, 'budget_plan_section_id');
    }
}
