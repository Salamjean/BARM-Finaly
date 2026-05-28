<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offreemploi extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'description',
        'localisation',
        'datefin',
        'autor_id'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id', 'id');
    }
}
