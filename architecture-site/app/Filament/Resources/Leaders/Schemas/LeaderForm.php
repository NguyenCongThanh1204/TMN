<?php

namespace App\Filament\Resources\Leaders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

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

                FileUpload::make('image')
                    ->label('Hình ảnh chân dung')
                    ->image()
                    ->directory('leaders')
                    ->columnSpanFull(),

                TextInput::make('email')
                    ->label('Email liên hệ')
                    ->email()
                    ->placeholder('name@tanminhnhan.com.vn')
                    ->columnSpanFull(),

                Textarea::make('bio')
                    ->label('Tiểu sử / Giới thiệu chi tiết')
                    ->rows(4)
                    ->placeholder('Nhập tiểu sử hiển thị khi khách hàng bấm vào xem chi tiết...')
                    ->columnSpanFull(),
            ]);
    }
}