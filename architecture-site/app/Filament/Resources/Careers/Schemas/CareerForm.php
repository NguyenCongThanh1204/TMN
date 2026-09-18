<?php

namespace App\Filament\Resources\Careers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CareerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('job_title')
                    ->label('Vị trí tuyển dụng')
                    ->placeholder('Ví dụ: Shopdrawing kết cấu / Hoàn thiện')
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('cover_image')
                    ->label('Ảnh bìa vị trí tuyển dụng')
                    ->image()
                    ->disk('public')
                    ->directory('careers/covers')
                    ->visibility('public')
                    ->imageEditor()
                    ->columnSpanFull(),

                TextInput::make('department')
                    ->label('Phòng ban')
                    ->placeholder('Ví dụ: Ban Chỉ huy công trường'),

                TextInput::make('location')
                    ->label('Địa điểm làm việc')
                    ->placeholder('Ví dụ: Đà Nẵng & Miền Trung'),

                TextInput::make('salary_range')
                    ->label('Mức lương')
                    ->placeholder('Ví dụ: Thỏa thuận / 15 - 20 triệu'),

                DatePicker::make('deadline')
                    ->label('Hạn nộp hồ sơ')
                    ->displayFormat('d/m/Y')
                    ->native(false),

                // Menu chọn trạng thái đóng / mở thay vì gõ text
                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'open'   => 'Đang tuyển dụng',
                        'closed' => 'Dừng nhận hồ sơ',
                    ])
                    ->default('open')
                    ->required()
                    ->native(false),

                Textarea::make('description')
                    ->label('Mô tả & Yêu cầu công việc')
                    ->rows(8)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}