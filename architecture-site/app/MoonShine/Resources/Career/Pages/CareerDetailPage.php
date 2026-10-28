<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Career\Pages;

use App\MoonShine\Fields\CloudinaryImage;
use App\MoonShine\Resources\Career\CareerResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Throwable;

/**
 * @extends DetailPage<CareerResource>
 */
class CareerDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),

            CloudinaryImage::make('Ảnh bìa vị trí tuyển dụng', 'cover_image')
                ->disk('cloudinary')
                ->dir('careers/covers'),

            Text::make('Vị trí tuyển dụng', 'job_title'),
            Text::make('Phòng ban', 'department'),
            Text::make('Địa điểm làm việc', 'location'),
            Text::make('Mức lương', 'salary_range'),
            Date::make('Hạn nộp hồ sơ', 'deadline')
                ->format('d/m/Y'),
            Text::make('Trạng thái', 'status')
                ->badge(fn ($status) => $status === 'open' ? 'success' : 'gray')
                ->changePreview(fn ($status) => $status === 'open' ? 'Đang tuyển' : 'Đã đóng'),
            Textarea::make('Mô tả & Yêu cầu công việc', 'description'),
            Date::make('Ngày tạo', 'created_at')
                ->format('d/m/Y H:i'),
            Date::make('Ngày cập nhật', 'updated_at')
                ->format('d/m/Y H:i'),
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
