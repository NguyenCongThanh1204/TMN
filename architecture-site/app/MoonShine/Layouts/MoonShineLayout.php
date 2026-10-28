<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Pages\MediaLibrary;
use App\MoonShine\Resources\Career\CareerResource;
use App\MoonShine\Resources\Leader\LeaderResource;
use App\MoonShine\Resources\Partner\PartnerResource;
use App\MoonShine\Resources\Post\PostResource;
use App\MoonShine\Resources\PostCategory\PostCategoryResource;
use App\MoonShine\Resources\Project\ProjectResource;
use App\MoonShine\Resources\ProjectCategory\ProjectCategoryResource;
use MoonShine\ColorManager\ColorManager;
use MoonShine\ColorManager\Palettes\PurplePalette;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\ColorManager\PaletteContract;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{
    /**
     * @var null|class-string<PaletteContract>
     */
    protected ?string $palette = PurplePalette::class;

    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            ...parent::menu(),
            MenuItem::make(CareerResource::class, 'Tuyển dụng'),
            MenuItem::make(LeaderResource::class, 'Lãnh đạo'),
            MenuItem::make(PartnerResource::class, 'Đối tác'),
            MenuItem::make(PostCategoryResource::class, 'Danh mục bài viết'),
            MenuItem::make(PostResource::class, 'Bài viết'),
            MenuItem::make(ProjectCategoryResource::class, 'Danh mục dự án'),
            MenuItem::make(ProjectResource::class, 'Dự án'),
            MenuItem::make(MediaLibrary::class, 'Media Library', 'photo'),
        ];
    }

    protected function getFooterMenu(): array
    {
        return [];
    }

    protected function getFooterCopyright(): string
    {
        return '';
    }

    /**
     * @param  ColorManager  $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        $colorManager
            ->primary('#0284C7', '#FFFFFF')
            ->secondary('#DC2626', '#FFFFFF')
            ->background('#F0F9FF', '#FFFFFF')
            ->borders('#BAE6FD')
            ->dividers('#BAE6FD')
            ->set('button', '#0284C7')
            ->set('button-text', '#FFFFFF')
            ->set('error', '#DC2626')
            ->set('error-text', '#FFFFFF');
    }
}
