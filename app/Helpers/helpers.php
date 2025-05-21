<?php

use App\Models\User;

function hasAbility($ability, User $user = null,$canAdminAccess = true):bool
{
    if (!$user) {
        $user = auth()->user();
        if (!$user) {
            return false; // Deny if no user is logged in
        }
    }

    if ($user->isAdmin()  && $canAdminAccess) {
        return true;
    }
    
    return $user->hasPermission($ability);
}
