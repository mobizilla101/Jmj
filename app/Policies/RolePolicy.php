<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user)
    {
        return hasAbility('view.role',$user);
    }

    public function create(User $user)
    {
        return hasAbility('create.role',$user);
    }

    public function update(User $user)
    {
        return hasAbility('update.role',$user);
    }

    public function delete(User $user)
    {
        return hasAbility('delete.role',$user);
    }
}
