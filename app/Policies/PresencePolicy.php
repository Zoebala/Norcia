<?php

namespace App\Policies;

use App\Models\Presence;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PresencePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("ViewAny Presences");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Presence $presence): bool
    {
        //
        return $user->hasPermissionTo("View Presences");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasPermissionTo("Create Presences");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Presence $presence): bool
    {
        //
        return $user->hasPermissionTo("Update Presences");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Presence $presence): bool
    {
        //
        return $user->hasPermissionTo("Delete Presences");
    }
    public function deleteAny(User $user): bool
    {
        //
        return $user->hasPermissionTo("DeleteAny Presences");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Presence $presence): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Presence $presence): bool
    {
        //
    }
}
