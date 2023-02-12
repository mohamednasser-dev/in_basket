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
    Route::post('register', 'AuthController@sign_up');
    Route::post('login', 'AuthController@login');
    Route::post('forget-password', 'AuthController@forget_password');
    Route::post('verify-code', 'AuthController@verify_code');
    Route::post('change-password', 'AuthController@change_password');
    Route::post('social-login', 'AuthController@socialLogin');

});
