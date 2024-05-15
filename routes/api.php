<?php

use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(
    function(){
        Route::get('/logout', [AuthController::class, 'logout']);  
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/perfil/{id}',[AuthController::class, 'perfil']);
    }
);



