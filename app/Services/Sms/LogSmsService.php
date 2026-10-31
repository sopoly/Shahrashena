<?php

namespace App\Services\Sms;

use App\Services\Sms\Contracts\SmsServiceInterface;
use Psr\Log\LoggerInterface;

readonly class LogSmsService implements SmsServiceInterface
{
    public function __construct(private LoggerInterface $logger) {}
    public function send(string $phoneNumber, string $message): void
    {
        $this->logger->info('SMS sent', [
            'phone_number' => $phoneNumber,
            'message' => $message
        ]);
    }
}
