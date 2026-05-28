<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cohort extends Model
{
    use HasFactory;

    protected $fillable = ['reference','title', 'description','number_adherent'];

    public function adhrents() : HasMany
    {
        return $this->hasMany(Candidature::class)->where('resignation', '0')->where('death', '0');
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    public function candidats() : HasMany
    {
    return $this->hasMany(Candidature::class)->where('resignation', '0')->where('death', '0')->where('session_collective','0');
    }

    public function trainings(): HasMany
    {
        return $this->hasMany(related: Training::class);
    }
}
