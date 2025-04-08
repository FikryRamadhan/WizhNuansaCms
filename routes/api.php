<?php

use App\Http\Resources\User;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', function (Request $request) {
        return new User($request->user());
    });

});
Route::prefix('tours')->group(function () {
     Route::get('/', [\App\Http\Controllers\Api\TourController::class, 'index']);
     Route::get('/{tour}', [\App\Http\Controllers\Api\TourController::class, 'show']);
 });
