<?php

namespace App\Models;

use App\Models\Candidatentretien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CandidatureSessioncollective extends Model
{
    use HasFactory;

    protected $table = 'candidature_sessioncollective';

    protected $guarded = [];


    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class, 'candidature_id', 'id');
    }

    public function sessioncollective(): BelongsTo
    {
        return $this->belongsTo(Sessioncollective::class, 'sessioncollective_id', 'id');
    }

}


