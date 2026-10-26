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
use App\Http\Resources\Auth\AuthResource;
use App\Http\Resources\Auth\TokenPairResource;
use App\Models\RefreshToken\RefreshTokenFields;
use App\Models\User\UserFields;
use App\Services\Auth\AuthResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Random\RandomException;

class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        $validated = $request->validated();

        $result = $action(
            $validated[UserFields::EMAIL],
            $validated[UserFields::PASSWORD],
            $validated[RefreshTokenFields::DEVICE_ID] ?? null,
        );

        return $this->authResponse($result);
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
            $validated[RefreshTokenFields::DEVICE_ID] ?? null,
        );

        return $this->authResponse($result, $result->isNewUser ? 201 : 200);
    }

    /**
     * @throws InvalidRefreshTokenException
     * @throws \Throwable
     */
    public function refresh(RefreshTokenRequest $request, RefreshTokenAction $action): JsonResponse
    {
        $validated = $request->validated();

        $tokens = $action(
            $validated[RefreshTokenFields::REFRESH_TOKEN],
            $validated[RefreshTokenFields::DEVICE_ID] ?? null,
        );

        return $this->sendResponse((new TokenPairResource($tokens))->resolve());
    }

    public function logout(Request $request, LogoutAction $action): JsonResponse
    {
        $action($request->user());

        return $this->sendResponse([], 'خروج با موفقیت انجام شد.');
    }

    private function authResponse(AuthResult $result, int $httpCode = 200): JsonResponse
    {
        return $this->sendResponse((new AuthResource($result))->resolve(), null, $httpCode);
    }
}
