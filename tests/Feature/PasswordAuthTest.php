<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PasswordAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful registration with valid inputs and complex password.
     */
    public function test_user_can_register_with_valid_password(): void
    {
        $response = $this->postJson(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'gender' => 'Male',
            'profile_created_by' => 'Self'
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe'
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('SecurePass123!', $user->password));
        $this->assertNotNull($user->profile);
        $this->assertEquals('Male', $user->profile->gender);
    }

    /**
     * Test registration fails with invalid password complexities.
     */
    public function test_registration_fails_if_password_does_not_meet_requirements(): void
    {
        $passwords = [
            'short',             // too short (< 8 chars)
            'nouppercase123!',   // no uppercase
            'NOLOWERCASE123!',   // no lowercase
            'NoNumberSpecial',   // no number, no symbol
            'NoSpecialChar123',  // no symbol
        ];

        foreach ($passwords as $invalidPassword) {
            $response = $this->postJson(route('register'), [
                'name' => 'John Doe',
                'email' => 'john' . rand() . '@example.com',
                'password' => $invalidPassword,
                'password_confirmation' => $invalidPassword,
                'gender' => 'Male',
                'profile_created_by' => 'Self'
            ]);

            $response->assertStatus(422);
            $response->assertJsonValidationErrors(['password']);
        }
    }

    /**
     * Test registration fails with password confirmation mismatch.
     */
    public function test_registration_fails_if_passwords_do_not_match(): void
    {
        $response = $this->postJson(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'DifferentPass123!',
            'gender' => 'Male',
            'profile_created_by' => 'Self'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }

    /**
     * Test successful login with correct password.
     */
    public function test_user_can_login_with_valid_password(): void
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('JaneSecurePass123!'),
        ]);

        $response = $this->postJson(route('login.submit'), [
            'email' => 'jane@example.com',
            'password' => 'JaneSecurePass123!'
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login fails with incorrect password.
     */
    public function test_login_fails_with_incorrect_password(): void
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('JaneSecurePass123!'),
        ]);

        $response = $this->postJson(route('login.submit'), [
            'email' => 'jane@example.com',
            'password' => 'WrongPassword!'
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('message', 'Incorrect password.');
        $this->assertGuest();
    }

    /**
     * Test login fails with non-existent email.
     */
    public function test_login_fails_with_non_existent_email(): void
    {
        $response = $this->postJson(route('login.submit'), [
            'email' => 'nonexistent@example.com',
            'password' => 'SomePassword123!'
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('message', 'No account found with this email address.');
        $this->assertGuest();
    }

    /**
     * Test password reset flow with OTP and validation.
     */
    public function test_user_can_reset_password_using_otp(): void
    {
        $user = User::create([
            'name' => 'Jane Reset',
            'email' => 'reset@example.com',
            'password' => Hash::make('OldPassword123!'),
        ]);

        // Request Reset OTP
        $response = $this->post(route('password.email'), [
            'email' => 'reset@example.com'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('password.verify.otp', ['email' => 'reset@example.com']));
        
        // Check OTP was stored in cache
        $otp = Cache::get('reset_otp_reset@example.com');
        $this->assertNotNull($otp);

        // Reset password with valid OTP and new complex password
        $resetResponse = $this->post(route('password.update'), [
            'email' => 'reset@example.com',
            'otp' => $otp,
            'password' => 'NewSecurePass123!',
            'password_confirmation' => 'NewSecurePass123!'
        ]);

        $resetResponse->assertStatus(302);
        $resetResponse->assertRedirect(route('home'));
        
        // Verify password is updated
        $user->refresh();
        $this->assertTrue(Hash::check('NewSecurePass123!', $user->password));
    }
}
