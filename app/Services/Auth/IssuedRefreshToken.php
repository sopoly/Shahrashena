<?php

namespace App\Services\Auth;

use Carbon\CarbonInterface;

final readonly class IssuedRefreshToken
{
    public function __construct(
        public string $plainToken,
        public CarbonInterface $expiresAt,
    ) {}
}
