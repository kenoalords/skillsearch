<?php

namespace App\Providers;

use App\Services\PointService;
use Illuminate\Support\ServiceProvider;

class PointServiceProvider extends ServiceProvider
{
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
        $this->app->singleton(PointService::class, function($app){
            return new PointService(config('services.points'));
        });
    }
}
