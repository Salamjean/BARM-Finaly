<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidatformation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'candidature_id',
        'formation_id',
        'presence',
        'commentaire',
        'attestation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'candidature_id' => 'integer',
        'formation_id' => 'integer',
    ];

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }
}
