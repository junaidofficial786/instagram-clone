<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'alpha_dash',
                'max:30',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'bio' => ['nullable', 'string', 'max:500'],
            'website' => ['nullable', 'url', 'max:255'],
            'gender' => ['nullable', 'string', 'in:male,female,other,prefer_not_to_say'],
            'avatar' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.max' => 'Name cannot be longer than 255 characters.',
            'username.required' => 'Username is required.',
            'username.alpha_dash' => 'Username can only contain letters, numbers, dashes and underscores.',
            'username.max' => 'Username cannot be longer than 30 characters.',
            'username.unique' => 'This username is already taken.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'bio.max' => 'Bio cannot be longer than 500 characters.',
            'website.url' => 'Please provide a valid website URL.',
            'website.max' => 'Website URL cannot be longer than 255 characters.',
            'gender.in' => 'Please select a valid gender option.',
            'avatar.image' => 'The file must be an image.',
            'avatar.max' => 'Profile picture cannot be larger than 2MB.',
            'avatar.mimes' => 'Profile picture must be a JPG, JPEG, or PNG file.',
        ];
    }
}
