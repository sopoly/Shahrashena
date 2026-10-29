<?php

namespace App\Http\Requests\Concerns;

use App\Models\User\UserFields;
use App\Services\Phone\PhoneNumberNormalizer;

/**
 * To be used only in FormRequest classes (relies on input() and merge()).
 */
trait NormalizesPhoneNumber
{
    protected function prepareForValidation(): void
    {
        $phoneNumber = $this->input(UserFields::PHONE_NUMBER);

        if (! is_string($phoneNumber)) {
            return;
        }

        $this->merge([
            UserFields::PHONE_NUMBER => app(PhoneNumberNormalizer::class)->normalize($phoneNumber),
        ]);
    }
}
