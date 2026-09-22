<?php

namespace App\Services\Auth;

class DeviceIdResolver
{
    private const string DEFAULT_DEVICE_ID = 'default';
    public function resolve(?string $deviceId): string
    {
        return $deviceId ?: self::DEFAULT_DEVICE_ID;
    }
}
