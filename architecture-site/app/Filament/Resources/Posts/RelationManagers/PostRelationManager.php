<?php

namespace App\Filament\Resources\Posts\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class PostRelationManager extends RelationManager
{
    protected static string $relationship = 'media';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\FileUpload::make('file_path')
                    ->label('Ảnh (Có thể chọn nhiều)')
                    ->disk('cloudinary')
                    ->visibility('public')
                    ->directory(function () {
                        $record = $this->getOwnerRecord();

                        $slug = $record?->slug
                            ?: Str::slug(
                                $record?->title ?? 'bai-viet'
                            );

                        return "posts/{$slug}/media";
                    })
                    ->image()
                    ->maxSize(20480)
                    ->required()
                    ->multiple()
                    ->preserveFilenames(false)
                    ->getUploadedFileNameForStorageUsing(
                        function (
                            TemporaryUploadedFile $file
                        ): string {
                            $originalName = pathinfo(
                                $file->getClientOriginalName(),
                                PATHINFO_FILENAME
                            );

                            $extension = strtolower(
                                $file->getClientOriginalExtension()
                            );

                            $slug = Str::slug($originalName);

                            if (!$slug) {
                                $slug = 'anh';
                            }

                            return "{$slug}.{$extension}";
                        }
                    )
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('file_path')

            ->columns([
                ImageColumn::make('file_path')
                    ->disk('cloudinary')
                    ->label('Ảnh'),

                TextColumn::make('file_path')
                    ->label('Tên file ảnh')
                    ->formatStateUsing(
                        fn ($state) => basename($state)
                    )
                    ->searchable()
                    ->sortable(),
            ])

            ->filters([
                //
            ])

            ->headerActions([
                CreateAction::make()
                    ->using(function (
                        array $data,
                        string $model
                    ): Model {
                        $record = $this->getOwnerRecord();

                        $files = is_array($data['file_path'] ?? null)
                            ? $data['file_path']
                            : [$data['file_path'] ?? null];

                        $lastMedia = null;

                        $slug = $record?->slug
                            ?: Str::slug(
                                $record?->title ?? 'bai-viet'
                            );

                        $directory = "posts/{$slug}/media";

                        foreach ($files as $file) {

                            /*
                             * File upload mới
                             */
                            if ($file instanceof TemporaryUploadedFile) {

                                $originalName = pathinfo(
                                    $file->getClientOriginalName(),
                                    PATHINFO_FILENAME
                                );

                                $extension = strtolower(
                                    $file->getClientOriginalExtension()
                                );

                                $filename = Str::slug(
                                    $originalName
                                );

                                if (!$filename) {
                                    $filename = 'anh';
                                }

                                /*
                                 * Đảm bảo không ghi đè
                                 * nếu 2 ảnh có cùng tên.
                                 */
                                $baseFilename = $filename;
                                $counter = 1;

                                $path = "{$directory}/{$filename}.{$extension}";

                                while (
                                    Storage::disk('cloudinary')
                                        ->exists($path)
                                ) {
                                    $filename =
                                        "{$baseFilename}-{$counter}";

                                    $path =
                                        "{$directory}/{$filename}.{$extension}";

                                    $counter++;
                                }

                                /*
                                 * Upload Cloudinary với
                                 * tên file SEO mong muốn.
                                 */
                                $path = $file->storeAs(
                                    $directory,
                                    "{$filename}.{$extension}",
                                    'cloudinary'
                                );

                            } else {

                                /*
                                 * Trường hợp Filament đã trả
                                 * về path đã upload.
                                 */
                                $path = is_string($file)
                                    ? $file
                                    : null;
                            }

                            if ($path) {
                                $lastMedia = $record->media()->create([
                                    'file_path' => $path,
                                ]);
                            }
                        }

                        return $lastMedia
                            ?? $record->media()->first();
                    }),
            ])

            ->actions([
                Action::make('copyUrl')
                    ->label('Copy Link')
                    ->icon('heroicon-m-clipboard')
                    ->color('gray')
                    ->extraAttributes(
                        fn ($record) => [
                            'x-on:click.stop' =>
                                "navigator.clipboard.writeText(" .
                                json_encode(
                                    Storage::disk('cloudinary')
                                        ->url($record->file_path)
                                ) .
                                ").then(() => \$wire.notifyCopied())",
                        ]
                    ),

                DeleteAction::make()
                    ->before(function ($record) {
                        if ($record->file_path) {
                            Storage::disk('cloudinary')
                                ->delete($record->file_path);
                        }
                    }),
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->file_path) {
                                    Storage::disk('cloudinary')
                                        ->delete($record->file_path);
                                }
                            }
                        }),
                ]),
            ]);
    }

    public function notifyCopied(): void
    {
        Notification::make()
            ->title('Đã sao chép đường dẫn đầy đủ!')
            ->success()
            ->send();
    }
}