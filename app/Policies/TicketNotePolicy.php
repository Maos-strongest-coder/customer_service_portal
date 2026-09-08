<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserRole;

class TicketNotePolicy
{
    /**
     * Create a new policy instance.
     */
    public function before(User $user): bool
    {
        return $user->role === UserRole::ADMIN ? true : false;
    }
}
