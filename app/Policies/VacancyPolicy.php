<?php

namespace App\Policies;

use App\User;
use App\Vacancy;
use http\Env\Request;
use Illuminate\Auth\Access\HandlesAuthorization;


class VacancyPolicy
{
    use HandlesAuthorization;



    public function book(User $user, User $model)
    {
        if ($user->role === 'worker' && $user->id === $model->id) {
            return true;
        }

        return false;
    }

    public function unbook(User $user)
    {

        if ($user->role === 'worker') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the vacancy.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->role === 'admin' || $user->role === 'employer' || $user->role === 'worker'){
            return true;
        }

        return false;
    }



    /**
     * Determine whether the user can view the vacancy.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function view(User $user)
    {
        if ($user->role === 'admin' || $user->role === 'employer' || $user->role === 'worker'){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create vacancies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->role === 'employer'){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the vacancy.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->role === 'admin' || $user->role === 'employer'){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the vacancy.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->role === 'admin' || $user->role === 'employer'){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the vacancy.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function restore(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the vacancy.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function forceDelete(User $user, Vacancy $vacancy)
    {
        //
    }
}
