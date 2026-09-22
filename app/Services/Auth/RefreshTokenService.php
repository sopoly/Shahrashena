<?php

namespace App\Services\Auth;

use App\Exceptions\InvalidRefreshTokenException;
use App\Models\RefreshToken;
use App\Models\RefreshToken\RefreshTokenFields;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RefreshTokenService
{
    private const int TTL_DAYS = 7;

    public function __construct(private readonly DeviceIdResolver $deviceIdResolver) {}

    /**
     * @param User $user
     * @param string|null $deviceId
     * @return array
     */
    public function issueOrRotate(User $user, ?string $deviceId): array
    {
        $deviceId = $this->deviceIdResolver->resolve($deviceId);

        $existing = RefreshToken::query()
            ->where(RefreshTokenFields::USER_ID, $user->id)
            ->where(RefreshTokenFields::DEVICE_ID, $deviceId)
            ->first();

        if ($existing) return $this->rotate($existing);

        return $this->create($user->id, $deviceId);
    }

    /**
     * @throws InvalidRefreshTokenException
     */
    public function validateAndRotate(string $plainToken, ?string $deviceId): array
    {
        $deviceId = $this->deviceIdResolver->resolve($deviceId);

        $record = RefreshToken::query()->where(RefreshTokenFields::DEVICE_ID, $deviceId)->first();

        if (! $record || ! Hash::check($plainToken, $record->{RefreshTokenFields::TOKEN}) || $record->isExpired()) {
            throw new InvalidRefreshTokenException();
        }

        return [
            'user' => $record->user,
            ...$this->rotate($record),
        ];
    }

    /**
     * @param int $userId
     * @param string $deviceId
     * @return array
     */
    private function create(int $userId, string $deviceId): array
    {
        $plainToken = Str::random(64);
        $expiresAt = now()->addDays(self::TTL_DAYS);

        RefreshToken::query()->create([
            RefreshTokenFields::USER_ID => $userId,
            RefreshTokenFields::DEVICE_ID => $deviceId,
            RefreshTokenFields::TOKEN => Hash::make($plainToken),
            RefreshTokenFields::EXPIRES_AT => $expiresAt,
        ]);

        return ['token' => $plainToken, 'expires_at' => $expiresAt];
    }

    /**
     * @param RefreshToken $record
     * @return array
     */
    private function rotate(RefreshToken $record): array
    {
        $plainToken = Str::random(64);
        $expiresAt = now()->addDays(self::TTL_DAYS);

        $record->update([
            RefreshTokenFields::TOKEN => Hash::make($plainToken),
            RefreshTokenFields::EXPIRES_AT => $expiresAt,
        ]);

        return ['token' => $plainToken, 'expires_at' => $expiresAt];
    }
}
