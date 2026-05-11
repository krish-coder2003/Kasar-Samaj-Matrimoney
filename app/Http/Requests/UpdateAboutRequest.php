<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'about_me' => 'required|string|min:20',
            'describe_words' => 'nullable|array',
            'interests' => 'nullable|array',
            'food_preference' => 'nullable|string',
            'smoking_habit' => 'nullable|string',
            'drinking_habit' => 'nullable|string',
            'family_type' => 'nullable|string',
            'is_physically_challenged' => 'nullable|string',
            'mangalik' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'about_me.min' => 'Please provide a bit more detail in the About Me section (min 20 characters).',
        ];
    }
}
