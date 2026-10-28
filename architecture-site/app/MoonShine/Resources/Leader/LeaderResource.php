<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Leader;

use App\Models\Leader;
use App\MoonShine\Resources\Leader\Pages\LeaderDetailPage;
use App\MoonShine\Resources\Leader\Pages\LeaderFormPage;
use App\MoonShine\Resources\Leader\Pages\LeaderIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Leader, LeaderIndexPage, LeaderFormPage, LeaderDetailPage>
 */
class LeaderResource extends ModelResource
{
    protected string $model = Leader::class;

    protected string $title = 'Leaders';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            LeaderIndexPage::class,
            LeaderFormPage::class,
            LeaderDetailPage::class,
        ];
    }
}
