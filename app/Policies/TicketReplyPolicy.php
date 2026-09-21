<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TicketReply;
use App\Enums\UserRole;
use App\Models\Ticket;

class TicketReplyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function update(User $user, TicketReply $reply): bool
    {
        return $user->role === UserRole::ADMIN || $reply->user_id === $user->id;
    }

    public function create(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::ADMIN || $ticket->issued_by_id === $user->id;
    }
}
