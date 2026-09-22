<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\RefreshTokenAction;
use App\Actions\Auth\SendOtpAction;
use App\Actions\Auth\VerifyOtpAction;
use App\Exceptions\InvalidRefreshTokenException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Resources\UserResource;
use App\Models\RefreshToken\RefreshTokenFields;
use App\Models\User\UserFields;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Random\RandomException;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @param LoginAction $action
     * @return JsonResponse
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        $validated = $request->validated();

        $result = $action(
            $validated[UserFields::EMAIL],
            $validated[UserFields::PASSWORD],
            $validated[RefreshTokenFields::DEVICE_ID] ?? null,
        );

        return $this->sendResponse($this->tokenPayload($result));
    }

    /**
     * @throws RandomException
     */
    public function sendOtp(SendOtpRequest $request, SendOtpAction $action): JsonResponse
    {
        $action($request->validated()[UserFields::PHONE_NUMBER]);

        return $this->sendResponse([], 'کد تایید ارسال شد.');
    }

    public function verifyOtp(VerifyOtpRequest $request, VerifyOtpAction $action): JsonResponse
    {
        $validated = $request->validated();

        $result = $action(
            $validated[UserFields::PHONE_NUMBER],
            $validated[UserFields::OTP_CODE],
            $validated[RefreshTokenFields::DEVICE_ID] ?? null
        );

        $payload = array_merge($this->tokenPayload($result), [
            'is_new_user' => $result['is_new_user'],
        ]);

        return $this->sendResponse($payload, null, $result['is_new_user'] ? 201 : 200);
    }

    public function refresh(RefreshTokenRequest $request, RefreshTokenAction $action): JsonResponse
    {
        $validated = $request->validated();

        try {
            $result = $action($validated['refresh_token'], $validated['device_id'] ?? null);
        } catch (InvalidRefreshTokenException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 401);
        }

        return $this->sendResponse($result);
    }

    public function logout(Request $request, LogoutAction $action): JsonResponse
    {
        $action($request->user());

        return $this->sendResponse([], 'خروج با موفقیت انجام شد.');
    }

    private function tokenPayload(array $result): array
    {
        return [
            'user' => new UserResource($result['user']),
            'access_token' => $result['access_token'],
            'access_token_expires_at' => $result['access_token_expires_at'],
            'refresh_token' => $result['refresh_token'],
            'refresh_token_expires_at' => $result['refresh_token_expires_at'],
        ];
    }
}
