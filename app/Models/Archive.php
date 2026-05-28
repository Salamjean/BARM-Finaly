<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;
    
    protected $fillable = ['dossier_id', 'titre','description','image','date_publication'];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class,'dossier_id','id');
    }
}
