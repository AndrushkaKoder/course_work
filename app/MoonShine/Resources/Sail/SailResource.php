<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sail;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sail;
use App\MoonShine\Resources\Sail\Pages\SailIndexPage;
use App\MoonShine\Resources\Sail\Pages\SailFormPage;
use App\MoonShine\Resources\Sail\Pages\SailDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Sail, SailIndexPage, SailFormPage, SailDetailPage>
 */
class SailResource extends ModelResource
{
    protected string $model = Sail::class;

    protected string $title = 'Сделки';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            SailIndexPage::class,
            SailFormPage::class,
        ];
    }
}
