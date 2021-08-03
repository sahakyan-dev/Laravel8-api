<?php

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

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::post('getToken', 'App\Http\Controllers\NewPasswordController@getForgotPasswordToken');
    Route::post('forgot-password', 'App\Http\Controllers\NewPasswordController@forgotPassword');
    Route::post('reset-password', 'App\Http\Controllers\NewPasswordController@resetPassword');

    Route::post('users', 'App\Http\Controllers\UsersController@getUsers');
    Route::post('editUser', 'App\Http\Controllers\UsersController@editUser');
});

// Route::group(['middleware' => ['auth:api', 'role:admin']], function() {
//     ;
// });
// Route::group(['middleware' => ['auth:api', 'role:admin']], function() {
//     Route::get('/users', 'App\Http\Controllers\UsersController@getUsers');
//     // Route::post('editUser', 'App\Http\Controllers\AuthController@editUser');
// })


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
