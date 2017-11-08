<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Portfolio;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortfolioPolicy
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

    public function edit(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }

    public function delete(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }
}
