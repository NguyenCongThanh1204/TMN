<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\Career\CareerResource;
use App\MoonShine\Resources\Leader\LeaderResource;
use App\MoonShine\Resources\Media\MediaResource;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRole\MoonShineUserRoleResource;
use App\MoonShine\Resources\Partner\PartnerResource;
use App\MoonShine\Resources\Post\PostResource;
use App\MoonShine\Resources\PostCategory\PostCategoryResource;
use App\MoonShine\Resources\Project\ProjectResource;
use App\MoonShine\Resources\ProjectCategory\ProjectCategoryResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;

class MoonShineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadViewsFrom(resource_path('views/moonshine'), 'app-moonshine');
    }

    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core): void
    {
        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                CareerResource::class,
                LeaderResource::class,
                PartnerResource::class,
                PostCategoryResource::class,
                PostResource::class,
                ProjectCategoryResource::class,
                ProjectResource::class,
                MediaResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
            ]);
    }
}
