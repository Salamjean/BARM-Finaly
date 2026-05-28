<?php

namespace App\Policies;

use App\Models\Pointing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PointingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pointing $pointing): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pointing $pointing): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pointing $pointing): bool
    {
        return $user->role[0]->name == 'admin' ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pointing $pointing): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pointing $pointing): bool
    {
        //
    }
}
