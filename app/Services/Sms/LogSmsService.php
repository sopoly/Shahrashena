<?php
// app/Services/Sms/LogSmsService.php
namespace App\Services\Sms;

use App\Services\Sms\Contracts\SmsServiceInterface;
use Illuminate\Support\Facades\Log;

class LogSmsService implements SmsServiceInterface
{
    public function send(string $phoneNumber, string $message): void
    {
        Log::info("SMS to {$phoneNumber}: {$message}");
    }
}
