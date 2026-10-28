<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Partner;

use App\Models\Partner;
use App\MoonShine\Resources\Partner\Pages\PartnerDetailPage;
use App\MoonShine\Resources\Partner\Pages\PartnerFormPage;
use App\MoonShine\Resources\Partner\Pages\PartnerIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Partner, PartnerIndexPage, PartnerFormPage, PartnerDetailPage>
 */
class PartnerResource extends ModelResource
{
    protected string $model = Partner::class;

    protected string $title = 'Partners';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            PartnerIndexPage::class,
            PartnerFormPage::class,
            PartnerDetailPage::class,
        ];
    }
}
