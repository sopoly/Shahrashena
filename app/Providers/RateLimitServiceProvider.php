<?php

namespace App\Providers;

use App\Models\User\UserFields;
use App\Services\Phone\PhoneNumberNormalizer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class RateLimitServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('login', fn (Request $request): array => [
            Limit::perMinute(5)->by('login:minute:' . $this->email($request) . '|' . $request->ip()),
            Limit::perMinute(20)->by('login:ip:' . $request->ip()),
        ]);

        RateLimiter::for('otp-send', fn (Request $request): array => [
            Limit::perMinute(1)->by('otp-send:minute:' . $this->phone($request)),
            Limit::perHour(5)->by('otp-send:hour:' . $this->phone($request)),
            Limit::perHour(20)->by('otp-send:ip:' . $request->ip()),
        ]);

        RateLimiter::for('otp-verify', fn (Request $request): array => [
            Limit::perMinute(10)->by('otp-verify:phone:' . $this->phone($request)),
            Limit::perMinute(20)->by('otp-verify:ip:' . $request->ip()),
        ]);

        RateLimiter::for('token-refresh', fn (Request $request): Limit =>
        Limit::perMinute(120)->by('token-refresh:ip:' . $request->ip())
        );
    }

    private function phone(Request $request): string
    {
        $phone = $request->input(UserFields::PHONE_NUMBER);

        return is_string($phone)
            ? app(PhoneNumberNormalizer::class)->normalize($phone)
            : '';
    }

    private function email(Request $request): string
    {
        $email = $request->input(UserFields::EMAIL);
        return is_string($email) ? Str::lower($email) : '';
    }
}
