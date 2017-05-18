<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Task;
use App\Models\Portfolio;
use App\Models\Comment;
use App\Policies\UserPolicy;
use App\Policies\TaskPolicy;
use App\Policies\CommentPolicy;
use App\Policies\PortfolioPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Task::class => TaskPolicy::class,
        Portfolio::class => PortfolioPolicy::class,
        Comment::class => CommentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
