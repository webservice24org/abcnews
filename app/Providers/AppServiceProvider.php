<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;
use App\Models\SiteInfo;
use App\Models\SocialConnection;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('siteSetting', SiteSetting::first());
            $view->with('siteInfo', SiteInfo::first());
            $view->with('social', SocialConnection::first());
        });
    }
}
