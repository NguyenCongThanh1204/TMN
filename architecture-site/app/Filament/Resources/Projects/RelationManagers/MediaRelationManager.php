<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Illuminate\Support\Str;

class MediaRelationManager extends RelationManager
{
    protected static string $relationship = 'media';

    protected static ?string $title = 'Hình ảnh & Bản vẽ công trình';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('file_path')
                    ->label('Hình ảnh công trình')
                    ->disk('cloudinary')
                    ->visibility('public')
                    ->image()
                    ->maxSize(20480)
                    ->imageEditor()
                    ->fetchFileInformation(false)
                    ->required()
                    ->preserveFilenames(false)
                    ->getUploadedFileNameForStorageUsing(
                        function (
                            \Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file,
                            $livewire
                        ): string {
                            $project = $livewire->getOwnerRecord();

                            $slug = $project->slug
                                ?? Str::slug(
                                    $project->title ?? 'du-an'
                                );

                            $sortOrder = $livewire->data['sort_order']
                                ?? 0;

                            // KHÔNG thêm .jpg/.png
                            // Cloudinary adapter sẽ tự thêm extension
                            return "{$slug}-{$sortOrder}";
                        }
                    )
                    ->directory(function ($livewire) {
                        $project = $livewire->getOwnerRecord();

                        $slug = $project->slug
                            ?? Str::slug(
                                $project->title ?? 'du-an'
                            );

                        return "projects/{$slug}/gallery";
                    })
                    ->columnSpanFull(),

                TextInput::make('caption')
                    ->label('Chú thích ảnh / Bản vẽ')
                    ->placeholder(
                        'Ví dụ: Mặt cắt tầng 1, Phối cảnh ban đêm...'
                    )
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Thứ tự sắp xếp')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('caption')
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('file_path')
                    ->label('Ảnh')
                    ->disk('cloudinary')
                    ->square(),

                TextColumn::make('caption')
                    ->label('Chú thích')
                    ->searchable()
                    ->placeholder('(Chưa có chú thích)'),

                TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Ngày tải lên')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Thêm hình ảnh'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}