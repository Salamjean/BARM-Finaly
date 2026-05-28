<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    //use Sluggable;

    protected $guarded = [];

    /*public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }*/

    public function roles(){
        return $this->belongsTomany(Role::class,'roles_permissions');
    }

    public function users(){
        return $this->belongsTomany(User::class,'users_permissions');
    }
}
