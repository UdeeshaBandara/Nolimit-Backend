<?php

use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
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

//Customer registration routes
Route::group(['prefix' => 'customer'], function () {

    Route::post('/', [CustomerController::class, 'store']);
    Route::post('/login', [CustomerController::class, 'login']);
    Route::post('/confirm-otp', [CustomerController::class, 'confrimOTP']);
    Route::post('/resend-otp', [CustomerController::class, 'login']);


});

//Home screen routes
Route::get('/home-banners', [MediaController::class, 'getHomeBanners']);

Route::group(['prefix' => 'products'], function () {

    Route::get('/', [ProductController::class, 'index']);
    Route::get('/flash-sale', [ProductController::class, 'getFlashSale']);
    Route::get('/featured', [ProductController::class, 'getFeaturedProduct']);
    Route::get('/new-arrivals', [ProductController::class, 'getNewArrivals']);
    Route::get('/{id}', [ProductController::class, 'getOneProduct']);

});


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/customer', [CustomerController::class, 'index']);
});

Route::group(['prefix' => 'wish-list', 'middleware' => ['auth:sanctum']], function () {

    Route::get('/', [WishListController::class, 'index']);
    Route::post('/', [WishListController::class, 'store']);
    Route::delete('/', [WishListController::class, 'destroy']);
});
Route::group(['prefix' => 'reviews', 'middleware' => ['auth:sanctum']], function () {

    Route::get('/', [ReviewController::class, 'index']);
    Route::post('/', [ReviewController::class, 'store']);
    Route::delete('/', [ReviewController::class, 'destory']);
});
Route::group(['prefix' => 'address', 'middleware' => ['auth:sanctum']], function () {

    Route::get('/', [CustomerAddressController::class, 'index']);
    Route::post('/', [CustomerAddressController::class, 'store']);
    Route::delete('/', [CustomerAddressController::class, 'destory']);
    Route::put('/', [CustomerAddressController::class, 'patch']);

    Route::get('/cities', [CustomerAddressController::class, 'getCities']);
});




