<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Models\User\UserFields;
use App\Services\Auth\AuthResult;
use App\Services\Auth\TokenService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

readonly class LoginAction
{
    public function __construct(
        private TokenService $tokenService
    ) {}

    public function __invoke(string $email, string $password, ?string $deviceId): AuthResult
    {
        $user = User::query()->where(UserFields::EMAIL, $email)->first();
        $hashedPassword = $user?->getAttribute(UserFields::PASSWORD);

        if (! $hashedPassword || ! Hash::check($password, $hashedPassword)) {
            throw ValidationException::withMessages([
                UserFields::EMAIL => ['ایمیل یا رمز عبور اشتباه است.'],
            ]);
        }

        return new AuthResult(
            $user,
            $this->tokenService->issueTokens($user, $deviceId),
        );
    }
}
