<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Client;

use App\Models\Client;
use App\MoonShine\Resources\Client\Pages\ClientDetailPage;
use App\MoonShine\Resources\Client\Pages\ClientFormPage;
use App\MoonShine\Resources\Client\Pages\ClientIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Client, ClientIndexPage, ClientFormPage, ClientDetailPage>
 */
class ClientResource extends ModelResource
{
    protected string $model = Client::class;

    protected string $title = 'Клиенты';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ClientIndexPage::class,
            ClientFormPage::class,
        ];
    }

    protected function search(): array
    {
        return ['name', 'phone'];
    }
}
