<?php
namespace App\Policies;

use App\Enum\UserRole;
use App\Models\User;
use App\Models\Brand;

class BrandPolicy
{
    public function viewAny(User $user)
    {
        return hasAbility('view.brand',$user);
    }

    public function create(User $user)
    {
        return hasAbility('create.brand',$user);
    }

    public function update(User $user)
    {
        return hasAbility('update.brand',$user);
    }

    public function delete(User $user)
    {
        return hasAbility('delete.brand',$user);
    }
}

