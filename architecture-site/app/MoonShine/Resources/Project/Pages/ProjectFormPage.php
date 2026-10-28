<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Project\Pages;

use App\MoonShine\Fields\CloudinaryImage;
use App\MoonShine\Fields\MediaPicker;
use App\MoonShine\Fields\ProjectGallery;
use App\MoonShine\Resources\Project\ProjectResource;
use App\MoonShine\Resources\ProjectCategory\ProjectCategoryResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Throwable;

/**
 * @extends FormPage<ProjectResource>
 */
class ProjectFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                BelongsTo::make(
                    'Danh mục dự án',
                    'category',
                    'name',
                    resource: ProjectCategoryResource::class,
                ),
                Select::make('Trạng thái xuất bản', 'status')
                    ->options([
                        'draft' => 'Bản nháp',
                        'published' => 'Đã xuất bản',
                        'archived' => 'Lưu trữ',
                    ])
                    ->default('published')
                    ->required(),
                Text::make('Tên dự án / Công trình', 'title')->required(),
                Text::make('Slug', 'slug')->required(),
                Text::make('Chủ đầu tư / Khách hàng', 'client_name'),
                Text::make('Địa điểm thực hiện', 'location'),
                Text::make('Diện tích sàn (m²)', 'area_sqm'),
                Text::make('Năm thực hiện', 'year'),
                Text::make('Loại kết cấu / Hạng mục', 'structural_type'),
                Text::make('Tiến độ / Thời gian thi công', 'timeline'),
                Switcher::make('Dự án tiêu biểu', 'is_featured')
                    ->default(false),
                CloudinaryImage::make('Ảnh đại diện / Ảnh bìa', 'cover_image')
                    ->disk('cloudinary')
                    ->dir('projects/covers')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp'])
                    ->removable(),
                MediaPicker::forColumn('Hoặc chọn ảnh từ thư viện', 'cover_image'),
                ProjectGallery::make('Ảnh chi tiết dự án', 'gallery_manage'),
                Textarea::make('Nội dung chi tiết dự án', 'body_content')
                    ->customAttributes(['rows' => 12]),
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
            'category_id' => ['nullable', 'exists:project_categories,id'],
            'status' => ['required', 'in:draft,published,archived'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'area_sqm' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer'],
            'structural_type' => ['nullable', 'string', 'max:255'],
            'timeline' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
            'gallery_files' => ['nullable', 'array', 'max:20'],
            'gallery_files.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:20480'],
            'body_content' => ['nullable', 'string'],
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
