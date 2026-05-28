<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubPrefecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name'
    ];

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class);
    }
}
