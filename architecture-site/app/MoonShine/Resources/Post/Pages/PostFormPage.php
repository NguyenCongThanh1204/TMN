<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Post\Pages;

use App\Models\MediaFolder;
use App\Models\Post;
use App\MoonShine\Fields\CloudinaryImage;
use App\MoonShine\Fields\EscapedTextarea;
use App\MoonShine\Fields\MediaPicker;
use App\MoonShine\Fields\TinyMce;
use App\MoonShine\Resources\PostCategory\PostCategoryResource;
use App\Services\MediaCatalog;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\DependencyInjection\FieldsContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\FlexibleRender;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class PostFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        /** @var Post|null $record */
        $record = $this->getResource()->getItem();

        return [
            // =========================================================
            // HÀNG 1: TIÊU ĐỀ - SLUG - DANH MỤC
            // =========================================================
            Box::make([
                Grid::make([
                    Column::make([
                        Text::make('Tiêu đề bài viết *', 'title')
                            ->placeholder('Nhập tiêu đề bài viết...')
                            ->reactive(
                                static function (FieldsContract $fields, ?string $value) use ($record): FieldsContract {
                                    if ($record !== null) {
                                        return $fields;
                                    }

                                    $fields->findByColumn('slug')?->setValue(Str::slug($value ?? ''));

                                    return $fields;
                                },
                                debounce: 300,
                            )
                            ->required(),
                    ])->columnSpan(6),

                    Column::make([
                        Slug::make('Đường dẫn tĩnh (Slug) *', 'slug')
                            ->from('title')
                            ->unique()
                            ->placeholder('Tự động tạo từ tiêu đề')
                            ->required(),
                    ])->columnSpan(3),

                    Column::make([
                        BelongsTo::make('Danh mục bài viết *', 'category', resource: PostCategoryResource::class)
                            ->searchable()
                            ->required(),
                    ])->columnSpan(3),
                ]),
            ]),

            // =========================================================
            // HÀNG 2: NỘI DUNG (CỘT TRÁI) + LINK MEDIA NHANH (CỘT PHẢI)
            // =========================================================
            Grid::make([
                // CỘT TRÁI (Chiếm 9 phần)
                Column::make([
                    Tabs::make([
                        // -----------------------------------------
                        // TAB: NỘI DUNG CHÍNH
                        // -----------------------------------------
                        Tab::make('Nội dung chính', [
                            TinyMce::make('Nội dung chi tiết bài viết', 'content')
                                ->customAttributes([
                                    'data-tinymce' => 'true',
                                ])
                                ->required(),
                        ]),

                        // -----------------------------------------
                        // TAB: HÌNH ẢNH & THƯ VIỆN
                        // -----------------------------------------
                        Tab::make('Hình ảnh & Thư viện', [
                            CloudinaryImage::make('Ảnh đại diện chính (Cover Image)', 'thumbnail')
                                ->disk('cloudinary')
                                ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp'])
                                ->removable(),

                            MediaPicker::forColumn('Hoặc chọn ảnh từ thư viện', 'thumbnail'),

                            Grid::make([
                                Column::make([
                                    Text::make('Chú thích ảnh chính', 'thumbnail_caption')
                                        ->placeholder('Nhập chú thích hiển thị dưới ảnh đại diện...'),
                                ])->columnSpan(6),

                                Column::make([
                                    Text::make('Mô tả hình ảnh (Thẻ Alt SEO)', 'thumbnail_alt')
                                        ->placeholder('Mô tả hình ảnh phục vụ SEO...'),
                                ])->columnSpan(6),
                            ]),
                        ]),

                        // -----------------------------------------
                        // TAB: SEO & TÁC GIẢ
                        // -----------------------------------------
                        Tab::make('SEO & Tác giả', [
                            EscapedTextarea::make('Đoạn trích tóm tắt (Excerpt)', 'excerpt')
                                ->customAttributes(['rows' => 4])
                                ->placeholder('Đoạn tóm tắt ngắn phục vụ xem trước và SEO...'),

                            Grid::make([
                                Column::make([
                                    Text::make('Tên tác giả', 'author_name')
                                        ->placeholder('Ví dụ: Ban biên tập'),
                                ])->columnSpan(6),

                                Column::make([
                                    Text::make('Chức danh tác giả', 'author_role')
                                        ->placeholder('Ví dụ: Kiến trúc sư trưởng'),
                                ])->columnSpan(6),
                            ]),
                        ]),

                        // -----------------------------------------
                        // TAB: XUẤT BẢN & CÀI ĐẶT
                        // -----------------------------------------
                        Tab::make('Xuất bản & Cài đặt', [
                            Grid::make([
                                Column::make([
                                    Date::make('Thời gian xuất bản', 'published_at')
                                        ->withTime()
                                        ->default(now()->toDateTimeString()),
                                ])->columnSpan(6),

                                Column::make([
                                    Number::make('Lượt xem khởi tạo', 'views')
                                        ->default(0),
                                ])->columnSpan(6),
                            ]),

                            Switcher::make('Bài viết nổi bật', 'is_featured')
                                ->hint('Hiển thị ở khu vực tiêu điểm trên trang chủ')
                                ->default(false),
                        ]),
                    ]),
                ])->columnSpan(9),

                // CỘT PHẢI (Chiếm 3 phần): THƯ VIỆN LINK NHANH
                Column::make([
                    Box::make('Thư viện Link Nhanh', [
                        FlexibleRender::make(fn (): string => $this->renderQuickMediaList($record)->toHtml()),
                    ]),
                ])->columnSpan(3),
            ]),
        ];
    }

    /**
     * Tự động giải quyết đường dẫn ảnh từ Cloudinary hoặc Storage
     */
    protected function resolveImageUrl(?string $path): string
    {
        if (blank($path)) {
            return '';
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        try {
            /** @var FilesystemAdapter $disk */
            $disk = Storage::disk('cloudinary');

            return $disk->url($path);
        } catch (\Throwable) {
            return $path;
        }
    }

    /**
     * Quick-link list: images from the Media Library folder matching the post (slug, then title),
     * plus images already attached to the post.
     */
    protected function renderQuickMediaList(?Post $record): HtmlString
    {
        if (! $record || ! $record->exists) {
            return new HtmlString(
                '<div style="font-size: 11px; color: #9ca3af; text-align: center; padding: 12px;">Vui lòng lưu bài viết trước.</div>'
            );
        }

        $folder = MediaFolder::findForPost($record->slug, $record->title);
        $libraryUrl = route('moonshine.page', array_filter([
            'pageUri' => 'media-library',
            'folder' => $folder?->id,
        ]));

        $mediaItems = $folder !== null
            ? app(MediaCatalog::class)->items($folder, MediaFolder::query()->get())->take(60)
            : $record->media()->latest()->limit(60)->get();

        $header = $folder !== null
            ? '<div style="font-size: 12px; color: #374151;">Thư mục: <strong>'.e($folder->name).'</strong></div>'
            : '<div style="font-size: 11px; color: #9ca3af;">Chưa có thư mục trùng slug hoặc tiêu đề bài viết. Tạo thư mục tên <strong>'.e($record->slug).'</strong> trong Media Library để ảnh hiện ở đây.</div>';

        $link = '<a href="'.e($libraryUrl).'" target="_blank" rel="noopener" style="display: block; text-align: center; padding: 6px 10px; font-size: 12px; font-weight: 600; color: #ffffff; background: #0284c7; border-radius: 6px; text-decoration: none;">'
            .($folder !== null ? 'Mở thư mục trong Media Library' : 'Mở Media Library').'</a>';

        if ($mediaItems->isEmpty()) {
            return new HtmlString(
                '<div style="display: flex; flex-direction: column; gap: 8px;">'.$header.$link
                .'<div style="font-size: 11px; color: #9ca3af; text-align: center; padding: 8px;">Chưa có ảnh nào.</div></div>'
            );
        }

        $html = '<div style="display: flex; flex-direction: column; gap: 8px;">'.$header.$link
            .'<div style="display: flex; flex-direction: column; gap: 8px; max-height: 520px; overflow-y: auto; padding-right: 2px;">';

        foreach ($mediaItems as $mediaItem) {
            $fileName = basename($mediaItem->file_path ?? '');
            $fileUrl = $mediaItem->url;

            $safeFileName = htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8');
            $copyUrl = e($fileUrl);
            $thumbUrl = e($mediaItem->thumbnail_url);

            $html .= '
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px; padding: 6px 8px; border-radius: 6px; background: rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.08);">
                    <img src="'.$thumbUrl.'" alt="" loading="lazy" style="width: 36px; height: 36px; object-fit: cover; border-radius: 4px; flex-shrink: 0;">
                    <span style="font-size: 12px; font-weight: 500; color: #374151; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1; min-width: 0;" title="'.$safeFileName.'">
                        '.$safeFileName.'
                    </span>
                    <button type="button"
                        data-url="'.$copyUrl.'" onclick="navigator.clipboard.writeText(this.dataset.url); this.textContent=\'Đã copy\'; setTimeout(() => this.textContent=\'Copy\', 1200);"
                        style="padding: 2px 8px; font-family: inherit; font-size: 11px; font-weight: 600; color: #0284c7; background: #ffffff; border: 1px solid #bae6fd; border-radius: 4px; cursor: pointer; flex-shrink: 0;">
                        Copy
                    </button>
                </div>
            ';
        }

        $html .= '</div></div>';

        return new HtmlString($html);
    }

    /**
     * @return array<string, string>
     */
    public function validationMessages(): array
    {
        return [
            'slug.regex' => 'Slug không được chứa dấu "/" hoặc khoảng trắng.',
        ];
    }

    /**
     * Quy tắc kiểm tra dữ liệu đầu vào (Validation Rules)
     */
    protected function rules(mixed $item): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[^\/\s]+$/u',
                Rule::unique('posts', 'slug')->ignore($item?->getKey()),
            ],
            'category_id' => ['required', 'integer'],
            'content' => ['required', 'string'],
            'thumbnail' => ['nullable'],
            'thumbnail_library' => ['nullable', 'string', 'max:1000'],
            'thumbnail_caption' => ['nullable', 'string', 'max:255'],
            'thumbnail_alt' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'author_name' => ['nullable', 'string', 'max:255'],
            'author_role' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'views' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }
}
