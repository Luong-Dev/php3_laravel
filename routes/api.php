<?php

use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\ApiProductDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('products', ApiProductController::class);
Route::resource('productDetails', ApiProductDetailController::class);
Route::get('/productDetails/{productId}/{a}/{b}', [ApiProductDetailController::class, 'detail']);