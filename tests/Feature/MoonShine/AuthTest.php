<?php

declare(strict_types=1);

namespace Tests\Feature\MoonShine;

use Tests\Concerns\CreatesMoonShineUsers;
use Tests\TestCase;

final class AuthTest extends TestCase
{
    use CreatesMoonShineUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpMoonShine();
    }

    public function test_guest_is_redirected_from_admin_to_login(): void
    {
        $this->get(route('moonshine.index'))
            ->assertRedirect(route('moonshine.login'));
    }

    public function test_login_page_is_available_for_guest(): void
    {
        $this->get(route('moonshine.login'))
            ->assertOk();
    }

    public function test_admin_can_authenticate_with_valid_credentials(): void
    {
        $user = $this->createAdminUser([
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        $this->post(route('moonshine.authenticate'), [
            'username' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('moonshine.index'));

        $this->assertAuthenticatedAs($user, 'moonshine');
    }

    public function test_authenticate_fails_with_invalid_password(): void
    {
        $user = $this->createAdminUser([
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        $this->post(route('moonshine.authenticate'), [
            'username' => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('username');

        $this->assertGuest('moonshine');
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = $this->createAdminUser();

        $this->actingAs($user, 'moonshine')
            ->get(route('moonshine.index'))
            ->assertOk();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = $this->createAdminUser();

        $this->actingAs($user, 'moonshine')
            ->delete(route('moonshine.logout'))
            ->assertRedirect(route('moonshine.login'));

        $this->assertGuest('moonshine');
    }
}
