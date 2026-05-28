<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCandidate extends Model
{
    protected $fillable = [
        'candidature_id',
        'fullname',
        'birth_date',
        'level',
        'file',
        'job',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }
}
