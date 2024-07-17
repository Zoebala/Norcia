<?php

namespace App\Policies;

use App\Models\Fournisseur;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FournisseurPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("ViewAny Fournisseurs");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Fournisseur $fournisseur): bool
    {
        //
        return $user->hasPermissionTo("View Fournisseurs");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasPermissionTo("Create Fournisseurs");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Fournisseur $fournisseur): bool
    {
        //
        return $user->hasPermissionTo("Update Fournisseurs");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Fournisseur $fournisseur): bool
    {
        //
        return $user->hasPermissionTo("Delete Fournisseurs");
    }
    public function deleteAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("DeleteAny Fournisseurs");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Fournisseur $fournisseur): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Fournisseur $fournisseur): bool
    {
        //
    }
}
