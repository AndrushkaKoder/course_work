<?php

declare(strict_types=1);

namespace Tests\Feature\MoonShine;

use App\MoonShine\Resources\Client\ClientResource;
use App\MoonShine\Resources\Report\ReportResource;
use App\MoonShine\Resources\UserRole\UserRoleResource;
use Tests\Concerns\CreatesMoonShineUsers;
use Tests\TestCase;

final class ResourceAccessTest extends TestCase
{
    use CreatesMoonShineUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpMoonShine();
    }

    public function test_admin_can_open_client_resource_index(): void
    {
        $admin = $this->createAdminUser();

        $this->actingAs($admin, 'moonshine')
            ->get($this->moonshineResourceIndexUrl(ClientResource::class))
            ->assertOk();
    }

    public function test_admin_can_open_report_resource_index(): void
    {
        $admin = $this->createAdminUser();

        $this->actingAs($admin, 'moonshine')
            ->get($this->moonshineResourceIndexUrl(ReportResource::class))
            ->assertOk();
    }

    public function test_manager_can_open_client_resource_index(): void
    {
        $manager = $this->createManagerUser();

        $this->actingAs($manager, 'moonshine')
            ->get($this->moonshineResourceIndexUrl(ClientResource::class))
            ->assertOk();
    }

    public function test_manager_cannot_open_report_resource_index(): void
    {
        $manager = $this->createManagerUser();

        $this->actingAs($manager, 'moonshine')
            ->get($this->moonshineResourceIndexUrl(ReportResource::class))
            ->assertForbidden();
    }

    public function test_manager_cannot_open_user_roles_resource_index(): void
    {
        $manager = $this->createManagerUser();

        $this->actingAs($manager, 'moonshine')
            ->get($this->moonshineResourceIndexUrl(UserRoleResource::class))
            ->assertForbidden();
    }

    public function test_manager_cannot_load_report_resource_list_via_api(): void
    {
        $manager = $this->createManagerUser();

        $this->actingAs($manager, 'moonshine')
            ->getJson($this->moonshineResourceIndexApiUrl(ReportResource::class))
            ->assertForbidden();
    }
}
