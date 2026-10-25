<?php

namespace App\Services\Auth;

use App\Models\User;

final readonly class RotatedRefreshToken
{
    public function __construct(
        public User $user,
        public IssuedRefreshToken $token,
    ) {}
}
