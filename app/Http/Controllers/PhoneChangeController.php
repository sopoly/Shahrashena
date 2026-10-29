<?php

namespace App\Http\Controllers;

use App\Actions\Profile\RequestPhoneChangeAction;
use App\Actions\Profile\VerifyPhoneChangeAction;
use App\Http\Requests\Profile\RequestPhoneChangeRequest;
use App\Http\Requests\Profile\VerifyPhoneChangeRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User\UserFields;
use Illuminate\Http\JsonResponse;
use Random\RandomException;

class PhoneChangeController extends Controller
{
    /**
     * @throws RandomException
     */
    public function request(RequestPhoneChangeRequest $request, RequestPhoneChangeAction $action): JsonResponse
    {
        $action($request->validated()[UserFields::PHONE_NUMBER]);

        return $this->sendResponse([], 'کد تایید ارسال شد.');
    }

    public function verify(VerifyPhoneChangeRequest $request, VerifyPhoneChangeAction $action): JsonResponse
    {
        $validated = $request->validated();

        $user = $action(
            $request->user(),
            $validated[UserFields::PHONE_NUMBER],
            $validated[UserFields::OTP_CODE],
        );

        return $this->sendResponse(
            ['user' => (new UserResource($user))->resolve()],
            'شماره موبایل با موفقیت تغییر کرد.'
        );
    }
}
