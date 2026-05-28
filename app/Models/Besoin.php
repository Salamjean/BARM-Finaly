<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Besoin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle',
        'status',
        'user_id',
        'chef_barm_id',
        'rh_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function chef_barm(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chef_barm_id', 'id');
    }

    public function rh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rh_id', 'id');
    }

    public function besoinitems(): HasMany
    {
        return $this->hasMany(Besoinitem::class);
    }
}
