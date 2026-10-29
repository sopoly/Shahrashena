<?php

namespace App\Services\Auth;

use App\Exceptions\InvalidRefreshTokenException;
use App\Models\RefreshToken;
use App\Models\RefreshToken\RefreshTokenFields;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable as ThrowableAlias;

class RefreshTokenService
{
    private const int TTL_DAYS = 7;

    public function __construct(private readonly DeviceIdResolver $deviceIdResolver) {}

    public function issue(User $user, ?string $deviceId): IssuedRefreshToken
    {
        $issued = $this->generate();

        RefreshToken::query()->updateOrCreate(
            [
                RefreshTokenFields::USER_ID => $user->id,
                RefreshTokenFields::DEVICE_ID => $this->deviceIdResolver->resolve($deviceId),
            ],
            [
                RefreshTokenFields::REFRESH_TOKEN => $this->hash($issued->plainToken),
                RefreshTokenFields::EXPIRES_AT => $issued->expiresAt,
            ],
        );

        return $issued;
    }

    /**
     * @throws InvalidRefreshTokenException|ThrowableAlias
     */
    public function validateAndRotate(string $plainToken, ?string $deviceId): RotatedRefreshToken
    {
        $deviceId = $this->deviceIdResolver->resolve($deviceId);

        return DB::transaction(function () use ($plainToken, $deviceId): RotatedRefreshToken {
            $record = RefreshToken::query()
                ->where(RefreshTokenFields::DEVICE_ID, $deviceId)
                ->where(RefreshTokenFields::REFRESH_TOKEN, $this->hash($plainToken))
                ->lockForUpdate()
                ->first();

            if (! $record || $record->isExpired()) {
                throw new InvalidRefreshTokenException();
            }

            $issued = $this->generate();

            $record->update([
                RefreshTokenFields::REFRESH_TOKEN => $this->hash($issued->plainToken),
                RefreshTokenFields::EXPIRES_AT => $issued->expiresAt,
            ]);

            return new RotatedRefreshToken($record->user, $issued);
        });
    }

    public function revoke(User $user, string $deviceId): void
    {
        RefreshToken::query()
            ->where(RefreshTokenFields::USER_ID, $user->getKey())
            ->where(RefreshTokenFields::DEVICE_ID, $deviceId)
            ->delete();
    }

    public function revokeAllExcept(User $user, string $deviceId): void
    {
        RefreshToken::query()
            ->where(RefreshTokenFields::USER_ID, $user->getKey())
            ->where(RefreshTokenFields::DEVICE_ID, '!=', $deviceId)
            ->delete();
    }

    private function generate(): IssuedRefreshToken
    {
        return new IssuedRefreshToken(
            Str::random(64),
            now()->addDays(self::TTL_DAYS),
        );
    }

    private function hash(string $plainToken): string
    {
        return hash_hmac('sha256', $plainToken, (string) config('app.key'));
    }
}
