<?php

namespace Tests\Feature;

use App\Models\RefreshToken\RefreshTokenFields;
use App\Models\User\UserFields;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class RateLimitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_login_is_limited_after_five_requests_for_the_same_email_and_ip(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->postJson('/api/v1/login', [
                UserFields::EMAIL => 'person@example.com',
            ])->assertUnprocessable();
        }

        $this->postJson('/api/v1/login', [
            UserFields::EMAIL => 'person@example.com',
        ])->assertTooManyRequests();
    }

    public function test_otp_send_is_limited_per_normalized_phone_number(): void
    {
        $this->postJson('/api/v1/send-otp', [
            UserFields::PHONE_NUMBER => '+98 912-345-6789',
        ])->assertOk();

        $this->postJson('/api/v1/send-otp', [
            UserFields::PHONE_NUMBER => '09123456789',
        ])->assertTooManyRequests();
    }

    public function test_otp_verification_is_limited_after_ten_requests_per_phone(): void
    {
        for ($attempt = 0; $attempt < 10; $attempt++) {
            $this->postJson('/api/v1/verify-otp', [
                UserFields::PHONE_NUMBER => '09123456789',
                UserFields::OTP_CODE => '000000',
            ])->assertUnprocessable();
        }

        $this->postJson('/api/v1/verify-otp', [
            UserFields::PHONE_NUMBER => '09123456789',
            UserFields::OTP_CODE => '000000',
        ])->assertTooManyRequests();
    }

    public function test_token_refresh_is_limited_after_120_requests_per_ip(): void
    {
        for ($attempt = 0; $attempt < 120; $attempt++) {
            $this->postJson('/api/v1/refresh', [
                RefreshTokenFields::REFRESH_TOKEN => '',
            ])->assertUnprocessable();
        }

        $this->postJson('/api/v1/refresh', [
            RefreshTokenFields::REFRESH_TOKEN => '',
        ])->assertTooManyRequests();
    }
}
