<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersController;
use Modules\Users\Http\Controllers\RoleController;
use Modules\Users\Http\Controllers\RolePermissionController;
use Modules\Users\Http\Controllers\MedicalTeamController;
use Modules\Users\Http\Controllers\ProfileRoleController;

// Groupe de routes API pour `Users`
Route::prefix('users')->group(function () {
    Route::get('/', [UsersController::class, 'index']);
    Route::get('/{id}', [UsersController::class, 'show']);
    Route::post('/', [UsersController::class, 'store']);
    Route::put('/{id}', [UsersController::class, 'update']);
    Route::delete('/{id}', [UsersController::class, 'destroy']);
});

// Routes pour les rôles
Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index']);
    Route::post('/', [RoleController::class, 'store']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);
});

// Routes pour les permissions
Route::prefix('permissions')->group(function () {
    Route::get('/', [RolePermissionController::class, 'index']);
    Route::post('/', [RolePermissionController::class, 'store']);
    Route::put('/{id}', [RolePermissionController::class, 'update']);
    Route::delete('/{id}', [RolePermissionController::class, 'destroy']);
});

// Routes pour les équipes médicales
Route::prefix('medical-teams')->group(function () {
    Route::get('/', [MedicalTeamController::class, 'index']);
    Route::post('/', [MedicalTeamController::class, 'store']);
    Route::put('/{id}', [MedicalTeamController::class, 'update']);
    Route::delete('/{id}', [MedicalTeamController::class, 'destroy']);
});

// Routes pour les profils
Route::prefix('profiles')->group(function () {
    Route::get('/', [ProfileRoleController::class, 'index']);
    Route::post('/', [ProfileRoleController::class, 'store']);
    Route::put('/{id}', [ProfileRoleController::class, 'update']);
    Route::delete('/{id}', [ProfileRoleController::class, 'destroy']);
});


//Route::middleware('auth:api')->get('/users', function (Request $request) {
    //return $request->user();
//});