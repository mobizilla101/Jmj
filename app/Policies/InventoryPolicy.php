<?php

namespace App\Policies;

use App\Models\User;

class InventoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user)
    {
        return hasAbility('view.inventory',$user);
    }

    public function create(User $user)
    {
        return hasAbility('create.inventory',$user);
    }

    public function update(User $user)
    {
        return hasAbility('update.inventory',$user);
    }

    public function delete(User $user)
    {
        return hasAbility('delete.inventory',$user);
    }
}
