<?php

namespace App\Services\Otp;

use Illuminate\Support\Facades\Cache;

class OtpRepository
{
    public function store(string $phoneNumber, string $code, int $ttlMinutes): void
    {
        Cache::put($this->key($phoneNumber), $code, now()->addMinutes($ttlMinutes));
    }

    public function get(string $phoneNumber): ?string
    {
        return Cache::get($this->key($phoneNumber));
    }

    public function forget(string $phoneNumber): void
    {
        Cache::forget($this->key($phoneNumber));
    }

    private function key(string $phoneNumber): string
    {
        return "otp:{$phoneNumber}";
    }
}
