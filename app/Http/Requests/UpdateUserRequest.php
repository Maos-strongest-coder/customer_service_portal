<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Policies\UserPolicy;
use Illuminate\Validation\Rule;
use App\Enums\UserRole;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(UserPolicy::class)->update($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'   => ['sometimes', 'string', 'max:255'],
            'last_name'    => ['sometimes', 'string', 'max:255'],
            'email'        => ['sometimes', 'string', 'email', 'max:255',
                            Rule::unique('users', 'email')->ignore($this->route('user'))],
            'role'         => ['sometimes', Rule::enum(UserRole::class)],
            'phone_number' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
        
}
