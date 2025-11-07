<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;
use App\Models\Announcement;

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
        // Share site settings with all views
        View::composer('*', function ($view) {
            try {
                $view->with('siteLogo', SiteSetting::getLogo());
                $view->with('siteName', SiteSetting::getSiteName());
                $view->with('activeBar', Announcement::getActiveBar());
                $view->with('activePopup', Announcement::getActivePopup());
            } catch (\Exception $e) {
                // Fallback if database not ready
                $view->with('siteLogo', null);
                $view->with('siteName', 'Bina Adult Care');
                $view->with('activeBar', null);
                $view->with('activePopup', null);
            }
        });
    }
}
