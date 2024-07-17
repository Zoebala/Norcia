<?php

namespace App\Policies;

use App\Models\Entree;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EntreePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("ViewAny Entrees");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Entree $entree): bool
    {
        //
        return $user->hasPermissionTo("View Entrees");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasPermissionTo("Create Entrees");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Entree $entree): bool
    {
        //
        return $user->hasPermissionTo("Update Entrees");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Entree $entree): bool
    {
        //
        return $user->hasPermissionTo("Delete Entrees");
    }
    public function deleteAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("DeleteAny Entrees");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Entree $entree): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Entree $entree): bool
    {
        //
    }
}
