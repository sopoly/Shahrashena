<?php

namespace App\Services\Profile;

use App\Models\User;
use App\Models\User\UserFields;

class PhoneNumberAvailability
{
    public function isTaken(string $phoneNumber): bool
    {
        return User::query()
            ->where(UserFields::PHONE_NUMBER, $phoneNumber)
            ->exists();
    }
}
