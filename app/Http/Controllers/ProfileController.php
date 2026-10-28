<?php

namespace App\Http\Controllers;

use App\Actions\Profile\UpdateProfileAction;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request) : JsonResponse
    {
        return $this->sendResponse([
            'user' => (new UserResource($request->user()))->resolve(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, UpdateProfileAction $action) : JsonResponse
    {
        $user = $action($request->user(), $request->validated());

        return $this->sendResponse(
            ['user' => (new UserResource($user))->resolve()],
            'پروفایل با موفقیت ذخیره شد.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
