<?php

namespace App\Policies;

use App\Models\User;

class ModelPolicy
{
    public function viewAny(User $user)
    {
        return hasAbility('view.model',$user);
    }

    public function create(User $user)
    {
        return hasAbility('create.model',$user);
    }

    public function update(User $user)
    {
        return hasAbility('update.model',$user);
    }

    public function delete(User $user)
    {
        return hasAbility('delete.model',$user);
    }
}
