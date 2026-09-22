<?php

namespace App\Services\Auth;

use App\Exceptions\InvalidRefreshTokenException;
use App\Models\User;

class TokenService
{
    public function __construct(
        private readonly AccessTokenService $accessTokenService,
        private readonly RefreshTokenService $refreshTokenService,
        private readonly TokenResponseFormatter $responseFormatter,
    ) {
    }

    public function issueTokens(User $user, ?string $deviceId): array
    {
        $accessToken = $this->accessTokenService->issue($user, $deviceId);
        $refreshToken = $this->refreshTokenService->issueOrRotate($user, $deviceId);

        return $this->responseFormatter->format($accessToken, $refreshToken);
    }

    /**
     * @throws InvalidRefreshTokenException
     */
    public function refreshTokens(string $refreshTokenPlain, ?string $deviceId): array
    {
        $refreshResult = $this->refreshTokenService->validateAndRotate($refreshTokenPlain, $deviceId);
        $user = $refreshResult['user'];

        $accessToken = $this->accessTokenService->issue($user, $deviceId);
        $refreshToken = ['token' => $refreshResult['token'], 'expires_at' => $refreshResult['expires_at']];

        return $this->responseFormatter->format($accessToken, $refreshToken);
    }
}
