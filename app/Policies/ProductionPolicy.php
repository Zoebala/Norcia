<?php

namespace App\Policies;

use App\Models\Production;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("ViewAny Productions");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Production $production): bool
    {
        //
        return $user->hasPermissionTo("View Productions");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasPermissionTo("Create Productions");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Production $production): bool
    {
        //
        return $user->hasPermissionTo("Update Productions");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Production $production): bool
    {
        //
        return $user->hasPermissionTo("Delete Productions");
    }
    public function deleteAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("DeleteAny Productions");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Production $production): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Production $production): bool
    {
        //
    }
}
