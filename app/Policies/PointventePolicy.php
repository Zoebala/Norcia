<?php

namespace App\Policies;

use App\Models\Pointvente;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PointventePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("ViewAny Pointventes");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pointvente $pointvente): bool
    {
        //
        return $user->hasPermissionTo("View Pointventes");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasPermissionTo("Create Pointventes");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pointvente $pointvente): bool
    {
        //
        return $user->hasPermissionTo("Update Pointventes");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pointvente $pointvente): bool
    {
        //
        return $user->hasPermissionTo("Delete Pointventes");
    }
    public function deleteAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("DeleteAny Pointventes");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pointvente $pointvente): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pointvente $pointvente): bool
    {
        //
    }
}
