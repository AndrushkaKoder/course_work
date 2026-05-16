<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Option;

use Illuminate\Database\Eloquent\Model;
use App\Models\Option;
use App\MoonShine\Resources\Option\Pages\OptionIndexPage;
use App\MoonShine\Resources\Option\Pages\OptionFormPage;
use App\MoonShine\Resources\Option\Pages\OptionDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Option, OptionIndexPage, OptionFormPage, OptionDetailPage>
 */
class OptionResource extends ModelResource
{
    protected string $model = Option::class;

    protected string $title = 'Options';
    
    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            OptionIndexPage::class,
            OptionFormPage::class,
            OptionDetailPage::class,
        ];
    }
}
