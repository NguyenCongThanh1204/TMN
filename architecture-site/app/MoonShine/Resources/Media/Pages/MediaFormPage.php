<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Media\Pages;

use App\Models\MediaFolder;
use App\MoonShine\Resources\Media\MediaResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Throwable;

/**
 * @extends FormPage<MediaResource>
 */
class MediaFormPage extends FormPage
{
    /**
     * Fields shown in the media edit form.
     * file_path is read-only — images always enter through the upload workflow.
     * post_id is intentionally removed — media is standalone by default.
     *
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make('Thông tin ảnh', [
                ID::make(),

                Text::make('Cloudinary Public ID', 'file_path')
                    ->readonly(),

                Text::make('Chú thích ảnh', 'caption')
                    ->nullable()
                    ->placeholder('Mô tả ngắn hiển thị dưới ảnh'),

                Text::make('Văn bản thay thế (Alt)', 'alt_text')
                    ->nullable()
                    ->placeholder('Mô tả ảnh cho SEO và trình đọc màn hình'),

                Text::make('Từ khóa', 'keywords')
                    ->nullable()
                    ->placeholder('Các từ khóa cách nhau bởi dấu phẩy, ví dụ: văn phòng, kiến trúc, dự án'),

                Textarea::make('Mô tả chi tiết', 'description')
                    ->nullable()
                    ->placeholder('Mô tả chi tiết ảnh, sử dụng để gợi ý khi viết bài'),

                Select::make('Thư mục', 'folder_id')
                    ->options(
                        MediaFolder::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->all()
                    )
                    ->nullable(),
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

    /**
     * Validation rules — post_id is optional; images are standalone by design.
     */
    protected function rules(DataWrapperContract $item): array
    {
        return [
            'file_path' => ['required', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:255'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:2000'],
            'folder_id' => ['nullable', 'integer', 'exists:media_folders,id'],
            'post_id' => ['nullable', 'integer', 'exists:posts,id'],
        ];
    }

    protected function modifyFormComponent(
        FormBuilderContract $component
    ): FormBuilderContract {
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
