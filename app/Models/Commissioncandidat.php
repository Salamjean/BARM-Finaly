<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Commissioncandidat extends Model
{
    use HasFactory;

    protected $table = 'commissioncandidats';

    protected $guarded = [];

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class, 'candidature_id', 'id');
    }

    public function commission(): BelongsTo
    {
        return $this->belongsTo(Commission::class, 'commission_id', 'id');
    }

}
