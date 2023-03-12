<?php

use Illuminate\Http\Request;

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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api', 'middleware' => ['api']], function () {
    //auth
    Route::post('register', 'AuthController@sign_up');
    Route::post('login', 'AuthController@login');
    Route::post('forget-password', 'AuthController@forget_password');
    Route::post('verify-code', 'AuthController@verify_code');
    Route::post('change-password', 'AuthController@change_password');
    Route::post('social-login', 'AuthController@socialLogin');
    Route::get('user-data', 'AuthController@getUserData');

    //Home
    Route::get('cities', 'HomeController@cities');
    Route::get('sliders', 'HomeController@sliders');
    Route::get('home-product', 'HomeController@homeProduct');
    Route::get('main-categories', 'HomeController@mainCategories');
    Route::get('category-products/{id}', 'HomeController@ProductsByCategory');
    Route::get('sub-category/{id}', 'HomeController@subCategory');
    Route::get('product-details/{id}', 'HomeController@productDetails');


    //AuthActionUser
    Route::Post('add-to-wishlist', 'AuthUserActions@AddToWishlist');
    Route::Post('remove-from-wishlist', 'AuthUserActions@RemoveFromWishlist');
    Route::get('wishlist', 'AuthUserActions@wishlist');

    //Cart
    Route::Post('add-to-cart', 'CartController@AddToCart');
    Route::Post('remove-from-cart', 'CartController@RemoveFromCart');
    Route::get('cart', 'CartController@GetCart');
    Route::get('increase-cart/{id}', 'CartController@increaseCart');
    Route::get('decrease-cart/{id}', 'CartController@decreaseCart');

    //orders
    Route::Post('place-order', 'CartController@MakeOrder');
    Route::get('my-orders', 'CartController@GetOrders');


});
