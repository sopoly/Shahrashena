<?php

namespace App\Services\Auth;

class TokenResponseFormatter
{
    public function format(array $accessToken, array $refreshToken): array
    {
        return [
            'access_token' => $accessToken['token'],
            'access_token_expires_at' => $accessToken['expires_at']->toIso8601String(),
            'refresh_token' => $refreshToken['token'],
            'refresh_token_expires_at' => $refreshToken['expires_at']->toIso8601String(),
        ];
    }
}
