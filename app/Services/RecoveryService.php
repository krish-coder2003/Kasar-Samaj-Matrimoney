<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class RecoveryService
{
    /**
     * Generate and send a password reset OTP.
     *
     * @param string $email
     * @return int
     */
    public function sendOtp($email)
    {
        // Use the global helper generateOtp()
        $otp = generateOtp(6);
        
        Cache::put('reset_otp_' . $email, $otp, now()->addMinutes(15));

        // Send actual email and log it for debug
        Log::info("Password Reset OTP for Email {$email}: {$otp}");
        Mail::to($email)->send(new OtpMail($otp, 'Password Reset'));

        return $otp;
    }

    /**
     * Verify OTP and reset the user's password.
     *
     * @param array $data
     * @return bool|\App\Models\User
     */
    public function verifyAndResetPassword(array $data)
    {
        $cachedOtp = Cache::get('reset_otp_' . $data['email']);

        if (!$cachedOtp || $cachedOtp != $data['otp']) {
            return false;
        }

        $user = User::where('email', $data['email'])->first();
        if (!$user) return false;

        $user->password = Hash::make($data['password']);
        $user->save();

        Cache::forget('reset_otp_' . $data['email']);

        return $user;
    }
}
