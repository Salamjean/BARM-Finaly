<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retired extends Model
{
    use HasFactory;

    protected $table = 'retireds';

    protected $fillable = [
        'year',
        'grade',
        'mecano',
        'matricule',
        'personal_id',
        'firstname',
        'lastname',
        'birth_date',
        'gender',
        'unit',
        'army',
        'used',
        'retired_date',
        'retired_type',
        'file_authorization',
        'forced_authorization',
    ];
}
