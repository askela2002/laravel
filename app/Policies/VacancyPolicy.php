<?php

namespace App\Policies;

use App\Organization;
use App\User;
use App\Vacancy;
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

    public function unbook(User $user, User $model)
    {

        if ($user->role === 'worker' && $user->id === $model->id) {
            return true;
        }

        return false;

    }

    /**
     * Determine whether the user can view the vacancy.
     *
     * @param \App\User $user
     * @param \App\Vacancy $vacancy
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->role === 'admin' || $user->role === 'employer' || $user->role === 'worker') {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can view the vacancy.
     *
     * @param \App\User $user
     * @param \App\Vacancy $vacancy
     * @return mixed
     */
    public function view(User $user)
    {
        if ($user->role === 'admin' || $user->role === 'employer' || $user->role === 'worker') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create vacancies.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user, $organization_id)
    {
        $organizations = Organization::where('user_id', $user->id)->get();
        if ($user->role === 'employer') {
            foreach ($organizations as $organization) {
                if ($organization->id === $organization_id) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the vacancy.
     *
     * @param \App\User $user
     * @param \App\Vacancy $vacancy
     * @return mixed
     */
    public function update(User $user, Vacancy $vacancy)
    {
        $user_id = Organization::find($vacancy->organization_id)->user_id;
        if ($user->role === 'admin' || $user->role === 'employer' && $user->id === $user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the vacancy.
     *
     * @param \App\User $user
     * @param \App\Vacancy $vacancy
     * @return mixed
     */
    public function delete(User $user, Vacancy $vacancy)
    {
        $user_id = Organization::find($vacancy->organization_id)->user_id;
        if ($user->role === 'admin' || $user->role === 'employer' && $user->id === $user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the vacancy.
     *
     * @param \App\User $user
     * @param \App\Vacancy $vacancy
     * @return mixed
     */
    public function restore(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the vacancy.
     *
     * @param \App\User $user
     * @param \App\Vacancy $vacancy
     * @return mixed
     */
    public function forceDelete(User $user, Vacancy $vacancy)
    {
        //
    }
}
