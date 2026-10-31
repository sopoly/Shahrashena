<?php

namespace App\Services\Otp;

use Illuminate\Cache\RateLimiter;

class OtpAttemptLimiter
{
    private const int MAX_ATTEMPTS = 5;
    private const int DECAY_SECONDS = 300;

    public function __construct(private readonly RateLimiter $rateLimiter) {}

    public function tooManyAttempts(string $phoneNumber): bool
    {
        return $this->rateLimiter->tooManyAttempts($this->key($phoneNumber), self::MAX_ATTEMPTS);
    }

    public function hit(string $phoneNumber): void
    {
        $this->rateLimiter->hit($this->key($phoneNumber), self::DECAY_SECONDS);
    }

    public function clear(string $phoneNumber): void
    {
        $this->rateLimiter->clear($this->key($phoneNumber));
    }

    private function key(string $phoneNumber): string
    {
        return "otp-attempts:{$phoneNumber}";
    }
}
