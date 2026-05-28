<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lettrerecommandation extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidature_id',
        'date_demande',
        'status',
        'commentaire',
        'lettre',
        'autor_id',
    ];

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }
}
