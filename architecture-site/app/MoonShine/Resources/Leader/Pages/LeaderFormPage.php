<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Leader\Pages;

use App\MoonShine\Fields\CloudinaryImage;
use App\MoonShine\Fields\MediaPicker;
use App\MoonShine\Resources\Leader\LeaderResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Throwable;

/**
 * @extends FormPage<LeaderResource>
 */
class LeaderFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Select::make('Cấp bậc / Khối quản lý', 'level_id')
                    ->options([
                        1 => '1. Hội Đồng Quản Trị (HĐQT)',
                        2 => '2. Ban Tổng Giám Đốc',
                        3 => '3. Trợ Lý Chủ Tịch & Giám Đốc Khối',
                        4 => '4. Khối Điều Hành Dự Án',
                    ])
                    ->required(),
                Number::make('Thứ tự sắp xếp', 'position_order')
                    ->default(0)
                    ->required(),
                Text::make('Họ và tên', 'name')->required(),
                Text::make('Chức vụ', 'title')->required(),
                CloudinaryImage::make('Hình ảnh chân dung', 'image')
                    ->disk('cloudinary')
                    ->dir('leaders')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp'])
                    ->removable(),
                MediaPicker::forColumn('Hoặc chọn ảnh từ thư viện', 'image'),
                Text::make('Email liên hệ', 'email'),
                Textarea::make('Tiểu sử / Giới thiệu chi tiết', 'bio')
                    ->customAttributes(['rows' => 5]),
            ]),
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    protected function formButtons(): ListOf
    {
        return parent::formButtons();
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'level_id' => ['required', 'integer', 'in:1,2,3,4'],
            'position_order' => ['required', 'integer', 'min:0'],
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
            'email' => ['nullable', 'email', 'max:255'],
            'bio' => ['nullable', 'string'],
        ];
    }

    /**
     * @param  FormBuilder  $component
     * @return FormBuilder
     */
    protected function modifyFormComponent(FormBuilderContract $component): FormBuilderContract
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
