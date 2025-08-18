<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;
use App\Models\SiteInfo;
use App\Models\SocialConnection;
use App\Models\ColorSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use DevRabiul\LivewireDoctor\LivewireDoctor;

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
            $siteSetting = Cache::remember('siteSetting', 3600, fn() => SiteSetting::first());
            $siteInfo = Cache::remember('siteInfo', 3600, fn() => SiteInfo::first());
            $social = Cache::remember('social', 3600, fn() => SocialConnection::first());
            $color = Cache::remember('color', 3600, fn() => ColorSetting::first());

            $view->with(compact('siteSetting', 'siteInfo', 'social', 'color'));
        });
        // Register Livewire Doctor
       // LivewireDoctor::register();
    }
}
