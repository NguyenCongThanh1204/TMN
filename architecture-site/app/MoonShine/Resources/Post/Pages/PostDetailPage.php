<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Post\Pages;

use App\MoonShine\Fields\CloudinaryImage;
use App\MoonShine\Fields\EscapedTextarea;
use App\MoonShine\Resources\Post\PostResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use Throwable;

/**
 * @extends DetailPage<PostResource>
 */
class PostDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            CloudinaryImage::make('Ảnh đại diện', 'thumbnail')
                ->disk('cloudinary')
                ->dir('posts/thumbnails'),
            Text::make('Danh mục', 'category.name'),
            Text::make('Tiêu đề', 'title'),
            Text::make('Slug', 'slug'),
            Text::make('Chú thích ảnh', 'thumbnail_caption'),
            Text::make('Alt ảnh', 'thumbnail_alt'),
            Text::make('Tác giả', 'author_name'),
            Text::make('Vai trò tác giả', 'author_role'),
            Date::make('Ngày xuất bản', 'published_at')->format('d/m/Y H:i'),
            EscapedTextarea::make('Tóm tắt', 'excerpt'),
            EscapedTextarea::make('Nội dung', 'content'),
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    /**
     * @param  TableBuilder  $component
     * @return TableBuilder
     */
    protected function modifyDetailComponent(ComponentContract $component): ComponentContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     *
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer(),
        ];
    }

    /**
     * @return list<ComponentContract>
     *
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer(),
        ];
    }

    /**
     * @return list<ComponentContract>
     *
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer(),
        ];
    }
}
