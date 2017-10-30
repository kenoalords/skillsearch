<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ContactRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactRequestPolicy
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

    public function update(User $user, ContactRequest $contact_request)
    {
        return $user->id === $contact_request->user_id;
    }
}
