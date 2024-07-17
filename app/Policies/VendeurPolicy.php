<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Auth\Access\Response;

class VendeurPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("ViewAny Vendeurs");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Vendeur $vendeur): bool
    {
        //
        return $user->hasPermissionTo("View Vendeurs");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasPermissionTo("Create Vendeurs");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Vendeur $vendeur): bool
    {
        //
        return $user->hasPermissionTo("Update Vendeurs");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vendeur $vendeur): bool
    {
        //
        return $user->hasPermissionTo("Delete Vendeurs");
    }
    public function deleteAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("DeleteAny Vendeurs");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Vendeur $vendeur): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Vendeur $vendeur): bool
    {
        //
    }
}
