<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
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
                    ->preserveFilenames(false)

                    ->getUploadedFileNameForStorageUsing(
                        function (
                            \Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file,
                            $get
                        ): string {
                            return Str::slug(
                                $get('name') ?? 'doi-tac'
                            );
                        }
                    )

                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
