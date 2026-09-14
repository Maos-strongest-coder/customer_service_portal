<?php

namespace App\Http\Requests;

use App\Enums\TicketStatus;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateTicketRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isAdmin = $this->user()->role === UserRole::ADMIN;

        return [
            'title' => [
                'required',
                'string',
                'min:1',
                'max:255',
            ],
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id'
            ],

            'status' => [
                $isAdmin ? 'required' : 'sometimes',
                new Enum(TicketStatus::class)
            ],

            'issued_to_id' => [
                $isAdmin ? 'required' : 'sometimes',
                'integer',
                'exists:users,id',
            ],
        ];
    }
}