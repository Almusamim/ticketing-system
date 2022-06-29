<?php

namespace App\Policies;

use App\Models\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->is_admin === true;
    }

    function edit(User $user)
    {
        
        if ($user->is_admin === true) {
            return true;
        }

        return false;
    }

    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }
}