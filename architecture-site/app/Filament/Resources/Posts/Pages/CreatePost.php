<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    // Giúp form mở rộng toàn màn hình thay vì bị giới hạn container
    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }
}