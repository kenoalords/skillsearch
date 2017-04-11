<?php

namespace App\Providers;

use App\Services\InstagramService;
use Illuminate\Support\ServiceProvider;

class InstagramPortfolioServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(InstagramService::class, function($app){
            return new InstagramService(config('services.instagram'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [InstagramService::class];
    }
}
