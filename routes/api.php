<?php

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', 'Auth\UserController@current');


    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::group(['prefix' => 'big_project'], function () {
        Route::any('list/{id?}', 'Settings\BigprojectController@list');
        Route::post('insert', 'Settings\BigprojectController@insert');
        Route::post('update', 'Settings\BigprojectController@update');
    });

    Route::group(['prefix' => 'project'], function () {
        Route::any('list/{id?}', 'Settings\ProjectController@list');
        Route::post('insert', 'Settings\ProjectController@insert');
        Route::post('update', 'Settings\ProjectController@update');
        Route::any('list_for_info/{id?}', 'Settings\ProjectController@list_for_info');
    });

    Route::group(['prefix' => 'size'], function () {
        Route::any('list/{id?}', 'Settings\SizeController@list');
        Route::post('insert', 'Settings\SizeController@insert');
        Route::post('update', 'Settings\SizeController@update');
    });

    Route::group(['prefix' => 'style'], function () {
        Route::any('list/{id?}', 'Settings\StyleController@list');
        Route::post('insert', 'Settings\StyleController@insert');
        Route::post('update', 'Settings\StyleController@update');
    });

    // 图片上传
    Route::group(['prefix' => 'image', 'as' => 'image.'], function () {
        Route::post('upload', 'Settings\UploadController@upload')->name('upload');
    });

});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
