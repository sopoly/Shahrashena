<?php

namespace App\Exceptions;

use App\Models\User\UserFields;
use Illuminate\Validation\ValidationException;

class InvalidOtpCodeException extends ValidationException
{
    public static function make(): static
    {
        return static::withMessages([
            UserFields::OTP_CODE => ['کد تایید منقضی شده یا نامعتبر است.'],
        ]);
    }
}
