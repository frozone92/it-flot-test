<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [\App\Http\Controllers\RegistrationController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::delete('/login', [\App\Http\Controllers\AuthController::class, 'logout']);

Route::middleware('web')->get('/csrf-token', [\App\Http\Controllers\AuthController::class, 'csrf']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/login', function () {
        return ['user' => \Illuminate\Support\Facades\Auth::user()];
    });

    Route::group(['prefix' => '/catalogItem'], function () {
        Route::get('/', [\App\Http\Controllers\CatalogItemController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\CatalogItemController::class, 'store']);
        Route::get('/{catalogItemId}', [\App\Http\Controllers\CatalogItemController::class, 'get']);
    });
});
