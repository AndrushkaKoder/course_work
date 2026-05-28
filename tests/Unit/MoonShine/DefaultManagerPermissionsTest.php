<?php

declare(strict_types=1);

namespace Tests\Unit\MoonShine;

use App\Models\User;
use App\MoonShine\Resources\Client\ClientResource;
use App\MoonShine\Resources\Report\ReportResource;
use App\Support\MoonShine\DefaultManagerPermissions;
use Database\Seeders\UserRoleSeeder;
use MoonShine\Support\Enums\Ability;
use Tests\TestCase;

final class DefaultManagerPermissionsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRoleSeeder::class);
    }

    public function test_manager_has_default_client_permissions(): void
    {
        $manager = User::factory()->manager()->create();

        $this->assertTrue(
            DefaultManagerPermissions::allows($manager, ClientResource::class, Ability::VIEW_ANY),
        );
        $this->assertTrue(
            DefaultManagerPermissions::allows($manager, ClientResource::class, Ability::CREATE),
        );
    }

    public function test_manager_has_no_default_report_permissions(): void
    {
        $manager = User::factory()->manager()->create();

        $this->assertFalse(
            DefaultManagerPermissions::allows($manager, ReportResource::class, Ability::VIEW_ANY),
        );
    }

    public function test_admin_is_not_granted_manager_defaults(): void
    {
        $admin = User::factory()->admin()->create();

        $this->assertFalse(
            DefaultManagerPermissions::allows($admin, ClientResource::class, Ability::VIEW_ANY),
        );
    }

    public function test_to_permissions_array_contains_resource_ability_keys(): void
    {
        $permissions = DefaultManagerPermissions::toPermissionsArray();

        $this->assertArrayHasKey(ClientResource::class, $permissions);
        $this->assertTrue($permissions[ClientResource::class][Ability::VIEW_ANY->value]);
        $this->assertArrayNotHasKey(ReportResource::class, $permissions);
    }
}
