<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\Category;

class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function update(User $user, Category $category): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
