<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Please enter new password.',
            'password.min' => 'Your New password/Confirm New Password must include at least 6 characters including 1 uppercase, 1 lowercase & 1 number',
            'password.regex' => 'Your New password/Confirm New Password must include at least 6 characters including 1 uppercase, 1 lowercase & 1 number',
            'password_confirmation.required' => 'Please enter confirm password.',
            'password_confirmation.same' => 'New password and confirm new password must be same.',
        ];
    }
}
