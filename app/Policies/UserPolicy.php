<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Phone;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        //
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        //
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        //
    }

    public function is_admin(User $user)
    {
        return $user->is_admin === 1;
    }

    public function owns_phone(User $user, Phone $phone)
    {
        return $user->id === $phone->user_id;
    }
}
