<?php

namespace App\Policies;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Entry $entry): bool
    {
        return $user->households()->whereKey($entry->household_id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Entry $entry): bool
    {
        return $user->households()->whereKey($entry->household_id)->wherePivotIn('role', ['owner', 'editor'])->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Entry $entry): bool
    {
        return $user->households()->whereKey($entry->household_id)->wherePivotIn('role', ['owner', 'editor'])->exists();
    }
}
