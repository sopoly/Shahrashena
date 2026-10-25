<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Models\User\UserFields;
use App\Services\Auth\TokenService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

readonly class LoginAction
{
    public function __construct(
        private TokenService $tokenService
    ) {}

    public function __invoke(string $email, string $password, ?string $deviceId): array
    {
        $user = User::query()->where(UserFields::EMAIL, $email)->first();

        $hasUsablePassword = $user && $user->getAttribute(UserFields::PASSWORD);

        if (! $hasUsablePassword || ! Hash::check($password, $user->getAttribute(UserFields::PASSWORD))) {
            throw ValidationException::withMessages([
                UserFields::EMAIL => ['ایمیل یا رمز عبور اشتباه است.'],
            ]);
        }

        $tokens = $this->tokenService->issueTokens($user, $deviceId);

        return [...$tokens, 'user' => $user];
    }
}
