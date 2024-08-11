<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Assuming you handle authorization elsewhere (e.g., middleware)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_name' => 'required|string',
            'company_name' => 'required|string',
            'email_address' => 'required|email',
            'contact_number' => [
                'nullable', // Allow null values
                'digits:10',
                Rule::unique('users', 'contact_number')->ignore($this->route('user')),
                'regex:/^1/', // Check if the contact number starts with '1' (US country code)
            ],
            'status' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_name.required' => 'Please enter the supplier name.',
            'supplier_name.string' => 'The supplier name must be a string.',

            'company_name.required' => 'Please enter the company name.',
            'company_name.string' => 'The company name must be a string.',

            'email_address.required' => 'Please enter the email address.',
            'email_address.email' => 'Please enter a valid email address.',

            'contact_number.digits' => 'The contact number must be exactly 10 digits.',
            'contact_number.unique' => 'The contact number has already been taken.',
            'contact_number.regex' => 'The contact number must belong to the US country.',

            'status.required' => 'The status is required.',
            'status.integer' => 'The status must be an integer.',
        ];
    }
}
