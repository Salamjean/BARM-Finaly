<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pointing extends Model
{
    use HasFactory;

    public function personal () : BelongsTo
    {
        return $this->belongsTo(User::class, 'personal_id', 'id');
    }
}
