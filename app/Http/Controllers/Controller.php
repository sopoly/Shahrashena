<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function sendResponse(?array $data = [], $message = null, int $httpCode = 200): JsonResponse
    {
        if (!is_array($data)) $data = [];
        if ($message) $message = __($message);
        /*
         * TODO: Add resources/lang directory
         */
        $response = array_merge([
            'success' => true,
            'message' => $message,
        ], $data);
        return response()->json($response, $httpCode);
    }
}
