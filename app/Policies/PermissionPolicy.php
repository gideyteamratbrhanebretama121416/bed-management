<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Permission;
use App\Models\User;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasRole('Admin');

    }

}
