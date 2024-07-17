<?php

namespace App\Policies;

use App\Models\Fonction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FonctionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("ViewAny Fonctions");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Fonction $fonction): bool
    {
        //
        return $user->hasPermissionTo("View Fonctions");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasPermissionTo("Create Fonctions");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Fonction $fonction): bool
    {
        //
        return $user->hasPermissionTo("Update Fonctions");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Fonction $fonction): bool
    {
        //
        return $user->hasPermissionTo("Delete Fonctions");
    }
    public function deleteAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("DeleteAny Fonctions");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Fonction $fonction): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Fonction $fonction): bool
    {
        //
    }
}
