<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\User\UserFields;
use App\Services\Otp\OtpService;
use App\Services\Profile\PhoneNumberAvailability;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhoneChangeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_request_change_sends_otp_to_normalized_available_number(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $this->mock(OtpService::class)
            ->shouldReceive('generateAndSend')
            ->once()
            ->with('09123456789');

        $response = $this->postJson('/api/v1/profile/phone/request-change', [
            UserFields::PHONE_NUMBER => '+98 912-345-6789',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true);
    }

    public function test_request_change_does_not_send_otp_when_number_is_taken(): void
    {
        $user = User::factory()->create();
        User::factory()->create([UserFields::PHONE_NUMBER => '09123456789']);
        $this->actingAs($user, 'sanctum');

        $this->mock(OtpService::class)
            ->shouldNotReceive('generateAndSend');

        $response = $this->postJson('/api/v1/profile/phone/request-change', [
            UserFields::PHONE_NUMBER => '09123456789',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true);
    }

    public function test_verify_change_updates_phone_number_after_valid_otp(): void
    {
        $user = User::factory()->create([UserFields::PHONE_NUMBER => '09111111111']);
        $this->actingAs($user, 'sanctum');

        $this->mock(OtpService::class)
            ->shouldReceive('verify')
            ->once()
            ->with('09123456789', '123456')
            ->andReturnTrue();

        $response = $this->postJson('/api/v1/profile/phone/verify-change', [
            UserFields::PHONE_NUMBER => '+98 912-345-6789',
            UserFields::OTP_CODE => '123456',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('user.'.UserFields::PHONE_NUMBER, '09123456789');

        $this->assertDatabaseHas(UserFields::TABLE, [
            UserFields::ID => $user->getKey(),
            UserFields::PHONE_NUMBER => '09123456789',
        ]);
    }

    public function test_verify_change_does_not_update_phone_number_after_invalid_otp(): void
    {
        $user = User::factory()->create([UserFields::PHONE_NUMBER => '09111111111']);
        $this->actingAs($user, 'sanctum');

        $this->mock(OtpService::class)
            ->shouldReceive('verify')
            ->once()
            ->andReturnFalse();

        $response = $this->postJson('/api/v1/profile/phone/verify-change', [
            UserFields::PHONE_NUMBER => '09123456789',
            UserFields::OTP_CODE => '123456',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(UserFields::OTP_CODE);

        $this->assertDatabaseHas(UserFields::TABLE, [
            UserFields::ID => $user->getKey(),
            UserFields::PHONE_NUMBER => '09111111111',
        ]);
    }

    public function test_phone_number_availability_reports_existing_and_unused_numbers(): void
    {
        User::factory()->create([UserFields::PHONE_NUMBER => '09123456789']);

        $availability = app(PhoneNumberAvailability::class);

        $this->assertTrue($availability->isTaken('09123456789'));
        $this->assertFalse($availability->isTaken('09198765432'));
    }
}
