<?php

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ProductController;
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
*/

Route::get('/cidades', [CidadeController::class, 'get']);

Route::get('/products', [ProductController::class, 'get']);
Route::post('/products', [ProductController::class, 'post']);
Route::get('/products/{id}', [ProductController::class, 'getById']);
Route::put('/products/{id}', [ProductController::class, 'putById']);
Route::delete('/products/{id}', [ProductController::class, 'deleteById']);
