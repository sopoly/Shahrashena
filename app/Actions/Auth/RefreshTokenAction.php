<?php

namespace App\Actions\Auth;

use App\Exceptions\InvalidRefreshTokenException;
use App\Services\Auth\TokenService;

readonly class RefreshTokenAction
{
    public function __construct(
        private TokenService $tokenService
    ) {}

    /**
     * @throws InvalidRefreshTokenException
     */
    public function __invoke(string $refreshToken, ?string $deviceId): array
    {
        return $this->tokenService->refreshTokens($refreshToken, $deviceId);
    }
}
