<?php

namespace App\Http\Resources\User;

use App\Models\User;
use App\Models\User\UserFields;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            UserFields::ID => $this->{UserFields::ID},
            UserFields::NAME => $this->{UserFields::NAME},
            UserFields::EMAIL => $this->{UserFields::EMAIL},
            UserFields::PHONE_NUMBER => $this->{UserFields::PHONE_NUMBER},
            UserFields::CREATED_AT => $this->{UserFields::CREATED_AT},
        ];
    }
}
