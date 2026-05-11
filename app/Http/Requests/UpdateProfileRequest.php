<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'dob' => 'required|date|before:today',
            'marital_status' => 'required|string',
            'height' => 'required|string',
            'education' => 'required|string',
            'occupation' => 'required|string',
            'annual_income' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'photo1' => 'nullable|image|max:2048',
            'photo2' => 'nullable|image|max:2048',
            'photo3' => 'nullable|image|max:2048',
            'aadhaar_card' => 'nullable|image|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'dob.before' => 'The date of birth must be in the past.',
        ];
    }
}
