<?php

namespace App\Policies;

use App\Models\User;

class SecondhandInventoryPolicy
{
    public function viewAny(User $user)
    {
        return hasAbility('view.secondhand',$user);
    }

    public function create(User $user)
    {
        return hasAbility('create.secondhand',$user);
    }

    public function update(User $user)
    {
        return hasAbility('update.secondhand',$user);
    }

    public function delete(User $user)
    {
        return hasAbility('delete.secondhand',$user);
    }
}
