<?php

namespace App\Actions\Auth;

use App\Exceptions\InvalidOtpCodeException;
use App\Models\User;
use App\Models\User\UserFields;
use App\Services\Auth\AuthResult;
use App\Services\Auth\TokenService;
use App\Services\Otp\OtpService;

readonly class VerifyOtpAction
{
    public function __construct(
        private OtpService   $otpService,
        private TokenService $tokenService
    ) {}

    public function __invoke(string $phoneNumber, string $code, ?string $deviceId): AuthResult
    {
        if (! $this->otpService->verify($phoneNumber, $code)) {
            throw InvalidOtpCodeException::make();
        }

        $user = User::firstOrCreate([UserFields::PHONE_NUMBER => $phoneNumber]);

        return new AuthResult(
            $user,
            $this->tokenService->issueTokens($user, $deviceId),
            $user->wasRecentlyCreated,
        );
    }
}
