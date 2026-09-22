<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
{
    // Xử lý lưu các file upload nhanh từ sidebar bên phải
    if (request()->hasFile('quick_uploads')) {
        foreach (request()->file('quick_uploads') as $file) {
            $path = $file->store("posts/{$record->slug}/media", 'cloudinary');
            $record->media()->create(['file_path' => $path]);
        }
    }

    $record->update($data);
    return $record;
}
}
