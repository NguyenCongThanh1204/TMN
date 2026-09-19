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
            ->columns(2) // Kích hoạt lưới 2 cột toàn màn hình
            ->components([
                // Hàng 1: Danh mục & Trạng thái
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

                // Hàng 2: Tên dự án (Full width)
                TextInput::make('title')
                    ->label('Tên dự án / Công trình')
                    ->placeholder('Ví dụ: Văn phòng Tân Minh Nhân')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, $set) {
                        if ($operation === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    })
                    ->columnSpanFull(),

                // Hàng 3: Slug (Full width)
                TextInput::make('slug')
                    ->label('Đường dẫn tĩnh (Slug)')
                    ->placeholder('Ví dụ: van-phong-tan-minh-nhan')
                    ->required()
                    ->maxLength(255)
                    ->unique(Project::class, 'slug', ignoreRecord: true)
                    ->columnSpanFull(),

                // Hàng 4: Khách hàng & Địa điểm
                TextInput::make('client_name')
                    ->label('Chủ đầu tư / Khách hàng')
                    ->placeholder('Ví dụ: Công ty Cổ phần Tân Minh Nhân'),

                TextInput::make('location')
                    ->label('Địa điểm thực hiện')
                    ->placeholder('Ví dụ: Đà Nẵng'),

                // Hàng 5: Diện tích & Năm
                TextInput::make('area_sqm')
                    ->label('Diện tích sàn (m²)')
                    ->placeholder('Ví dụ: 1.200 m²')
                    ->maxLength(255),

                TextInput::make('year')
                    ->label('Năm thực hiện')
                    ->placeholder('Ví dụ: 2026')
                    ->numeric(),

                // Hàng 6: Kết cấu & Tiến độ
                TextInput::make('structural_type')
                    ->label('Loại kết cấu / Hạng mục')
                    ->placeholder('Ví dụ: Kết cấu thép, Nội thất văn phòng'),

                TextInput::make('timeline')
                    ->label('Tiến độ / Thời gian thi công')
                    ->placeholder('Ví dụ: 6 tháng, Hoàn thành Q2/2026'),

                // Hàng 7: Bật trang chủ (Full width)
                Toggle::make('is_featured')
                    ->label('Dự án tiêu biểu (Hiện lên Accordion trang chủ)')
                    ->helperText('Bật tùy chọn này để đưa công trình ra dải nổi bật ngoài trang chủ')
                    ->default(false)
                    ->columnSpanFull(),

                // Hàng 8: Ảnh đại diện (Tự động chuẩn hóa tên file, loại bỏ khoảng trắng và dấu)
                
                FileUpload::make('cover_image')
                    ->label('Ảnh đại diện / Ảnh bìa')
                    ->disk('public')
                    ->visibility('public')
                    ->image()
                    ->maxSize(20480)
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null, // Cho phép chỉnh khung linh hoạt không giới hạn tỷ lệ
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->preserveFilenames(false) // Tắt giữ tên gốc để hệ thống tự đặt lại tên sạch sẽ
                    ->getUploadedFileNameForStorageUsing(function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file): string {
                        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $extension = $file->getClientOriginalExtension();
                        
                        // Chuyển tên file thành slug (bỏ dấu tiếng Việt, thay khoảng trắng thành '-')
                        $cleanName = Str::slug($filename);
                        
                        return Str::slug($filename) . '.' . $extension;
                    })
                    ->afterStateHydrated(function ($component, $state) {
                        if (is_array($state)) {
                            $component->state($state['path'] ?? $state['url'] ?? reset($state) ?? null);
                        } elseif (is_string($state) && str_starts_with($state, '{')) {
                            $decoded = json_decode($state, true);
                            $component->state($decoded['path'] ?? $decoded['url'] ?? null);
                        } else {
                            $component->state($state);
                        }
                    })
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            return $state['path'] ?? $state['url'] ?? reset($state) ?? null;
                        }
                        if (is_string($state) && str_starts_with($state, '{')) {
                            $decoded = json_decode($state, true);
                            return $decoded['path'] ?? $decoded['url'] ?? null;
                        }
                        return $state;
                    })
                    ->directory(function ($get) {
                        $slug = $get('slug') ?: Str::slug($get('title') ?? 'du-an-moi');
                        return "projects/{$slug}/covers";
                    })
                    ->columnSpanFull(),

                // Hàng 9: Mô tả chi tiết (Full width)
                Textarea::make('body_content')
                    ->label('Nội dung chi tiết dự án')
                    ->placeholder('Mô tả quy mô, thiết kế và tiến trình dự án...')
                    ->rows(6)
                    ->columnSpanFull(),
            ]);
    }
}