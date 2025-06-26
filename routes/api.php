<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\EnergyMeasurementController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/complete-profile', [AuthController::class, 'completeProfile']);

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::put('/password', [ProfileController::class, 'updatePassword']);
        Route::post('/photo', [ProfileController::class, 'updatePhoto']);
        Route::delete('/photo', [ProfileController::class, 'deletePhoto']);
    });
    Route::prefix('devices')->group(function () {
        Route::get('/', [DeviceController::class, 'me']);
        Route::post('/', [DeviceController::class, 'store']);
        Route::get('/{id}', [DeviceController::class, 'show']);
        Route::put('/{id}', [DeviceController::class, 'update']);
        Route::delete('/{id}', [DeviceController::class, 'destroy']);
        Route::get('/building/{building}', [DeviceController::class, 'byBuilding']);
        Route::get('/status/{status}', [DeviceController::class, 'byStatus']);
    });
    Route::prefix('energy-measurements')->group(function () {
        Route::get('/', [EnergyMeasurementController::class, 'index']);
        Route::post('/', [EnergyMeasurementController::class, 'store']);
        Route::get('/{id}', [EnergyMeasurementController::class, 'show']);
        Route::put('/{id}', [EnergyMeasurementController::class, 'update']);
        Route::delete('/{id}', [EnergyMeasurementController::class, 'destroy']);
        Route::get('/device/{deviceId}/latest', [EnergyMeasurementController::class, 'latest']);
        Route::get('/device/{deviceId}/statistics', [EnergyMeasurementController::class, 'statistics']);
    });
});

Route::get('/test-api', function () {
    return response()->json(['message' => 'API works!']);
});
