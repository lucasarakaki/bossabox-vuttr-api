<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\v1\ToolController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(fn () => [

    Route::middleware(['api', 'auth:sanctum'])->group(fn () => [
        Route::apiResource('users', UserController::class),
        Route::apiResource('tools', ToolController::class),
        Route::post('logout', [AuthController::class, 'logout'])->name('logout'),
    ]),

    Route::post('login', [AuthController::class, 'login'])->name('login'),
]);
