<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role_id == RoleEnum::ADMIN;
    }

    public function view(User $user): bool
    {
        return $user->role_id == RoleEnum::ADMIN;
    }

    public function create(User $user): bool
    {
        return $user->role_id == RoleEnum::ADMIN;
    }

    public function update(User $user): bool
    {
        return $user->role_id == RoleEnum::ADMIN;
    }

    public function delete(User $user): bool
    {
        return $user->role_id == RoleEnum::ADMIN;
    }

    public function restore(User $user): bool
    {
        return $user->role_id == RoleEnum::ADMIN;
    }

    public function forceDelete(User $user): bool
    {
        return $user->role_id == RoleEnum::ADMIN;
    }
}
