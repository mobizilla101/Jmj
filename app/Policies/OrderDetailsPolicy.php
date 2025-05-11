<?php

namespace App\Policies;

use App\Models\User;

class OrderDetailsPolicy
{
    public function viewAny(User $user)
    {
        return hasAbility('view.order',$user);
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user)
    {
        return hasAbility('update.order',$user);
    }

    public function delete(User $user)
    {
        return false;
    }
}
