<?php

namespace App\Policies;

use App\User;
use App\Organization;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any organization.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->role === 'admin' || $user->role === 'employer') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any organization.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function view(User $user, Organization $organization)
    {
        if ($user->role === 'admin' || ($user->role === 'employer' && $user->id === $organization->user_id)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create organizations.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->role === 'employer') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the organization.
     *
     * @param \App\User $user
     * @param \App\Organization $organization
     * @return mixed
     */
    public function update(User $user, Organization $organization)
    {
        if ($user->role === 'admin' || ($user->role === 'employer' && $user->id === $organization->user_id)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the organization.
     *
     * @param \App\User $user
     * @param \App\Organization $organization
     * @return mixed
     */
    public function delete(User $user, Organization $organization)
    {
        if ($user->role === 'admin' || ($user->role === 'employer' && $user->id === $organization->user_id)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the organization.
     *
     * @param \App\User $user
     * @param \App\Organization $organization
     * @return mixed
     */
    public function restore(User $user, Organization $organization)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the organization.
     *
     * @param \App\User $user
     * @param \App\Organization $organization
     * @return mixed
     */
    public function forceDelete(User $user, Organization $organization)
    {
        //
    }
}
