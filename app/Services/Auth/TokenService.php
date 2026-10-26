<?php

namespace App\Services\Auth;

use App\Exceptions\InvalidRefreshTokenException;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

readonly class TokenService
{
    public function __construct(
        private AccessTokenService  $accessTokenService,
        private RefreshTokenService $refreshTokenService,
    ) {}

    public function issueTokens(User $user, ?string $deviceId): TokenPair
    {
        return new TokenPair(
            $this->accessTokenService->issue($user, $deviceId),
            $this->refreshTokenService->issue($user, $deviceId),
        );
    }

    /**
     * @throws InvalidRefreshTokenException
     * @throws \Throwable
     */
    public function refreshTokens(string $refreshTokenPlain, ?string $deviceId): TokenPair
    {
        $rotated = $this->refreshTokenService->validateAndRotate($refreshTokenPlain, $deviceId);

        return new TokenPair(
            $this->accessTokenService->issue($rotated->user, $deviceId),
            $rotated->token,
        );
    }

    public function revokeCurrentDevice(User $user): void
    {
        $accessToken = $user->currentAccessToken();

        if (! $accessToken instanceof PersonalAccessToken) {
            return;
        }

        $this->refreshTokenService->revoke(
            $user,
            $this->accessTokenService->deviceIdOf($accessToken),
        );

        $accessToken->delete();
    }
}
