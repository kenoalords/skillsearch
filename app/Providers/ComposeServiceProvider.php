<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'includes.skills',
            \App\Http\ViewComposers\PopularSkillComposer::class
        );
        view()->composer(
            ['includes.admin-sidebar','includes.sidebar-mobile'],
            \App\Http\ViewComposers\AdminSidebarComposer::class
        );
        view()->composer(
            ['includes.top-users'],
            \App\Http\ViewComposers\TopUserComposer::class
        );
        view()->composer(
            ['includes.featured-portfolios'],
            \App\Http\ViewComposers\FeaturedPortfolioComposer::class
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
