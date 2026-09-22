<?php

namespace App\Models;

use App\Models\RefreshToken\RefreshTokenFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefreshToken extends Model
{
    protected $table = RefreshTokenFields::TABLE;



    protected $casts = [
        RefreshTokenFields::EXPIRES_AT => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, RefreshTokenFields::USER_ID);
    }

    public function isExpired(): bool
    {
        return $this->{RefreshTokenFields::EXPIRES_AT}->isPast();
    }
}
