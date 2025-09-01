<?php

declare(strict_types = 1);

namespace App\Http\Requests\Api\v1;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'password' => ['nullable', 'confirmed', 'min:6', 'max:16'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string'   => 'The name must be a valid text.',
            'name.max'      => 'The name may not be greater than 255 characters.',

            'email.required' => 'The email field is required.',
            'email.unique'   => 'This email address is already registered.',
            'email.email'    => 'Please provide a valid email address.',
            'email.max'      => 'The email may not be greater than 255 characters.',

            'password.required'  => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min'       => 'The password must be at least 6 characters long.',
            'password.max'       => 'The password may not be greater than 16 characters.',
        ];
    }
}
