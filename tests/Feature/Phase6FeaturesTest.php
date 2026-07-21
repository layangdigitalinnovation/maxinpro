<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

class Phase6FeaturesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Regression guard for a critical bug: User implemented the MustVerifyEmail
     * CONTRACT without the matching TRAIT that provides the method bodies —
     * this caused a fatal "class contains abstract method" error on every
     * single request. If this test can even boot a User and call these
     * methods without crashing, the fix is holding.
     */
    public function test_user_model_correctly_implements_must_verify_email(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $this->assertFalse($user->hasVerifiedEmail());
        $this->assertNotEmpty($user->getEmailForVerification());

        $user->markEmailAsVerified();
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_remember_me_checkbox_results_in_persistent_login(): void
    {
        $user = User::factory()->create(['password' => 'Password123!', 'role' => 'customer']);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'Password123!',
            'remember' => '1',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
        $this->assertNotEmpty($user->fresh()->getRememberToken());
    }

    public function test_remember_me_is_carried_through_the_2fa_challenge(): void
    {
        $user = User::factory()->create(['password' => 'Password123!', 'role' => 'admin']);
        $this->actingAs($user)->get(route('account.two-factor.show'));
        $user->refresh();
        $user->confirmTwoFactor((new Google2FA())->getCurrentOtp($user->two_factor_secret));
        $this->app['auth']->logout();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'Password123!',
            'remember' => '1',
        ]);

        $code = (new Google2FA())->getCurrentOtp($user->two_factor_secret);
        $this->post(route('two-factor.challenge.store'), ['code' => $code]);

        $this->assertAuthenticatedAs($user);
        $this->assertNotEmpty($user->fresh()->getRememberToken());
    }

    public function test_emergency_2fa_reset_disables_two_factor_via_signed_link(): void
    {
        Notification::fake();

        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user)->get(route('account.two-factor.show'));
        $user->refresh();
        $user->confirmTwoFactor((new Google2FA())->getCurrentOtp($user->two_factor_secret));
        $this->assertTrue($user->fresh()->hasTwoFactorEnabled());

        $this->post(route('two-factor.emergency-reset.request'), ['email' => $user->email]);

        $signedUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'two-factor.emergency-reset.confirm',
            now()->addMinutes(30),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $this->get($signedUrl)->assertRedirect(route('login'));
        $this->assertFalse($user->fresh()->hasTwoFactorEnabled());
    }

    public function test_emergency_2fa_reset_rejects_invalid_hash(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user)->get(route('account.two-factor.show'));
        $user->refresh();
        $user->confirmTwoFactor((new Google2FA())->getCurrentOtp($user->two_factor_secret));

        $signedUrlWithWrongHash = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'two-factor.emergency-reset.confirm',
            now()->addMinutes(30),
            ['id' => $user->id, 'hash' => 'not-the-real-hash']
        );

        $this->get($signedUrlWithWrongHash)->assertForbidden();
        $this->assertTrue($user->fresh()->hasTwoFactorEnabled());
    }

    public function test_emergency_2fa_reset_link_cannot_be_reused(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user)->get(route('account.two-factor.show'));
        $user->refresh();
        $user->confirmTwoFactor((new Google2FA())->getCurrentOtp($user->two_factor_secret));

        $signedUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'two-factor.emergency-reset.confirm',
            now()->addMinutes(30),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $this->get($signedUrl); // first use: disables 2FA
        $second = $this->get($signedUrl); // still a validly-signed URL, but 2FA is already off

        $second->assertRedirect(route('login'));
        $second->assertSessionHas('status', '2FA pada akun ini sudah tidak aktif.');
    }
}
