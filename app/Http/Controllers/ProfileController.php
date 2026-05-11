<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateAboutRequest;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile ?? $user->profile()->create();
        
        return view('profile.edit', compact('user', 'profile'));
    }

    public function plans()
    {
        return view('profile.plans');
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->profileService->updateBasicProfile(Auth::user(), $request->all());

        return back()->with('success', 'Basic profile updated successfully!');
    }

    public function editAbout()
    {
        $user = Auth::user();
        $profile = $user->profile ?? $user->profile()->create();
        
        return view('profile.about', compact('user', 'profile'));
    }

    public function updateAbout(UpdateAboutRequest $request)
    {
        $this->profileService->updateAboutAndInterests(Auth::user(), $request->all());

        return redirect()->route('profile.edit')->with('success', 'Personal details and interests updated successfully!');
    }

    public function deletePhoto($index)
    {
        $success = $this->profileService->deletePhoto(Auth::user(), $index);

        if ($success) {
            return back()->with('success', "Photo {$index} removed successfully!");
        }

        return back()->with('error', 'Photo not found.');
    }
}
