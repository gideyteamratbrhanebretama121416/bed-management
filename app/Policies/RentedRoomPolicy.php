<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\RentedRoom;
use App\Models\User;

class RentedRoomPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasRole(['Admin','Receptionist']);

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RentedRoom $rentedRoom): bool
    {
        //
        return $user->hasRole(['Admin','Receptionist']);

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasRole(['Admin','Receptionist']);

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RentedRoom $rentedRoom): bool
    {
        //
        return $user->hasRole(['Admin','Receptionist']);

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RentedRoom $rentedRoom): bool
    {
        //
        return $user->hasRole('Admin');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RentedRoom $rentedRoom): bool
    {
        //
        return $user->hasRole('Admin');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RentedRoom $rentedRoom): bool
    {
        //
        return $user->hasRole('Admin');

    }
}
