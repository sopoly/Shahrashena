<?php

namespace App\Services\Otp;

use Random\RandomException;

class OtpCodeGenerator
{
    private const int LENGTH = 6;

    /**
     * @throws RandomException
     */
    public function generate(): string
    {
        return str_pad((string) random_int(0, 10 ** self::LENGTH - 1), self::LENGTH, '0', STR_PAD_LEFT);
    }
}
