<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tên đối tác / Thương hiệu')
                    ->placeholder('Ví dụ: SUN GROUP, JOTUN, DONGTAM...')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                FileUpload::make('logo')
                    ->label('Ảnh logo đối tác')
                    ->image()
                    ->disk('cloudinary')
                    ->directory('partners')
                    ->visibility('public')
                    ->imageEditor()
                    ->fetchFileInformation(false)
                    ->getUploadedFileUrlUsing(
                        fn ($file) => $file
                            ? (str_starts_with($file, 'http://') || str_starts_with($file, 'https://')
                                ? $file
                                : Storage::disk('cloudinary')->url($file))
                            : null
                    )
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}