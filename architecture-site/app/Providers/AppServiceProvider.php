<?php

namespace App\Providers;

use App\Http\SharedHandlerHttpFactory;
use App\Models\Career;
use App\Models\Leader;
use App\Models\Partner;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostMedia;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectMedia;
use App\Services\PageCache;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Client\Factory;
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

        $this->app->singleton(Factory::class, static fn ($app): Factory => new SharedHandlerHttpFactory($app->make(Dispatcher::class)));
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

        // Any create/update/delete of public content (including from MoonShine) refreshes the page cache.
        // Post::increment('views') only fires "updated", so page views do not flush it.
        foreach ([Post::class, PostCategory::class, PostMedia::class, Project::class, ProjectCategory::class, ProjectMedia::class, Leader::class, Partner::class, Career::class] as $model) {
            $model::saved(static fn () => PageCache::flushAfterCommit());
            $model::deleted(static fn () => PageCache::flushAfterCommit());
        }
    }
}
