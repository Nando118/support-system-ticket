<?php

namespace App\Policies;

use App\Models\Log;
use App\Models\User;

class LogPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewLogs(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }
}
