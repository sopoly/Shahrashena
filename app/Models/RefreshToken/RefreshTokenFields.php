<?php

namespace App\Models\RefreshToken;

class RefreshTokenFields
{
    const string TABLE      = 'refresh_tokens';

    const string USER_ID    = 'user_id';
    const string DEVICE_ID  = 'device_id';
    const string TOKEN      = 'token';
    const string EXPIRES_AT = 'expires_at';
}
