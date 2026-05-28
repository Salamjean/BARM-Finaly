<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Partner;
use App\Models\Candidat;
use App\Models\Personnel;
use App\Models\Submission;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Authorizable, HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mecano',
        'matricule',
        'phone',
        'username',
        'lastname',
        'firstname',
        'email',
        'password',
        'created_by',
        'updated_by',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function fullName() : string
    {
        return strtoupper($this->firstname) . ' ' . ucwords(strtolower($this->lastname));
    }

    public function jobOffers(): HasMany
    {
        return $this->hasMany(JobOffer::class);
    }

    public function candidate(): HasOne
    {
        return $this->hasOne(Candidature::class);
    }
    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class);
    }
    public function personnel()
    {
        return $this->hasOne(Personnel::class);
    }

    public function partenaire(): HasOne
    {
        return $this->hasOne(Partenaire::class);
    }

    public function userCreatedAccount() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function userUpdatedAccount(): HasMany
    {
        return $this->hasMany(User::class, 'updated_by', 'id');
    }


    // public function plansAffaires()
    // {
    //     return $this->hasMany(Plan_affaire::class,'plan_affaire_id');
    // }
}
