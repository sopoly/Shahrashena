<?php

namespace App\Services\Auth;

use App\Exceptions\InvalidRefreshTokenException;
use App\Models\User;

readonly class TokenService
{
    public function __construct(
        private AccessTokenService     $accessTokenService,
        private RefreshTokenService    $refreshTokenService,
        private TokenResponseFormatter $responseFormatter,
    ) {}

    public function issueTokens(User $user, ?string $deviceId): array
    {
        $accessToken = $this->accessTokenService->issue($user, $deviceId);
        $refreshToken = $this->refreshTokenService->issue($user, $deviceId);

        return $this->responseFormatter->format($accessToken, $refreshToken);
    }

    /**
     * @throws InvalidRefreshTokenException
     * @throws \Throwable
     */
    public function refreshTokens(string $refreshTokenPlain, ?string $deviceId): array
    {
        $rotated = $this->refreshTokenService->validateAndRotate($refreshTokenPlain, $deviceId);

        $accessToken = $this->accessTokenService->issue($rotated->user, $deviceId);

        return $this->responseFormatter->format($accessToken, $rotated->token);
    }
}
