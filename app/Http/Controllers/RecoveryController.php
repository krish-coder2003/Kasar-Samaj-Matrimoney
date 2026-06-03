<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendResetOtpRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\RecoveryService;
use Illuminate\Http\Request;

class RecoveryController extends Controller
{
    protected $recoveryService;

    public function __construct(RecoveryService $recoveryService)
    {
        $this->recoveryService = $recoveryService;
    }

    // --- Forgot Password (User & Admin) ---

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetOtp(SendResetOtpRequest $request)
    {
        $otp = $this->recoveryService->sendOtp($request->email);

        return redirect()->route('password.verify.otp', ['email' => $request->email])
                         ->with('success', 'Reset OTP has been sent to your registered email.');
    }

    public function showVerifyOtp(Request $request)
    {
        $email = $request->query('email');
        return view('auth.verify-reset-otp', compact('email'));
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = $this->recoveryService->verifyAndResetPassword($request->validated());

        if (!$user) {
            return back()->with('error', 'Invalid or expired OTP.');
        }

        $loginRoute = $user->isAdmin() ? 'admin.login' : 'home';
        return redirect()->route($loginRoute)->with('success', 'Password reset successfully. You can now login.');
    }
}
