<?php

namespace Tests\Unit;

use App\Services\Otp\OtpAttemptLimiter;
use App\Services\Otp\OtpRepository;
use App\Services\Otp\OtpService;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class OtpAttemptLimiterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_it_blocks_after_five_attempts_and_clear_resets_the_limit(): void
    {
        $limiter = app(OtpAttemptLimiter::class);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->assertFalse($limiter->tooManyAttempts('09123456789'));
            $limiter->hit('09123456789');
        }

        $this->assertTrue($limiter->tooManyAttempts('09123456789'));

        $limiter->clear('09123456789');

        $this->assertFalse($limiter->tooManyAttempts('09123456789'));
    }

    public function test_otp_service_rejects_and_forgets_the_code_after_five_failed_attempts(): void
    {
        $phoneNumber = '09123456789';
        $repository = app(OtpRepository::class);
        $repository->store($phoneNumber, '123456', 5);
        $service = app(OtpService::class);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->assertFalse($service->verify($phoneNumber, '000000'));
        }

        $this->assertFalse($service->verify($phoneNumber, '123456'));
        $this->assertNull($repository->get($phoneNumber));
    }
}
