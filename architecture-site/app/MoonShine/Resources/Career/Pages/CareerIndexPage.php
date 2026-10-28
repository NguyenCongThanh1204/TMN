<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Career\Pages;

use App\MoonShine\Fields\CloudinaryImage;
use App\MoonShine\Traits\HideRowViewEditActions;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Badge;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class CareerIndexPage extends IndexPage
{
    use HideRowViewEditActions;

    protected int $itemsPerPage = 10;

    /**
     * Trong IndexPage (Separated Pages), phương thức bắt buộc phải là fields()
     *
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            CloudinaryImage::make('Ảnh bìa', 'cover_image')
                ->disk('cloudinary')
                ->dir('careers/covers'),

            Text::make('Vị trí tuyển dụng', 'job_title')
                ->sortable(),

            Text::make('Phòng ban', 'department'),

            Text::make('Địa điểm', 'location'),

            Text::make('Mức lương', 'salary_range'),

            Date::make('Hạn nộp', 'deadline')
                ->format('d/m/Y')
                ->sortable(),

            // Nút gạt chuyển trạng thái nhanh
            Switcher::make('Đang tuyển', 'status')
                ->updateOnPreview()
                ->onValue('open')
                ->offValue('closed'),

            // Cột nhãn badge trạng thái
            Text::make('Trạng thái', 'status')
                ->badge(fn ($status) => $status === 'open' ? 'success' : 'gray')
                ->changePreview(fn ($status) => $status === 'open' ? 'Đang tuyển' : 'Đã đóng'),

            Date::make('Ngày tạo', 'created_at')
                ->format('d/m/Y H:i')
                ->sortable(),

            Date::make('Ngày cập nhật', 'updated_at')
                ->format('d/m/Y H:i')
                ->sortable(),
        ];
    }

    protected function modifyListComponent(ComponentContract $component): TableBuilder
    {
        return $component->clickAction(ClickAction::EDIT);
    }
}
