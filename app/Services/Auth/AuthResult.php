<?php

namespace App\Services\Auth;

use App\Models\User;

final readonly class AuthResult
{
    /**
     * @param bool|null $isNewUser null
     */
    public function __construct(
        public User $user,
        public TokenPair $tokens,
        public ?bool $isNewUser = null,
    ) {}
}
