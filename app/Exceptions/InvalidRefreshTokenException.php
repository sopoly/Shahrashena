<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InvalidRefreshTokenException extends Exception
{
    public function __construct()
    {
        parent::__construct('Refresh token نامعتبر یا منقضی شده است. لطفاً دوباره وارد شوید.', 401);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
        ], 401);
    }
}
