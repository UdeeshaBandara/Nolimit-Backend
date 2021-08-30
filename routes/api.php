<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SanctumController;
use App\Http\Controllers\WishListController;
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

Route::post('/customer', [CustomerController::class, 'store']);
Route::post('/customer/login', [CustomerController::class, 'login']);
Route::post('/customer/confirm-otp', [CustomerController::class, 'confrimOTP']);
Route::post('/customer/resend-otp', [CustomerController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/flash-sale', [ProductController::class, 'getFlashSale']);
Route::get('/products/featured', [ProductController::class, 'getFeaturedProduct']);
Route::get('/products/new-arrivals', [ProductController::class, 'getNewArrivals']);
Route::get('/products/{id}', [ProductController::class, 'getOneProduct']);



Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/customer', [CustomerController::class, 'index']);
});

Route::group(['prefix' => 'wish-list', 'middleware' => ['auth:sanctum']], function () {

    Route::get('/', [WishListController::class, 'index']);
    Route::post('/', [WishListController::class, 'store']);
    Route::delete('/', [WishListController::class, 'destroy']);
});




Route::get('/login', [SanctumController::class, 'indicate'])->name('login');
