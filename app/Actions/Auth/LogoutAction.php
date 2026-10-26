<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Services\Auth\TokenService;

readonly class LogoutAction
{
    public function __construct(
        private TokenService $tokenService
    ) {}

    public function __invoke(User $user): void
    {
        $this->tokenService->revokeCurrentDevice($user);
    }
}
