<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function stat(User $user){

        if($user->role === 'admin'){
            return true;
        }

        return false;
    }


}
