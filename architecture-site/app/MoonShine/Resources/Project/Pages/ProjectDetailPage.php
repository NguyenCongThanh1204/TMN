<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Project\Pages;

use App\MoonShine\Fields\CloudinaryImage;
use App\MoonShine\Resources\Project\ProjectResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Throwable;

/**
 * @extends DetailPage<ProjectResource>
 */
class ProjectDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            CloudinaryImage::make('Ảnh bìa', 'cover_image')->disk('cloudinary')->dir('projects/covers'),
            Text::make('Danh mục', 'category.name'),
            Text::make('Tên dự án', 'title'),
            Text::make('Slug', 'slug'),
            Text::make('Chủ đầu tư', 'client_name'),
            Text::make('Địa điểm', 'location'),
            Text::make('Diện tích', 'area_sqm'),
            Text::make('Năm', 'year'),
            Text::make('Loại kết cấu', 'structural_type'),
            Text::make('Tiến độ', 'timeline'),
            Text::make('Trạng thái', 'status'),
            Textarea::make('Nội dung', 'body_content'),
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
