<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserEvents' => [
            'App\Listeners\UserEventsListener',
        ],
        'App\Events\PortfolioImageUploadEvent' => [
            'App\Listeners\PortfolioImageUploadEventListener'
        ],
        'App\Events\PortfolioFilesUploadEvent' => [
            'App\Listeners\PortfolioFilesUploadEventListener'
        ],
        'App\Events\CommentPostedEvent' => [
            'App\Listeners\CommentPostedEventListener'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
