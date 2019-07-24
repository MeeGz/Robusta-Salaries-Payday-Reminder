<?php

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

Route::group([ 'prefix' => 'v1.0'], function () {
    Route::post('login','API_V1_0\Auth\PassportController@login');
    Route::post('password/email','Auth\ForgotPasswordController@getResetToken')->name('password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');
});

Route::group([ 'prefix' => 'v1.0', 'middleware' => 'auth:api' ], function () {
    Route::post('logout', 'API_V1_0\Auth\PassportController@logout');
    Route::resource('employees', 'API_V1_0\EmployeeController');
    Route::resource('admins', 'API_V1_0\AdminController');
    Route::resource('payments', 'API_V1_0\PaymentController')->only('index');
});

Route::get('forget_success','Auth\ResetPasswordController@forgetSuccess');