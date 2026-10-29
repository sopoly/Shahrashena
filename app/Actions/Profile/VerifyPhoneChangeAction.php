<?php

namespace App\Actions\Profile;

use App\Models\User;
use App\Models\User\UserFields;
use App\Services\Auth\TokenService;
use App\Services\Otp\OtpService;
use Illuminate\Database\UniqueConstraintViolationException;
use App\Exceptions\InvalidOtpCodeException;

readonly class VerifyPhoneChangeAction
{
    public function __construct(
        private OtpService $otpService,
        private TokenService $tokenService,
    ) {}

    /**
     * @throws InvalidOtpCodeException
     */
    public function __invoke(User $user, string $newPhoneNumber, string $code): User
    {
        if (! $this->otpService->verify($newPhoneNumber, $code)) {
            throw InvalidOtpCodeException::make();
        }

        try {
            $user->update([UserFields::PHONE_NUMBER => $newPhoneNumber]);
        } catch (UniqueConstraintViolationException) {
            // Intentionally the same error as a wrong OTP: a distinct "number taken"
            // error would leak which phone numbers are registered (enumeration).
            throw InvalidOtpCodeException::make();
        }

        $this->tokenService->revokeOtherDevices($user);

        return $user->refresh();
    }
}
