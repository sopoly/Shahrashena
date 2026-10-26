<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Auth\TokenPairResource;
use App\Http\Resources\User\UserResource;
use App\Services\Auth\AuthResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AuthResult
 */
class AuthResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->user),
            ...(new TokenPairResource($this->tokens))->toArray($request),
            'is_new_user' => $this->when(
                $this->isNewUser !== null,
                fn (): bool => $this->isNewUser,
            ),
        ];
    }
}
