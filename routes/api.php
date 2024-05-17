<?php

use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


//Rutas de Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(
    function(){
        Route::get('/logout', [AuthController::class, 'logout']);  
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/perfil/{id}',[AuthController::class, 'perfil']);
    }
);

//Rutas Producto
Route::post('/producto', [ProductoController::class, 'store'])->name('productos');
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('producto.show');
Route::put('/producto/{id}', [ProductoController::class, 'update'])->name('producto.update');
Route::delete('/producto/{id}', [ProductoController::class, 'destroy'])->name('producto.destroy');

//Rutas Categoria
Route::resource('categoria', CategoriaController::class);

