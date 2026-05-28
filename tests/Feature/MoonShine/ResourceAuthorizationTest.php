<?php

declare(strict_types=1);

namespace Tests\Feature\MoonShine;

use App\MoonShine\Resources\Client\ClientResource;
use App\MoonShine\Resources\Report\ReportResource;
use App\MoonShine\Resources\UserRole\UserRoleResource;
use MoonShine\Support\Enums\Ability;
use Tests\Concerns\CreatesMoonShineUsers;
use Tests\TestCase;

final class ResourceAuthorizationTest extends TestCase
{
    use CreatesMoonShineUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpMoonShine();
    }

    public function test_manager_resource_permissions_match_policy(): void
    {
        $manager = $this->createManagerUser();

        $this->actingAs($manager, 'moonshine');

        $this->assertTrue(app(ClientResource::class)->can(Ability::VIEW_ANY));
        $this->assertFalse(app(ReportResource::class)->can(Ability::VIEW_ANY));
        $this->assertFalse(app(UserRoleResource::class)->can(Ability::VIEW_ANY));
    }

    public function test_admin_has_full_resource_permissions(): void
    {
        $admin = $this->createAdminUser();

        $this->actingAs($admin, 'moonshine');

        $this->assertTrue(app(ClientResource::class)->can(Ability::VIEW_ANY));
        $this->assertTrue(app(ReportResource::class)->can(Ability::VIEW_ANY));
        $this->assertTrue(app(UserRoleResource::class)->can(Ability::VIEW_ANY));
    }
}
