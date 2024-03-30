<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function viewTicket(User $user, Ticket $ticket): bool
    {
        if ($user->isAdmin()) {
            return true;
        }else if ($user->isRegular()) {
            return $user->id === $ticket->user_id;
        }else if ($user->isEngineer()) {
            return $user->id === $ticket->engineer_id;
        }
        return false;
    }

    public function createNewTicket(User $user): bool
    {
        if ($user->isRegular()) {
            return true;
        }else{
            return false;
        }
    }

    public function assignEngineerToTicket(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }else{
            return false;
        }
    }

    public function reply(User $user, Ticket $ticket): bool
    {
        return $ticket->status !== "closed";
    }
}
