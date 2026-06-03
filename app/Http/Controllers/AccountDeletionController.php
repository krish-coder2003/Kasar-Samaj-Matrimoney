<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class AccountDeletionController extends Controller
{
    public function requestDeletion(Request $request)
    {
        $user = Auth::user();
        $otp = rand(100000, 999999);
        
        Cache::put('deletion_otp_' . $user->id, $otp, now()->addMinutes(10));
        
        // Send actual verification email
        Log::info("Account Deletion OTP for {$user->email}: {$otp}");
        Mail::to($user->email)->send(new OtpMail($otp, 'Account Deletion'));
        
        return response()->json([
            'success' => true,
            'message' => 'Deletion OTP has been sent to your registered email.'
        ]);
    }

    public function confirmDeletion(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        $user = Auth::user();
        $cachedOtp = Cache::get('deletion_otp_' . $user->id);

        if ($cachedOtp && $cachedOtp == $request->otp) {
            $user->update([
                'deletion_requested_at' => now()
            ]);
            
            Cache::forget('deletion_otp_' . $user->id);
            Auth::logout();

            return response()->json([
                'success' => true,
                'message' => 'Your account has been scheduled for deletion. It will be permanently removed in 24 hours.',
                'redirect' => route('home')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired OTP.'
        ], 422);
    }

    public function recoverAccount(Request $request)
    {
        // This is called when a user tries to login but has a pending deletion
        // Or via a specific recovery link
        $user = Auth::user();
        
        if ($user && $user->isPendingDeletion()) {
            $user->update(['deletion_requested_at' => null]);
            return redirect()->route('home')->with('success', 'Your account has been successfully recovered!');
        }

        return redirect()->route('home');
    }
}
