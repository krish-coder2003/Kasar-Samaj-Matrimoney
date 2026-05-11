<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    /**
     * Update basic profile information and photos.
     *
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function updateBasicProfile(User $user, array $data)
    {
        $user->update(['name' => $data['name']]);

        $profileData = collect($data)->only([
            'gender', 'dob', 'marital_status', 'height', 
            'education', 'occupation', 'annual_income', 'city', 'state',
            'phone_number'
        ])->toArray();

        // Handle Photo Uploads
        for ($i = 1; $i <= 3; $i++) {
            if (isset($data["photo{$i}"])) {
                // Delete old photo if exists
                if ($user->profile && $user->profile->{"photo{$i}"}) {
                    Storage::disk('public')->delete($user->profile->{"photo{$i}"});
                }
                $path = $data["photo{$i}"]->store('profiles', 'public');
                $profileData["photo{$i}"] = $path;
            }
        }

        // Handle Aadhaar Card Upload (Premium Only)
        if (isset($data['aadhaar_card']) && $user->is_premium) {
            if ($user->profile && $user->profile->aadhaar_card) {
                Storage::disk('public')->delete($user->profile->aadhaar_card);
            }
            $path = $data['aadhaar_card']->store('verifications', 'public');
            $profileData['aadhaar_card'] = $path;
            $profileData['verification_status'] = 'pending';
            $profileData['is_verified'] = false; // Reset badge until approved
        }

        return $user->profile()->updateOrCreate(['user_id' => $user->id], $profileData);
    }

    /**
     * Update personal details and interests.
     *
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function updateAboutAndInterests(User $user, array $data)
    {
        $profileData = collect($data)->only([
            'about_me', 'describe_words', 'interests', 'food_preference',
            'smoking_habit', 'drinking_habit', 'family_type',
            'is_physically_challenged', 'mangalik'
        ])->toArray();

        return $user->profile()->updateOrCreate(['user_id' => $user->id], $profileData);
    }

    /**
     * Delete a specific photo from the profile.
     *
     * @param User $user
     * @param int $index
     * @return bool
     */
    public function deletePhoto(User $user, $index)
    {
        $profile = $user->profile;
        $photoField = "photo{$index}";

        if ($profile && $profile->$photoField) {
            Storage::disk('public')->delete($profile->$photoField);
            return $profile->update([$photoField => null]);
        }

        return false;
    }
}
