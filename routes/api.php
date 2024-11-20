<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AccessController;

Route::middleware(['LogRequestResponse'])->group(function () {
    // Auth Routes (Login & Refresh Tokens) : 
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh-token', [AuthController::class, 'refresh']);

    // PAJ-GPS-BACKEND-API Routes :
    Route::middleware('auth:sanctum')->group(function () {

        // User Controller Routes :
        Route::get('user-info', [UserController::class, 'userInfo']); // Get authenticated user info
        Route::post('user-create', [UserController::class, 'create']); // Create a user
        Route::put('user-update/{id}', [UserController::class, 'update']); // Update user details
        Route::delete('user-delete/{id}', [UserController::class, 'delete']); // Delete user

        // Device Controller Routes :
        Route::prefix('devices')->group(function () {
            Route::get('/', [DeviceController::class, 'index']); // List all devices
            Route::get('{id}', [DeviceController::class, 'show']); // Get specific device
            Route::post('create', [DeviceController::class, 'create']); // Create a new device
            Route::put('update/{id}', [DeviceController::class, 'update']); // Update device details
            Route::delete('delete/{id}', [DeviceController::class, 'delete']); // Delete a device
        });

        // Access Controller Routes :
        Route::prefix('access')->group(function () {
            Route::get('user/{user_id}', [AccessController::class, 'getUserAccess']); // Get all access for a specific user
            Route::get('device/{device_id}', [AccessController::class, 'getDeviceAccess']); // Get all access for a specific device
            Route::post('grant', [AccessController::class, 'grantAccess']); // Grant access to a user/device
            Route::put('update/{id}', [AccessController::class, 'updateAccess']); // Update access level for a user/device
            Route::delete('revoke/{id}', [AccessController::class, 'revokeAccess']); // Revoke access for a user/device
        });
    });
});
