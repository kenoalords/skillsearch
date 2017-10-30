<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Phone;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhonePolicy
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

    public function edit(User $user, Phone $phone)
    {
        return $user->id === $phone->user_id;
    }
}
