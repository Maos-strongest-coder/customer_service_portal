<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserRole;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function update(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function delete(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
