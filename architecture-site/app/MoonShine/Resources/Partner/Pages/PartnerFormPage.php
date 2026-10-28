<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Partner\Pages;

use App\MoonShine\Fields\CloudinaryImage;
use App\MoonShine\Fields\MediaPicker;
use App\MoonShine\Resources\Partner\PartnerResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use Throwable;

/**
 * @extends FormPage<PartnerResource>
 */
class PartnerFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Tên đối tác / Thương hiệu', 'name')
                    ->placeholder('Ví dụ: SUN GROUP, JOTUN, DONGTAM...')
                    ->required(),
                CloudinaryImage::make('Ảnh logo đối tác', 'logo')
                    ->disk('cloudinary')
                    ->dir('partners')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp'])
                    ->removable(),
                MediaPicker::forColumn('Hoặc chọn logo từ thư viện', 'logo'),
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
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['required_without:logo_library', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
            'logo_library' => ['nullable', 'string', 'max:500'],
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
