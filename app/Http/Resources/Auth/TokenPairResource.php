<?php

namespace App\Http\Resources\Auth;

use App\Services\Auth\TokenPair;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TokenPair
 */
class TokenPairResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->accessToken->plainToken,
            'access_token_expires_at' => $this->accessToken->expiresAt->toIso8601String(),
            'refresh_token' => $this->refreshToken->plainToken,
            'refresh_token_expires_at' => $this->refreshToken->expiresAt->toIso8601String(),
        ];
    }
}
