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
                    ->disk('public')
                    ->directory(function () {
                        $record = $this->getOwnerRecord();
                        $slug = $record?->slug ?: 'posts';
                        return "posts/{$slug}/media";
                    })
                    ->image()
                    ->required()
                    ->multiple() // Cho phép chọn nhiều file cùng lúc
                    ->preserveFilenames()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('file_path')
            ->columns([
                ImageColumn::make('file_path')
                    ->disk('public')
                    ->label('Ảnh'),

                TextColumn::make('file_path')
                    ->label('Tên file ảnh')
                    ->formatStateUsing(fn ($state) => basename($state))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->using(function (array $data, string $model): Model {
                        $record = $this->getOwnerRecord();
                        $files = is_array($data['file_path']) ? $data['file_path'] : [$data['file_path']];
                        $lastMedia = null;

                        foreach ($files as $file) {
                            if ($file instanceof TemporaryUploadedFile) {
                                $slug = $record?->slug ?: 'posts';
                                $path = $file->store("posts/{$slug}/media", 'public');
                            } else {
                                $path = is_string($file) ? $file : null;
                            }

                            if ($path) {
                                // Sử dụng quan hệ của record để tự động gán post_id chính xác tuyệt đối
                                $lastMedia = $record->media()->create([
                                    'file_path' => $path,
                                ]);
                            }
                        }

                        return $lastMedia ?? $record->media()->first();
                    }),
            ])
            ->actions([
                Action::make('copyUrl')
                    ->label('Copy Link')
                    ->icon('heroicon-m-clipboard')
                    ->color('gray')
                    ->extraAttributes(fn ($record) => [
                        'x-on:click.stop' => "window.navigator.clipboard.writeText('/storage/" . $record->file_path . "'); \$wire.notifyCopied()"
                    ]),

                DeleteAction::make()
                    ->before(function ($record) {
                        if ($record->file_path) {
                            Storage::disk('public')->delete($record->file_path);
                        }
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->file_path) {
                                    Storage::disk('public')->delete($record->file_path);
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