<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'table',
        'type',
        'user_type',
        'user_id',
        'adherent_id',
        'reason',
        'data',
    ];
}
