<?php

namespace App\Http\Requests\Auth;

use App\Models\RefreshToken\RefreshTokenFields;
use App\Models\User\UserFields;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
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
            UserFields::PHONE_NUMBER => ['required', 'string'],
            UserFields::OTP_CODE => ['required', 'string', 'size:6'],
            RefreshTokenFields::DEVICE_ID => ['nullable', 'string', 'max:255'],
        ];
    }
}
