<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPostMonitored extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_type',
        'created_by',
        'candidature_id',
        'report_title',
        'date_visit',
        'report_description',
        'file_report',
    ];

    public function candidature(){
        return $this->belongsTo(Candidature::class);
    }

    public function createdBy()
    {
        
        return $this->belongsTo(User::class, 'created_by');
    }
}
