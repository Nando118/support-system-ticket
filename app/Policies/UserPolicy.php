<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewUsers(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function createNewUser(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateUserData(User $user, User $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteUserData(User $user, User $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }else{
            return false;
        }
    }
}
