<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Traits\Helpers\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function login(AuthRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        if (Auth::attempt($validated)) {
            $user = Auth::user();
            $token = $user->createToken('auth')->plainTextToken;

            return $this->respondSuccess(__('Успешная авторизация'), ['token' => $token]);
        } else {
            return $this->respondError(__('Пользователь с таким email и паролем не найден'));
        }
    }

    public function csrf(): string
    {
        return csrf_token();
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->respondSuccess('Сеанс завершен');
    }
}
