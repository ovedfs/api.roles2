<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MeetingController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\RolePermissionsController;
use App\Http\Controllers\Api\UserPermissionsController;
use App\Http\Controllers\Api\UserRolesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ["auth:sanctum"]], function(){
    Route::get('profile', [AuthController::class, 'profile']);
    Route::get('logout', [AuthController::class, 'logout']);

    // Permissions CRUD
    Route::apiResource('permissions', PermissionController::class);

    // Roles CRUD
    Route::apiResource('roles', RoleController::class);

    // Role --> Permissions
    Route::get('role/{role}/permissions', [RolePermissionsController::class, 'show']);
    Route::post('role/{role}/permissions', [RolePermissionsController::class, 'sync']);

    // User --> Roles
    Route::get('user/{user}/roles', [UserRolesController::class, 'show']);
    Route::post('user/{user}/roles', [UserRolesController::class, 'sync']);

    // User --> Permissions
    Route::get('user/{user}/permissions', [UserPermissionsController::class, 'show']);
    Route::post('user/{user}/permissions', [UserPermissionsController::class, 'sync']);

    // Post CRUD
    Route::apiResource('posts', PostController::class);
});
