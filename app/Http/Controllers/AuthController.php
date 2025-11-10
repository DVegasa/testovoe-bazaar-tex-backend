<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\MeRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\TokenResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\App\AppValidationException;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('api')->plainTextToken;

        return TokenResource::make([
            'user' => $user,
            'token' => $token,
        ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Handle user login.
     *
     * @throws AppValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        /** @var User|null $user */
        $user = User::query()->where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw new AppValidationException('Неверный логин/пароль');
        }

        $token = $user->createToken('api')->plainTextToken;

        return TokenResource::make([
            'user' => $user,
            'token' => $token,
        ])->response();
    }

    /**
     * Return authenticated user.
     */
    public function me(MeRequest $request): JsonResponse
    {
        return UserResource::make($request->user())->response();
    }

    /**
     * Revoke current access token.
     */
    public function logout(LogoutRequest $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return MessageResource::make('Вы успешно вышли из системы.')->response();
    }
}
