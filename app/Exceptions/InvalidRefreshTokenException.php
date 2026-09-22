<?php

namespace App\Exceptions;

use Exception;

class InvalidRefreshTokenException extends Exception
{
    public function __construct()
    {
        parent::__construct('Refresh token نامعتبر یا منقضی شده است. لطفاً دوباره وارد شوید.', 401);
    }
}
