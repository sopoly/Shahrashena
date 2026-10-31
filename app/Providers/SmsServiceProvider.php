<?php

namespace App\Providers;

use App\Services\Sms\Contracts\SmsServiceInterface;
use App\Services\Sms\LogSmsService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(LogSmsService::class)
            ->needs(LoggerInterface::class)
            ->give(fn () => Log::channel('sms'));

        $this->app->singleton(SmsServiceInterface::class, LogSmsService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
