<?php

namespace App\Filament\Resources\Leaders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use App\Filament\Forms\Components\CloudinaryUpload;
use Filament\Schemas\Schema;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LeaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('level_id')
                    ->label('Cấp bậc / Khối quản lý')
                    ->options([
                        1 => '1. Hội Đồng Quản Trị (HĐQT)',
                        2 => '2. Ban Tổng Giám Đốc',
                        3 => '3. Trợ Lý Chủ Tịch & Giám Đốc Khối',
                        4 => '4. Khối Điều Hành Dự Án',
                    ])
                    ->required()
                    ->native(false),

                TextInput::make('position_order')
                    ->label('Thứ tự sắp xếp')
                    ->numeric()
                    ->default(0)
                    ->required(),

                TextInput::make('name')
                    ->label('Họ và tên')
                    ->required(),

                TextInput::make('title')
                    ->label('Chức vụ')
                    ->required(),

                CloudinaryUpload::make('image')
                    ->label('Hình ảnh chân dung')
                    ->image()
                    ->maxSize(20480)
                    ->imageEditor()
                    ->directory('leaders')
                    ->preserveFilenames(false)
                    ->getUploadedFileNameForStorageUsing(
                        function (
                            TemporaryUploadedFile $file,
                            $get
                        ): string {
                            $name = $get('name');

                            $filename = Str::slug(
                                $name ?: pathinfo(
                                    $file->getClientOriginalName(),
                                    PATHINFO_FILENAME
                                )
                            );

                            if (!$filename) {
                                $filename = 'lanh-dao';
                            }

                            // Không thêm extension.
                            // Cloudinary adapter tự thêm .jpg/.png...
                            return $filename;
                        }
                    )
                    ->directory(function ($get) {
                        $name = $get('name');

                        $filename = Str::slug(
                            $name ?: 'lanh-dao'
                        );

                        return "leaders/{$filename}";
                    })
                    ->columnSpanFull(),

                TextInput::make('email')
                    ->label('Email liên hệ')
                    ->email()
                    ->placeholder('name@tanminhnhan.com.vn')
                    ->columnSpanFull(),

                Textarea::make('bio')
                    ->label('Tiểu sử / Giới thiệu chi tiết')
                    ->rows(4)
                    ->placeholder(
                        'Nhập tiểu sử hiển thị khi khách hàng bấm vào xem chi tiết...'
                    )
                    ->columnSpanFull(),
            ]);
    }
}