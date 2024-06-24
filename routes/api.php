<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ProductosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('categorias', CategoriasController::class);
Route::resource('productos', ProductosController::class);
Route::get('productosporcategorias',[ProductosController::class, 'ProductosPorCategorias']);
Route::get('todoslosproductos',[ProductosController::class, 'all']);
