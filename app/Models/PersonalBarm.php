<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalBarm extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fullName(): string
    {
        return strtoupper($this->firstname) . ' ' . ucfirst(strtolower($this->lastname));
    }

}
