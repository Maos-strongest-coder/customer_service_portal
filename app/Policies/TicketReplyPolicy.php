<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TicketReply;
use App\Enums\UserRole;

class TicketReplyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function update(User $user, TicketReply $reply): bool
    {
        return $user->role === UserRole::ADMIN || $reply->user_id === $user->id;
    }
}
