<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Besoinitem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'qte_demande',
        'qte_recue',
        'qte_manquante',
        'disponible',
        'commentaire',
        'besoin_id',
        'consommable_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'besoin_id' => 'integer',
        'consommable_id' => 'integer',
    ];

    public function besoin(): BelongsTo
    {
        return $this->belongsTo(Besoin::class, 'besoin_id', 'id');
    }

    public function consommable(): BelongsTo
    {
        return $this->belongsTo(Consommable::class, 'consommable_id', 'id');
    }
}
