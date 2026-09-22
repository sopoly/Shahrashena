<?php

namespace App\Actions\Auth;

use App\Services\Otp\OtpService;
use Random\RandomException;

readonly class SendOtpAction
{
    public function __construct(
        private OtpService $otpService
    ) {}

    /**
     * @throws RandomException
     */
    public function __invoke(string $phoneNumber): void
    {
        $this->otpService->generateAndSend($phoneNumber);
    }
}
