<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Support/cloudinary.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Khi deploy lên server thật (APP_ENV=production), ép buộc toàn bộ URL và tài sản Media sinh ra ở dạng HTTPS
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}