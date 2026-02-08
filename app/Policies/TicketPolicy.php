<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin() || $user->hasRole(User::ROLE_STAFF) || $ticket->user_id === $user->id;
    }
}
