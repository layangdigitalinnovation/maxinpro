<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

class TwoFactorTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_set_up_and_confirm_two_factor(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get(route('account.two-factor.show'))->assertOk();
        $admin->refresh();
        $this->assertNotNull($admin->two_factor_secret);
        $this->assertFalse($admin->hasTwoFactorEnabled());

        $validCode = (new Google2FA())->getCurrentOtp($admin->two_factor_secret);

        $response = $this->actingAs($admin)->post(route('account.two-factor.enable'), ['code' => $validCode]);

        $response->assertRedirect(route('account.two-factor.show'));
        $this->assertTrue($admin->fresh()->hasTwoFactorEnabled());
    }

    public function test_wrong_code_does_not_enable_two_factor(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('account.two-factor.show'));

        $response = $this->actingAs($admin)->post(route('account.two-factor.enable'), ['code' => '000000']);

        $response->assertSessionHasErrors('code');
        $this->assertFalse($admin->fresh()->hasTwoFactorEnabled());
    }

    public function test_login_with_2fa_enabled_requires_challenge_before_dashboard_access(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'password' => 'Password123!']);
        $this->actingAs($admin)->get(route('account.two-factor.show'));
        $admin->refresh();
        $admin->confirmTwoFactor((new Google2FA())->getCurrentOtp($admin->two_factor_secret));
        $this->app['auth']->logout(); // simulate a fresh, unauthenticated browser

        $response = $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'Password123!',
        ]);

        // Must be redirected to the 2FA challenge, NOT straight into the admin dashboard.
        $response->assertRedirect(route('two-factor.challenge'));
        $this->assertGuest();

        $code = (new Google2FA())->getCurrentOtp($admin->two_factor_secret);
        $challengeResponse = $this->post(route('two-factor.challenge.store'), ['code' => $code]);

        $challengeResponse->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_login_is_rejected_without_completing_2fa_challenge(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'password' => 'Password123!']);
        $this->actingAs($admin)->get(route('account.two-factor.show'));
        $admin->refresh();
        $admin->confirmTwoFactor((new Google2FA())->getCurrentOtp($admin->two_factor_secret));
        $this->app['auth']->logout();

        $this->post(route('login'), ['email' => $admin->email, 'password' => 'Password123!']);

        // Without ever submitting a 2FA code, the admin dashboard must stay unreachable.
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_recovery_code_can_be_used_once_then_is_rejected(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('account.two-factor.show'));
        $admin->refresh();
        $admin->confirmTwoFactor((new Google2FA())->getCurrentOtp($admin->two_factor_secret));

        $code = $admin->fresh()->two_factor_recovery_codes[0];

        $this->assertTrue($admin->useRecoveryCode($code));
        $this->assertFalse($admin->fresh()->useRecoveryCode($code)); // second use must fail
    }

    public function test_disabling_2fa_requires_correct_current_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'password' => 'Password123!']);
        $this->actingAs($admin)->get(route('account.two-factor.show'));
        $admin->refresh();
        $admin->confirmTwoFactor((new Google2FA())->getCurrentOtp($admin->two_factor_secret));

        $wrong = $this->actingAs($admin)->delete(route('account.two-factor.disable'), ['current_password' => 'WrongPassword']);
        $wrong->assertSessionHasErrors('current_password');
        $this->assertTrue($admin->fresh()->hasTwoFactorEnabled());

        $right = $this->actingAs($admin)->delete(route('account.two-factor.disable'), ['current_password' => 'Password123!']);
        $right->assertRedirect(route('account.two-factor.show'));
        $this->assertFalse($admin->fresh()->hasTwoFactorEnabled());
    }
}
