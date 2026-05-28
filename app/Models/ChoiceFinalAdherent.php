<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChoiceFinalAdherent extends Model
{
    use HasFactory;

    protected $fillable = ['candidature_id', 'profilage_date', 'partner_id', 'choice_number', 'domaine','specialisation','region_retraite','department','locality','adress_geo','formation','autres_form'];

    public function partner() : BelongsTo
    {
        return $this->belongsTo(Partenaire::class, 'partner_id', 'id');
    }

    public function candidature() : BelongsTo
    {
        return $this->belongsTo(Candidature::class, 'candidature_id', 'id');
    }
}
