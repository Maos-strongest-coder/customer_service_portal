<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ticket;
use App\Enums\UserRole;

class TicketPolicy
{
        /**
    * Create a new policy instance.
    */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::ADMIN || $ticket->issued_by_id === $user->id;
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $this->view($user, $ticket);
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
