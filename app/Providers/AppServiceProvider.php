<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;
use App\Models\SiteInfo;
use App\Models\SocialConnection;
use App\Models\ColorSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

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
            

            // Get active theme from theme_settings table
            $theme = Cache::remember('activeTheme', 3600, function () {
                return DB::table('theme_settings')->where('key', 'selected_theme')->value('value') ?? 'theme1';
            });

            $defaultImage = $siteInfo?->site_image
            ? asset('storage/' . $siteInfo->site_image)
            : asset('storage/fallback/default.jpg'); 

            $view->with(compact('siteSetting', 'siteInfo', 'social', 'color', 'theme', 'defaultImage'));
        });
    }
}
