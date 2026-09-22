<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Models\User\UserFields;
use App\Services\Auth\TokenService;
use App\Services\Otp\OtpService;
use Illuminate\Validation\ValidationException;

readonly class VerifyOtpAction
{
    public function __construct(
        private OtpService   $otpService,
        private TokenService $tokenService
    ) {}

    public function __invoke(string $phoneNumber, string $code, ?string $deviceId): array
    {
        if (! $this->otpService->verify($phoneNumber, $code)) {
            throw ValidationException::withMessages([
                UserFields::OTP_CODE => ['کد تایید نامعتبر یا منقضی شده است.'],
            ]);
        }

        $user = User::firstOrCreate([UserFields::PHONE_NUMBER => $phoneNumber]);

        $tokens = $this->tokenService->issueTokens($user, $deviceId);

        return array_merge($tokens, [
            'user' => $user,
            'is_new_user' => $user->wasRecentlyCreated,
        ]);
    }
}
