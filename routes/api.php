<?php

use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/register', 'createUser');
    Route::post('/auth/login', 'loginUser');
    Route::post('/auth/guest', 'createGuest');
});

Route::post('/auth/guest/register', [AuthController::class, 'createUserFromGuest'])
    ->middleware(['auth:sanctum', 'abilities:guest']);

Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories/{parent_id}', 'index');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'getProducts');
    Route::get('/products/{slug}', 'getProductsBySlug');
});

// Route::controller(UserController::class)->group(function () {
//     Route::post('/user', 'store');
//     Route::get('/users', 'index');
// });

Route::controller(ShoppingCartController::class)
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::patch('/cart/add/product/{product_id}', 'addProduct');
        Route::patch('/cart/remove/product/{product_id}', 'removeProduct');
        Route::get('/cart', 'show');
        Route::delete('/cart', 'destroy');
    });

Route::controller(OrderController::class)
    ->middleware(['auth:sanctum', 'abilities:guest,user'])
    ->group(function () {
        Route::post('/order', 'store');
        Route::get('/orders', 'index');
    });