<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Project\Pages;

use App\MoonShine\Fields\CloudinaryImage;
use App\MoonShine\Resources\Project\ProjectResource;
use App\MoonShine\Traits\HideRowViewEditActions;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Metrics\Wrapped\Metric;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use Throwable;

/**
 * @extends IndexPage<ProjectResource>
 */
class ProjectIndexPage extends IndexPage
{
    use HideRowViewEditActions;

    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            CloudinaryImage::make('Ảnh bìa', 'cover_image')->disk('cloudinary')->dir('projects/covers'),
            Text::make('Tên dự án', 'title')->sortable(),
            Text::make('Danh mục', 'category.name'),
            Text::make('Địa điểm', 'location'),
            Text::make('Năm', 'year')->sortable(),
            Switcher::make('Hiện trang chủ', 'is_featured')->updateOnPreview(),
            Text::make('Trạng thái', 'status')
                ->badge(fn ($status) => match ($status) {
                    'published' => 'success',
                    'draft' => 'gray',
                    default => 'warning',
                })
                ->changePreview(fn ($status) => match ($status) {
                    'published' => 'Đã xuất bản',
                    'draft' => 'Bản nháp',
                    default => 'Lưu trữ',
                }),
            Date::make('Cập nhật', 'updated_at')->format('d/m/Y H:i'),
        ];
    }

    /**
     * @return ListOf<ActionButtonContract>
     */
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

    /**
     * @return list<QueryTag>
     */
    protected function queryTags(): array
    {
        return [];
    }

    /**
     * @return list<Metric>
     */
    protected function metrics(): array
    {
        return [];
    }

    /**
     * @param  TableBuilder  $component
     * @return TableBuilder
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return $component->clickAction(ClickAction::EDIT);
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
