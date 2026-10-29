<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\Concerns\NormalizesPhoneNumber;
use App\Models\User\UserFields;
use App\Rules\MobileNumber;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestPhoneChangeRequest extends FormRequest
{
    use NormalizesPhoneNumber;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            UserFields::PHONE_NUMBER => [
                'bail',
                'required',
                'string',
                new MobileNumber(),
                Rule::notIn([$this->user()->{UserFields::PHONE_NUMBER}]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            UserFields::PHONE_NUMBER . '.not_in' => 'شماره جدید باید با شماره فعلی متفاوت باشد.',
        ];
    }
}
