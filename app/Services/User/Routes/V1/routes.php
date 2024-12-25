<?php

use App\Services\User\Http\Controllers\Auth\AuthController;
use App\Services\User\Http\Controllers\UserController;

Route::prefix('auth')->group(function () {
    Route::name('auth.login')->middleware('throttle:10,1')->post('login', [AuthController::class, 'login']);
    Route::name('auth.register')->middleware('throttle:10,1')->post('register', [AuthController::class, 'register']);
    Route::name('auth.logout')->middleware('throttle:10,1')->post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'show']);
    Route::match(['put', 'patch'], 'user', [UserController::class, 'update']);
});
