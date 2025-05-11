<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user)
    {
        return hasAbility('view.user',$user);
    }

    public function create(User $user)
    {
        return hasAbility('create.user',$user);
    }

    public function update(User $user)
    {
        return hasAbility('update.user',$user);
    }

    public function delete(User $user)
    {
        return hasAbility('delete.user',$user);
    }
}
