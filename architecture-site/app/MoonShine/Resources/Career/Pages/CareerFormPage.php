<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Career\Pages;

use App\MoonShine\Fields\CloudinaryImage;
use App\MoonShine\Fields\MediaPicker;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class CareerFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(),

                Text::make('Vị trí tuyển dụng', 'job_title')
                    ->placeholder('Ví dụ: Shopdrawing kết cấu / Hoàn thiện')
                    ->required(),

                CloudinaryImage::make('Ảnh bìa vị trí tuyển dụng', 'cover_image')
                    ->disk('cloudinary')
                    ->dir('careers/covers')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp'])
                    ->removable(),

                MediaPicker::forColumn('Hoặc chọn ảnh từ thư viện', 'cover_image'),

                Flex::make([
                    Text::make('Phòng ban', 'department')
                        ->placeholder('Ví dụ: Ban Chỉ huy công trường'),

                    Text::make('Địa điểm làm việc', 'location')
                        ->placeholder('Ví dụ: Đà Nẵng & Miền Trung'),
                ]),

                Flex::make([
                    Text::make('Mức lương', 'salary_range')
                        ->placeholder('Ví dụ: Thỏa thuận / 15 - 20 triệu'),

                    Date::make('Hạn nộp hồ sơ', 'deadline')
                        ->format('d/m/Y'),

                    Select::make('Trạng thái', 'status')
                        ->options([
                            'open' => 'Đang tuyển dụng',
                            'closed' => 'Dừng nhận hồ sơ',
                        ])
                        ->default('open')
                        ->required(),
                ]),

                Textarea::make('Mô tả & Yêu cầu công việc', 'description')
                    ->customAttributes(['rows' => 8])
                    ->required(),
            ]),
        ];
    }

    /**
     * Quy tắc kiểm tra tính hợp lệ dữ liệu (Validation Rules)
     */
    protected function rules(DataWrapperContract $item): array
    {
        return [
            'job_title' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'salary_range' => ['nullable', 'string', 'max:255'],
            'deadline' => ['nullable', 'date'],
            'status' => ['required', 'in:open,closed'],
            'description' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
        ];
    }
}
