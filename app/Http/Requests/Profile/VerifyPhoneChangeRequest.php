<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\Concerns\NormalizesPhoneNumber;
use App\Models\User\UserFields;
use App\Rules\MobileNumber;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyPhoneChangeRequest extends FormRequest
{
    use NormalizesPhoneNumber;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            UserFields::PHONE_NUMBER => ['bail', 'required', 'string', new MobileNumber()],
            UserFields::OTP_CODE => ['required', 'string', 'size:6'],
        ];
    }
}
