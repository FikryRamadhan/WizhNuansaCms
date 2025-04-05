<?php

use App\Http\Resources\User;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // Api For Users
    Route::prefix('users')->group(function () {
        Route::get('/{id}', function (string $id) {
            return new User(ModelsUser::findOrFail($id));
        });
    });

    // Api For Wisata
    Route::prefix('wisata')->group(function () {
        // Route::get('/{id}', function (string $id) {
        //     return new User(ModelsUser::findOrFail($id));
        // });
        Route::get('/', function () {
            return ModelsUser::all();
        });
    });
});
