<?php

namespace App\Services\Otp;

use App\Services\Sms\Contracts\SmsServiceInterface;
use Random\RandomException;

class OtpService
{
    private const int TTL_MINUTES = 5;

    public function __construct(
        private readonly OtpCodeGenerator $codeGenerator,
        private readonly OtpRepository $otpRepository,
        private readonly SmsServiceInterface $smsService,
    ) {}

    /**
     * @throws RandomException
     */
    public function generateAndSend(string $phoneNumber): void
    {
        $code = $this->codeGenerator->generate();

        $this->otpRepository->store($phoneNumber, $code, self::TTL_MINUTES);

        $this->smsService->send($phoneNumber, "کد تایید شما: {$code}");
    }

    public function verify(string $phoneNumber, string $code): bool
    {
        $storedCode = $this->otpRepository->get($phoneNumber);

        if ($storedCode === null || ! hash_equals($storedCode, $code)) {
            return false;
        }

        $this->otpRepository->forget($phoneNumber);

        return true;
    }
}
