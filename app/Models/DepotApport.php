<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepotApport extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class,'personnel_ayant_cree_id', 'id');
    }
    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class,'candidature_id', 'id');
    }
}
