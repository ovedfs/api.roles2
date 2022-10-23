<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MeetingController;
use App\Http\Controllers\Api\PermissionController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ["auth:sanctum"]], function(){
    Route::get('profile', [AuthController::class, 'profile']);
    Route::get('logout', [AuthController::class, 'logout']);

    // Permissions CRUD
    Route::apiResource('permissions', PermissionController::class);
});
