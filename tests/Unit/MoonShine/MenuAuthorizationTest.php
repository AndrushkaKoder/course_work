<?php

declare(strict_types=1);

namespace Tests\Unit\MoonShine;

use App\Models\User;
use App\MoonShine\Resources\Client\ClientResource;
use App\MoonShine\Resources\Report\ReportResource;
use App\Support\MoonShine\MenuAuthorization;
use Database\Seeders\UserRoleSeeder;
use MoonShine\Support\Enums\Ability;
use Tests\TestCase;

final class MenuAuthorizationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRoleSeeder::class);
    }

    public function test_guest_cannot_access_resources(): void
    {
        $this->assertFalse(MenuAuthorization::can(ClientResource::class));
        $this->assertFalse(MenuAuthorization::can(ReportResource::class));
    }

    public function test_admin_can_access_any_resource(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin, 'moonshine');

        $this->assertTrue(MenuAuthorization::can(ClientResource::class));
        $this->assertTrue(MenuAuthorization::can(ReportResource::class));
        $this->assertTrue(MenuAuthorization::can(ReportResource::class, Ability::CREATE));
    }

    public function test_manager_can_access_client_but_not_report_resource(): void
    {
        $manager = User::factory()->manager()->create();

        $this->actingAs($manager, 'moonshine');

        $this->assertTrue(MenuAuthorization::can(ClientResource::class));
        $this->assertFalse(MenuAuthorization::can(ReportResource::class));
        $this->assertFalse(MenuAuthorization::can(ReportResource::class, Ability::CREATE));
    }

    public function test_user_without_role_has_no_resource_access(): void
    {
        $user = User::factory()->create([
            'user_role_id' => null,
        ]);

        $this->actingAs($user, 'moonshine');

        $this->assertFalse(MenuAuthorization::can(ClientResource::class));
    }
}
