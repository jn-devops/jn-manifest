<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LocationReason;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationReasonPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_location::reason');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LocationReason $locationReason): bool
    {
        return $user->can('view_location::reason');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_location::reason');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LocationReason $locationReason): bool
    {
        return $user->can('update_location::reason');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LocationReason $locationReason): bool
    {
        return $user->can('delete_location::reason');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_location::reason');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, LocationReason $locationReason): bool
    {
        return $user->can('force_delete_location::reason');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_location::reason');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, LocationReason $locationReason): bool
    {
        return $user->can('restore_location::reason');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_location::reason');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, LocationReason $locationReason): bool
    {
        return $user->can('replicate_location::reason');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_location::reason');
    }
}
