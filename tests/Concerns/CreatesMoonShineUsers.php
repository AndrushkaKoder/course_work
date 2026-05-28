<?php

declare(strict_types=1);

namespace Tests\Concerns;

use App\Models\User;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

trait CreatesMoonShineUsers
{
    protected function setUpMoonShine(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->seed(UserRoleSeeder::class);
    }

    protected function createAdminUser(array $attributes = []): User
    {
        return User::factory()
            ->admin()
            ->create($attributes);
    }

    protected function createManagerUser(array $attributes = []): User
    {
        return User::factory()
            ->manager()
            ->create($attributes);
    }

    /**
     * HTML-страница списка ресурса (не JSON API {@see moonshine.crud.index}).
     *
     * @param  class-string  $resourceClass
     */
    protected function moonshineResourceIndexUrl(string $resourceClass): string
    {
        $resource = app($resourceClass);

        return route('moonshine.resource.page', [
            'resourceUri' => $resource->getUriKey(),
            'pageUri' => $resource->getIndexPage()->getUriKey(),
        ]);
    }

    /**
     * @param  class-string  $resourceClass
     */
    protected function moonshineResourceIndexApiUrl(string $resourceClass): string
    {
        $resource = app($resourceClass);

        return route('moonshine.crud.index', [
            'resourceUri' => $resource->getUriKey(),
        ]);
    }
}
