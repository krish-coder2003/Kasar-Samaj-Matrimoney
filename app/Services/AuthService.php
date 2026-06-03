<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Send OTP to user email.
     *
     * @param string $email
     * @return array
     */
    public function sendOtp($email)
    {
        $otp = generateOtp(6);
        Cache::put('otp_' . $email, $otp, now()->addMinutes(10));

        // Simulate sending email
        Log::info("Login OTP for {$email}: {$otp}");

        $userExists = User::where('email', $email)->exists();

        return [
            'otp' => $otp,
            'is_new' => !$userExists
        ];
    }

    /**
     * Verify OTP and login user.
     *
     * @param string $email
     * @param string $otp
     * @param string|null $name
     * @return array
     */
    public function verifyAndLogin($email, $otp, $name = null, $extraData = [])
    {
        $cachedOtp = Cache::get('otp_' . $email);

        if (!$cachedOtp || $cachedOtp != $otp) {
            return ['success' => false, 'message' => 'Invalid or expired OTP.'];
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            if (!$name) {
                return ['success' => false, 'message' => 'Name is required for registration.'];
            }
            $user = User::create([
                'email' => $email,
                'name' => $name,
            ]);

            // Create profile with extra data
            $user->profile()->create([
                'gender' => $extraData['gender'] ?? 'Male',
                'profile_created_by' => $extraData['profile_created_by'] ?? 'Self',
            ]);
        }

        Auth::login($user);
        Cache::forget('otp_' . $email);

        return [
            'success' => true,
            'user' => $user,
            'is_recovery' => $user->isPendingDeletion()
        ];
    }

    /**
     * Register a new user with password.
     *
     * @param array $data
     * @return array
     */
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
        ]);

        $user->profile()->create([
            'gender' => $data['gender'] ?? 'Male',
            'profile_created_by' => $data['profile_created_by'] ?? 'Self',
        ]);

        Auth::login($user);

        return [
            'success' => true,
            'user' => $user,
            'is_recovery' => false
        ];
    }

    /**
     * Authenticate user with password.
     *
     * @param array $credentials
     * @return array
     */
    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return ['success' => false, 'message' => 'No account found with this email address.'];
        }

        if (!\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            return ['success' => false, 'message' => 'Incorrect password.'];
        }

        Auth::login($user);

        return [
            'success' => true,
            'user' => $user,
            'is_recovery' => $user->isPendingDeletion()
        ];
    }
}

