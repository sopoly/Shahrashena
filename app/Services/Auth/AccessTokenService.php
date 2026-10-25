<?php

namespace App\Services\Auth;

use App\Models\User;

class AccessTokenService
{
    private const int TTL_MINUTES = 5;

    public function __construct(private readonly DeviceIdResolver $deviceIdResolver) {}

    public function issue(User $user, ?string $deviceId = null): IssuedAccessToken
    {
        $deviceId = $this->deviceIdResolver->resolve($deviceId);
        $expiresAt = now()->addMinutes(self::TTL_MINUTES);

        $user->tokens()->where('name', $deviceId)->delete();

        $newToken = $user->createToken($deviceId, ['*'], $expiresAt);

        return new IssuedAccessToken($newToken->plainTextToken, $expiresAt);
    }
}
