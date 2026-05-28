<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entreprise',
        'intitule',
        'date_db',
        'date_fin',
        'lieu',
        'autor_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_db' => 'date',
        'date_fin' => 'date',
    ];

    public function candidatures(): BelongsToMany
    {
        return $this->belongsToMany(Candidature::class,'candidatformations','formation_id','candidature_id')->withPivot('presence','commentaire','attestation');
    }

    public function candidatformations(): HasMany
    {
        return $this->hasMany(Candidatformation::class);
    }
}
