<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\TicketNote;

class TicketNotePolicy
{
    /**
     * Create a new policy instance.
     */
    public function before(User $user): ?bool
    {
        
        if ($user->role === UserRole::ADMIN || $user->role === UserRole::ADMIN->value) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return false; 
    }

    public function create(User $user): bool
{
    return false;
}

    public function update(User $user, TicketNote $note): bool
    {
        return false;
    }

    public function delete(User $user, TicketNote $note): bool
    {
        return false;
    }

}
