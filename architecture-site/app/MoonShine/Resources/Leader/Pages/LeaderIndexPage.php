<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Leader\Pages;

use App\MoonShine\Fields\CloudinaryImage;
use App\MoonShine\Resources\Leader\LeaderResource;
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
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use Throwable;

/**
 * @extends IndexPage<LeaderResource>
 */
class LeaderIndexPage extends IndexPage
{
    use HideRowViewEditActions;

    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            CloudinaryImage::make('Ảnh', 'image')->disk('cloudinary')->dir('leaders'),
            Text::make('Họ và tên', 'name')->sortable(),
            Text::make('Chức vụ', 'title'),
            Text::make('Cấp bậc', 'level_id')->changePreview(fn ($value) => match ((int) $value) {
                1 => 'Hội Đồng Quản Trị',
                2 => 'Ban Tổng Giám Đốc',
                3 => 'Trợ Lý & GĐ Khối',
                4 => 'Khối Dự Án',
                default => 'Khác',
            }),
            Number::make('Thứ tự', 'position_order')->sortable(),
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
