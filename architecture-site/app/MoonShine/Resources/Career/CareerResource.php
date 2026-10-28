<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Career;

use App\Models\Career;
use App\MoonShine\Resources\Career\Pages\CareerDetailPage;
use App\MoonShine\Resources\Career\Pages\CareerFormPage;
use App\MoonShine\Resources\Career\Pages\CareerIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Career, CareerIndexPage, CareerFormPage, CareerDetailPage>
 */
class CareerResource extends ModelResource
{
    protected string $model = Career::class;

    protected string $title = 'Careers';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            CareerIndexPage::class,
            CareerFormPage::class,
            CareerDetailPage::class,
        ];
    }
}
