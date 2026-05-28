<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidaturePartnerTechnicial extends Model
{
    use HasFactory;

    protected $table = 'candidaturepartenaires';


    protected $fillable = [
        'candidature_id',
        'partner_id',
        'status',
    ];

    public function adherent()
    {
        return $this->belongsTo(Candidature::class, 'candidature_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partenaire::class, 'partner_id');
    }
}
