<?php

namespace App\Services\Auth;

use App\Models\RefreshToken\RefreshTokenFields;
use App\Models\User;

class AccessTokenService
{
    private const int TTL_MINUTES = 5;
    public function __construct(private readonly DeviceIdResolver $deviceIdResolver) {}

    public function issue(User $user, ?string $deviceId = null): array
    {
        $deviceId = $this->deviceIdResolver->resolve($deviceId);

        $user->tokens()->where('name', $deviceId)->delete();

        $newToken = $user->createToken($deviceId);
        $expiresAt = now()->addMinutes(self::TTL_MINUTES);

        $newToken->accessToken->forceFill([RefreshTokenFields::EXPIRES_AT => $expiresAt])->save();

        return [
            'token' => $newToken->plainTextToken,
            'expires_at' => $expiresAt->toDateTimeString(), //TODO: Check the format
        ];
    }
}
