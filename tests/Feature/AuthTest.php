<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Warga Contoh',
            'email' => 'warga@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', ['email' => 'warga@example.com', 'role' => 'customer']);
    }

    public function test_registration_cannot_create_admin_role(): void
    {
        // Even if a malicious client injects a `role` field, it must be ignored server-side.
        $this->post(route('register'), [
            'name' => 'Percobaan Curang',
            'email' => 'curang@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'curang@example.com', 'role' => 'customer']);
    }

    public function test_user_can_change_own_password(): void
    {
        $user = User::factory()->create(['password' => 'OldPassword123']);

        $response = $this->actingAs($user)->put(route('account.password.update'), [
            'current_password' => 'OldPassword123',
            'password' => 'NewPassword456',
            'password_confirmation' => 'NewPassword456',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('NewPassword456', $user->fresh()->password));
    }

    public function test_wrong_current_password_is_rejected(): void
    {
        $user = User::factory()->create(['password' => 'OldPassword123']);

        $response = $this->actingAs($user)->put(route('account.password.update'), [
            'current_password' => 'WrongPassword',
            'password' => 'NewPassword456',
            'password_confirmation' => 'NewPassword456',
        ]);

        $response->assertSessionHasErrors('current_password');
    }
}
