<?php

namespace App\Services\Auth;

final readonly class TokenPair
{
    public function __construct(
        public IssuedAccessToken $accessToken,
        public IssuedRefreshToken $refreshToken,
    ) {}
}
