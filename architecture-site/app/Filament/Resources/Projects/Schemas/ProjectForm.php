<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([

                // =========================================================
                // HÀNG 1: DANH MỤC & TRẠNG THÁI
                // =========================================================

                Select::make('category_id')
                    ->label('Danh mục dự án')
                    ->relationship('category', 'name')
                    ->placeholder('Chọn danh mục dự án')
                    ->preload()
                    ->searchable(),

                Select::make('status')
                    ->label('Trạng thái xuất bản')
                    ->options([
                        'draft'     => 'Bản nháp',
                        'published' => 'Đã xuất bản',
                        'archived'  => 'Lưu trữ',
                    ])
                    ->default('published')
                    ->required(),

                // =========================================================
                // HÀNG 2: TÊN DỰ ÁN
                // =========================================================

                TextInput::make('title')
                    ->label('Tên dự án / Công trình')
                    ->placeholder('Ví dụ: Văn phòng Tân Minh Nhân')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (
                        string $operation,
                        $state,
                        $set
                    ) {
                        if ($operation === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    })
                    ->columnSpanFull(),

                // =========================================================
                // HÀNG 3: SLUG
                // =========================================================

                TextInput::make('slug')
                    ->label('Đường dẫn tĩnh (Slug)')
                    ->placeholder('Ví dụ: van-phong-tan-minh-nhan')
                    ->required()
                    ->maxLength(255)
                    ->unique(
                        Project::class,
                        'slug',
                        ignoreRecord: true
                    )
                    ->columnSpanFull(),

                // =========================================================
                // HÀNG 4: KHÁCH HÀNG & ĐỊA ĐIỂM
                // =========================================================

                TextInput::make('client_name')
                    ->label('Chủ đầu tư / Khách hàng')
                    ->placeholder(
                        'Ví dụ: Công ty Cổ phần Tân Minh Nhân'
                    ),

                TextInput::make('location')
                    ->label('Địa điểm thực hiện')
                    ->placeholder('Ví dụ: Đà Nẵng'),

                // =========================================================
                // HÀNG 5: DIỆN TÍCH & NĂM
                // =========================================================

                TextInput::make('area_sqm')
                    ->label('Diện tích sàn (m²)')
                    ->placeholder('Ví dụ: 1.200 m²')
                    ->maxLength(255),

                TextInput::make('year')
                    ->label('Năm thực hiện')
                    ->placeholder('Ví dụ: 2026')
                    ->numeric(),

                // =========================================================
                // HÀNG 6: KẾT CẤU & TIẾN ĐỘ
                // =========================================================

                TextInput::make('structural_type')
                    ->label('Loại kết cấu / Hạng mục')
                    ->placeholder(
                        'Ví dụ: Kết cấu thép, Nội thất văn phòng'
                    ),

                TextInput::make('timeline')
                    ->label('Tiến độ / Thời gian thi công')
                    ->placeholder(
                        'Ví dụ: 6 tháng, Hoàn thành Q2/2026'
                    ),

                // =========================================================
                // HÀNG 7: HIỂN THỊ TRANG CHỦ
                // =========================================================

                Toggle::make('is_featured')
                    ->label(
                        'Dự án tiêu biểu (Hiện lên Accordion trang chủ)'
                    )
                    ->helperText(
                        'Bật tùy chọn này để đưa công trình ra dải nổi bật ngoài trang chủ'
                    )
                    ->default(false)
                    ->columnSpanFull(),

                // =========================================================
                // HÀNG 8: ẢNH ĐẠI DIỆN / ẢNH BÌA
                // =========================================================

                FileUpload::make('cover_image')
                    ->label('Ảnh đại diện / Ảnh bìa')

                    // Upload trực tiếp lên Cloudinary
                    ->disk('cloudinary')

                    // Ảnh public để website có thể hiển thị
                    ->visibility('public')

                    // Chỉ cho phép upload hình ảnh
                    ->image()

                    // Tối đa 20 MB
                    ->maxSize(20480)

                    // Cho phép chỉnh sửa ảnh trước khi upload
                    ->imageEditor()

                    // Tỷ lệ ảnh
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ])

                    // Không sử dụng tên file gốc
                    ->preserveFilenames(false)

                    // =====================================================
                    // ĐẶT TÊN FILE THEO SLUG CỦA PROJECT
                    //
                    // Ví dụ:
                    // title = Văn phòng Tân Minh Nhân
                    // slug  = van-phong-tan-minh-nhan
                    //
                    // => van-phong-tan-minh-nhan.jpg
                    // =====================================================

                    ->getUploadedFileNameForStorageUsing(
                        function (
                            \Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file,
                            $get
                        ): string {
                            $slug = $get('slug');

                            // Nếu chưa có slug thì lấy title tạo slug
                            if (!$slug) {
                                $slug = Str::slug(
                                    $get('title') ?? 'du-an-moi'
                                );
                            }

                            $extension = strtolower(
                                $file->getClientOriginalExtension()
                            );

                            return "{$slug}.{$extension}";
                        }
                    )

                    // =====================================================
                    // FOLDER CLOUDINARY
                    //
                    // projects/
                    //     van-phong-tan-minh-nhan/
                    //         covers/
                    //             van-phong-tan-minh-nhan.jpg
                    // =====================================================

                    ->directory(function ($get) {
                        $slug = $get('slug')
                            ?: Str::slug(
                                $get('title') ?? 'du-an-moi'
                            );

                        return "projects/{$slug}/covers";
                    })

                    // =====================================================
                    // XỬ LÝ DỮ LIỆU CŨ
                    // =====================================================

                    ->afterStateHydrated(function (
                        $component,
                        $state
                    ) {
                        if (is_array($state)) {
                            $component->state(
                                $state['path']
                                    ?? $state['url']
                                    ?? reset($state)
                                    ?? null
                            );

                            return;
                        }

                        if (
                            is_string($state)
                            && str_starts_with($state, '{')
                        ) {
                            $decoded = json_decode(
                                $state,
                                true
                            );

                            $component->state(
                                $decoded['path']
                                    ?? $decoded['url']
                                    ?? null
                            );

                            return;
                        }

                        $component->state($state);
                    })

                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            return $state['path']
                                ?? $state['url']
                                ?? reset($state)
                                ?? null;
                        }

                        if (
                            is_string($state)
                            && str_starts_with($state, '{')
                        ) {
                            $decoded = json_decode(
                                $state,
                                true
                            );

                            return $decoded['path']
                                ?? $decoded['url']
                                ?? null;
                        }

                        return $state;
                    })

                    ->columnSpanFull(),

                // =========================================================
                // HÀNG 9: MÔ TẢ CHI TIẾT
                // =========================================================

                Textarea::make('body_content')
                    ->label('Nội dung chi tiết dự án')
                    ->placeholder(
                        'Mô tả quy mô, thiết kế và tiến trình dự án...'
                    )
                    ->rows(6)
                    ->columnSpanFull(),
            ]);
    }
}