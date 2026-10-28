<?php

namespace App\Actions\Profile;

use App\Models\User;
readonly class UpdateProfileAction
{
    public function __invoke(User $user, array $data): User
    {
        $user->update($data);
        return $user->refresh();
    }
}
