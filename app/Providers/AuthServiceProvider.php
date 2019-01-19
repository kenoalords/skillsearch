<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Task;
use App\Models\Portfolio;
use App\Models\Comment;
use App\Models\Phone;
use App\Models\ContactRequest;
use App\Policies\UserPolicy;
use App\Policies\TaskPolicy;
use App\Policies\CommentPolicy;
use App\Policies\PortfolioPolicy;
use App\Policies\PhonePolicy;
use App\Policies\ContactRequestPolicy;
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
        Comment::class => CommentPolicy::class,
        Phone::class => PhonePolicy::class,
        ContactRequest::class => ContactRequestPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('update-blog', function( $user, $blog ){
            return $user->id === $blog->user_id;
        } );

        Gate::define('view-enquiry', function( $user, $enquiry ){
            return $user->id === $enquiry->user_id;
        } );
        //
    }
}
