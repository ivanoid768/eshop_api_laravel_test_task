<?php

use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'getProducts');
    Route::get('/products/{slug}', 'getProductsBySlug');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/user', 'store');
    Route::get('/users', 'index');
});

Route::controller(ShoppingCartController::class)->group(function () {
    Route::patch('/cart/{id}/add/product/{product_id}', 'addProduct');
    Route::patch('/cart/{id}/remove/product/{product_id}', 'removeProduct');
    Route::get('/cart/{shoppingcart}', 'show');
    Route::delete('/cart/{id}', 'destroy');
});

Route::controller(OrderController::class)->group(function () {
    Route::post('/order/{user_id}', 'store');
    Route::get('/orders/{user_id}', 'index');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/register', 'createUser');
    Route::post('/auth/login', 'loginUser');
});