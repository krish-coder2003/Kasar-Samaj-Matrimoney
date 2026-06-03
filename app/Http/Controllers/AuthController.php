<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $profile = $user->profile;

            if (!$user->isAdmin() && (!$profile || !$profile->gender)) {
                return redirect()->route('profile.edit')->with('info', 'Please set your gender to see matches.');
            }

            $query = User::where('id', '!=', $user->id)
                ->where('role', '!=', 'admin')
                ->whereNull('deletion_requested_at');

            if ($profile && $profile->gender) {
                $oppositeGender = ($profile->gender === 'Male') ? 'Female' : 'Male';
                $query->whereHas('profile', function ($q) use ($oppositeGender) {
                    $q->where('gender', $oppositeGender);
                });
            }

            // Filter by Name
            if ($request->has('name') && $request->name != '') {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            // Filter by Occupation
            if ($request->has('occupation') && $request->occupation != '') {
                $query->whereHas('profile', function ($q) use ($request) {
                    $q->where('occupation', 'like', '%' . $request->occupation . '%');
                });
            }

            $matches = $query->with('profile')->get();

            $sentInterestIds = \App\Models\Interest::where('sender_id', $user->id)
                ->pluck('receiver_id')
                ->toArray();

            $likedUserIds = \App\Models\Like::where('user_id', $user->id)
                ->pluck('liked_user_id')
                ->toArray();

            $stories = \App\Models\SuccessStory::latest()->take(3)->get();
            $faqs = \App\Models\Faq::latest()->get();

            return view('landing', compact('matches', 'sentInterestIds', 'likedUserIds', 'stories', 'faqs'));
        }

        $stories = \App\Models\SuccessStory::latest()->take(3)->get();
        $faqs = \App\Models\Faq::latest()->get();
        return view('landing', compact('stories', 'faqs'));
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $result = $this->authService->sendOtp($request->email);

        return response()->json([
            'message' => 'OTP sent successfully!',
            'email' => $request->email,
            'otp' => $result['otp'], // Return OTP for testing
            'is_new' => $result['is_new']
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        $result = $this->authService->verifyAndLogin(
            $request->email, 
            $request->otp, 
            $request->name,
            $request->only(['gender', 'profile_created_by'])
        );

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => $result['is_recovery'] 
                ? 'Your account is scheduled for deletion. You can recover it within 24 hours.' 
                : 'Login successful!',
            'is_recovery' => $result['is_recovery'],
            'redirect' => route('home')
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function upgrade()
    {
        $user = Auth::user();
        $user->update(['is_premium' => true]);
        return redirect()->route('home')->with('success', '👑 Congratulations! You are now a Premium Member. You can now view contact numbers and connect directly with matches.');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'gender' => 'required|string|in:Male,Female',
            'profile_created_by' => 'required|string',
        ]);

        $result = $this->authService->register($request->only([
            'name', 'email', 'password', 'gender', 'profile_created_by'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'redirect' => route('home')
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $result = $this->authService->login($request->only(['email', 'password']));

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => $result['is_recovery'] 
                ? 'Your account is scheduled for deletion. You can recover it within 24 hours.' 
                : 'Login successful!',
            'is_recovery' => $result['is_recovery'],
            'redirect' => route('home')
        ]);
    }
}

