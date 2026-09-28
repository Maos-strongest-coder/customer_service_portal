<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TicketReply;
use App\Models\Ticket;

class TicketReplyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function update(User $user, TicketReply $reply): bool
    {
        return $user->isAdmin() || $reply->user_id === $user->id;
    }

    public function create(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin() || $ticket->issued_by_id === $user->id;
    }
}
