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

        view()->composer(
            ['includes.user-badge'],
            \App\Http\ViewComposers\UserImageComposer::class
        );
        view()->composer(
            ['blog.latest_posts'], \App\Http\ViewComposers\LatestBlogComposer::class
        );
        // view()->composer(
        //     ['blog.read_more'], \App\Http\ViewComposers\ReadMoreBlogComposer::class
        // );
        view()->composer(
            ['includes.admin-sidebar', 'enquiry.enquiry'], \App\Http\ViewComposers\EnquiryCountComposer::class
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
