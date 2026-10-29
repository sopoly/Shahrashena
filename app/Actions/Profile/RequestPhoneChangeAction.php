<?php

namespace App\Actions\Profile;

use App\Services\Otp\OtpService;
use App\Services\Profile\PhoneNumberAvailability;
use Random\RandomException;

readonly class RequestPhoneChangeAction
{
    public function __construct(
        private PhoneNumberAvailability $availability,
        private OtpService $otpService,
    ) {}

    /**
     * @throws RandomException
     */
    public function __invoke(string $newPhoneNumber): void
    {
        if ($this->availability->isTaken($newPhoneNumber)) {
            return;
        }

        $this->otpService->generateAndSend($newPhoneNumber);
    }
}
