<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/hello-world', fn() => "Hello World");
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/users/info', [AuthController::class, 'updateInfo']);
    Route::put('/users/password', [AuthController::class, 'updatePassword']);

    Route::apiResource('/users', UserController::class);
    Route::apiResource('/products', ProductController::class);

    Route::apiResource('/roles', RoleController::class);
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::post('/upload', [ImageController::class, 'upload']);

    Route::apiResource('/orders', OrderController::class)->only(['index', 'show']);
    Route::post('/export', [OrderController::class, 'export']);
    Route::get('/chart', [OrderController::class, 'chart']);
});
