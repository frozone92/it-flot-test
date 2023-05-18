<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    use ApiResponseTrait;

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $user = new User();
            $user->fill($validated);

            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(10);

            if ($user->save()) {
                Auth::login($user);

                return $this->respondSuccess(__('Успешная регистрация'));
            }
        }catch (ValidationException $exception){
            return $this->respondValidationErrors($exception);
        }catch (\Exception $e){
            return $this->respondError($e->getMessage());
        }

    }
}
