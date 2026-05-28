<?php

namespace App\Models;

use App\Models\Personnel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Decoration extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class,'personnel_id', 'id');
    }
}
