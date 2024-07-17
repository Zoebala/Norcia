<?php

namespace App\Policies;

use App\Models\Sortie;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SortiePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("ViewAny Sorties");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Sortie $sortie): bool
    {
        //
        return $user->hasPermissionTo("View Sorties");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasPermissionTo("Create Sorties");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Sortie $sortie): bool
    {
        //
        return $user->hasPermissionTo("Update Sorties");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Sortie $sortie): bool
    {
        //
        return $user->hasPermissionTo("Delete Sorties");
    }

    public function deleteAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("DeleteAny Sorties");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Sortie $sortie): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Sortie $sortie): bool
    {
        //
    }
}
