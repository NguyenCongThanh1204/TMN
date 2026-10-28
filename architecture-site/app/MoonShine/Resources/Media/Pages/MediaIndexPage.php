<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Media\Pages;

use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;

class MediaIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * Columns in the media index list.
     *
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),

            Image::make('Ảnh', 'thumbnail_url')
                ->disk('cloudinary'),

            Text::make('Public ID', 'file_path'),

            Text::make('Chú thích', 'caption'),

            Text::make('Alt Text', 'alt_text'),

            Text::make('Từ khóa', 'keywords'),

            Text::make('Thư mục', 'folder_id'),

            Text::make('Ngày tạo', 'created_at'),
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    /**
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [];
    }

    protected function queryTags(): array
    {
        return [];
    }

    protected function metrics(): array
    {
        return [];
    }

    protected function modifyListComponent(
        ComponentContract $component
    ): ComponentContract {
        return $component;
    }

    protected function topLayer(): array
    {
        return [
            ...parent::topLayer(),
        ];
    }

    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer(),
        ];
    }

    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer(),
        ];
    }
}
