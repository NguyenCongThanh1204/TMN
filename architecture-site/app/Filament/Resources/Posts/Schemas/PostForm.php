<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Visualbuilder\FilamentTinyEditor\TinyEditor;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // =========================================================
                // HÀNG 1: TIÊU ĐỀ - SLUG - DANH MỤC
                // =========================================================
                Grid::make(12)
                    ->schema([
                        TextInput::make('title')
                            ->label('Tiêu đề bài viết *')
                            ->placeholder('Nhập tiêu đề bài viết...')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                function (
                                    string $operation,
                                    $state,
                                    Set $set
                                ) {
                                    if ($operation === 'create') {
                                        $set(
                                            'slug',
                                            Str::slug($state)
                                        );
                                    }
                                }
                            )
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 6,
                            ]),

                        TextInput::make('slug')
                            ->label('Đường dẫn tĩnh (Slug) *')
                            ->placeholder('Tự động tạo từ tiêu đề')
                            ->required()
                            ->maxLength(255)
                            ->unique(
                                Post::class,
                                'slug',
                                ignoreRecord: true
                            )
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 3,
                            ]),

                        Select::make('category_id')
                            ->label('Danh mục bài viết *')
                            ->relationship('category', 'name')
                            ->placeholder('Chọn danh mục')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 3,
                            ]),
                    ])
                    ->columnSpanFull(),

                // =========================================================
                // HÀNG 2: NỘI DUNG + THƯ VIỆN LINK NHANH
                // =========================================================
                Grid::make(12)
                    ->extraAttributes([
                        'style' => 'align-items: start;',
                    ])
                    ->schema([

                        // =================================================
                        // CỘT TRÁI
                        // =================================================
                        Tabs::make('ArticleTabs')
                            ->tabs([

                                // -----------------------------------------
                                // TAB: NỘI DUNG CHÍNH
                                // -----------------------------------------
                                Tab::make('Nội dung chính')
                                    ->schema([
                                        TinyEditor::make('content')
                                            ->label(
                                                'Nội dung chi tiết bài viết'
                                            )
                                            ->required()
                                            ->profile('full')

                                            /*
                                             * Giữ public cho TinyEditor
                                             * để tránh phát sinh lại lỗi
                                             * upload Livewire/TinyEditor.
                                             *
                                             * Có thể chuyển Cloudinary
                                             * sau khi kiểm tra riêng
                                             * cơ chế upload của TinyEditor.
                                             */
                                            ->fileAttachmentsDisk('public')

                                            ->fileAttachmentsDirectory(
                                                function (Get $get) {
                                                    $slug = $get('slug')
                                                        ?: Str::slug(
                                                            $get('title')
                                                                ?? 'bai-viet-moi'
                                                        );

                                                    return "posts/{$slug}/content";
                                                }
                                            )

                                            ->fileAttachmentsVisibility(
                                                'public'
                                            )

                                            ->minHeight(500)
                                            ->maxHeight(650)
                                            ->showMenuBar()

                                            ->extraAttributes([
                                                'style' =>
                                                    'max-height: 650px; overflow-y: auto;',
                                            ])

                                            ->columnSpanFull(),
                                    ]),

                                // -----------------------------------------
                                // TAB: HÌNH ẢNH & THƯ VIỆN
                                // -----------------------------------------
                                Tab::make('Hình ảnh & Thư viện')
                                    ->schema([

                                        FileUpload::make('thumbnail')
                                            ->label(
                                                'Ảnh đại diện chính (Cover Image)'
                                            )

                                            // Cloudinary
                                            ->disk('cloudinary')
                                            ->visibility('public')

                                            ->image()
                                            ->maxSize(20480)

                                            /*
                                             * Không yêu cầu Filament
                                             * đọc metadata file từ disk.
                                             *
                                             * Quan trọng với Cloudinary:
                                             * tránh tình trạng preview
                                             * hiển thị "0 bytes".
                                             */
                                            ->fetchFileInformation(false)

                                            /*
                                             * Khi record đã có ảnh,
                                             * lấy URL trực tiếp từ Cloudinary.
                                             */
                                            ->getUploadedFileUrlUsing(
                                                function ($file) {
                                                    if (!$file) {
                                                        return null;
                                                    }

                                                    return Storage::disk(
                                                        'cloudinary'
                                                    )->url($file);
                                                }
                                            )

                                            ->imageEditor()

                                            /*
                                             * Không dùng tên file gốc.
                                             * Tên file sẽ được tạo theo slug.
                                             */
                                            ->preserveFilenames(false)

                                            /*
                                             * Tên file:
                                             *
                                             * posts/
                                             *   {slug}/
                                             *      thumbnail/
                                             *          {slug}.jpg
                                             */
                                            ->getUploadedFileNameForStorageUsing(
                                                function (
                                                    TemporaryUploadedFile $file,
                                                    $get
                                                ): string {
                                                    $slug = $get('slug')
                                                        ?: Str::slug(
                                                            $get('title')
                                                                ?? 'bai-viet'
                                                        );

                                                    if (!$slug) {
                                                        $slug = 'bai-viet';
                                                    }

                                                    return $slug;
                                                }
                                            )

                                            ->directory(
                                                function ($get) {
                                                    $slug = $get('slug')
                                                        ?: Str::slug(
                                                            $get('title')
                                                                ?? 'bai-viet'
                                                        );

                                                    if (!$slug) {
                                                        $slug = 'bai-viet';
                                                    }

                                                    return "posts/{$slug}/thumbnail";
                                                }
                                            )

                                            ->columnSpanFull(),

                                        // ---------------------------------
                                        // THÔNG TIN ẢNH
                                        // ---------------------------------
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make(
                                                    'thumbnail_caption'
                                                )
                                                    ->label(
                                                        'Chú thích ảnh chính'
                                                    )
                                                    ->placeholder(
                                                        'Nhập chú thích hiển thị dưới ảnh đại diện...'
                                                    ),

                                                TextInput::make(
                                                    'thumbnail_alt'
                                                )
                                                    ->label(
                                                        'Mô tả hình ảnh (Thẻ Alt SEO)'
                                                    )
                                                    ->placeholder(
                                                        'Mô tả hình ảnh phục vụ SEO...'
                                                    ),
                                            ]),
                                    ]),

                                // -----------------------------------------
                                // TAB: SEO & TÁC GIẢ
                                // -----------------------------------------
                                Tab::make('SEO & Tác giả')
                                    ->schema([

                                        Textarea::make('excerpt')
                                            ->label(
                                                'Đoạn trích tóm tắt (Excerpt)'
                                            )
                                            ->rows(4)
                                            ->placeholder(
                                                'Đoạn tóm tắt ngắn phục vụ xem trước và SEO...'
                                            )
                                            ->columnSpanFull(),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make(
                                                    'author_name'
                                                )
                                                    ->label('Tên tác giả')
                                                    ->placeholder(
                                                        'Ví dụ: Ban biên tập'
                                                    ),

                                                TextInput::make(
                                                    'author_role'
                                                )
                                                    ->label(
                                                        'Chức danh tác giả'
                                                    )
                                                    ->placeholder(
                                                        'Ví dụ: Kiến trúc sư trưởng'
                                                    ),
                                            ]),
                                    ]),

                                // -----------------------------------------
                                // TAB: XUẤT BẢN & CÀI ĐẶT
                                // -----------------------------------------
                                Tab::make('Xuất bản & Cài đặt')
                                    ->schema([

                                        Grid::make(2)
                                            ->schema([
                                                DateTimePicker::make(
                                                    'published_at'
                                                )
                                                    ->label(
                                                        'Thời gian xuất bản'
                                                    )
                                                    ->default(now()),

                                                TextInput::make('views')
                                                    ->label(
                                                        'Lượt xem khởi tạo'
                                                    )
                                                    ->numeric()
                                                    ->default(0),
                                            ]),

                                        Toggle::make('is_featured')
                                            ->label(
                                                'Bài viết nổi bật'
                                            )
                                            ->helperText(
                                                'Hiển thị ở khu vực tiêu điểm trên trang chủ'
                                            )
                                            ->inline(false)
                                            ->default(false),
                                    ]),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 9,
                            ]),

                        // =================================================
                        // CỘT PHẢI: THƯ VIỆN LINK NHANH
                        // =================================================
                        Section::make('Thư viện Link Nhanh')
                            ->description(
                                'Copy nhanh link ảnh hệ thống'
                            )
                            ->schema([

                                Placeholder::make('quick_media_list')
                                    ->hiddenLabel()
                                    ->content(
                                        function (?Post $record) {

                                            if (
                                                !$record
                                                || !$record->exists
                                            ) {
                                                return new HtmlString(
                                                    '<div style="font-size: 11px; color: #9ca3af; text-align: center; padding: 8px;">
                                                        Vui lòng lưu bài viết trước.
                                                    </div>'
                                                );
                                            }

                                            // Lấy media mới nhất
                                            $mediaItems = $record
                                                ->media()
                                                ->latest()
                                                ->get();

                                            if (
                                                $mediaItems->count() === 0
                                            ) {
                                                return new HtmlString(
                                                    '<div style="font-size: 11px; color: #9ca3af; text-align: center; padding: 8px;">
                                                        Chưa có ảnh nào được tải lên.
                                                    </div>'
                                                );
                                            }

                                            $html =
                                                '<div style="
                                                    display: flex;
                                                    flex-direction: column;
                                                    gap: 6px;
                                                    max-height: 520px;
                                                    overflow-y: auto;
                                                    padding-right: 2px;
                                                ">';

                                            foreach (
                                                $mediaItems as $mediaItem
                                            ) {
                                                $fileName = basename(
                                                    $mediaItem->file_path
                                                );

                                                /*
                                                 * QUAN TRỌNG:
                                                 *
                                                 * Không còn:
                                                 * /storage/...
                                                 *
                                                 * Mà lấy URL trực tiếp
                                                 * từ Cloudinary.
                                                 */
                                                $fileUrl = Storage::disk(
                                                    'cloudinary'
                                                )->url(
                                                    $mediaItem->file_path
                                                );

                                                $safeFileName =
                                                    htmlspecialchars(
                                                        $fileName,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );

                                                $safeFileUrl =
                                                    htmlspecialchars(
                                                        $fileUrl,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );

                                                $html .= '
                                                    <div style="
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: space-between;
                                                        gap: 4px;
                                                        padding: 5px 8px;
                                                        border-radius: 6px;
                                                        background: #f9fafb;
                                                        border: 1px solid #e5e7eb;
                                                    ">

                                                        <span
                                                            style="
                                                                font-size: 11px;
                                                                font-weight: 500;
                                                                color: #374151;
                                                                white-space: nowrap;
                                                                overflow: hidden;
                                                                text-overflow: ellipsis;
                                                                max-width: 120px;
                                                            "
                                                            title="' . $safeFileName . '"
                                                        >
                                                            ' . $safeFileName . '
                                                        </span>

                                                        <button
                                                            type="button"
                                                            onclick="navigator.clipboard.writeText(' .
                                                                htmlspecialchars(
                                                                    json_encode(
                                                                        $fileUrl,
                                                                        JSON_UNESCAPED_SLASHES |
                                                                            JSON_UNESCAPED_UNICODE
                                                                    ),
                                                                    ENT_QUOTES,
                                                                    'UTF-8'
                                                                ) .
                                                                ').then(() => {
                                                                    new FilamentNotification()
                                                                        .title(\'Đã copy đường dẫn!\')
                                                                        .success()
                                                                        .send();
                                                                });"
                                                            style="
                                                                padding: 2px 6px;
                                                                font-size: 10px;
                                                                font-weight: 600;
                                                                color: #2563eb;
                                                                background: white;
                                                                border: 1px solid #d1d5db;
                                                                border-radius: 4px;
                                                                cursor: pointer;
                                                                flex-shrink: 0;
                                                            "
                                                        >
                                                            Copy
                                                        </button>

                                                    </div>
                                                ';
                                            }

                                            $html .= '</div>';

                                            return new HtmlString($html);
                                        }
                                    ),
                            ])
                            ->compact()
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 3,
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}