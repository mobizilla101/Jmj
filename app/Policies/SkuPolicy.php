<?php

namespace App\Policies;

use App\Models\User;

class SkuPolicy
{
    /**
     * Create a new policy instance.
     */

    public function viewAny(User $user)
    {
        return hasAbility('view.sku',$user);
    }

    public function create(User $user)
    {
        return hasAbility('create.sku',$user);
    }

    public function update(User $user)
    {
        return hasAbility('update.sku',$user);
    }

    public function delete(User $user)
    {
        return hasAbility('delete.sku',$user);
    }

}
