<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes (tidak perlu authentication)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes (memerlukan authentication JWT)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);

    // Token management routes
    Route::get('/tokens', [TokenController::class, 'index']);
    Route::get('/tokens/current', [TokenController::class, 'current']);
    Route::delete('/tokens/{tokenId}', [TokenController::class, 'revoke']);
    Route::post('/tokens/revoke-all', [TokenController::class, 'revokeAll']);

    // Item routes - special routes harus sebelum resource routes
    Route::get('/items/recent', [ItemController::class, 'recent']);
    Route::get('/items/category/{category}', [ItemController::class, 'getByCategory']);
    Route::apiResource('items', ItemController::class);
});

// Health check
Route::get('/health', function () {
    return response()->json(['status' => 'OK', 'timestamp' => now()], 200);
});
