<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'gender', 'dob', 'marital_status', 'height', 
        'education', 'occupation', 'annual_income', 'city', 'state', 'about_me',
        'photo1', 'photo2', 'photo3', 'phone_number',
        'describe_words', 'interests', 'food_preference', 'smoking_habit',
        'drinking_habit', 'family_type', 'is_physically_challenged', 'mangalik',
        'is_verified', 'is_featured', 'aadhaar_card', 'verification_status'
    ];

    protected $casts = [
        'dob' => 'date',
        'describe_words' => 'array',
        'interests' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
