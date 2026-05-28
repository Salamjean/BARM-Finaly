<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataCollect extends Model
{
    use HasFactory;

    protected $table = 'data_collects';

    protected $fillable = [
        'candidature_id',
        'beging_date',
        'end_date',
        'documents',
    ];

    public function candidature() : BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }
}
