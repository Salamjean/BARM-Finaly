<?php

namespace App\Models;

use App\Models\User;
use App\Models\Formation;
use App\Models\Decoration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personnel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
    public function decorations(): HasMany
    {
        return $this->hasMany(Decoration::class);
    }

    public function personnel()
    {
        return $this->hasOne(Personnel::class);
    }
    public function personnelformations(): HasMany{
        return $this->hasMany(PersonnelFormation::class);
    }
    public function personnelformationsRequests(): HasMany{
        return $this->hasMany(PersonnelFormationRequest::class);
    }
    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'personnel_formations', 'personnel_id', 'formation_id');
    }
}
