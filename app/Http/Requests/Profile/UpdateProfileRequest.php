<?php

namespace App\Http\Requests\Profile;

use App\Models\User\UserFields;
use Illuminate\Contracts\Validation\ValidationRule;
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            UserFields::NAME => ['required', 'string', 'max:255'],
            UserFields::EMAIL => [
                'nullable', 'email', 'max:255',
                Rule::unique(UserFields::TABLE, UserFields::EMAIL)->ignore($this->user()->getKey()),
            ]
        ];
    }
}
