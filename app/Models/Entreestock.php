<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entreestock extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function consommable(): BelongsTo
    {
        return $this->belongsTo(Consommable::class, 'consommable_id', 'id');
    }
}
