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
        // return $user->email === 'admin@mail.com';
        return $user->is_admin === true;
    }

    function edit(User $user)
    {
        
        if ($user->is_admin === true) {
            return true;
        }
        return false;
    }

    // function owner(User $user, User $model)
    // {
    //     if ($user->id == Auth::user()->id) {
    //         return true;
    //     }

    //     return false;
    // }
}