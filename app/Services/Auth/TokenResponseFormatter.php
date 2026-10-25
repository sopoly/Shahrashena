<?php

namespace App\Services\Auth;

class TokenResponseFormatter
{
    public function format(IssuedAccessToken $accessToken, IssuedRefreshToken $refreshToken): array
    {
        return [
            'access_token' => $accessToken->plainToken,
            'access_token_expires_at' => $accessToken->expiresAt->toIso8601String(),
            'refresh_token' => $refreshToken->plainToken,
            'refresh_token_expires_at' => $refreshToken->expiresAt->toIso8601String(),
        ];
    }
}
