<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\PostCategory;

use App\Models\PostCategory;
use App\MoonShine\Resources\PostCategory\Pages\PostCategoryDetailPage;
use App\MoonShine\Resources\PostCategory\Pages\PostCategoryFormPage;
use App\MoonShine\Resources\PostCategory\Pages\PostCategoryIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<PostCategory, PostCategoryIndexPage, PostCategoryFormPage, PostCategoryDetailPage>
 */
class PostCategoryResource extends ModelResource
{
    protected string $model = PostCategory::class;

    protected string $column = 'name';

    protected string $title = 'PostCategories';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            PostCategoryIndexPage::class,
            PostCategoryFormPage::class,
            PostCategoryDetailPage::class,
        ];
    }
}
